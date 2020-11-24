<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        /** @var User|null $user */
        $user = User::query()
            ->where('email', $validatedData['email'])
            ->first();

        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return response()->json([
                'error' => 'Credentials are incorrect or account does not exist!'
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json($user, Response::HTTP_OK);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $token = md5(rand(1,100000)) . md5(time());

        $validatedData = $request->validated();

        $user = new User();
        $user->token = $token;
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        $user->name = $validatedData['name'];
        $user->save();

        return response()->json($user, Response::HTTP_CREATED);
    }

    public function refresh(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        $user->token = md5(rand(1,100000)) . md5(time());
        $user->save();

        return response()->json(['token' => $user->token], Response::HTTP_ACCEPTED);
    }

    public function logout(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        $user->token = md5(rand(1,100000)) . md5(time());
        $user->save();

        return response()->json(['status' => true], Response::HTTP_ACCEPTED);
    }
}