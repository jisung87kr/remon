<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Category;
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

            $campaign->categories()->attach([$location->id]);
            $campaign->categories()->attach($campaignAttributes);
            $campaign->categories()->attach($campaignMissions);
        });
    }
}
