<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\Campaign\MediaEnum;
use App\Enums\MediaConnectedStatusEnum;
use App\Helper\CommonHelper;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserMedia>
 */
class UserMediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $media = CommonHelper::getRandomEnumCase(MediaEnum::cases());
        $status = CommonHelper::getRandomEnumCase(MediaConnectedStatusEnum::cases());

        return [
            'media' => $media,
            'url' => $this->faker->url,
            'connected_status' => $status,
        ];
    }
}
