<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SendInvitationEmails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $users = \App\Models\User::query()
            ->where('verified', 0)
            ->get()
            ->toArray();


        $emailData = [];

        $invitationData = array_map(function (array $user) use (&$emailData){
            $data = [
                'user_id' => $user['id'],
                'hash' => $hash = md5(time() . $user['id'] . rand(1,100))
            ];

            \Illuminate\Support\Facades\Mail::to($user['email'])->send(new \App\Mail\InvitationLinkEmail($hash));

            return $data;

        }, $users);

        \App\Models\UserVefirication::insert($invitationData);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
