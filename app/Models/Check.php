<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Check extends Model
{
//запрет на поля created_at и update_at
    public $timestamps = false;

    //    мутатор для записи названии СМП с большой буквы
    public function setObjectAttribute($value)
    {
        $this->attributes['object'] = Str::title($value);
    }


    //    мутатор для записи названии Объекта с большой буквы
    public function setControlAttribute($value)
    {
        $this->attributes['control'] = Str::title($value);
    }


//    связь с таблицей Control
    public function control()
    {
        return $this->belongsTo(Control::class);
    }

//    связь с таблицей CheckObject
    public function object()
    {
        return $this->belongsTo(CheckObject::class);
    }


//    получение релевантного списка для поиска
    public static function getProductToSearch($baseSearch)
    {
        $wordsSearch = self::cleanSearchString($baseSearch);
        if (!$wordsSearch) {
            return $products = "Ваш запрос слишком короткий";
        }
        $baseSearchClear = implode(' ', $wordsSearch);
        $count = count($wordsSearch);
        //значения каждого отдельного слова в названии СМП и Объекте проверки для расчета релевантности
        $separateWordName = round((20 / $count), 2);
        $separateWordDescription = round((10 / $count), 2);
        //Задаем параметры релевантности
        //Условия для полного запроса в названии СМП и Объекте проверки
        $relevance = "IF (`checks` . `object` LIKE '%" . $baseSearchClear . "%', 60, 0)";
        $relevance .= " + IF (`checks` . `control` LIKE '%" . $baseSearchClear . "%', 60, 0)";
        $relevance .= " + IF (`checks` . `date_start` LIKE '%" . $baseSearchClear . "%', 60, 0)";
        $relevance .= " + IF (`checks` . `date_finish` LIKE '%" . $baseSearchClear . "%', 60, 0)";
        //Условия для каждого из слов запроса в названии СМП и Объекте проверки
        foreach ($wordsSearch as $word) {
            $relevance .= " + IF (`checks` . `object` LIKE '%" . $word . "%', " . $separateWordName . ", 0)";
            $relevance .= " + IF (`checks` . `control` LIKE '%" . $word . "%', " . $separateWordDescription . ", 0)";
            $relevance .= " + IF (`checks` . `date_start` LIKE '%" . $word . "%', " . $separateWordDescription . ", 0)";
            $relevance .= " + IF (`checks` . `date_finish` LIKE '%" . $word . "%', " . $separateWordDescription . ", 0)";
        }
        $query = Check::query()
            ->select('checks.*')
            //Создается новое поле "relevance", значение которого будет устанавливаться путем выполнения условий, записанных в $relevance
            ->selectRaw("$relevance AS relevance")
            ->orderBy('relevance', 'desc')
            ->where('checks.object', 'like', '%' . $baseSearchClear . '%')
            ->orWhere('checks.date_start', 'like', '%' . $baseSearchClear . '%')
            ->orWhere('checks.date_finish', 'like', '%' . $baseSearchClear . '%')
            ->orWhere('checks.object', 'like', '%' . $wordsSearch[0] . '%');
        for ($i = 1; $i < $count; $i++) {
            $query = $query->orWhere('checks.object', 'like', $wordsSearch[$i]);
        }
        $query = $query
            ->orWhere('checks.control', 'like', '%' . $baseSearchClear . '%')
            ->orWhere('checks.control', 'like', '%' . $wordsSearch[0] . '%');
        for ($i = 1; $i < $count; $i++) {
            $query = $query->orWhere('products.control', 'like', $wordsSearch[$i]);
        }
        $checks = $query
            ->paginate(15);
        if ($checks[0] === null) {
            $checks = "По вашему запросу '$baseSearchClear' ничего не найдено";
        }
        return $checks;
    }

//    обработка поискового запроса
    public static function cleanSearchString($baseSearch)
    {
        // заменить двойные пробелы на одинарные
        $search = preg_replace('#\s+#u', ' ', $baseSearch);
        $search = trim($search);
        //Разделяем поисковый запрос на отдельные слова

        $baseWordsSearch = explode(' ', $search);
        $wordsSearch = [];
        foreach ($baseWordsSearch as $word) {
            //для латиницы
            if (preg_match('/[zA-Za]/i', $word)) {
                //если слово больше 3х букв
                if (strlen($word) > 3) {
                    if (strlen($word) > 7) {
                        $word = substr($word, 0, (strlen($word) - 2));
                        array_push($wordsSearch, $word);
                    } elseif (strlen($word) > 5) {
                        $word = substr($word, 0, (strlen($word) - 1));
                        array_push($wordsSearch, $word);
                    } else {
                        array_push($wordsSearch, $word);
                    }
                }
                //Для кирилицы
            } elseif (strlen($word) > 6) {
                //если слово больше 6х букв
                if (strlen($word) > 14) {
                    $word = substr($word, 0, (strlen($word) - 4));
                    array_push($wordsSearch, $word);
                } elseif (strlen($word) > 10) {
                    $word = substr($word, 0, (strlen($word) - 2));
                    array_push($wordsSearch, $word);
                } else {
                    array_push($wordsSearch, $word);
                }
            }
        }
        if (empty($wordsSearch)) {
            return null;
        } else {
            return array_unique($wordsSearch);
        }
    }
}
