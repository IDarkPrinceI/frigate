<?php

namespace App\Http\Controllers;

use App\Exports\ChecksExport;
use App\Imports\ChecksImport;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class MaatwebsiteController extends Controller
{
    public function export() //экспорт результатов поиска в Excel
    {
        return Excel::download(new ChecksExport, 'checksExport.xlsx');
    }

    public function import() //импорт записей в БД из файла Excel
    {
        Session::forget('excel'); // очищаем сессию от старой записи
        if ( file_exists(public_path('/checksImport.xlsx') ) ) { // проверяем, есть ли файл для загрузки
            Excel::import(new ChecksImport(), 'checksImport.xlsx'); //импортируем
            return redirect()->route('main.index');
        }
        $error = array('Файл checksImport.xlsx для импорта не обнаружен'); //записываем ошибку
        session()->flash('error', $error);
        return redirect()->route('main.index');

    }

}

