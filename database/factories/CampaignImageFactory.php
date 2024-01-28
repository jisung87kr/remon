<?php

namespace Database\Factories;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\Campaign\ImageType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CampaignImage>
 */
class CampaignImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $maxSize = count(ImageType::cases()) - 1;
        $type = ImageType::cases()[rand(0, $maxSize)]->value;
        $path = storage_path('app/public/dummy');

        if($type == ImageType::THUMBNAIL->value){
            //$filePath = $this->faker->image($path, 400, 400, null, false);
            $filePath = 'thumbnail.png';
        }

        if($type == ImageType::DETAIL->value){
            //$filePath = $this->faker->image($path, 1200, 600, null, false);
            $filePath = '1.png';
        }

        return [
            'type' => $type,
            'file_path' => 'dummy/'.$filePath,
            'file_name' => $filePath,
        ];
    }
}
