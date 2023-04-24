<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class UsersExport implements FromQuery
{
    use Exportable;

    public function __construct(int $department_id)
    {
        $this->department_id = $department_id;
    }

    public function query()
    {
        return User::query()->where('department_id', $this->department_id);
    }
}
