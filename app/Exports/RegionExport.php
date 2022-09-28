<?php

namespace App\Exports;

use App\Models\Region;
use Maatwebsite\Excel\Concerns\FromCollection;

class RegionExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Region::select('soato', 'name_uz', 'name_ru', 'admincenter_uz', 'admincenter_ru')->orderBy('id')->get();
    }
}
