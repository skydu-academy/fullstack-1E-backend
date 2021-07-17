<?php

namespace Database\Factories;

use App\Models\CommentPost;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CommentPost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'   => 1,
            'post_id'   => 1,
            'comment'   => 'this is post',
        ];
    }
}
