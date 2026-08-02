<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

   protected $fillable = [
        'user_id',
        'hall_id',
        'booking_date',
        'start_time',
        'end_time',
        'reason',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hall(): BelongsTo
    {
        return $this->belongsTo(Hall::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }
}
