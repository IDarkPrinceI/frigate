<?php

namespace App\Imports;

use App\Models\Check;
use App\Models\CheckObject;
use App\Models\Control;
use Maatwebsite\Excel\Concerns\ToCollection;

class ChecksImport implements ToCollection
{
    public function collection($rows) //импорт Excel
    {
        $countWrite = 0; //счетчик импортированных записей
        $countOverlapping = 0; //счетчик дублирующих записей
        $rows->forget(0); //удалить из импортированной таблицы заголовки
        $errors = []; //массив с ошибками

        foreach ($rows as $row) { //перебор коллекции для id элементов
            $object = self::getRecord(CheckObject::class, 'name', $row[1]); //получение id объекта
            if ( empty($object) ) { //если запись с таким названием не найдена прерываем итерацию, записываем ошибку
                array_push($errors, " Строка №$row[0]. Название проверяемого объекта \"$row[1]\" не найдено в базе. Эта запись не была импортирована.");
                continue;
            }
            $control = self::getRecord(Control::class, 'title', $row[2]); //получение id объекта
            if ( empty($control) ) { //если запись с таким названием не найдена прерываем итерацию, записываем ошибку
                array_push($errors," Строка №$row[0]. Название контролирующего органа \"$row[2]\" не найдено в базе. Эта запись не была импортирована.");
                continue;
            }

            if ( empty( self::getTryString($object, $control, $row) ) ) { //если проверка не найдена, создается новая запись
                $newCheck = new Check;
                $newCheck->object_id = $object->id;
                $newCheck->control_id = $control->id;
                $newCheck->date_start = $row[3];
                $newCheck->date_finish = $row[4];
                $newCheck->lasting = $row[5];
                $newCheck->save();
                $countWrite++; //увеличиваем счетчик импортированных записей
            } else { //если проверка найдена, создается запись о дублировании
                $countOverlapping++; //увеличиваем счетчик дублирующих записей
                array_push($errors, " Дублирующая строка №$row[0].");
            }
        } // запись флеш сообщений
        if ($countOverlapping !== 0) { //если есть дублирующие записи
            array_push($errors, " Импортируемый файл содержит \"$countOverlapping\" дублирующих записей. Эти записи не были импортированы.");
        }
        if ($countWrite !==0) { //если есть удачно импортированные записи
            session()->flash('success', " Успешно импортированно $countWrite записей(сь).");
        }
        if (!empty($errors) ) { //если есть ошибки
            session()->flash('error', $errors);
        }
    }

    public function getRecord($model, $column, $object) //нахождение записи
    {
        $record = $model::query()
            ->where($column, '=', $object)
            ->first();
        return $record;
    }


    public function getTryString($object, $control, $row)
    {
        $check = Check::query() // поиск записи в БД на совпадения целой строки из импортированного файла
        ->where([
            ['object_id', '=', $object->id],
            ['control_id', '=', $control->id],
            ['date_start', '=', $row[3]],
            ['date_finish', '=', $row[4]],
            ['lasting', '=', $row[5]],
        ])
            ->first();
        return $check;
    }
}
