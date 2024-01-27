<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\CampaignMedia;
use App\Models\CampaignMissionOption;
use App\Models\CampaignMissionOptionItem;
use App\Models\Category;
use App\Models\MissionOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Campaign::factory(100)->create()->each(function($campaign){
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

            foreach ($missionOptions as $index => $missionOption) {
                $campaign->missionOptions()->attach($missionOption);
                $option = CampaignMissionOption::where('campaign_id', $campaign->id)
                    ->where('mission_option_id',$missionOption)
                    ->latest()
                    ->first();

                CampaignMissionOptionItem::factory(rand(1, 3))->create([
                    'campaign_mission_option_id' => $option->id
                ]);
            }
        });
    }
}
