<?php

namespace Database\Seeders;

use App\Imports\TerritoryImport;
use App\Models\Territory;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class TerrirtorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Territory::truncate();
        $file = '';
        if (file_exists(public_path('/imports/seeders/territories.xlsx'))) {
            $file = '/imports/seeders/territories.xlsx';
        } elseif (file_exists(public_path('/imports/seeders/territories.xls'))) {
            $file = '/imports/seeders/territories.xls';
        }
        if ($file) {
            Excel::import(new TerritoryImport, public_path($file)); // seed qilish uchun public/excel/ file bo'lishi kerak
        } else {
            $this->command->error('territories.xlsx or territories.xls file not found, path: /public/imports/seeders/');
        }
    }
}
