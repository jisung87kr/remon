<?php

namespace Database\Factories;

use App\Helper\CommonHelper;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\MessageTypeEnum;
use App\Enums\MessageNameEnum;
use App\Enums\MessageStatusEnum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserMessage>
 */
class UserMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $messageType = CommonHelper::getRandomEnumCase(MessageTypeEnum::cases());
        $messageName = CommonHelper::getRandomEnumCase(MessageNameEnum::cases());
        $status = CommonHelper::getRandomEnumCase(MessageStatusEnum::cases());
        if(rand(0, 1) == 0){
            $confirmed_at = null;
        } else {
            $confirmed_at = $this->faker->dateTimeBetween('-30 days', '+0 days');
        }

        return [
            'message_type' => $messageType,
            'message_name' => $messageName,
            'content' => $this->faker->sentence,
            'status' => $status,
            'confirmed_at' => $confirmed_at,
        ];
    }
}
