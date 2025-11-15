<?php

namespace App\Enums;

enum ServiceType: string
{
    case Haircut = 'Haircut';
    case Massage = 'Massage';
    case Cleaning = 'Cleaning';
    case Consultation = 'Consultation';
    case FacialTreatment = 'Facial Treatment';

    public function label(): string
    {
        return match ($this) {
            self::Haircut => 'Haircut',
            self::Massage => 'Massage',
            self::Cleaning => 'Cleaning',
            self::Consultation => 'Consultation',
            self::FacialTreatment => 'Facial Treatment',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn(self $case) => [$case->value => $case->label()])
            ->all();
    }
}
