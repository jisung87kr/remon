<x-admin-layout>
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

    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            <svg class="w-8 h-8 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
            </svg>
            <h1 class="text-2xl font-bold">출금 요청 관리</h1>
        </div>
        <a href="{{ route('admin.withdrawal-request.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
            </svg>
            출금 요청 생성
        </a>
    </div>

    {{-- 통계 카드 --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="card bg-gradient-to-br from-yellow-50 to-amber-100 border-yellow-200 p-5 md:p-6">
            <div class="flex items-center justify-between gap-3">
                <div class="flex-1">
                    <div class="text-xs md:text-sm text-yellow-600 font-medium mb-3">대기 중</div>
                    <div class="text-xl md:text-2xl font-bold text-yellow-900">{{ number_format($statistics['pending_count']) }}<span class="text-base">건</span></div>
                    <div class="text-xs md:text-sm text-yellow-700 mt-2 font-semibold">{{ number_format($statistics['pending_amount']) }}P</div>
                </div>
                <div class="text-yellow-400 flex-shrink-0">
                    <svg class="w-8 h-8 md:w-10 md:h-10" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="card bg-gradient-to-br from-blue-50 to-indigo-100 border-blue-200 p-5 md:p-6">
            <div class="flex items-center justify-between gap-3">
                <div class="flex-1">
                    <div class="text-xs md:text-sm text-blue-600 font-medium mb-3">승인</div>
                    <div class="text-xl md:text-2xl font-bold text-blue-900">{{ number_format($statistics['approved_count']) }}<span class="text-base">건</span></div>
                </div>
                <div class="text-blue-400 flex-shrink-0">
                    <svg class="w-8 h-8 md:w-10 md:h-10" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="card bg-gradient-to-br from-green-50 to-emerald-100 border-green-200 p-5 md:p-6">
            <div class="flex items-center justify-between gap-3">
                <div class="flex-1">
                    <div class="text-xs md:text-sm text-green-600 font-medium mb-3">완료</div>
                    <div class="text-xl md:text-2xl font-bold text-green-900">{{ number_format($statistics['completed_count']) }}<span class="text-base">건</span></div>
                </div>
                <div class="text-green-400 flex-shrink-0">
                    <svg class="w-8 h-8 md:w-10 md:h-10" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="card bg-gradient-to-br from-gray-50 to-slate-100 border-gray-200 p-5 md:p-6">
            <div class="flex items-center justify-between gap-3">
                <div class="flex-1">
                    <div class="text-xs md:text-sm text-gray-600 font-medium mb-3">전체</div>
                    <div class="text-xl md:text-2xl font-bold text-gray-900">{{ number_format($withdrawalRequests->total()) }}<span class="text-base">건</span></div>
                </div>
                <div class="text-gray-400 flex-shrink-0">
                    <svg class="w-8 h-8 md:w-10 md:h-10" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- 필터 --}}
    <div class="card mb-6 bg-gray-50">
        <div class="flex items-center mb-4">
            <svg class="w-5 h-5 text-gray-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"/>
            </svg>
            <h3 class="text-sm font-semibold text-gray-700">필터</h3>
        </div>
        <form action="{{ route('admin.withdrawal-request.index') }}" method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">상태</label>
                <select name="status" class="form-select w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">전체</option>
                    <option value="{{ \App\Enums\User\WithdrawalStatusEnum::PENDING->value }}" {{ $filter['status'] == \App\Enums\User\WithdrawalStatusEnum::PENDING->value ? 'selected' : '' }}>대기</option>
                    <option value="{{ \App\Enums\User\WithdrawalStatusEnum::APPROVED->value }}" {{ $filter['status'] == \App\Enums\User\WithdrawalStatusEnum::APPROVED->value ? 'selected' : '' }}>승인</option>
                    <option value="{{ \App\Enums\User\WithdrawalStatusEnum::REJECTED->value }}" {{ $filter['status'] == \App\Enums\User\WithdrawalStatusEnum::REJECTED->value ? 'selected' : '' }}>거절</option>
                    <option value="{{ \App\Enums\User\WithdrawalStatusEnum::COMPLETED->value }}" {{ $filter['status'] == \App\Enums\User\WithdrawalStatusEnum::COMPLETED->value ? 'selected' : '' }}>완료</option>
                </select>
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">시작일</label>
                <input type="date" name="date_from" value="{{ $filter['date_from'] }}" class="form-control w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">종료일</label>
                <input type="date" name="date_to" value="{{ $filter['date_to'] }}" class="form-control w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                    </svg>
                    조회
                </button>
                <a href="{{ route('admin.withdrawal-request.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition ml-2">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                    </svg>
                    초기화
                </a>
            </div>
        </form>
    </div>

    {{-- 출금 요청 테이블 --}}
    <div class="card !p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table">
                <thead class="border-y">
                    <tr>
                        <th class="w-20">ID</th>
                        <th class="w-32">신청일</th>
                        <th class="w-48">사용자</th>
                        <th class="w-32 text-right">출금 포인트</th>
                        <th class="w-56">계좌 정보</th>
                        <th class="w-24">상태</th>
                        <th>관리자 메모</th>
                        <th class="w-32">처리일</th>
                        <th class="w-48">액션</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($withdrawalRequests as $request)
                        <tr>
                            <td class="text-sm text-gray-600">{{ $request->id }}</td>
                            <td class="text-sm text-gray-600">
                                {{ $request->created_at->format('Y-m-d H:i') }}
                            </td>
                            <td>
                                <a href="{{ route('admin.user.general.show', $request->user) }}" class="text-blue-600 hover:underline">
                                    {{ $request->user->name }}
                                </a>
                                <div class="text-xs text-gray-500">{{ $request->user->email }}</div>
                            </td>
                            <td class="text-right font-medium text-gray-900">
                                {{ number_format($request->point) }}P
                            </td>
                            <td class="text-sm">
                                <div><strong>{{ $request->bank_name }}</strong></div>
                                <div class="text-gray-600">{{ $request->account_number }}</div>
                                <div class="text-gray-600">{{ $request->account_holder }}</div>
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
                                @if($request->processedBy)
                                    <div class="text-xs text-gray-500">{{ $request->processedBy->name }}</div>
                                @endif
                            </td>
                            <td>
                                @if($request->status === \App\Enums\User\WithdrawalStatusEnum::PENDING)
                                    <div class="flex gap-2">
                                        <button type="button" onclick="openApproveModal({{ $request->id }})"
                                                class="button button-sm button-success">
                                            승인
                                        </button>
                                        <button type="button" onclick="openRejectModal({{ $request->id }})"
                                                class="button button-sm button-danger">
                                            거절
                                        </button>
                                    </div>
                                @elseif($request->status === \App\Enums\User\WithdrawalStatusEnum::APPROVED)
                                    <button type="button" onclick="openCompleteModal({{ $request->id }})"
                                            class="button button-sm button-default">
                                        완료 처리
                                    </button>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-12 text-gray-500">
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

    {{-- 승인 모달 --}}
    <div id="approveModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-6 border w-96 shadow-2xl rounded-xl bg-white">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 ml-3">출금 요청 승인</h3>
            </div>
            <form id="approveForm" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">승인 메모</label>
                    <textarea name="admin_note" rows="3" class="form-control w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="승인 메모를 입력하세요 (선택)"></textarea>
                </div>
                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="closeApproveModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">취소</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition">승인</button>
                </div>
            </form>
        </div>
    </div>

    {{-- 거절 모달 --}}
    <div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-6 border w-96 shadow-2xl rounded-xl bg-white">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0 bg-red-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 ml-3">출금 요청 거절</h3>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        거절 사유 <span class="text-red-500">*</span>
                    </label>
                    <textarea name="admin_note" rows="3" class="form-control w-full focus:ring-2 focus:ring-red-500 focus:border-red-500"
                              placeholder="거절 사유를 입력하세요" required></textarea>
                </div>
                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">취소</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition">거절</button>
                </div>
            </form>
        </div>
    </div>

    {{-- 완료 처리 모달 --}}
    <div id="completeModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-6 border w-96 shadow-2xl rounded-xl bg-white">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 ml-3">출금 완료 처리</h3>
            </div>
            <form id="completeForm" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">완료 메모</label>
                    <textarea name="admin_note" rows="3" class="form-control w-full focus:ring-2 focus:ring-green-500 focus:border-green-500"
                              placeholder="완료 메모를 입력하세요 (선택)"></textarea>
                </div>
                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="closeCompleteModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">취소</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition">완료 처리</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openApproveModal(requestId) {
            document.getElementById('approveForm').action = `/admin/withdrawal-requests/${requestId}/approve`;
            document.getElementById('approveModal').classList.remove('hidden');
        }

        function closeApproveModal() {
            document.getElementById('approveModal').classList.add('hidden');
        }

        function openRejectModal(requestId) {
            document.getElementById('rejectForm').action = `/admin/withdrawal-requests/${requestId}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }

        function openCompleteModal(requestId) {
            document.getElementById('completeForm').action = `/admin/withdrawal-requests/${requestId}/complete`;
            document.getElementById('completeModal').classList.remove('hidden');
        }

        function closeCompleteModal() {
            document.getElementById('completeModal').classList.add('hidden');
        }

        // ESC 키로 모달 닫기
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeApproveModal();
                closeRejectModal();
                closeCompleteModal();
            }
        });
    </script>
</x-admin-layout>
