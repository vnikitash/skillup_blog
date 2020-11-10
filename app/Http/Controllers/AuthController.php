<?php

namespace App\Http\Controllers;


use App\Http\Requests\RegisterUserRequest;
use App\Mail\InvitationLinkEmail;
use App\Models\User;
use App\Models\UserVefirication;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(RegisterUserRequest $request)
    {
        $validated = $request->validated();

        $unverfiedUser = User::query()
            ->where('email', $validated['email'])
            ->where('verified', 0)
            ->first();

        if ($unverfiedUser) {
            die("Check email for invitation link!");
        }

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

        $uv = new UserVefirication();
        $uv->user_id = $user->id;
        $uv->hash = md5(time() . $user->id);
        $uv->save();

        Mail::to($user)->send(new InvitationLinkEmail($uv->hash));

        /*$auth = Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password']
        ]);*/

        die("Check your email!");

        return redirect('/blogs');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/blogs');
    }
}