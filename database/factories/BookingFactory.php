<?php

namespace Database\Factories;

use App\Enums\ServiceType;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_name' => $this->faker->name(),
            'phone' => $this->faker->numerify('05########'),
            'booking_date' => $this->faker->dateTimeBetween('+1 day', '+2 months')->format('Y-m-d'),
            'service_type' => $this->faker->randomElement(ServiceType::cases())->value,
            'notes' => $this->faker->optional()->sentence(),
            'status' => $this->faker->randomElement(Booking::STATUSES),
        ];
    }
}
