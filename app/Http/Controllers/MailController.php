<?php

namespace App\Http\Controllers;


use App\Mail\AdvertisementEmail;
use App\Mail\HelloEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class MailController
{
    public function index()
    {
        $users = User::query()->get();

        /** @var User $user */
        foreach ($users as $user) {
            try {
                $mailable = new HelloEmail($user);
                Mail::to($user)->send($mailable);
            } catch (\Exception $e) {
                dd($e->getMessage());
            }
        }
    }
}