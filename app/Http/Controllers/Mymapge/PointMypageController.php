<?php

namespace App\Http\Controllers\Mymapge;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PointMypageController extends Controller
{
    /**
     * 포인트 내역 조회
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // 필터링 조건
        $filter = [
            'type' => $request->input('type'), // increment, decrement
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
        ];

        // 포인트 내역 조회
        $pointsQuery = $user->points()->with('campaign')->orderBy('created_at', 'desc');

        // 타입 필터
        if ($filter['type']) {
            $pointsQuery->where('type', $filter['type']);
        }

        // 날짜 필터
        if ($filter['date_from']) {
            $pointsQuery->whereDate('created_at', '>=', $filter['date_from']);
        }

        if ($filter['date_to']) {
            $pointsQuery->whereDate('created_at', '<=', $filter['date_to']);
        }

        $points = $pointsQuery->paginate(20);

        // 포인트 요약 정보
        $summary = [
            'total_point' => $user->total_point,
            'used_point' => $user->used_point,
            'available_point' => $user->available_point,
            'expiring_soon_point' => $user->expiring_soon_point ?? 0,
        ];

        return view('mypage.point', compact('points', 'summary', 'filter'));
    }
}
