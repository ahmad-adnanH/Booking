<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'room_number',
        'name',
        'capacity',
        'floor',
        'status',
    ];


    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }


    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
