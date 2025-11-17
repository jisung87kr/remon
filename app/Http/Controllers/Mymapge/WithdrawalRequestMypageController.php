<?php

namespace App\Http\Controllers\Mymapge;

use App\Enums\User\PointTypeEnum;
use App\Enums\User\WithdrawalStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\PointWithdrawalRequest;
use Illuminate\Http\Request;

class WithdrawalRequestMypageController extends Controller
{
    /**
     * 출금 요청 목록 및 신청 폼
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // 필터링 조건
        $filter = [
            'status' => $request->input('status'),
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
        ];

        // 출금 요청 내역 조회
        $withdrawalRequests = $user->withdrawalRequests()
            ->filter($filter)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // 사용자 포인트 정보
        $pointInfo = [
            'available_point' => $user->available_point,
            'pending_withdrawal' => $user->withdrawalRequests()
                ->where('status', WithdrawalStatusEnum::PENDING)
                ->sum('point'),
        ];

        return view('mypage.withdrawal-request', compact('withdrawalRequests', 'pointInfo', 'filter'));
    }

    /**
     * 출금 요청 생성
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'point' => 'required|integer|min:10000|max:' . $user->available_point,
            'bank_name' => 'required|string|max:50',
            'account_number' => 'required|string|max:50',
            'account_holder' => 'required|string|max:50',
        ], [
            'point.required' => '출금 포인트를 입력해주세요.',
            'point.integer' => '포인트는 숫자만 입력 가능합니다.',
            'point.min' => '최소 10,000포인트 이상 출금 가능합니다.',
            'point.max' => '잔여 포인트를 초과할 수 없습니다.',
            'bank_name.required' => '은행명을 입력해주세요.',
            'account_number.required' => '계좌번호를 입력해주세요.',
            'account_holder.required' => '예금주를 입력해주세요.',
        ]);

        // 대기 중인 출금 요청 확인
        $hasPendingRequest = $user->withdrawalRequests()
            ->where('status', WithdrawalStatusEnum::PENDING)
            ->exists();

        if ($hasPendingRequest) {
            return redirect()->route('mypage.withdrawal-request')
                ->with('error', '이미 처리 대기 중인 출금 요청이 있습니다.');
        }

        // 출금 요청 생성
        PointWithdrawalRequest::create([
            'user_id' => $user->id,
            'point' => $validated['point'],
            'bank_name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
            'account_holder' => $validated['account_holder'],
            'status' => WithdrawalStatusEnum::PENDING,
        ]);

        // TODO: 관리자 알림 전송 (추후 구현)

        return redirect()->route('mypage.withdrawal-request')
            ->with('success', '출금 요청이 완료되었습니다. 관리자 승인 후 처리됩니다.');
    }

    /**
     * 출금 요청 취소
     */
    public function cancel(Request $request, PointWithdrawalRequest $withdrawalRequest)
    {
        // 권한 확인
        if ($withdrawalRequest->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        // 대기 중인 요청만 취소 가능
        if ($withdrawalRequest->status !== WithdrawalStatusEnum::PENDING) {
            return redirect()->route('mypage.withdrawal-request')
                ->with('error', '대기 중인 요청만 취소할 수 있습니다.');
        }

        $withdrawalRequest->update([
            'status' => WithdrawalStatusEnum::REJECTED,
            'admin_note' => '사용자가 요청을 취소했습니다.',
            'processed_at' => now(),
        ]);

        return redirect()->route('mypage.withdrawal-request')
            ->with('success', '출금 요청이 취소되었습니다.');
    }
}
