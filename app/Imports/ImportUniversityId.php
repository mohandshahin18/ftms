<?php

namespace App\Imports;

use App\Models\Subsicribe;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportUniversityId implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Subsicribe([
            'name'     => $row[0],
            'university_id'    => $row[1],
        ]);
    }
}
