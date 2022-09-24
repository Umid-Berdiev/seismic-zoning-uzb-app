<?php

namespace Database\Seeders;

use App\Imports\RegionImport;
use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Region::truncate();

        $file = '';

        if (file_exists(public_path('/seeders/regions.xlsx'))) {
            $file = '/seeders/regions.xlsx';
        } elseif (file_exists(public_path('/seeders/regions.xls'))) {
            $file = '/seeders/regions.xls';
        }
        if ($file) {
            Excel::import(new RegionImport, public_path($file)); // seed qilish uchun public/excel/ file bo'lishi kerak
        } else {
            $this->command->error('regions.xlsx or regions.xls file not found, path: /public/seeders/');
        }
    }
}
