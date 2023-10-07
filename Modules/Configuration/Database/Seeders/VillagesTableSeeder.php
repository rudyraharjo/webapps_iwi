<?php

namespace Modules\Configuration\Database\Seeders;

use App\Imports\VillageImport;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;

class VillagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();
        Excel::import(new VillageImport, module_path('Configuration') . '/database/seeders/csvs/villages.csv', null, \Maatwebsite\Excel\Excel::CSV);
        // $this->call("OthersTableSeeder");
    }
}
