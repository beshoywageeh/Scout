<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public function __construct(int $department_id)
    {
        $this->department_id = $department_id;
    }

    public function query()
    {
        $user = User::query()->where('department_id', $this->department_id)->orderby('first_name', 'asc');

        return $user;
    }

    public function headings(): array
    {
        return [
            'كود',
            'الاسم',
            'العنوان',
            'التليفون الشخصي',
            'تليفون البيت',
            'أب الاعتراف',
            'تاريخ الميلاد',
        ];
    }

    public function map($user): array
    {
        return [
            $user->code,
            $user->first_name.' '.$user->second_name.' '.$user->third_name.' '.$user->forth_name,
            $user->address,
            $user->phone_number,
            $user->home_number,
            $user->church_father,
            $user->birth_date,

        ];
    }
}
