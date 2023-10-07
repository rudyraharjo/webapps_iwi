<?php

namespace App\Imports;

// use App\Models\City;
use Maatwebsite\Excel\Concerns\ToModel;
use Modules\Configuration\Entities\City;

class CityImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return District|null
     */
    public function model(array $row)
    {
        return new City([
            'id'            => $row[0],
            'province_id'   => $row[1],
            'name'          => $row[2],
        ]);
    }
}
