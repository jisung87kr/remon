<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\Campaign\Media;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CampaignMedia>
 */
class CampaignMediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $count = count(Media::cases()) - 1;
        $media = Media::cases()[rand(0, $count)]->value;
        return [
            'media' => $media,
        ];
    }
}
