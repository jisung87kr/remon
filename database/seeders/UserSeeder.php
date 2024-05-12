<?php

namespace Database\Seeders;

use App\Enums\AdminRoleEnum;
use App\Enums\RoleEnum;
use App\Models\UserMedia;
use App\Models\UserMessage;
use App\Models\UserMeta;
use App\Models\UserPoint;
use App\Models\UserShippingAddress;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Enums\User\MetaEnum;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $jisung = User::factory()->create([
            'name' => '유지성',
            'email' => 'jisung87kr@gmail.com',
        ]);

        $admin = User::factory()->create([
            'name' => '관리자',
            'email' => 'admin@test.com',
        ]);

        $business = User::factory()->create([
            'name' => '비즈니스',
            'email' => 'business@test.com',
        ]);

        $jisung->assignRole(AdminRoleEnum::ADMIN->value);
        $admin->assignRole(AdminRoleEnum::ADMIN->value);
        $business->assignRole(RoleEnum::BUSINESS_USER->value);

        User::factory(10)->create()->each(function($user, $i) use($faker){
            UserPoint::factory(3)->create([
               'user_id' => $user->id,
            ]);

            UserShippingAddress::factory(3)->create([
                'user_id' => $user->id,
            ]);

            UserMedia::factory(3)->create([
                'user_id' => $user->id,
            ]);

            UserMeta::factory()->create([
                'user_id' => $user->id,
                'meta_key' => MetaEnum::TOP_SIZE,
                'meta_value' => $faker->sentence,
            ]);

            UserMeta::factory()->create([
                'user_id' => $user->id,
                'meta_key' => MetaEnum::BOTTOM_SIZE,
                'meta_value' => $faker->sentence,
            ]);

            UserMeta::factory()->create([
                'user_id' => $user->id,
                'meta_key' => MetaEnum::HEIGHT,
                'meta_value' => $faker->sentence,
            ]);

            UserMessage::factory(3)->create([
                'user_id' => $user->id,
            ]);

            if($i < 3){
                $user->assignRole(RoleEnum::GENERAL_USER->value);
            } else {
                $user->assignRole(RoleEnum::BUSINESS_USER->value);
            }
        });
    }
}
