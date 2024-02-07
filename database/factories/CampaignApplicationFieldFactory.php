<?php

namespace Database\Factories;

use App\Enums\Campaign\ApplicationFieldCategoryEnum;
use App\Enums\Campaign\ApplicationFieldTypeEnum;
use App\Helper\CommonHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CampaignApplicationField>
 */
class CampaignApplicationFieldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = CommonHelper::getRandomEnumCase(ApplicationFieldCategoryEnum::cases());
        $type = CommonHelper::getRandomEnumCase(ApplicationFieldTypeEnum::cases());
        return [
            'field_category' => $category->name,
            'type' => $type->name,
            'name' => $this->faker->word,
            'label' => $this->faker->word,
            'option' => $this->faker->word,
            'is_required' => $this->faker->boolean,
        ];
    }
}
