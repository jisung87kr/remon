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
        $notice = Board::factory()->hasPosts(30)->create(['slug' => 'notice', 'name' => '공지사항']);
        $event = Board::factory()->hasPosts(30)->create(['slug' => 'event', 'name' => '이벤트']);
        $news = Board::factory()->hasPosts(30)->create(['slug' => 'news', 'name' => '레몬소식']);
        $free = Board::factory()->hasPosts(30)->create(['slug' => 'free', 'name' => '레몬톡톡']);
        $neighbor = Board::factory()->hasPosts(30)->create(['slug' => 'neighbor', 'name' => '우리친구할까요?']);
        $inquiry = Board::factory()->hasPosts(30)->create(['slug' => 'inquiry', 'name' => '1:1문의']);
        $guide = Board::factory()->hasPosts(30)->create(['slug' => 'guide', 'name' => '가이드']);
        $ad = Board::factory()->hasPosts(30)->create(['slug' => 'ad', 'name' => '광고문의']);
    }
}
