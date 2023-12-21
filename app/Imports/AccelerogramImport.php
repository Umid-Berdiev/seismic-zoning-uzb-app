<?php

namespace App\Imports;

use App\Models\Accelerogram;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AccelerogramImport implements WithMultipleSheets
{
    public $region_soato;

    public function __construct($region_soato)
    {
        $this->region_soato = $region_soato;
    }

    public function sheets(): array
    {
        return [
            '90%' => new AccelerogramWithAccuracyImport($this->region_soato, 90),
            '95%' => new AccelerogramWithAccuracyImport($this->region_soato, 95),
            '98%' => new AccelerogramWithAccuracyImport($this->region_soato, 98),
            '99%' => new AccelerogramWithAccuracyImport($this->region_soato, 99),
        ];
    }
}
