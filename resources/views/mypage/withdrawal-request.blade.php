<x-mypage-layout>
    <x-slot name="header">포인트 출금 요청</x-slot>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 포인트 정보 --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="card bg-gradient-to-br from-green-50 to-emerald-100 border-green-200 p-5 md:p-6">
            <div class="flex items-center justify-between gap-3">
                <div class="flex-1">
                    <div class="text-xs md:text-sm text-green-600 font-medium mb-3">출금 가능 포인트</div>
                    <div class="text-xl md:text-3xl font-bold text-green-900">{{ number_format($pointInfo['available_point']) }}<span class="text-lg md:text-xl">P</span></div>
                </div>
                <div class="text-green-400 flex-shrink-0">
                    <svg class="w-10 h-10 md:w-12 md:h-12" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="card bg-gradient-to-br from-yellow-50 to-amber-100 border-yellow-200 p-5 md:p-6">
            <div class="flex items-center justify-between gap-3">
                <div class="flex-1">
                    <div class="text-xs md:text-sm text-yellow-600 font-medium mb-3">출금 대기 중</div>
                    <div class="text-xl md:text-3xl font-bold text-yellow-900">{{ number_format($pointInfo['pending_withdrawal']) }}<span class="text-lg md:text-xl">P</span></div>
                </div>
                <div class="text-yellow-400 flex-shrink-0">
                    <svg class="w-10 h-10 md:w-12 md:h-12" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- 출금 요청 폼 --}}
    <div class="card mb-6 bg-gradient-to-r from-gray-50 to-slate-50 p-3">
        <div class="flex items-center mb-6">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 ml-3">출금 신청</h3>
        </div>
        <form action="{{ route('mypage.withdrawal-request.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        출금 포인트 <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="point" value="{{ old('point') }}"
                           min="10000" max="{{ $pointInfo['available_point'] }}"
                           class="form-control w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="10,000" required>
                    <p class="text-xs text-gray-500 mt-2 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        최소 10,000 포인트 이상 (1P = 1원)
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        은행명 <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="bank_name" value="{{ old('bank_name') }}"
                           class="form-control w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="예: 국민은행" required>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        계좌번호 <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="account_number" value="{{ old('account_number') }}"
                           class="form-control w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="'-' 없이 숫자만 입력" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        예금주 <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="account_holder" value="{{ old('account_holder') }}"
                           class="form-control w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="예금주 이름" required>
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition duration-150">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                    </svg>
                    출금 신청하기
                </button>
            </div>
        </form>
    </div>

    {{-- 필터 --}}
    <div class="card mb-6 bg-gray-50 p-3">
        <div class="flex items-center mb-4">
            <svg class="w-5 h-5 text-gray-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"/>
            </svg>
            <h3 class="text-sm font-semibold text-gray-700">필터</h3>
        </div>
        <form action="{{ route('mypage.withdrawal-request') }}" method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">상태</label>
                <select name="status" class="form-select w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">전체</option>
                    <option value="{{ \App\Enums\User\WithdrawalStatusEnum::PENDING->value }}" {{ request('status') == \App\Enums\User\WithdrawalStatusEnum::PENDING->value ? 'selected' : '' }}>대기</option>
                    <option value="{{ \App\Enums\User\WithdrawalStatusEnum::APPROVED->value }}" {{ request('status') == \App\Enums\User\WithdrawalStatusEnum::APPROVED->value ? 'selected' : '' }}>승인</option>
                    <option value="{{ \App\Enums\User\WithdrawalStatusEnum::REJECTED->value }}" {{ request('status') == \App\Enums\User\WithdrawalStatusEnum::REJECTED->value ? 'selected' : '' }}>거절</option>
                    <option value="{{ \App\Enums\User\WithdrawalStatusEnum::COMPLETED->value }}" {{ request('status') == \App\Enums\User\WithdrawalStatusEnum::COMPLETED->value ? 'selected' : '' }}>완료</option>
                </select>
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">시작일</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">종료일</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                    </svg>
                    조회
                </button>
                <a href="{{ route('mypage.withdrawal-request') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition ml-2">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                    </svg>
                    초기화
                </a>
            </div>
        </form>
    </div>

    {{-- 출금 요청 내역 테이블 --}}
    <div class="card !p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table">
                <thead class="border-y">
                    <tr>
                        <th class="w-32">신청일</th>
                        <th class="w-32 text-right">출금 포인트</th>
                        <th class="w-48">계좌 정보</th>
                        <th class="w-24">상태</th>
                        <th>관리자 메모</th>
                        <th class="w-32">처리일</th>
                        <th class="w-24">액션</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($withdrawalRequests as $request)
                        <tr>
                            <td class="text-sm text-gray-600">
                                {{ $request->created_at->format('Y-m-d H:i') }}
                            </td>
                            <td class="text-right font-medium text-gray-900">
                                {{ number_format($request->point) }}P
                            </td>
                            <td class="text-sm">
                                <div>{{ $request->bank_name }}</div>
                                <div class="text-gray-500">{{ $request->account_number }}</div>
                                <div class="text-gray-500">{{ $request->account_holder }}</div>
                            </td>
                            <td>
                                <span class="badge badge-{{ $request->status->color() }}">
                                    {{ $request->status->label() }}
                                </span>
                            </td>
                            <td class="text-sm text-gray-600">
                                {{ $request->admin_note ?? '-' }}
                            </td>
                            <td class="text-sm text-gray-600">
                                {{ $request->processed_at ? $request->processed_at->format('Y-m-d H:i') : '-' }}
                            </td>
                            <td>
                                @if($request->status === \App\Enums\User\WithdrawalStatusEnum::PENDING)
                                    <form action="{{ route('mypage.withdrawal-request.cancel', $request) }}" method="POST"
                                          onsubmit="return confirm('출금 요청을 취소하시겠습니까?')">
                                        @csrf
                                        <button type="submit" class="button button-sm button-light">
                                            취소
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-gray-500">
                                출금 요청 내역이 없습니다.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 페이지네이션 --}}
    <div class="mt-6">
        {{ $withdrawalRequests->appends(request()->query())->links() }}
    </div>

    {{-- 안내 사항 --}}
    <div class="card p-3 mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-blue-200">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3 text-sm">
                <h4 class="font-bold text-blue-900 mb-3">출금 안내</h4>
                <ul class="space-y-2 text-blue-800">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>최소 출금 금액은 <span class="font-semibold">10,000포인트</span>입니다. (1포인트 = 1원)</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>출금 요청 시 관리자 승인이 필요하며, 승인 후 <span class="font-semibold">영업일 기준 3-5일 이내</span> 입금됩니다.</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>출금 대기 중인 요청이 있는 경우 <span class="font-semibold">추가 요청이 불가능</span>합니다.</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>계좌 정보는 정확하게 입력해주세요. 잘못된 정보로 인한 문제는 책임지지 않습니다.</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>출금 수수료는 별도로 <span class="font-semibold">부과되지 않습니다</span>.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-mypage-layout>
