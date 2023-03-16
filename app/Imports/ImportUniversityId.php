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
            'student_id'     => $row[1],
            'specialization_id'     => $row[2],
            'university_id'    => $row[3],
        ]);
    }
}
