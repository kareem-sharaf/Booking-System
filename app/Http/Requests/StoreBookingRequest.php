<?php

namespace App\Http\Requests;

use App\Enums\ServiceType;
use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:20'],
            'booking_date' => ['required', 'date'],
            'service_type' => ['required', Rule::enum(ServiceType::class)],
            'notes' => ['nullable', 'string'],
            'status' => ['nullable', 'in:' . implode(',', Booking::STATUSES)],
        ];
    }

    /**
     * Sanitized and normalized payload for downstream layers.
     *
     * @return array<string, mixed>
     */
    public function validatedData(): array
    {
        $data = $this->validated();

        $data['status'] = $data['status'] ?? Booking::STATUS_PENDING;

        return $data;
    }
}
