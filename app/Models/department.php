<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function badges()
    {
        return $this->hasMany(Badge::class, 'department_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'department_id')->orderby('first_name', 'asc');
    }

    public function attendance()
    {
        return $this->hasMany(attendance::class, 'department_id');
    }
}
