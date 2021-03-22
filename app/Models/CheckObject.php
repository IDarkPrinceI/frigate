<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckObject extends Model
{
    public static function searchCheckObjects($data) //формирование выпадающего списка СМП
    {
        $objects = CheckObject::query() //формирование запроса на наличие данных с input
        ->where('name', 'like', '%' . $data . '%')
            ->get();
        if (count($objects) === 0) {
            $objects = 'Совпадений не найдено'; //если ничего не найдено
        }
        $html = view('check.includeObject', compact('objects'))->render();
        return $html;
    }


    public static function getId($request) //получение id СМП
    {
        $object_id = CheckObject::query()
            ->where('name', '=', $request->object)
            ->first();
        return $object_id;
    }


    public static function getCheckObjects() //получение СМП
    {
        $objects = CheckObject::query()
            ->get();
        return $objects;
    }
}
