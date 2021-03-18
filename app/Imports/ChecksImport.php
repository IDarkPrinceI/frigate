<?php

namespace App\Imports;

use App\Models\Check;
use App\Models\CheckObject;
use App\Models\Control;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToCollection;

class ChecksImport implements ToCollection
{
    public function collection($rows) //импорт Excel
    {
        $countWrite = 0; //счетчик импортированных записей
        $countOverlapping = 0; //счетчик дублирующих записей
        $i = 0; //переменная для записи ошибок
        $rows->forget(0); //удалить из импортированной таблицы заголовки

        foreach ($rows as $row) { //перебор коллекции для id элементов
            $object = CheckObject::query()
                ->where('name', '=', $row[1])
                ->first();
            if ( empty($object) ) { //если запись с таким названием не найдена
                Session::put("excel.error.$i", "Импортируемый файл содержит ошибки в строке №\"$row[0]\" в названии проверяемого объекта \"$row[1]\". Эта запись не была импортирована");
                $i++;
                continue;
            }
            $control = Control::query()
                ->where('title', '=', $row[2])
                ->first();
            if ( empty($control) ) {
                Session::put("excel.error.$i", "Импортируемый файл содержит ошибки в строке №\"$row[0]\" в названии контролирующего органа \"$row[2]\". Эта запись не была импортирована");
                $i++;
                continue;
            }
            $date_start = $row[3];
            $date_finish = $row[4];
            $lasting = $row[5];
            $check = Check::query() // поиск проверки на совпадения целой строки из импортированного файла
                ->where([
                    ['object_id', '=', $object->id],
                    ['control_id', '=', $control->id],
                    ['date_start', '=', $date_start],
                    ['date_finish', '=', $date_finish],
                    ['lasting', '=', $lasting],
                ])
                ->first();
            if (empty($check)) { //если проверка не найдена, создается новая запись
                $newCheck = new Check;
                $newCheck->object_id = $object->id;
                $newCheck->control_id = $control->id;
                $newCheck->date_start = $row[3];
                $newCheck->date_finish = $row[4];
                $newCheck->lasting = $row[5];
                $newCheck->save();
                $countWrite++;
            } else { //если проверка найдена, создается запись о дублировании
                $countOverlapping++;
                Session::put('excel.overlapping.total', "Импортируемый файл содержит \"$countOverlapping\" дублирующих записей. Эти записи не были импортированы");
                Session::put("excel.overlapping.$row[0]", "Дублирующая строка №$row[0].");
            }
        }
        Session::put('excel.count', $countWrite); // сохранение количесва импортированных зайписей
    }
}
