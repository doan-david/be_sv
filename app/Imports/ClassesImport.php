<?php

namespace App\Imports;

use App\Models\ClassName;
use Maatwebsite\Excel\Concerns\ToModel;

class ClassesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ClassName([
            'code' => $row[0],
            'name' => $row[1],
            'advisor' => $row[2],
            'description' => $row[3],
        ]);
    }

    public function rules(): array
    {
        return [
            'code' => 'required',
            'name' => 'required',
            'advisor' => 'required',
            'description' => 'required',
        ];
    }
}
