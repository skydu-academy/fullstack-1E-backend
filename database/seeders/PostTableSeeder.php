<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $user = User::find(1);
        for ($i=0; $i < 4 ; $i++) {
            $user->posts()->create([
                'caption' => $faker->text($maxNBChars = 1000),
                'image'   => $faker->image($dir= 'public/storage/posts', $width = 640, $height = 480, 'cats', false),
            ]);
        }

        $user = User::find(2);
        for ($i=0; $i < 4 ; $i++) {
            $user->posts()->create([
                'caption' => $faker->text($maxNBChars = 1000),
                'image'   => $faker->image($dir= 'public/storage/posts', $width = 640, $height = 480, 'cats', false),
            ]);
        }

        $user = User::find(3);
        for ($i=0; $i < 4 ; $i++) {
            $user->posts()->create([
                'caption' => $faker->text($maxNBChars = 1000),
                'image'   => $faker->image($dir= 'public/storage/posts', $width = 640, $height = 480, 'cats', false),
            ]);
        }
        $user = User::find(4);
        for ($i=0; $i < 4 ; $i++) {
            $user->posts()->create([
                'caption' => $faker->text($maxNBChars = 1000),
                'image'   => $faker->image($dir= 'public/storage/posts', $width = 640, $height = 480, 'cats', false),
            ]);
        }
        $user = User::find(5);
        for ($i=0; $i < 4 ; $i++) {
            $user->posts()->create([
                'caption' => $faker->text($maxNBChars = 1000),
                'image'   => $faker->image($dir= 'public/storage/posts', $width = 640, $height = 480, 'cats', false),
            ]);
        }

    }
}
