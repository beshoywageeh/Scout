<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function department()
    {
        return $this->belongsTo(department::class, 'department_id');
    }

    public function badges()
    {
        return $this->belongsToMany(badge::class, 'user_badges', 'user_id');
    }

    public function attendance()
    {
        return $this->HasMany(attendance::class, 'user_id');
    }

    public function notes()
    {
        return $this->HasMany(Notes::class, 'user_id');
    }

    public function archive_check()
    {
        if ($this->deleted_at != null) {
            return '<span class="badge badge-danger">أرشيف</span>';
        }
    }

    public function black_list_check()
    {
        if ($this->black_list == 1) {
            return '<span class="badge badge-black">بلاك ليست</span>';
        }
    }

    public function full_name()
    {
        return    $this->first_name.' '.$this->second_name.' '.$this->third_name.' '.$this->fourth_name;
    }

    public function count_status($from, $to, $id, $department_id)
    {
        $data['came'] = attendance::where('user_id', $id)->where('department_id', $department_id)
            ->whereBetween('attendance_date', [$from, $to])
            ->where('status', '1')->count();
        $data['absent'] = attendance::where('user_id', $id)->where('department_id', $department_id)
            ->whereBetween('attendance_date', [$from, $to])
            ->where('status', '2')->count();
        $data['e3tezar'] = attendance::where('user_id', $id)->where('department_id', $department_id)
            ->whereBetween('attendance_date', [$from, $to])
            ->where('status', '3')->count();
        print_r('<td>' . $data['came'] . '</td>');
        print_r('<td>' . $data['absent'] . '</td>');
        print_r('<td>' . $data['e3tezar'] . '</td>');
    }
    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}