<?php

namespace App\Repositories\Booking;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class BookingRepository implements BookingRepositoryInterface
{
    public function __construct(
        private readonly Booking $model,
    ) {
    }

    public function createBooking(array $data): Booking
    {
        return $this->model->newQuery()->create($data);
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getAllBookings(): Collection
    {
        return $this->getBookingsQuery()
            ->orderByDesc('booking_date')
            ->get();
    }

    public function getBookingsQuery(): Builder
    {
        return $this->model->newQuery();
    }

    public function findBookingById(int $id): ?Booking
    {
        return $this->getBookingsQuery()->find($id);
    }

    public function updateBooking(int $id, array $data): Booking
    {
        $booking = $this->getBookingsQuery()->findOrFail($id);

        $booking->fill($data);
        $booking->save();

        return $booking;
    }

    public function deleteBooking(int $id): bool
    {
        return (bool) $this->getBookingsQuery()->whereKey($id)->delete();
    }
}
