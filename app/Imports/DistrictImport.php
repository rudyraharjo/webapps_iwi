<?php

namespace App\Imports;

// use App\Models\District;
use Maatwebsite\Excel\Concerns\ToModel;
use Modules\Configuration\Entities\District;

class DistrictImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return District|null
     */
    public function model(array $row)
    {
        return new District([
            'id'        => $row[0],
            'city_id'   => $row[1],
            'name'      => $row[2],
        ]);
    }
}
