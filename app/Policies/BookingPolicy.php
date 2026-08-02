<?php


namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{

    public function viewAny(User $user): bool
    {
        return false;
    }


    public function view(User $user, Booking $booking): bool
    {
        return false;
    }


    public function create(User $user): bool
    {
        return false;
    }


    public function update(User $user, Booking $booking): bool
    {
        return false;
    }

    public function delete(User $user, Booking $booking): bool
    {
        return false;
    }


    public function restore(User $user, Booking $booking): bool
    {
        return false;
    }


    public function forceDelete(User $user, Booking $booking): bool
    {
        return false;
    }
}
