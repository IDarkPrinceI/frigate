<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    public static function searchControls($data) //формирование выпадающего списка контролей
    {
        $controls = Control::query() //формирование запроса на наличие данных с input
        ->where('title', 'like', '%' . $data . '%')
            ->get();
        if (count($controls) === 0) {
            $controls = 'Совпадений не найдено'; //если ничего не найдено
        }
        $html = view('check.includeControl', compact('controls'))->render();
        return $html;
    }


    public static function getId($request) //получение id Контроля
    {
        $control_id = Control::query()
            ->where('title', '=', $request->control)
            ->first();
        return $control_id;
    }


    public static function getControls() //Контроли для выпадающего списка
    {
        $controls = Control::query()
            ->get();
        return $controls;
    }
}
