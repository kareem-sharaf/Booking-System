<?php

namespace App\Filament\Resources\Bookings;

use App\Enums\ServiceType;
use App\Filament\Resources\Bookings\Pages\CreateBooking;
use App\Filament\Resources\Bookings\Pages\EditBooking;
use App\Filament\Resources\Bookings\Pages\ListBookings;
use App\Filament\Resources\Bookings\Pages\ViewBooking;
use App\Filament\Resources\Bookings\Schemas\BookingForm;
use App\Filament\Resources\Bookings\Tables\BookingsTable;
use App\Models\Booking;
use App\Repositories\Booking\BookingRepositoryInterface;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'customer_name';

    protected static string|UnitEnum|null $navigationGroup = 'Operations';

    public static function form(Schema $schema): Schema
    {
        return BookingForm::configure(
            schema: $schema,
            serviceTypes: self::serviceTypeOptions(),
            statusOptions: self::statusOptions(),
        );
    }

    public static function table(Table $table): Table
    {
        return BookingsTable::configure(
            table: $table,
            statusOptions: self::statusOptions(),
            statusColorMap: self::statusColorMap(),
        );
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookings::route('/'),
            'create' => CreateBooking::route('/create'),
            'edit' => EditBooking::route('/{record}/edit'),
            'view' => ViewBooking::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return app(BookingRepositoryInterface::class)
            ->getBookingsQuery()
            ->latest('booking_date');
    }

    public static function statusOptions(): array
    {
        return collect(Booking::STATUSES)
            ->mapWithKeys(fn(string $status) => [$status => ucfirst($status)])
            ->all();
    }

    public static function statusColorMap(): array
    {
        return [
            Booking::STATUS_PENDING => 'warning',
            Booking::STATUS_CONFIRMED => 'success',
            Booking::STATUS_CANCELLED => 'danger',
        ];
    }

    public static function serviceTypeOptions(): array
    {
        return ServiceType::options();
    }
}
