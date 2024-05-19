<?php

namespace Database\Factories;

use App\Enums\PostStatusEnum;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'user_id' => User::inRandomOrder()->first(),
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'created_at' => $this->faker->dateTimeBetween('2024-01-01', '2024-06-01'),
            'updated_at' => $this->faker->dateTimeBetween('2024-01-01', '2024-06-01'),
            'status' => $this->faker->randomElement(PostStatusEnum::cases()),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            Comment::factory()->count(10)->state(new \Illuminate\Database\Eloquent\Factories\Sequence(
                fn ($sequence) => [
                    'user_id' => User::inRandomOrder()->first()->id,
                    'commentable_id' => $post->id,
                    'commentable_type' => Post::class,
                    'content' => $this->faker->paragraph,
                ]
            ))->create();
        });
    }
}
