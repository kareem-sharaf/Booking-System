<?php

namespace App\Filament\Resources\Bookings\Tables;

use App\Enums\ServiceType;
use App\Models\Booking;
use App\Services\Booking\BookingService;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookingsTable
{
    public static function configure(Table $table, array $statusOptions, array $statusColorMap): Table
    {
        return $table
            ->recordTitleAttribute('customer_name')
            ->columns([
                TextColumn::make('customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable(),
                TextColumn::make('booking_date')
                    ->label('Booking date')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
                TextColumn::make('service_type')
                    ->label('Service')
                    ->formatStateUsing(function ($state): string {
                        $enum = $state instanceof ServiceType ? $state : ServiceType::from((string) $state);

                        return $enum->label();
                    })
                    ->badge()
                    ->color('info')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn(string $state) => ucfirst($state))
                    ->badge()
                    ->color(fn(string $state) => $statusColorMap[$state] ?? 'gray'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options($statusOptions),
                Filter::make('booking_date_range')
                    ->form([
                        DatePicker::make('from')->label('From'),
                        DatePicker::make('until')->label('Until'),
                    ])
                    ->query(fn(Builder $query, array $data): Builder => $query
                        ->when($data['from'] ?? null, fn($q, $date) => $q->whereDate('booking_date', '>=', $date))
                        ->when($data['until'] ?? null, fn($q, $date) => $q->whereDate('booking_date', '<=', $date))),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->using(function (Booking $record) {
                        app(BookingService::class)->delete((int) $record->getKey());
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $service = app(BookingService::class);
                            $records->each(fn(Booking $booking) => $service->delete((int) $booking->getKey()));
                        }),
                ]),
            ]);
    }
}
