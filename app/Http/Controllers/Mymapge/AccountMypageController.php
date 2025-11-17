<?php

namespace App\Http\Controllers\Mymapge;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountMypageController extends Controller
{
    /**
     * 계좌 정보 등록/수정 페이지
     */
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('mypage.account', compact('user'));
    }

    /**
     * 계좌 정보 업데이트
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'bank_name' => 'required|string|max:50',
            'account_number' => 'required|string|max:50',
            'account_holder' => 'required|string|max:50',
        ], [
            'bank_name.required' => '은행명을 입력해주세요.',
            'account_number.required' => '계좌번호를 입력해주세요.',
            'account_holder.required' => '예금주를 입력해주세요.',
        ]);

        $user->update($validated);

        return redirect()->route('mypage.account.edit')
            ->with('success', '계좌 정보가 저장되었습니다.');
    }
}
