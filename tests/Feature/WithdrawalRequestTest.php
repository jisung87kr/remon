<?php

namespace Tests\Feature;

use App\Enums\User\PointTypeEnum;
use App\Enums\User\WithdrawalStatusEnum;
use App\Models\PointWithdrawalRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class WithdrawalRequestTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    /**
     * 출금 요청 생성 성공 테스트
     */
    public function test_user_can_create_withdrawal_request(): void
    {
        $user = User::factory()->create();

        // 사용자에게 20000P 적립
        $user->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 20000,
            'description' => '테스트 적립',
            'expired_at' => now()->addDays(60),
        ]);

        $response = $this->actingAs($user)
            ->post(route('mypage.withdrawal-request.store'), [
                'point' => 15000,
                'bank_name' => '국민은행',
                'account_number' => '123456789012',
                'account_holder' => '홍길동',
            ]);

        $response->assertRedirect(route('mypage.withdrawal-request'));
        $response->assertSessionHas('success');

        // 출금 요청이 생성되었는지 확인
        $this->assertDatabaseHas('point_withdrawal_requests', [
            'user_id' => $user->id,
            'point' => 15000,
            'bank_name' => '국민은행',
            'account_number' => '123456789012',
            'account_holder' => '홍길동',
            'status' => WithdrawalStatusEnum::PENDING->value,
        ]);
    }

    /**
     * 최소 출금 금액 검증 (10,000P)
     */
    public function test_minimum_withdrawal_amount_validation(): void
    {
        $user = User::factory()->create();

        $user->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 20000,
            'description' => '테스트 적립',
            'expired_at' => now()->addDays(60),
        ]);

        // 9000P 출금 시도 (최소 10000P 미만)
        $response = $this->actingAs($user)
            ->post(route('mypage.withdrawal-request.store'), [
                'point' => 9000,
                'bank_name' => '국민은행',
                'account_number' => '123456789012',
                'account_holder' => '홍길동',
            ]);

        $response->assertSessionHasErrors('point');
    }

    /**
     * 잔여 포인트 초과 출금 불가 테스트
     */
    public function test_cannot_withdraw_more_than_available_points(): void
    {
        $user = User::factory()->create();

        $user->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 10000,
            'description' => '테스트 적립',
            'expired_at' => now()->addDays(60),
        ]);

        // 15000P 출금 시도 (10000P 초과)
        $response = $this->actingAs($user)
            ->post(route('mypage.withdrawal-request.store'), [
                'point' => 15000,
                'bank_name' => '국민은행',
                'account_number' => '123456789012',
                'account_holder' => '홍길동',
            ]);

        $response->assertSessionHasErrors('point');
    }

    /**
     * 대기 중인 출금 요청이 있으면 추가 요청 불가
     */
    public function test_cannot_create_withdrawal_request_when_pending_exists(): void
    {
        $user = User::factory()->create();

        $user->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 30000,
            'description' => '테스트 적립',
            'expired_at' => now()->addDays(60),
        ]);

        // 첫 번째 출금 요청
        PointWithdrawalRequest::create([
            'user_id' => $user->id,
            'point' => 10000,
            'bank_name' => '국민은행',
            'account_number' => '123456789012',
            'account_holder' => '홍길동',
            'status' => WithdrawalStatusEnum::PENDING,
        ]);

        // 두 번째 출금 요청 시도
        $response = $this->actingAs($user)
            ->post(route('mypage.withdrawal-request.store'), [
                'point' => 10000,
                'bank_name' => '신한은행',
                'account_number' => '987654321098',
                'account_holder' => '홍길동',
            ]);

        $response->assertRedirect(route('mypage.withdrawal-request'));
        $response->assertSessionHas('error');
    }

    /**
     * 출금 요청 취소 테스트
     */
    public function test_user_can_cancel_pending_withdrawal_request(): void
    {
        $user = User::factory()->create();

        $withdrawalRequest = PointWithdrawalRequest::create([
            'user_id' => $user->id,
            'point' => 10000,
            'bank_name' => '국민은행',
            'account_number' => '123456789012',
            'account_holder' => '홍길동',
            'status' => WithdrawalStatusEnum::PENDING,
        ]);

        $response = $this->actingAs($user)
            ->post(route('mypage.withdrawal-request.cancel', $withdrawalRequest));

        $response->assertRedirect(route('mypage.withdrawal-request'));
        $response->assertSessionHas('success');

        // 상태가 REJECTED로 변경되었는지 확인
        $withdrawalRequest->refresh();
        $this->assertEquals(WithdrawalStatusEnum::REJECTED, $withdrawalRequest->status);
        $this->assertNotNull($withdrawalRequest->processed_at);
    }

    /**
     * 관리자 출금 승인 테스트 (포인트 자동 차감)
     */
    public function test_admin_can_approve_withdrawal_request(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create();

        // 사용자에게 20000P 적립
        $user->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 20000,
            'description' => '테스트 적립',
            'expired_at' => now()->addDays(60),
        ]);

        $withdrawalRequest = PointWithdrawalRequest::create([
            'user_id' => $user->id,
            'point' => 15000,
            'bank_name' => '국민은행',
            'account_number' => '123456789012',
            'account_holder' => '홍길동',
            'status' => WithdrawalStatusEnum::PENDING,
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.withdrawal-request.approve', $withdrawalRequest), [
                'admin_note' => '승인 완료',
            ]);

        $response->assertRedirect(route('admin.withdrawal-request.index'));
        $response->assertSessionHas('success');

        // 상태가 APPROVED로 변경되었는지 확인
        $withdrawalRequest->refresh();
        $this->assertEquals(WithdrawalStatusEnum::APPROVED, $withdrawalRequest->status);
        $this->assertEquals('승인 완료', $withdrawalRequest->admin_note);
        $this->assertNotNull($withdrawalRequest->processed_at);
        $this->assertEquals($admin->id, $withdrawalRequest->processed_by);

        // 포인트가 자동으로 차감되었는지 확인
        $user->refresh();
        $this->assertEquals(20000, $user->total_point);
        $this->assertEquals(15000, $user->used_point);
        $this->assertEquals(5000, $user->available_point);

        // 차감 내역 확인
        $deductRecord = $user->points()->where('type', PointTypeEnum::DECREMENT)->first();
        $this->assertNotNull($deductRecord);
        $this->assertEquals(15000, $deductRecord->point);
        $this->assertStringContainsString('[출금]', $deductRecord->description);
    }

    /**
     * 관리자 출금 거절 테스트
     */
    public function test_admin_can_reject_withdrawal_request(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create();

        $user->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 20000,
            'description' => '테스트 적립',
            'expired_at' => now()->addDays(60),
        ]);

        $withdrawalRequest = PointWithdrawalRequest::create([
            'user_id' => $user->id,
            'point' => 15000,
            'bank_name' => '국민은행',
            'account_number' => '123456789012',
            'account_holder' => '홍길동',
            'status' => WithdrawalStatusEnum::PENDING,
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.withdrawal-request.reject', $withdrawalRequest), [
                'admin_note' => '계좌 정보 불일치',
            ]);

        $response->assertRedirect(route('admin.withdrawal-request.index'));
        $response->assertSessionHas('success');

        // 상태가 REJECTED로 변경되었는지 확인
        $withdrawalRequest->refresh();
        $this->assertEquals(WithdrawalStatusEnum::REJECTED, $withdrawalRequest->status);
        $this->assertEquals('계좌 정보 불일치', $withdrawalRequest->admin_note);
        $this->assertNotNull($withdrawalRequest->processed_at);

        // 포인트는 차감되지 않아야 함
        $user->refresh();
        $this->assertEquals(20000, $user->available_point);
    }

    /**
     * 관리자 출금 완료 처리 테스트
     */
    public function test_admin_can_complete_withdrawal_request(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create();

        $withdrawalRequest = PointWithdrawalRequest::create([
            'user_id' => $user->id,
            'point' => 15000,
            'bank_name' => '국민은행',
            'account_number' => '123456789012',
            'account_holder' => '홍길동',
            'status' => WithdrawalStatusEnum::APPROVED,
            'processed_at' => now(),
            'processed_by' => $admin->id,
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.withdrawal-request.complete', $withdrawalRequest), [
                'admin_note' => '입금 완료',
            ]);

        $response->assertRedirect(route('admin.withdrawal-request.index'));
        $response->assertSessionHas('success');

        // 상태가 COMPLETED로 변경되었는지 확인
        $withdrawalRequest->refresh();
        $this->assertEquals(WithdrawalStatusEnum::COMPLETED, $withdrawalRequest->status);
        $this->assertEquals('입금 완료', $withdrawalRequest->admin_note);
    }

    /**
     * 승인된 요청만 완료 처리 가능 테스트
     */
    public function test_only_approved_requests_can_be_completed(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create();

        $withdrawalRequest = PointWithdrawalRequest::create([
            'user_id' => $user->id,
            'point' => 15000,
            'bank_name' => '국민은행',
            'account_number' => '123456789012',
            'account_holder' => '홍길동',
            'status' => WithdrawalStatusEnum::PENDING, // APPROVED가 아님
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.withdrawal-request.complete', $withdrawalRequest), [
                'admin_note' => '입금 완료',
            ]);

        $response->assertRedirect(route('admin.withdrawal-request.index'));
        $response->assertSessionHas('error');

        // 상태가 변경되지 않았는지 확인
        $withdrawalRequest->refresh();
        $this->assertEquals(WithdrawalStatusEnum::PENDING, $withdrawalRequest->status);
    }
}
