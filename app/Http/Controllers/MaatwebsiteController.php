<?php

namespace App\Http\Controllers;

use App\Exports\ChecksExport;
use App\Imports\ChecksImport;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class MaatwebsiteController extends Controller
{
    public function export() //экспорт результатов поиска в Excel
    {
        return Excel::download(new ChecksExport, 'checksExport.xlsx');
    }


    public function import(Request $request) //импорт записей в БД из файла Excel
    {
        $file = self::getFile($request); // получение импортируемго файла
        $request->importExcel->move(public_path(), $file); //перемещение в public
        Session::forget('excel'); // очищаем сессию от старой записи
        if ( file_exists(public_path("/$file") ) ) { // проверяем, есть ли файл для загрузки
            Excel::import(new ChecksImport(), $file); //импортируем
            unlink(public_path("/$file")); //удаляем файл
            return redirect()->route('main.index');
        }
        $error = array('Файл для импорта не обнаружен'); //записываем ошибку
        session()->flash('error', $error);
        return redirect()->route('main.index');
    }


    public static function getFile($request) // получение импортируемго файла
    {
        $extension = $request->importExcel->extension(); //расширение
        $file = self::randomName($extension); //генерируем имя
        return $file;
    }


    public static function randomName($extension) //генерация названия
    {
        $name = md5(microtime() . rand(0, 1000));
        $file = $name . '.' . $extension;
        return $file;
    }
}

