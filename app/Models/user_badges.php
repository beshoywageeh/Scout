<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class user_badges extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;

    public function user()
    {
        return $this->belongsToMany(badge::class);
    }

    public function badges()
    {
        return $this->belongsToMany(User::class);
    }
}
