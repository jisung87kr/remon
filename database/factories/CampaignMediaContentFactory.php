<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CampaignMediaContent>
 */
class CampaignMediaContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content_url' => $this->faker->url,
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
        ];
    }
}
