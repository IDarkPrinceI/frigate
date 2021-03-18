<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithColumnWidths;

class InvoicesExport implements WithColumnWidths
{
    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 100,
            'C' => 100,
            'D' => 100,
            'E' => 10,
        ];
    }
}
