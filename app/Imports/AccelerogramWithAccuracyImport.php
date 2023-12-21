<?php

namespace App\Imports;

use App\Models\Accelerogram;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AccelerogramWithAccuracyImport implements ToModel, WithHeadingRow
{
    public $region_soato;
    public $accuracy;

    public function __construct($region_soato, $accuracy)
    {
        $this->region_soato = $region_soato;
        $this->accuracy = $accuracy;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        ini_set('max_execution_time', '120');
        Accelerogram::where('region_soato', $this->region_soato)
            ->where('accuracy', $this->accuracy)
            ->delete();

        return new Accelerogram([
            'region_soato' => $this->region_soato,
            'accuracy' => (int) $this->accuracy,
            't_sec_a' => $row[0] ?? null,
            'e_cm_s2' => $row[1] ?? null,
            'n_cm_s2' => $row[2] ?? null,
            'z_cm_s2' => $row[3] ?? null,
        ]);
    }

    public function headingRow(): int
    {
        return 2;
    }
}
