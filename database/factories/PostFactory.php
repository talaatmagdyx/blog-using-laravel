<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'=> $this->faker->sentence,
            'body'=>$this->faker->sentences(3, true),
            'is_published'=>$this->faker->boolean,
            'excerpt'=>$this->faker->paragraph(1),
            'user_id'=>User::inRandomOrder()->first()->id,
            'created_at'=>\Carbon\Carbon::createFromDate(2020, rand(1, Carbon::now()->month), rand(1,28))
        ];
    }
}
