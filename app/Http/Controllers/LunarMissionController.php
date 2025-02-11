<?php

namespace App\Http\Controllers;

use App\Http\Requests\LunarMissionRequest;
use App\Http\Resources\LunarMissionResource;
use App\Http\Resources\SearchMissionResource;
use App\Models\LunarMission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class LunarMissionController extends Controller
{
    public function store(LunarMissionRequest $request):JsonResponse {
        $user = auth()->user();
        $user->lunarMissions()->create($request->validated()['mission']);

        return response()->json([
            'data' => [
                'code' => 201,
                'message' => 'Миссия добавлена',
            ],
        ], 201);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection {
        return LunarMissionResource::collection(LunarMission::query()->get());
    }

    public function show(LunarMission $id):JsonResponse {
        $user = auth()->user();
        $missionToShow = $user->lunarMissions()->findOrFail($id->id);
        return response()->json([
            'mission' => [
//                'author' => $missionToShow->author,
                'id' => $missionToShow->id,
                'name' => $missionToShow->name,
                'launch_details' => $missionToShow->launch_details,
                'landing_details' => $missionToShow->landing_details,
                'spacecraft' => $missionToShow->spacecraft,
            ]
        ]);
    }

    /**
     * @param LunarMission $id
     * @return Response
     */
    public function destroy(LunarMission $id): Response {
        $user = auth()->user();
        $missionToDelete = $user->lunarMissions()->findOrFail($id->id);
        $missionToDelete->delete();

        return response()->noContent();
    }


    public function update(LunarMissionRequest $request, LunarMission $id): array {
        $id->update($request->validated(['mission']));
        return [
            'data' => [
                'code' => 200,
                'message' => 'Миссия обновлена',
            ],
        ];
    }

    public function search() : AnonymousResourceCollection
    {
        $query = request()->input('query', '');

        return SearchMissionResource::collection(LunarMission::query()
            ->where('name', 'like', "%" . $query . "%")
            ->orWhere('spacecraft', 'like', "%" . $query . "%")
            ->get());
    }
}
