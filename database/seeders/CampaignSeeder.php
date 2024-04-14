<?php

namespace Database\Seeders;

use App\Enums\Campaign\ApplicationStatus;
use App\Helper\CommonHelper;
use App\Models\Campaign;
use App\Models\CampaignApplication;
use App\Models\CampaignApplicationField;
use App\Models\CampaignApplicationValue;
use App\Models\CampaignImage;
use App\Models\CampaignMedia;
use App\Models\CampaignMediaContent;
use App\Models\Category;
use App\Models\MissionOption;
use App\Models\User;
use Database\Factories\CampaignApplicationFactory;
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
            $campaignMedia = CampaignMedia::factory()->create([
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

            $applicationFields = CampaignApplicationField::factory(5)->create([
                'campaign_id' => $campaign->id
            ]);

            $users = User::inRandomOrder()->limit(3)->get();
            $status = CommonHelper::getRandomEnumCase(ApplicationStatus::cases());
            $campaign->applications()->attach($users->pluck('id')->toArray(), [
                'name' => $faker->name,
                'birthdate'=> $faker->dateTimeBetween('1970-01-01', '2014-12-31')->format('Y-m-d'),
                'sex' => ['man', 'woman'][rand(0, 1)],
                'phone' => $faker->phoneNumber,
                'status' => $status->value,
            ]);

            foreach ($users as $user) {
                $campaignApplication = CampaignApplication::where('campaign_id', $campaign->id)->where('user_id', $user->id)->first();
                foreach ($applicationFields as $index => $applicationField) {
                    CampaignApplicationValue::factory()->create([
                        'campaign_application_id' => $campaignApplication->id,
                        'campaign_application_field_id' => $applicationField->id
                    ]);
                }

                CampaignMediaContent::factory()->create([
                   'user_id' => $user->id,
                   'campaigns_media_id' => $campaignMedia->id
                ]);
            }
        });
    }
}
