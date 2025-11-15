<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use App\Services\Booking\BookingService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->requiresConfirmation(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return $this->resolveBookingService()->update((int) $record->getKey(), $data);
    }

    protected function handleRecordDeletion(Model $record): void
    {
        $this->resolveBookingService()->delete((int) $record->getKey());
    }

    private function resolveBookingService(): BookingService
    {
        return app(BookingService::class);
    }
}
