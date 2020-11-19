<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function aboutMe(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

    public function update(UpdateUserRequest $request): JsonResponse
    {
        $user = $request->user();

        $validatedData = $request->validated();

        $user->email = $validatedData['email'] ?? $user->email;
        $user->name = $validatedData['name'] ?? $user->name;
        $user->password = isset($validatedData['password']) ? Hash::make($validatedData['password']) : $user->password;
        $user->save();

        return response()->json($user, Response::HTTP_ACCEPTED);
    }

    public function somePublicMethod()
    {
        return response()->json(['status' => true]);
    }
}