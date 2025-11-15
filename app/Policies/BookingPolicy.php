<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->isStaff();
    }

    public function view(User $user, Booking $booking): bool
    {
        return $user->isStaff();
    }

    public function create(User $user): bool
    {
        return $user->isStaff();
    }

    public function update(User $user, Booking $booking): bool
    {
        return $user->isStaff();
    }

    public function delete(User $user, Booking $booking): bool
    {
        return $user->isStaff();
    }

    public function restore(User $user, Booking $booking): bool
    {
        return $user->isStaff();
    }

    public function forceDelete(User $user, Booking $booking): bool
    {
        return false;
    }
}