<?php


namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Check extends Model
{

    public $timestamps = false; //запрет на поля created_at и update_at


    public function setObjectAttribute($value) //мутатор для записи названии СМП с большой буквы
    {
        $this->attributes['object'] = Str::title($value);
    }


    public function setControlAttribute($value) //мутатор для записи названии Объекта с большой буквы
    {
        $this->attributes['control'] = Str::title($value);
    }


    public function control() //связь с таблицей Control
    {
        return $this->belongsTo(Control::class);
    }


    public function object() //связь с таблицей CheckObject
    {
        return $this->belongsTo(CheckObject::class);
    }


    public static function calculateRelevence($baseSearchClear, $wordsSearch, $separateWord) //Задаем параметры релевантности
    {
        //Условия для полного запроса в названии СМП и Объекте проверки
        $relevance = "IF (`check_objects` . `name` LIKE '%" . $baseSearchClear . "%', 60, 0)";
        $relevance .= " + IF (`controls` . `title` LIKE '%" . $baseSearchClear . "%', 60, 0)";
        $relevance .= " + IF (`checks` . `date_start` LIKE '%" . $baseSearchClear . "%', 60, 0)";
        $relevance .= " + IF (`checks` . `date_finish` LIKE '%" . $baseSearchClear . "%', 60, 0)";
        //Условия для каждого из слов запроса в названии СМП и Объекте проверки
        foreach ($wordsSearch as $word) {
            $relevance .= " + IF (`check_objects` . `name` LIKE '%" . $word . "%', " . $separateWord . ", 0)";
            $relevance .= " + IF (`controls` . `title` LIKE '%" . $word . "%', " . $separateWord . ", 0)";
            $relevance .= " + IF (`checks` . `date_start` LIKE '%" . $word . "%', " . $separateWord . ", 0)";
            $relevance .= " + IF (`checks` . `date_finish` LIKE '%" . $word . "%', " . $separateWord . ", 0)";
        }
        return $relevance;
    }


    public static function getQuery($relevance, $baseSearchClear, $wordsSearch, $count) //формирование запроса
    {
        $query = Check::query()
            ->join('check_objects', 'check_objects.id', '=', 'checks.object_id') //объединяем таблицы
            ->join('controls', 'controls.id', '=', 'checks.control_id') //объединяем таблицы
            ->select('checks.id', 'check_objects.name as object_name', 'controls.title as control_title', 'checks.date_start', 'checks.date_finish', 'checks.lasting') //выбираем данные
            //Создается новое поле "relevance", значение которого будет устанавливаться путем выполнения условий, записанных в $relevance
            ->selectRaw("$relevance AS relevance")
            ->orderBy('relevance', 'desc')
            ->where('check_objects.name', 'like', '%' . $baseSearchClear . '%')
            ->orWhere('controls.title', 'like', '%' . $baseSearchClear . '%')
            ->orWhere('checks.date_start', 'like', '%' . $baseSearchClear . '%')
            ->orWhere('checks.date_finish', 'like', '%' . $baseSearchClear . '%')
            ->orWhere('check_objects.name', 'like', '%' . $wordsSearch[0] . '%');
        for ($i = 1; $i < $count; $i++) {
            $query = $query->orWhere('check_objects.name', 'like', $wordsSearch[$i]);
        }
        $query = $query
            ->orWhere('controls.title', 'like', '%' . $baseSearchClear . '%')
            ->orWhere('controls.title', 'like', '%' . $wordsSearch[0] . '%');
        for ($i = 1; $i < $count; $i++) {
            $query = $query
                ->orWhere('controls.title', 'like', $wordsSearch[$i]);
        }
        $query = $query
            ->get();
        return $query;
    }

//    получение релевантного списка для поиска
    public static function getChecksToSearch($clearSearch)
    {
        $wordsSearch = self::explodeSearch($clearSearch); //разделяем поисковый запрос на отдельные слова
        $baseSearchClear = implode(' ', $wordsSearch); //собираем уникальные слова в одну строку
        $count = count($wordsSearch); //количество уникальных слов в запросе
        $separateWord = round((20 / $count), 2); //значения каждого отдельного слова для расчета релевантности
        $relevance = self::calculateRelevence($baseSearchClear, $wordsSearch, $separateWord); //задаем параметры релевантности
        $query = self::getQuery($relevance, $baseSearchClear, $wordsSearch, $count); //формирование запроса
        if ($query->isEmpty()) {
            $query = "По вашему запросу '$baseSearchClear' ничего не найдено";
        }
        return $query;
    }


    public static function cleanSearchString($baseSearch) //обработка поискового запроса
    {
        $search = preg_replace('#\s+#u', ' ', $baseSearch); // заменить двойные пробелы на одинарные
        return trim($search); //обрезать пробелы в начале и конце
    }

    public static function explodeSearch($search) //Разделяем поисковый запрос на отдельные слова
    {
        $baseWordsSearch = explode(' ', $search);
        $wordsSearch = [];
        foreach ($baseWordsSearch as $word) {
            array_push($wordsSearch, $word);
        }
        return array_unique($wordsSearch); //возвращаем массив уникальных слов запроса
    }


    public static function unsetRelevance($checksForExcel) //редактируем для экспорта в Excel
    {
        for ($i = 0; $i < count($checksForExcel); $i++) {
            $checksForExcel[$i]['id'] = $i + 1; //заменяем id на цифру номера
            unset($checksForExcel[$i]['relevance']); //убираем графу релевантность
        }
        $firstItem = collect(['№', 'СМП', 'Контролирующий орган', 'Дата начала проверки', 'Дата окончания проверки', 'Длительность']);
        $checksForExcel->prepend($firstItem);// добавляем заголовки
        return $checksForExcel;
    }


    public static function writeAttribute($check, $request) //запись атрибутов
    {
        $object_id = CheckObject::getId($request); //получение id СМП
        $control_id = Control::getId($request); //получение id Контроля

        $check->object_id = $object_id->id;
        $check->control_id = $control_id->id;
        $dateStart = Carbon::parse($request->date_start);
        $dateFinish = Carbon::parse($request->date_finish);
        $dif = $dateFinish->diff($dateStart)->days; //длительность проверки
        $check->date_start = Carbon::parse($dateStart)->format('d.m.Y');
        $check->date_finish = Carbon::parse($dateFinish)->format('d.m.Y');
        $check->lasting = $dif;
        return $check;
    }


    public static function getCheck($id) //получение записи проверки
    {
        $check = Check::query()
            ->find($id);
        return $check;
    }
}
