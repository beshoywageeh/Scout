<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param  array  $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        //   $name = explode(" ", $row['name']);
        //dd($name);
        return new User([
            'code' => $row['id'],
            'department_id' => $row['department_id'],
            'first_name' => $row['name'],
            'address' => $row['address'],
            'birth_date' => $row['birth_date'],
            'phone_number' => $row['phone_number'],
            'home_number' => $row['home_number'],
            'deleted_at' => $row['deleted_at'],
            'church_father' => $row['church_father'],

        ]);
    }
}
