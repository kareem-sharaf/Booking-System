<?php

namespace App\Services\Booking;

use App\DTO\Booking\StoreBookingData;
use App\Enums\ServiceType;
use App\Models\Booking;
use App\Repositories\Booking\BookingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

class BookingService
{
    public function __construct(
        private readonly BookingRepositoryInterface $bookingRepository,
    ) {}

    public function create(array $data): Booking
    {
        $payload = $this->prepareData($data);

        return $this->bookingRepository->createBooking($payload);
    }

    public function createFromApi(StoreBookingData $data): Booking
    {
        return $this->create($data->toArray());
    }

    public function update(int $id, array $data): Booking
    {
        $payload = $this->prepareData($data);

        return $this->bookingRepository->updateBooking($id, $payload);
    }

    public function delete(int $id): bool
    {
        return $this->bookingRepository->deleteBooking($id);
    }

    /**
     * @return Collection<int, Booking>
     */
    public function list(): Collection
    {
        return $this->bookingRepository->getAllBookings();
    }

    public function getById(int $id): ?Booking
    {
        return $this->bookingRepository->findBookingById($id);
    }

    /**
     * Prepare sanitized payload before persisting.
     */
    private function prepareData(array $data): array
    {
        if (isset($data['status']) && ! in_array($data['status'], Booking::STATUSES, true)) {
            throw new InvalidArgumentException('Invalid booking status provided.');
        }

        $data['status'] = $data['status'] ?? Booking::STATUS_PENDING;

        if (isset($data['booking_date'])) {
            $data['booking_date'] = (string) $data['booking_date'];
        }

        if (isset($data['service_type'])) {
            $data['service_type'] = match (true) {
                $data['service_type'] instanceof ServiceType => $data['service_type']->value,
                default => (string) $data['service_type'],
            };
        }

        return $data;
    }
}
