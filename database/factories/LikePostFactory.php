<?php

namespace Database\Factories;

use App\Models\LikePost;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikePostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LikePost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'user_id' => 1,
            'post_id' => 1,
        ];
    }
}
