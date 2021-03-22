<?php

namespace App\Exports;

use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;

class ChecksExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection() //экспорт Excel
    {
        $checks = Session::get('search');
        return $checks;
    }
}
