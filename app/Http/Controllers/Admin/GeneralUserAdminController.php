<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Enums\AdminRoleEnum;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\RoleEnum;

class GeneralUserAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $size = $request->input('size', 10);
        $filter = [
            'role' => RoleEnum::GENERAL_USER->value,
            'keyword' => $request->input('keyword'),
            'status' => $request->input('status'),
        ];

        if($request->input('export')){
            $filename = RoleEnum::GENERAL_USER->value."_export_".time().".xlsx";
            return (new UsersExport($filter))->download($filename);
        }

        $users = User::filter($filter)->paginate($size);
        return view('admin.user.general.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = new User;
        return view('admin.user.general.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CreateNewUser $createNewUser)
    {
        $user = $createNewUser->create($request->all());
        return redirect()->route('admin.user.general.show', $user);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user)
    {
        // 최근 포인트 내역 20개 로드 (캠페인 관계 포함)
        $recentPoints = $user->points()
            ->with('campaign')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        // 포인트 요약 정보
        $pointSummary = [
            'total_point' => $user->total_point,
            'used_point' => $user->used_point,
            'available_point' => $user->available_point,
            'expiring_soon_point' => $user->expiring_soon_point ?? 0,
        ];

        return view('admin.user.general.show', compact('user', 'recentPoints', 'pointSummary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $user)
    {
        return view('admin.user.general.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user, UpdateUserProfileInformation $updateUserProfileInformation)
    {
        $updateUserProfileInformation->update($user, $request->all());
        return redirect()->route('admin.user.general.show', $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.general.user.index');
    }

    /**
     * 관리자 수동 포인트 차감
     */
    public function deductPoint(Request $request, User $user)
    {
        $validated = $request->validate([
            'point' => 'required|integer|min:1|max:' . $user->available_point,
            'description' => 'required|string|max:255',
        ], [
            'point.required' => '차감할 포인트를 입력해주세요.',
            'point.integer' => '포인트는 숫자만 입력 가능합니다.',
            'point.min' => '최소 1포인트 이상 입력해주세요.',
            'point.max' => '잔여 포인트를 초과할 수 없습니다.',
            'description.required' => '차감 사유를 입력해주세요.',
            'description.max' => '차감 사유는 255자 이내로 입력해주세요.',
        ]);

        // 포인트 차감 기록 생성
        $user->points()->create([
            'type' => \App\Enums\User\PointTypeEnum::DECREMENT,
            'point' => $validated['point'],
            'description' => '[관리자 차감] ' . $validated['description'],
            'campaign_id' => null,
            'expired_at' => null,
        ]);

        return redirect()->route('admin.user.general.show', $user)
            ->with('success', number_format($validated['point']) . '포인트가 차감되었습니다.');
    }
}
