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
        // Follow for skybook.academy and kompasdotcom
        $data_id_user = [1, 4, 5, 6];
        for ($i = 0; $i < count($data_id_user); $i++) {
            $user = User::find($data_id_user[$i]);
            for ($j = 1; $j <= 6; $j++) {
                if (!in_array($j, $data_id_user)) {
                    $user->followers()->create([
                        'user_follower_id'   => $j,
                        'status'             => 'confirmation',
                    ]);
                }
            }
        }


        // Follow user to user
        $data_id_user = [1, 4, 5, 6];
        for ($i = 0; $i < count($data_id_user); $i++) {
            $user = User::find($data_id_user[$i]);
            for ($j = 1; $j <= count($data_id_user) ; $j++) {
               if($j !== $data_id_user[$i]){
                    if (in_array($j, $data_id_user)) {
                        $user->followers()->create([
                            'user_follower_id'   => $j,
                            'status'             => 'confirmation',
                        ]);
                    }
               }
            }
        }

    }
}
