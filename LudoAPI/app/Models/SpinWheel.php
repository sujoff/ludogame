<?php

namespace App\Models;

use App\Models\Scopes\SpinWheelDateScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpinWheel extends Model
{
    use HasFactory;

    protected $fillable = [
        'collection_id',
        'start_date',
        'end_date',
        'index'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'index' => 'integer'
    ];

    public function collection(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    public function scopeActiveWheel($query, $date): \Illuminate\Database\Eloquent\Builder
    {
        $scope = new SpinWheelDateScope();
        return $scope->apply($query);
    }
}
