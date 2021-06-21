<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->email = "user@gmail.com";
        $user->password = Hash::make('user123456');
        $user->regis_with = "email";
        $user->save();

        $user = new User;
        $user->name = "Ari Cahyono";
        $user->email = "cahyono.ari80@gmail.com";
        $user->regis_with = "google";
        $user->save();
    }
}
