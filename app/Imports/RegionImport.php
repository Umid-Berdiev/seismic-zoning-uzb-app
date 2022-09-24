<?php

namespace App\Imports;

use App\Models\Region;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RegionImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Region([
            'soato' => $row['soato'],
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
