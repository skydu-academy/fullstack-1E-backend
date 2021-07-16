<?php

namespace Database\Seeders;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Database\Seeder;

class FollowerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = User::find(1);
        for ($i=2; $i < 6 ; $i++) {
        $user->followers()->create([
                'user_follower_id'   => $i,
                'status'             => 'confirmation',
            ]);
        }

    }
}
