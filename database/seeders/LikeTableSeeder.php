<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class LikeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $data_id_user = [1, 4, 5, 6];
        $post_id = [4,6,9];
        for ($i = 0; $i < count($data_id_user); $i++) {
            $user = User::find($data_id_user[$i]);
            for ($j = 0; $j < count($post_id); $j++) {
                $user->post_like_users()->attach($post_id[$j]);

                $post =  Post::find($post_id[$j]);
                $user->notifications()->create([
                    'action_user_id'       => $post->user_id,
                    'action_id'            => $post_id[$j],
                    'action'               => 'like',
                    'status'               => 'waiting to be seen',
                ]);
            }
        }
        $data_id_user = [4, 5, 6];
        $post_id = [1, 5,  12, 13, 18];
        for ($i = 0; $i < count($data_id_user); $i++) {
            $user = User::find($data_id_user[$i]);
            for ($j = 0; $j < count($post_id); $j++) {
                    $user->post_like_users()->attach($post_id[$j]);

                    $post =  Post::find($post_id[$j]);
                    $user->notifications()->create([
                    'action_user_id'       => $post->user_id,
                    'action_id'            => $post_id[$j],
                    'action'               => 'like',
                    'status'               => 'waiting to be seen',
                ]);
            }
        }
        $data_id_user = [5, 6];
        $post_id = [8, 11, 15];
        for ($i = 0; $i < count($data_id_user); $i++) {
            $user = User::find($data_id_user[$i]);
            for ($j = 0; $j < count($post_id); $j++) {
                    $user->post_like_users()->attach($post_id[$j]);

                    $post =  Post::find($post_id[$j]);
                    $user->notifications()->create([
                    'action_user_id'       => $post->user_id,
                    'action_id'            => $post_id[$j],
                    'action'               => 'like',
                    'status'               => 'waiting to be seen',
                ]);
            }
        }
        $data_id_user = [1];
        $post_id = [3, 7];
        for ($i = 0; $i < count($data_id_user); $i++) {
            $user = User::find($data_id_user[$i]);
            for ($j = 0; $j < count($post_id); $j++) {
                    $user->post_like_users()->attach($post_id[$j]);

                    $post =  Post::find($post_id[$j]);
                    $user->notifications()->create([
                    'action_user_id'       => $post->user_id,
                    'action_id'            => $post_id[$j],
                    'action'               => 'like',
                    'status'               => 'waiting to be seen',
                ]);
            }
        }

    }
}
