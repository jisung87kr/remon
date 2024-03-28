<?php

namespace Database\Factories;

use App\Enums\Campaign\ApplicationStatus;
use App\Helper\CommonHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CampaignApplication>
 */
class CampaignApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = CommonHelper::getRandomEnumCase(ApplicationStatus::cases());
        return [
            'name' => $this->faker->name,
            'birthdate'=> $this->faker->dateTimeBetween('1970-01-01', '2014-12-31')->format('Y-m-d'),
            'sex' => ['man', 'woman'][rand(0, 1)],
            'phone' => $this->faker->phoneNumber,
            'status' => $status,
        ];
    }
}
