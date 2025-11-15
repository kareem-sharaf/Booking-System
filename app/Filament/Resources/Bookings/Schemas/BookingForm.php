<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Enums\ServiceType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema, array $serviceTypes, array $statusOptions): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('customer_name')
                    ->label('Customer name')
                    ->maxLength(120)
                    ->required(),
                TextInput::make('phone')
                    ->label('Phone')
                    ->mask('999-999-9999')
                    ->required(),
                DateTimePicker::make('booking_date')
                    ->label('Booking date')
                    ->seconds(false)
                    ->native(false)
                    ->required(),
                Select::make('service_type')
                    ->label('Service type')
                    ->options($serviceTypes)
                    ->searchable()
                    ->default(array_key_first($serviceTypes))
                    ->formatStateUsing(fn($state) => $state instanceof ServiceType ? $state->value : $state)
                    ->dehydrateStateUsing(fn($state) => $state instanceof ServiceType ? $state->value : $state)
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->options($statusOptions)
                    ->default(array_key_first($statusOptions))
                    ->required(),
                Textarea::make('notes')
                    ->label('Notes')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}
