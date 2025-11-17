<?php

namespace Tests\Feature;

use App\Enums\User\PointTypeEnum;
use App\Models\User;
use App\Models\UserPoint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 총 적립 포인트 계산 테스트
     */
    public function test_total_point_calculation(): void
    {
        $user = User::factory()->create();

        // 적립 포인트 추가 (만료되지 않음)
        $user->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 1000,
            'description' => '테스트 적립 1',
            'expired_at' => now()->addDays(60),
        ]);

        $user->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 2000,
            'description' => '테스트 적립 2',
            'expired_at' => now()->addDays(30),
        ]);

        // 만료된 포인트 (계산에 포함되지 않아야 함)
        $user->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 500,
            'description' => '만료된 적립',
            'expired_at' => now()->subDays(1),
        ]);

        $user->refresh();

        $this->assertEquals(3000, $user->total_point);
    }

    /**
     * 사용 포인트 계산 테스트
     */
    public function test_used_point_calculation(): void
    {
        $user = User::factory()->create();

        // 적립 포인트
        $user->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 5000,
            'description' => '테스트 적립',
            'expired_at' => now()->addDays(60),
        ]);

        // 차감 포인트
        $user->points()->create([
            'type' => PointTypeEnum::DECREMENT,
            'point' => 1500,
            'description' => '테스트 차감 1',
        ]);

        $user->points()->create([
            'type' => PointTypeEnum::DECREMENT,
            'point' => 500,
            'description' => '테스트 차감 2',
        ]);

        $user->refresh();

        $this->assertEquals(2000, $user->used_point);
    }

    /**
     * 잔여 포인트 계산 테스트
     */
    public function test_available_point_calculation(): void
    {
        $user = User::factory()->create();

        // 적립 포인트
        $user->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 10000,
            'description' => '테스트 적립',
            'expired_at' => now()->addDays(60),
        ]);

        // 차감 포인트
        $user->points()->create([
            'type' => PointTypeEnum::DECREMENT,
            'point' => 3000,
            'description' => '테스트 차감',
        ]);

        $user->refresh();

        $this->assertEquals(7000, $user->available_point);
    }

    /**
     * 만료 예정 포인트 계산 테스트 (30일 이내)
     */
    public function test_expiring_soon_point_calculation(): void
    {
        $user = User::factory()->create();

        // 30일 이내 만료 예정
        $user->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 1000,
            'description' => '만료 예정 1',
            'expired_at' => now()->addDays(10),
        ]);

        $user->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 500,
            'description' => '만료 예정 2',
            'expired_at' => now()->addDays(25),
        ]);

        // 30일 이후 만료 (포함되지 않아야 함)
        $user->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 2000,
            'description' => '만료 예정 아님',
            'expired_at' => now()->addDays(60),
        ]);

        // 만료일 없음 (포함되지 않아야 함)
        $user->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 3000,
            'description' => '만료일 없음',
            'expired_at' => null,
        ]);

        $user->refresh();

        $this->assertEquals(1500, $user->expiring_soon_point);
    }

    /**
     * 복합 시나리오 테스트
     */
    public function test_complex_point_scenario(): void
    {
        $user = User::factory()->create();

        // 시나리오: 캠페인 완료로 5000P 적립, 출금으로 2000P 차감, 관리자 차감 500P
        $user->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 5000,
            'description' => '캠페인 완료',
            'expired_at' => now()->addDays(90),
        ]);

        $user->points()->create([
            'type' => PointTypeEnum::DECREMENT,
            'point' => 2000,
            'description' => '[출금] 출금 신청 승인',
        ]);

        $user->points()->create([
            'type' => PointTypeEnum::DECREMENT,
            'point' => 500,
            'description' => '[관리자 차감] 패널티',
        ]);

        // 추가 적립 (30일 이내 만료)
        $user->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 1000,
            'description' => '캠페인 완료 2',
            'expired_at' => now()->addDays(20),
        ]);

        $user->refresh();

        $this->assertEquals(6000, $user->total_point); // 5000 + 1000
        $this->assertEquals(2500, $user->used_point);  // 2000 + 500
        $this->assertEquals(3500, $user->available_point); // 6000 - 2500
        $this->assertEquals(1000, $user->expiring_soon_point); // 30일 이내 만료 예정
    }
}
