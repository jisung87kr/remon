<?php

namespace App\Http\Controllers\Admin;

use App\Enums\User\PointTypeEnum;
use App\Enums\User\WithdrawalStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\PointWithdrawalRequest;
use App\Models\User;
use Illuminate\Http\Request;

class WithdrawalRequestAdminController extends Controller
{
    /**
     * 출금 요청 목록
     */
    public function index(Request $request)
    {
        $filter = [
            'status' => $request->input('status'),
            'user_id' => $request->input('user_id'),
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
        ];

        $withdrawalRequests = PointWithdrawalRequest::with(['user', 'processedBy'])
            ->filter($filter)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // 통계 정보
        $statistics = [
            'pending_count' => PointWithdrawalRequest::pending()->count(),
            'pending_amount' => PointWithdrawalRequest::pending()->sum('point'),
            'approved_count' => PointWithdrawalRequest::approved()->count(),
            'completed_count' => PointWithdrawalRequest::completed()->count(),
        ];

        return view('admin.withdrawal-request.index', compact('withdrawalRequests', 'filter', 'statistics'));
    }

    /**
     * 출금 요청 승인
     */
    public function approve(Request $request, PointWithdrawalRequest $withdrawalRequest)
    {
        if ($withdrawalRequest->status !== WithdrawalStatusEnum::PENDING) {
            return redirect()->route('admin.withdrawal-request.index')
                ->with('error', '대기 중인 요청만 승인할 수 있습니다.');
        }

        $validated = $request->validate([
            'admin_note' => 'nullable|string|max:500',
        ]);

        $withdrawalRequest->update([
            'status' => WithdrawalStatusEnum::APPROVED,
            'admin_note' => $validated['admin_note'] ?? '승인되었습니다.',
            'processed_at' => now(),
            'processed_by' => $request->user()->id,
        ]);

        // 포인트 차감
        $withdrawalRequest->user->points()->create([
            'type' => PointTypeEnum::DECREMENT,
            'point' => $withdrawalRequest->point,
            'description' => '[출금] 포인트 출금 신청 승인 (요청 ID: ' . $withdrawalRequest->id . ')',
            'campaign_id' => null,
            'expired_at' => null,
        ]);

        // TODO: 사용자 알림 전송 (추후 구현)

        return redirect()->route('admin.withdrawal-request.index')
            ->with('success', '출금 요청이 승인되었습니다.');
    }

    /**
     * 출금 요청 거절
     */
    public function reject(Request $request, PointWithdrawalRequest $withdrawalRequest)
    {
        if ($withdrawalRequest->status !== WithdrawalStatusEnum::PENDING) {
            return redirect()->route('admin.withdrawal-request.index')
                ->with('error', '대기 중인 요청만 거절할 수 있습니다.');
        }

        $validated = $request->validate([
            'admin_note' => 'required|string|max:500',
        ], [
            'admin_note.required' => '거절 사유를 입력해주세요.',
        ]);

        $withdrawalRequest->update([
            'status' => WithdrawalStatusEnum::REJECTED,
            'admin_note' => $validated['admin_note'],
            'processed_at' => now(),
            'processed_by' => $request->user()->id,
        ]);

        // TODO: 사용자 알림 전송 (추후 구현)

        return redirect()->route('admin.withdrawal-request.index')
            ->with('success', '출금 요청이 거절되었습니다.');
    }

    /**
     * 출금 완료 처리
     */
    public function complete(Request $request, PointWithdrawalRequest $withdrawalRequest)
    {
        if ($withdrawalRequest->status !== WithdrawalStatusEnum::APPROVED) {
            return redirect()->route('admin.withdrawal-request.index')
                ->with('error', '승인된 요청만 완료 처리할 수 있습니다.');
        }

        $validated = $request->validate([
            'admin_note' => 'nullable|string|max:500',
        ]);

        $withdrawalRequest->update([
            'status' => WithdrawalStatusEnum::COMPLETED,
            'admin_note' => $validated['admin_note'] ?? '출금이 완료되었습니다.',
        ]);

        // TODO: 사용자 알림 전송 (추후 구현)

        return redirect()->route('admin.withdrawal-request.index')
            ->with('success', '출금이 완료되었습니다.');
    }

    /**
     * 관리자가 사용자 대신 출금 요청 생성 폼
     */
    public function create(Request $request)
    {
        $userId = $request->input('user_id');
        $user = null;

        if ($userId) {
            $user = User::find($userId);
        }

        // 사용자 검색용
        $users = User::query()
            ->when($request->input('search'), function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('nick_name', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->limit(50)
            ->get();

        return view('admin.withdrawal-request.create', compact('user', 'users'));
    }

    /**
     * 관리자가 사용자 대신 출금 요청 생성
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'point' => 'required|integer|min:10000',
            'bank_name' => 'required|string|max:50',
            'account_number' => 'required|string|max:50',
            'account_holder' => 'required|string|max:50',
            'admin_note' => 'nullable|string|max:500',
        ], [
            'user_id.required' => '사용자를 선택해주세요.',
            'user_id.exists' => '존재하지 않는 사용자입니다.',
            'point.required' => '출금 포인트를 입력해주세요.',
            'point.min' => '최소 출금 포인트는 10,000P입니다.',
            'bank_name.required' => '은행명을 입력해주세요.',
            'account_number.required' => '계좌번호를 입력해주세요.',
            'account_holder.required' => '예금주를 입력해주세요.',
        ]);

        $user = User::findOrFail($validated['user_id']);

        // 사용 가능한 포인트 확인
        if ($user->available_point < $validated['point']) {
            return redirect()->back()
                ->withInput()
                ->with('error', '사용 가능한 포인트가 부족합니다. (현재: ' . number_format($user->available_point) . 'P)');
        }

        // 출금 요청 생성
        PointWithdrawalRequest::create([
            'user_id' => $validated['user_id'],
            'point' => $validated['point'],
            'bank_name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
            'account_holder' => $validated['account_holder'],
            'status' => WithdrawalStatusEnum::PENDING,
        ]);

        return redirect()->route('admin.withdrawal-request.index')
            ->with('success', '출금 요청이 생성되었습니다.');
    }
}
