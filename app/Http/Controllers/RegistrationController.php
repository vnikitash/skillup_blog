<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;

class RegistrationController extends Controller
{
    public function index()
    {
        $html = "
        <form action='/register' method='POST'>
            <input type='text' name='email' placeholder='email'>
            <input type='password' name='password' placeholder='password'>
            <input type='submit' value='register'>
        </form>";

        die($html);
    }

    public function store(RegisterUserRequest $request)
    {
        $validated = $request->validated();

        die("I WILL TRY TO REGISTER USER WITH EMAIL: {$validated['email']} AND PASS: {$validated['password']}");
    }
}