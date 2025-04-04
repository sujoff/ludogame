<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineTable extends Model
{
    /** @use HasFactory<\Database\Factories\OnlineTableFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'entry_cost',
        'prizes',
        'xps',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'entry_cost' => 'float',
        'prizes' => 'array',
        'xps' => 'array',
    ];
}
