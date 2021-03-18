<?php

namespace App\Exports;

use App\Models\Check;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;

class ChecksExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $checks = Session::get('search');
        return $checks;
    }
}
