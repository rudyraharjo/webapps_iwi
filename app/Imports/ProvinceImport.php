<?php

namespace App\Imports;

// use App\Models\Province;
use Maatwebsite\Excel\Concerns\ToModel;
use Modules\Configuration\Entities\Province;

class ProvinceImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return Province|null
     */
    public function model(array $row)
    {
        return new Province([
            'id'    => $row[0],
            'name'  => $row[1],
        ]);
    }
}
