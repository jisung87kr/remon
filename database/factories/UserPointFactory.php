<?php

namespace Database\Factories;

use App\Helper\CommonHelper;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\User\PointTypeEnum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserPoint>
 */
class UserPointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = CommonHelper::getRandomEnumCase(PointTypeEnum::cases());
        $point =  rand(1000, 100000);
        $point = $type == PointTypeEnum::DECREMENT ? $point * -1 : $point;
        return [
            'type' => $type,
            'point' => $point,
            'description' => $this->faker->sentence,
        ];
    }
}
