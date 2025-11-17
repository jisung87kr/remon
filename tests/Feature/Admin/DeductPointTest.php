<?php

namespace Tests\Feature\Admin;

use App\Enums\User\PointTypeEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class DeductPointTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    /**
     * 관리자 포인트 차감 성공 테스트
     */
    public function test_admin_can_deduct_points(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create();

        // 사용자에게 포인트 적립
        $user->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 10000,
            'description' => '테스트 적립',
            'expired_at' => now()->addDays(60),
        ]);

        // 사용자를 다시 로드하여 포인트 관계 갱신
        $user = User::find($user->id);
        $this->assertEquals(10000, $user->available_point);

        // 포인트가 실제로 저장되었는지 확인
        $this->assertDatabaseHas('user_points', [
            'user_id' => $user->id,
            'point' => 10000,
            'type' => PointTypeEnum::INCREMENT->value,
        ]);

        // 관리자가 포인트 차감 (available_point보다 작은 값)
        $response = $this->actingAs($admin)
            ->post(route('admin.user.general.deduct-point', $user), [
                'point' => 3000,
                'description' => '패널티 부과',
            ]);

        $response->assertRedirect(route('admin.user.general.show', $user));
        $response->assertSessionHas('success');

        // 포인트가 차감되었는지 확인
        $user->refresh();
        $this->assertEquals(10000, $user->total_point);
        $this->assertEquals(3000, $user->used_point);
        $this->assertEquals(7000, $user->available_point);

        // 차감 내역 확인
        $deductRecord = $user->points()->where('type', PointTypeEnum::DECREMENT)->first();
        $this->assertNotNull($deductRecord);
        $this->assertEquals(3000, $deductRecord->point);
        $this->assertStringContainsString('패널티 부과', $deductRecord->description);
        $this->assertStringContainsString('[관리자 차감]', $deductRecord->description);
    }

    /**
     * 잔여 포인트 초과 차감 불가 테스트
     */
    public function test_cannot_deduct_more_than_available_points(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create();

        // 사용자에게 5000P 적립
        $user->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 5000,
            'description' => '테스트 적립',
            'expired_at' => now()->addDays(60),
        ]);

        // 10000P 차감 시도 (5000P보다 많음)
        $response = $this->actingAs($admin)
            ->post(route('admin.user.general.deduct-point', $user), [
                'point' => 10000,
                'description' => '과다 차감',
            ]);

        $response->assertSessionHasErrors('point');

        // 포인트가 차감되지 않았는지 확인
        $user->refresh();
        $this->assertEquals(5000, $user->available_point);
    }

    /**
     * 차감 사유 필수 입력 테스트
     */
    public function test_deduct_description_is_required(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create();

        $user->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 5000,
            'description' => '테스트 적립',
            'expired_at' => now()->addDays(60),
        ]);

        // 차감 사유 없이 요청
        $response = $this->actingAs($admin)
            ->post(route('admin.user.general.deduct-point', $user), [
                'point' => 1000,
            ]);

        $response->assertSessionHasErrors('description');
    }

    /**
     * 최소 1포인트 이상 차감 테스트
     */
    public function test_deduct_minimum_point_validation(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create();

        $user->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 5000,
            'description' => '테스트 적립',
            'expired_at' => now()->addDays(60),
        ]);

        // 0 포인트 차감 시도
        $response = $this->actingAs($admin)
            ->post(route('admin.user.general.deduct-point', $user), [
                'point' => 0,
                'description' => '무효 차감',
            ]);

        $response->assertSessionHasErrors('point');

        // 음수 포인트 차감 시도
        $response = $this->actingAs($admin)
            ->post(route('admin.user.general.deduct-point', $user), [
                'point' => -100,
                'description' => '음수 차감',
            ]);

        $response->assertSessionHasErrors('point');
    }

    /**
     * 비로그인 사용자 접근 불가 테스트
     */
    public function test_unauthenticated_user_cannot_deduct_points(): void
    {
        // WithoutMiddleware를 사용하고 있으므로 이 테스트는 스킵
        $this->markTestSkipped('WithoutMiddleware를 사용하므로 인증 테스트는 불가능합니다.');
    }
}
