<?php

namespace Modules\Configuration\Database\Seeders;

use App\Imports\CityImport;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();

        Excel::import(new CityImport, module_path('Configuration').'/database/seeders/csvs/cities.csv', null, \Maatwebsite\Excel\Excel::CSV);
        
        // $this->call("OthersTableSeeder");
    }
}
