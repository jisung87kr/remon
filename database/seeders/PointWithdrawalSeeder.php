<?php

namespace Database\Seeders;

use App\Enums\User\PointTypeEnum;
use App\Enums\User\WithdrawalStatusEnum;
use App\Models\PointWithdrawalRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class PointWithdrawalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 테스트 사용자 찾기 또는 생성
        $testUser = User::where('email', 'test@example.com')->first();

        if (!$testUser) {
            $testUser = User::factory()->create([
                'name' => '테스트 사용자',
                'email' => 'test@example.com',
            ]);
        }

        // 사용자에게 포인트 적립 (50,000P)
        $testUser->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 50000,
            'description' => '[테스트] 시더로 적립된 포인트',
            'expired_at' => now()->addDays(60),
        ]);

        // 일부 포인트 사용 (5,000P)
        $testUser->points()->create([
            'type' => PointTypeEnum::DECREMENT,
            'point' => 5000,
            'description' => '[테스트] 테스트 사용',
        ]);

        // 만료 예정 포인트 추가 (10,000P - 20일 후 만료)
        $testUser->points()->create([
            'type' => PointTypeEnum::INCREMENT,
            'point' => 10000,
            'description' => '[테스트] 만료 예정 포인트',
            'expired_at' => now()->addDays(20),
        ]);

        // 대기 중인 출금 요청 생성
        PointWithdrawalRequest::create([
            'user_id' => $testUser->id,
            'point' => 15000,
            'bank_name' => '국민은행',
            'account_number' => '123456789012',
            'account_holder' => '테스트 사용자',
            'status' => WithdrawalStatusEnum::PENDING,
        ]);

        // 승인된 출금 요청 생성
        PointWithdrawalRequest::create([
            'user_id' => $testUser->id,
            'point' => 10000,
            'bank_name' => '신한은행',
            'account_number' => '987654321098',
            'account_holder' => '테스트 사용자',
            'status' => WithdrawalStatusEnum::APPROVED,
            'admin_note' => '승인 완료',
            'processed_at' => now()->subDays(2),
            'processed_by' => 1, // 관리자 ID
        ]);

        // 완료된 출금 요청 생성
        PointWithdrawalRequest::create([
            'user_id' => $testUser->id,
            'point' => 20000,
            'bank_name' => '우리은행',
            'account_number' => '111122223333',
            'account_holder' => '테스트 사용자',
            'status' => WithdrawalStatusEnum::COMPLETED,
            'admin_note' => '입금 완료',
            'processed_at' => now()->subDays(5),
            'processed_by' => 1, // 관리자 ID
        ]);

        // 거절된 출금 요청 생성
        PointWithdrawalRequest::create([
            'user_id' => $testUser->id,
            'point' => 12000,
            'bank_name' => '카카오뱅크',
            'account_number' => '444455556666',
            'account_holder' => '테스트 사용자',
            'status' => WithdrawalStatusEnum::REJECTED,
            'admin_note' => '계좌 정보 불일치',
            'processed_at' => now()->subDays(3),
            'processed_by' => 1, // 관리자 ID
        ]);

        $this->command->info('✅ 포인트 출금 테스트 데이터 생성 완료!');
        $this->command->info('📧 테스트 계정: test@example.com');
        $this->command->info('💰 총 적립: 60,000P');
        $this->command->info('💸 사용: 5,000P');
        $this->command->info('💵 잔여: 55,000P (출금 대기 중 15,000P 포함)');
        $this->command->info('📋 출금 요청: 4건 (대기 1, 승인 1, 완료 1, 거절 1)');
    }
}
