<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for ($i = 0; $i < 5; $i++) {
           User::create([
                'name'               => $faker->name,
                'email'              => $faker->email,
                'password'           => Hash::make('user123456'),
                'regis_with'         => "email",
                'profil_picture'     => "user-default.png",
                'email_verified_at'  => now(),
            ]);
        }
    }
}
