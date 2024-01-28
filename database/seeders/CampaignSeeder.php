<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\CampaignImage;
use App\Models\CampaignMedia;
use App\Models\Category;
use App\Models\MissionOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        Campaign::factory(10)->create()->each(function($campaign) use($faker){
            $location = Category::where('parent_id', '11')->inRandomOrder()->first();
            $campaignAttributes = Category::where('parent_id', '75')->inRandomOrder()->limit(rand(1, 2))->get()->pluck('id')->toArray();
            $campaignMissions = Category::where('parent_id', '63')->inRandomOrder()->limit(rand(2, 4))->get()->pluck('id')->toArray();
            $missionOptions = MissionOption::inRandomOrder()->limit(rand(4, 8))->get()->pluck('id')->toArray();

            $campaign->categories()->attach([$location->id]);
            $campaign->categories()->attach($campaignAttributes);
            $campaign->categories()->attach($campaignMissions);
            CampaignMedia::factory(rand(1,3))->create([
               'campaign_id' => $campaign->id,
            ]);

            CampaignImage::factory(5)->create([
                'campaign_id' => $campaign->id,
            ]);

            foreach ($missionOptions as $index => $missionOption) {
                $campaign->missionOptions()->attach($missionOption, [
                    'content' => $faker->sentence,
                    'sub_content' => $faker->sentence,
                ]);
            }
        });
    }
}
