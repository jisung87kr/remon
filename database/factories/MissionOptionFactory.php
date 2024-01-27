<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MissionOption>
 */
class MissionOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'option_name' => $this->faker->name,
            'option_value' => $this->faker->word,
            'additional_price' => $this->faker->numberBetween(1000, 100000),
            'extra_name1' => $this->faker->word,
            'extra_value1' => $this->faker->word,
            'extra_name2' => $this->faker->word,
            'extra_value2' => $this->faker->word,
            'extra_name3' => $this->faker->word,
            'extra_value3' => $this->faker->word,
        ];
    }
}
