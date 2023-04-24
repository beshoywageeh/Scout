<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class attendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'department_id', 'admin_id', 'attendance_date', 'status'];

    public function department()
    {
        return $this->belongsTo(department::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'code');
    }

    public function status_check($status_code)
    {
        if ($status_code == '1') {
            print_r('<td class="alert alert-success">حضور</td>');
        } elseif ($status_code == '2') {
            print_r('<td class="alert alert-danger">غياب</td>');
        } elseif ($status_code == '3') {
            print_r('<td class="alert alert-warning">عذر</td>');
        } else {
            print_r('<td class="alert alert-info">جديد</td>');
        }
    }

    public function get_full_name($key)
    {
        $data = User::where('code', $key)->first();
        if (is_null($data)) {
            $full_name = 'no';
        } else {
            $full_name = $data->first_name.' '.$data->second_name.' '.
            $data->third_name.' '.$data->fourth_name;
        }

        return $full_name;
    }
}
