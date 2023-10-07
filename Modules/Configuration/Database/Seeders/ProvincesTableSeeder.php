<?php

namespace Modules\Configuration\Database\Seeders;

use App\Imports\ProvinceImport;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();
        Excel::import(new ProvinceImport, module_path('Configuration').'/database/seeders/csvs/provinces.csv', null, \Maatwebsite\Excel\Excel::CSV);
        // $this->call("OthersTableSeeder");
    }
}
