<?php

namespace App\Http\Controllers;


use App\Jobs\SimpleJob;
use App\Models\User;

class JobController
{
    public function index()
    {

        $users = User::query()->get();

        for ($i = 0; $i < 10; $i++) {
            foreach ($users as $user) {
                $job = new SimpleJob($user->email);
                dispatch($job)->onQueue('email');
            }
        }

        die("DONE!");
    }
}

//?hash=abcasdasda123123