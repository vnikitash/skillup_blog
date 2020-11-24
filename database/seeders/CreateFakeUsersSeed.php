<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateFakeUsersSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [];

        $now = new Carbon();

        for ($i = 0; $i < 100; $i++) {
            $users[] = [
                'email' => 'fake' . $i . '@localhost',
                'name' => 'fake' . $i . '@localhost',
                'password' => Hash::make('fake' . $i . '@localhost'),
                'token' => $i,
                'created_at' => $now,
                'updated_at' => $now
            ];
        }

        User::insert($users);
    }
}
