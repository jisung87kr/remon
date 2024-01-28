<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Campaign;
use App\Models\CampaignType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $this->call([
            PenaltySeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            MissionSeeder::class,
            CampaignTypeSeeder::class,
            CampaignSeeder::class,
         ]);
    }
}
