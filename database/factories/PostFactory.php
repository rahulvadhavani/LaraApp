<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userid = User::where('role','admin')->first()->id??1;
        return [
            'title' => fake()->title(),
            'description' => fake()->text(200),
            'user_id' => $userid,
            'image' => fake()->image(storage_path('app/public/uplaods/images/post/'),250,250,null,false)
        ];
    }
}
