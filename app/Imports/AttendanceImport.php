<?php

namespace App\Imports;

use App\Models\attendance;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AttendanceImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue
{
    /*    private $users;
        public function __construct()
        {
            $this->users=User::all(['id','first_name'])->pluck('id','first_name');
        }
    */
    public function model(array $row)
    {
        //$user = $this->users->where('first_name',$row['name'])->first();
        return new attendance([
            'department_id' => $row['department_id'],
            'user_id' => $row['id'],
            'admin_id' => Auth::id(),
            'attendance_date' => $row['attendance_date'],
            'status' => $row['status'],
        ]);
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
