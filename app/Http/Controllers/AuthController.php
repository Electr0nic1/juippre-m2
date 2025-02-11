<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    /**
     * @param RegistrationRequest $request
     * @return JsonResponse
     */
    public function registration(RegistrationRequest $request):JsonResponse {
        $user = User::query()->create($request->validated());
        return response()->json([
            'data' => [
                'user' => [
                    'name' => $user->full_name,
                    'email' => $user->email,
                ],
                'code' => 201,
                'message' => 'Пользователь создан'
            ]
        ], 201);
    }

    /**
     * @param AuthRequest $request
     * @return JsonResponse
     */
    public function authorization(AuthRequest $request): JsonResponse {
        if (auth()->attempt($request->validated())) {
            return response()->json([
                'data' => [
                    'user' => [
                        'id' => auth()->user()->id,
                        'name' => auth()->user()->firstFullName,
                        'birth_date' => auth()->user()->birth_date,
                        'email' => auth()->user()->email,
                    ],
                    'token' => auth()->user()->createToken('api')->plainTextToken,
                ]
            ]);
        }
        return response()->json([
            'code' => 401,
            'message' => 'Login failed'
        ], 401);
    }

    /**
     * @return Response
     */
    public function logout():Response{
        auth()->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
}
