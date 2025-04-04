<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = [
        'collection_id',
        'day',
        'cycle'
    ];

    protected $casts = [
        'day' => 'int',
        'cycle' => 'int'
    ];

    public function collection(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }
}
