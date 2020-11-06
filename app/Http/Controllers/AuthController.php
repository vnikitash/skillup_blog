<?php

namespace App\Http\Controllers;


use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(RegisterUserRequest $request)
    {
        $validated = $request->validated();

        $auth = Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password']
        ]);

        if ($auth) {
            return redirect('/blogs');
        }

        die("FAILED");
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function register(RegisterUserRequest $request)
    {
        $validated = $request->validated();

        $user = new User();
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->name = $validated['email'];
        $user->save();

        $auth = Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password']
        ]);

        return redirect('/blogs');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/blogs');
    }
}