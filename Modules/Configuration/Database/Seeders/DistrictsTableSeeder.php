<?php

namespace Modules\Configuration\Database\Seeders;

use App\Imports\DistrictImport;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;

class DistrictsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();
        Excel::import(new DistrictImport, module_path('Configuration') . '/database/seeders/csvs/districts.csv', null, \Maatwebsite\Excel\Excel::CSV);
        // $this->call("OthersTableSeeder");
    }
}
