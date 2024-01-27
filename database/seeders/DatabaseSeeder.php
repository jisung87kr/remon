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
         \App\Models\User::factory(10)->create();
         \App\Models\User::factory()->create([
             'name' => '유지성',
             'email' => 'jisung87kr@gmail.com',
         ]);

         $this->call([
            CategorySeeder::class,
            CampaignTypeSeeder::class,
            CampaignSeeder::class,
            MissionSeeder::class,
         ]);
    }
}
