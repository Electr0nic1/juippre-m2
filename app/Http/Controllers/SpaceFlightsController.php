<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpaceFlightsRequest;
use App\Models\SpaceFlights;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SpaceFlightsController extends Controller
{
    /**
     * @param SpaceFlightsRequest $request
     * @return JsonResponse
     */
    public function store(SpaceFlightsRequest $request):JsonResponse {
        $user = auth()->user();
        $user->spaceFlights()->create($request->validated());

        return response()->json([
            'data' => [
                'code' => 201,
                'message' => 'Космический полет создан'
            ]
        ], 201);
    }


    public function index(): array {
        return [
            'data' => Spaceflights::query()->get()->map(function (SpaceFlights $flight ) {
                return [
                    'flight_number' => $flight->flight_number,
                    'destination' => $flight->destination,
                    'launch_date' => $flight->launch_date,
                    'seats_available' => $flight->seats_available - $flight->books()->count(),
                ];
            })
        ];
    }

    public function book(Request $request):JsonResponse {
        $flightNumber = $request->input("flight_number");

        $spaceFlight = SpaceFlights::query()
        ->where('flight_number', $flightNumber)
        ->first();

        if (!$spaceFlight) {
            throw new NotFoundHttpException();
        }

        if ($spaceFlight->seats_available <= $spaceFlight->books()->count()) {
            throw new AccessDeniedHttpException();
        }

        $spaceFlight->books()->create([
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'data' => [
                'code' => 201,
                'message' => 'Рейс забронирован'
            ]
        ], 201);

    }
}
