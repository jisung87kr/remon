<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserShippingAddress>
 */
class UserShippingAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_default' => $this->faker->boolean,
            'title' => $this->faker->word,
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'address_zipcode' => $this->faker->randomDigit(),
            'address_first' => $this->faker->address,
            'address_last' => $this->faker->streetAddress,
        ];
    }
}
