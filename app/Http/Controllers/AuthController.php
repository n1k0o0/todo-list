<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @throws Exception
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::query()->where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return $this->respondUnauthorized('The provided credentials are incorrect.');
        }

        $token = $user->createToken($request->input('device_name') || $user->name)->plainTextToken;
        return $this->respondWithToken($token);
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function getMe(): JsonResponse
    {
        return $this->respondSuccess(UserResource::make(auth()->user()));
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()?->currentAccessToken()->delete();
        return $this->respondEmpty();
    }
}
