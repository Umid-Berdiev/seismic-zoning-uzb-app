<?php

namespace App\Imports;

use App\Models\SoilMobilePhosphorusPointer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SoilMobilePhosphorusPointerImport implements ToCollection, WithStartRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            SoilMobilePhosphorusPointer::create([
                'location_id' => 1,
                'value' => $row[0],
                'mobile_phosphorus' => $row[1],
                'area' => $row[2],
                'formed_at' => date('d-m-Y')
            ]);
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
