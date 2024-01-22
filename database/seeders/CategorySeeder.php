<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()->create([
            'name' => '전체'
        ]);

        Category::factory()->create([
            'name' => '오늘오픈'
        ]);

        Category::factory()->create([
            'name' => '제품별'
        ]);

        Category::factory()->create([
            'name' => '지역별'
        ]);
    }
}
