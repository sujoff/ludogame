<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSpinWheel extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'spin_wheel_id',
        'ad_spin_at'
    ];

    protected $casts = [
        'ad_spin_at' => 'datetime'
    ];
}
