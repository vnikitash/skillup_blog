<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function index()
    {
        $html = "
        ";

        die($html);
    }

    public function store(RegisterUserRequest $request)
    {
        $validated = $request->validated();

        $user = new User();
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->name = $validated['email'];
        $user->save();

        dd($user);
    }
}