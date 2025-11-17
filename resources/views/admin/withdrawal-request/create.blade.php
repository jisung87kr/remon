<x-admin-layout>
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.withdrawal-request.index') }}" class="text-gray-600 hover:text-gray-900 mr-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <svg class="w-8 h-8 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
        </svg>
        <h1 class="text-2xl font-bold">출금 요청 생성</h1>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 안내 사항 --}}
    <div class="card mb-6 bg-gradient-to-r from-yellow-50 to-amber-50 border-yellow-200 p-5 md:p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3 text-sm">
                <h4 class="font-bold text-yellow-900 mb-2">관리자 출금 요청 생성 안내</h4>
                <ul class="space-y-1 text-yellow-800">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>사용자가 직접 요청하지 않은 경우에도 관리자가 대신 출금 요청을 생성할 수 있습니다.</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>사용자의 사용 가능한 포인트를 확인하고 생성하세요.</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>최소 출금 포인트는 10,000P입니다.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.withdrawal-request.store') }}" method="POST">
        @csrf

        {{-- 사용자 선택 --}}
        <div class="card mb-6 p-5 md:p-6 bg-gradient-to-r from-gray-50 to-slate-50">
            <div class="flex items-center mb-4">
                <svg class="w-6 h-6 text-gray-700 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                </svg>
                <h3 class="text-lg font-bold text-gray-900">사용자 선택</h3>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        사용자 검색 <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="userSearch" class="form-control w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="사용자 이름, 이메일, 닉네임으로 검색" value="{{ request('search') }}">
                </div>

                <div id="userList" class="grid grid-cols-1 gap-3 max-h-96 overflow-y-auto">
                    @foreach($users as $u)
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-blue-50 transition {{ $user && $user->id == $u->id ? 'bg-blue-50 border-blue-300' : 'bg-white border-gray-200' }}">
                            <input type="radio" name="user_id" value="{{ $u->id }}"
                                   class="form-radio text-blue-600 focus:ring-blue-500"
                                   {{ old('user_id', $user?->id) == $u->id ? 'checked' : '' }}
                                   onchange="selectUser({{ $u->id }}, '{{ $u->name }}', '{{ $u->email }}', {{ $u->available_point }}, '{{ $u->bank_name }}', '{{ $u->account_number }}', '{{ $u->account_holder }}')">
                            <div class="ml-3 flex-1">
                                <div class="font-semibold text-gray-900">{{ $u->name }}</div>
                                <div class="text-sm text-gray-600">{{ $u->email }}</div>
                                <div class="text-sm text-blue-600 font-medium mt-1">사용 가능 포인트: {{ number_format($u->available_point) }}P</div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 선택된 사용자 정보 --}}
        <div id="selectedUserInfo" class="card mb-6 p-5 md:p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-blue-200 {{ $user ? '' : 'hidden' }}">
            <div class="flex items-center mb-4">
                <svg class="w-6 h-6 text-blue-700 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
                <h3 class="text-lg font-bold text-blue-900">선택된 사용자</h3>
            </div>
            <div class="space-y-2 text-blue-800">
                <div class="flex">
                    <span class="font-semibold w-32">이름:</span>
                    <span id="selectedUserName">{{ $user?->name }}</span>
                </div>
                <div class="flex">
                    <span class="font-semibold w-32">이메일:</span>
                    <span id="selectedUserEmail">{{ $user?->email }}</span>
                </div>
                <div class="flex">
                    <span class="font-semibold w-32">사용 가능 포인트:</span>
                    <span id="selectedUserPoint" class="text-blue-600 font-bold">{{ $user ? number_format($user->available_point) : '0' }}P</span>
                </div>
            </div>
        </div>

        {{-- 출금 정보 --}}
        <div class="card mb-6 p-5 md:p-6 bg-gradient-to-r from-gray-50 to-slate-50">
            <div class="flex items-center mb-4">
                <svg class="w-6 h-6 text-gray-700 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                </svg>
                <h3 class="text-lg font-bold text-gray-900">출금 정보</h3>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        출금 포인트 <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="point" value="{{ old('point') }}"
                           class="form-control w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="최소 10,000P" min="10000" step="1000" required>
                    <p class="text-xs text-gray-500 mt-1">최소 출금 포인트: 10,000P</p>
                </div>
            </div>
        </div>

        {{-- 계좌 정보 --}}
        <div class="card mb-6 p-5 md:p-6 bg-gradient-to-r from-gray-50 to-slate-50">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-700 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>
                    <h3 class="text-lg font-bold text-gray-900">계좌 정보</h3>
                </div>
                <button type="button" id="loadAccountBtn" onclick="loadUserAccount()" class="text-sm text-blue-600 hover:text-blue-800 font-medium hidden">
                    사용자 계좌 정보 불러오기
                </button>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        은행명 <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="bank_name" name="bank_name" value="{{ old('bank_name') }}"
                           class="form-control w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="예: 국민은행" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        계좌번호 <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="account_number" name="account_number" value="{{ old('account_number') }}"
                           class="form-control w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="'-' 없이 숫자만 입력" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        예금주 <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="account_holder" name="account_holder" value="{{ old('account_holder') }}"
                           class="form-control w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="예금주 이름" required>
                </div>
            </div>
        </div>

        <div class="flex gap-3 justify-end">
            <a href="{{ route('admin.withdrawal-request.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition">
                취소
            </a>
            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition duration-150">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                출금 요청 생성
            </button>
        </div>
    </form>

    <script>
        let selectedUserData = {
            bank_name: '{{ old('bank_name', $user?->bank_name) }}',
            account_number: '{{ old('account_number', $user?->account_number) }}',
            account_holder: '{{ old('account_holder', $user?->account_holder) }}'
        };

        function selectUser(id, name, email, point, bankName, accountNumber, accountHolder) {
            document.getElementById('selectedUserInfo').classList.remove('hidden');
            document.getElementById('selectedUserName').textContent = name;
            document.getElementById('selectedUserEmail').textContent = email;
            document.getElementById('selectedUserPoint').textContent = point.toLocaleString() + 'P';

            // 사용자의 계좌 정보 저장
            selectedUserData = {
                bank_name: bankName,
                account_number: accountNumber,
                account_holder: accountHolder
            };

            // 계좌 정보 불러오기 버튼 표시 (계좌 정보가 있는 경우)
            if (bankName && accountNumber && accountHolder) {
                document.getElementById('loadAccountBtn').classList.remove('hidden');
            } else {
                document.getElementById('loadAccountBtn').classList.add('hidden');
            }
        }

        function loadUserAccount() {
            if (selectedUserData.bank_name) {
                document.getElementById('bank_name').value = selectedUserData.bank_name;
                document.getElementById('account_number').value = selectedUserData.account_number;
                document.getElementById('account_holder').value = selectedUserData.account_holder;
            }
        }

        // 사용자 검색
        let searchTimeout;
        document.getElementById('userSearch').addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const search = e.target.value;
                window.location.href = '{{ route('admin.withdrawal-request.create') }}?search=' + encodeURIComponent(search);
            }, 500);
        });

        // 초기 로드 시 사용자가 선택된 경우
        @if($user)
            document.getElementById('selectedUserInfo').classList.remove('hidden');
            @if($user->bank_name && $user->account_number && $user->account_holder)
                document.getElementById('loadAccountBtn').classList.remove('hidden');
            @endif
        @endif
    </script>
</x-admin-layout>
