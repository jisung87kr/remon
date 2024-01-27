<?php

namespace Database\Seeders;

use App\Models\CampaignType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampaignTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            '방문형',
            '배송형',
        ];

        foreach ($data as $index => $datum) {
            CampaignType::factory()->create([
                'name' => $datum,
            ]);
        }
    }
}
