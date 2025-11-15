<?php

namespace App\Http\Controllers\Api;

use App\DTO\Booking\StoreBookingData;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use App\Services\Booking\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class BookingApiController extends Controller
{
    public function __construct(
        private readonly BookingService $bookingService,
    ) {}

    public function store(StoreBookingRequest $request): JsonResponse
    {
        $dto = StoreBookingData::fromArray($request->validatedData());

        try {
            $booking = $this->bookingService->createFromApi($dto);

            return (new BookingResource($booking))
                ->additional(['success' => true])
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to create booking at the moment.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
