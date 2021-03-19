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
        Session::forget('excel');
        Excel::import(new ChecksImport(), 'checksImport.xlsx');

        return redirect()->route('main.index');
    }

}

