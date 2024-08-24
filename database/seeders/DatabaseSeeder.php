<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\AdminRoleEnum;
use App\Models\Board;
use App\Models\Campaign;
use App\Models\CampaignType;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//         $this->call([
//            PenaltySeeder::class,
//            RoleSeeder::class,
//            UserSeeder::class,
//            CategorySeeder::class,
//            MissionSeeder::class,
//            CampaignTypeSeeder::class,
//            CampaignSeeder::class,
//            BoardSeeder::class,
//         ]);

        $this->call([
            RoleSeeder::class,
            CategorySeeder::class,
            MissionSeeder::class,
            CampaignTypeSeeder::class,
        ]);

        $admin = User::factory()->create([
            'name' => '관리자',
            'email' => 'admin@test.com',
        ]);

        $admin->assignRole(AdminRoleEnum::SUPER_ADMIN->value);

        $notice = Board::factory()->create(['slug' => 'notice', 'name' => '공지사항']);
        $event = Board::factory()->create(['slug' => 'event', 'name' => '이벤트']);
        $news = Board::factory()->create(['slug' => 'news', 'name' => '플릿소식']);
        $free = Board::factory()->create(['slug' => 'free', 'name' => '자유게시판']);
        $neighbor = Board::factory()->create(['slug' => 'neighbor', 'name' => '우리친구할까요?']);
        $inquiry = Board::factory()->create(['slug' => 'inquiry', 'name' => '1:1문의']);
        $guide = Board::factory()->create(['slug' => 'guide', 'name' => '가이드']);
        $ad = Board::factory()->create(['slug' => 'ad', 'name' => '광고문의']);
    }
}
