<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function getRegisterForm()
    {
        return view('auth.register');
    }

    public function register(RegisterUserRequest $request)
    {

        $validated = $request->validated();

        /** @var User $user */
        $user = User::query()
            ->where('email', $validated['email'])
            ->first();

        if ($user) {
            return response()
                ->json(['error' => "User has been already registered, Please <a href='/login'>Login</a>"], Response::HTTP_UNAUTHORIZED);
        }

        $user = new User();
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->save();

        Auth::login($user);

        return response()->json(['status' => true], Response::HTTP_CREATED);
    }

    public function getLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginUserRequest $request)
    {

        $validated = $request->validated();
        /** @var User $user */
        $user = User::query()->where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()
                ->json(['error' => "User you are looking for not found or password is incorrect!"], Response::HTTP_UNAUTHORIZED);
        }

        Auth::login($user);

        return response()->json(['status' => true]);
    }

    public function logout(Request $request) {
        if ($user = $request->user()) {
            Auth::logout();
        }

        return redirect('/');
    }
}