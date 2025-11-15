<?php

namespace App\DTO\Booking;

use App\Enums\ServiceType;

class StoreBookingData
{
    public function __construct(
        public readonly string $customerName,
        public readonly string $phone,
        public readonly string $bookingDate,
        public readonly ServiceType $serviceType,
        public readonly ?string $notes,
        public readonly string $status,
    ) {}

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            customerName: $payload['customer_name'],
            phone: $payload['phone'],
            bookingDate: $payload['booking_date'],
            serviceType: $payload['service_type'] instanceof ServiceType
                ? $payload['service_type']
                : ServiceType::from($payload['service_type']),
            notes: $payload['notes'] ?? null,
            status: $payload['status'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'customer_name' => $this->customerName,
            'phone' => $this->phone,
            'booking_date' => $this->bookingDate,
            'service_type' => $this->serviceType->value,
            'notes' => $this->notes,
            'status' => $this->status,
        ];
    }
}
