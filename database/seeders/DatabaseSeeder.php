<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Configuration\Database\Seeders\CitiesTableSeeder;
use Modules\Configuration\Database\Seeders\DistrictsTableSeeder;
use Modules\Configuration\Database\Seeders\ProvincesTableSeeder;
use Modules\Configuration\Database\Seeders\VillagesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // $this->call(LaratrustSeeder::class);
        $this->call(SetUserTeamAndRolePermissions::class);
        $this->call(ProvincesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(DistrictsTableSeeder::class);
        $this->call(VillagesTableSeeder::class);
    }
}
