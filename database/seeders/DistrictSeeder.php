<?php

namespace Database\Seeders;

use App\Imports\DistrictImport;
use App\Models\District;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        District::truncate();

        $file = '';

        if (file_exists(public_path('/seeders/districts.xlsx'))) {
            $file = '/seeders/districts.xlsx';
        } elseif (file_exists(public_path('/seeders/districts.xls'))) {
            $file = '/seeders/districts.xls';
        }
        if ($file) {
            Excel::import(new DistrictImport, public_path($file)); // seed qilish uchun public/excel/ file bo'lishi kerak
        } else {
            $this->command->error('districts.xlsx or districts.xls file not found, path: /public/seeders/');
        }
    }
}
