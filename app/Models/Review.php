<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'classroom_id',
        'reservation_id',
        'rating',
        'comment',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }


    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
}
