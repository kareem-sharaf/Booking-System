<?php

namespace App\Models;

use App\Enums\ServiceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELLED = 'cancelled';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_CONFIRMED,
        self::STATUS_CANCELLED,
    ];

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_name',
        'phone',
        'booking_date',
        'service_type',
        'notes',
        'status',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'booking_date' => 'date',
        'status' => 'string',
        'service_type' => ServiceType::class,
    ];

    /**
     * Determine if the booking is confirmed.
     */
    public function isConfirmed(): bool
    {
        return $this->status === self::STATUS_CONFIRMED;
    }

    /**
     * Normalize and store the phone number.
     */
    public function setPhoneAttribute(string $value): void
    {
        $normalized = preg_replace('/\D+/', '', $value) ?? $value;
        $this->attributes['phone'] = $normalized;
    }

    /**
     * Accessor to present phone numbers in a readable format.
     */
    public function getFormattedPhoneAttribute(): string
    {
        return preg_replace('/(\d{3})(\d{3})(\d+)/', '$1-$2-$3', $this->phone);
    }
}
