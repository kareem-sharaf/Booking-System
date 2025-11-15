<?php

namespace App\Repositories\Booking;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

interface BookingRepositoryInterface
{
    public function createBooking(array $data): Booking;

    /**
     * @return Collection<int, Booking>
     */
    public function getAllBookings(): Collection;

    public function getBookingsQuery(): Builder;

    public function findBookingById(int $id): ?Booking;

    public function updateBooking(int $id, array $data): Booking;

    public function deleteBooking(int $id): bool;
}
