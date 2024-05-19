<?php

namespace Database\Seeders;

use App\Models\Board;
use Database\Factories\BoardFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notice = Board::factory()->hasPosts(30)->create(['name' => 'notice', 'description' => '공지사항']);
        $event = Board::factory()->hasPosts(30)->create(['name' => 'event', 'description' => '이벤트']);
        $news = Board::factory()->hasPosts(30)->create(['name' => 'news', 'description' => '레몬소식']);
        $free = Board::factory()->hasPosts(30)->create(['name' => 'free', 'description' => '레몬톡톡']);
        $neighbor = Board::factory()->hasPosts(30)->create(['name' => 'community', 'description' => '우리친구할까요?']);
        $inquiry = Board::factory()->hasPosts(30)->create(['name' => 'inquiry', 'description' => '1:1문의']);
    }
}
