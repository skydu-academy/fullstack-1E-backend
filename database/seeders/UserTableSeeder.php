<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        // $faker = Faker::create('id_ID');
        // for ($i = 0; $i < 5; $i++) {
        //    User::create([
        //         'name'               => $faker->name,
        //         'email'              => $faker->email,
        //         'password'           => Hash::make('user123456'),
        //         'regis_with'         => "email",
        //         'profil_picture'     => "user-default.png",
        //         'email_verified_at'  => now(),
        //     ]);
        // }
        // $faker = Faker::create('id_ID');


        $name = ['Ari Cahyono', 'skydu.academy', 'kompasdotcom', 'fannyanst_', 'bahtarayudha_','badrusofficial' ];
        $email = ['ari', 'skydu','kompas', 'tanti', 'yudha', 'badrus'  ];
        $imageUser = ['ari', 'skydu','kompas', 'profil-tanti', 'profil-yudha', 'profil-badrus'  ];
        $deskripsi = ["", "🤝 Bantu kamu berkarir sebagai web developer profesional", "News & Media Website", "Active.", "Prepare today for the wishes of tomorrow, Al-Qur'an Asy Sams. 🕹","Public Figure"];
        for ($i = 0; $i < count($name); $i++) {
           User::create([
                'name'               => $name[$i],
                'email'              => $email[$i].'@test.com',
                'password'           => Hash::make('user123456'),
                'regis_with'         => "email",
                'profil_picture'     => $imageUser[$i].'.png',
                'email_verified_at'  => now(),
                'deskripsi'          => $deskripsi[$i],
            ]);
        }

}
}
