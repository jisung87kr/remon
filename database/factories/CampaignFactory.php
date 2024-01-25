<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = ['DRAFT', 'PUBLISHED'];
        $randomKey = array_rand($status);

        $applicationStartAt = $this->faker->dateTimeBetween('+1 days', '+7 days');
        $applicationEndAt = $this->faker->dateTimeBetween('+8 days', '+14 days');
        $announcementAt = $this->faker->dateTimeBetween('+15 days', '+21 days');
        $registrationStartDateAt = $this->faker->dateTimeBetween('+22 days', '+28 days');
        $registrationEndDateAt = $this->faker->dateTimeBetween('+29 days', '+35 days');
        $resultAnnouncementDateAt = $this->faker->dateTimeBetween('+36 days', '+42 days');

        return [
            'product_name' => $this->faker->word,
            'title' => $this->faker->sentence,
            'benefit' => $this->faker->paragraph,
            'benefit_point' => $this->faker->randomDigit(),
            'visit_instruction' => $this->faker->paragraph,
            'address' => $this->faker->address,
            'mission' => $this->faker->paragraph,
            'extra_information' => $this->faker->paragraph,
            'application_start_at' => $applicationStartAt,
            'application_end_at' => $applicationEndAt,
            'announcement_at' => $announcementAt,
            'registration_start_date_at' => $registrationStartDateAt,
            'registration_end_date_at' => $registrationEndDateAt,
            'result_announcement_date_at' => $resultAnnouncementDateAt,
            'status' => $status[$randomKey],
            'application_limit' => mt_rand(10, 100),
        ];
    }
}
