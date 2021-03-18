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
        return Excel::download(new ChecksExport, 'checks.xlsx');
    }

    public function import()
    {
        Session::forget('excel');
        Excel::import(new ChecksImport(), 'checks (2).xlsx');

        return redirect()->route('main.index')->with('success', 'All good!');
    }

}

