<?php

namespace App\Imports;

use App\Models\District;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DistrictImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new District([
            'soato' => $row['soato'],
            'region_soato' => $row['region_soato'],
            'name_uz' => $row['name_uz'],
            'name_ru' => $row['name_ru'],
            'admincenter_uz' => $row['admincenter_uz'],
            'admincenter_ru' => $row['admincenter_ru']
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
