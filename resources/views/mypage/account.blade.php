<x-mypage-layout>
    <x-slot name="header">출금 계좌 정보</x-slot>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
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

    {{-- 현재 계좌 정보 --}}
    @if($user->bank_name)
        <div class="card bg-gradient-to-r from-blue-50 to-indigo-50 border-blue-200 p-5 md:p-6 mb-6">
            <div class="flex items-start">
                <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="font-bold text-blue-900 mb-3 text-lg">현재 등록된 계좌 정보</h3>
                    <div class="space-y-2 text-blue-800">
                        <div class="flex">
                            <span class="font-semibold w-20">은행:</span>
                            <span>{{ $user->bank_name }}</span>
                        </div>
                        <div class="flex">
                            <span class="font-semibold w-20">계좌번호:</span>
                            <span>{{ $user->account_number }}</span>
                        </div>
                        <div class="flex">
                            <span class="font-semibold w-20">예금주:</span>
                            <span>{{ $user->account_holder }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- 계좌 정보 등록/수정 폼 --}}
    <div class="card p-5 md:p-6 bg-gradient-to-r from-gray-50 to-slate-50">
        <div class="flex items-center mb-6">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 ml-3">
                @if($user->bank_name)
                    계좌 정보 수정
                @else
                    계좌 정보 등록
                @endif
            </h3>
        </div>

        <form action="{{ route('mypage.account.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        은행명 <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="bank_name" value="{{ old('bank_name', $user->bank_name) }}"
                           class="form-control w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="예: 국민은행" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        계좌번호 <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="account_number" value="{{ old('account_number', $user->account_number) }}"
                           class="form-control w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="'-' 없이 숫자만 입력" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        예금주 <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="account_holder" value="{{ old('account_holder', $user->account_holder) }}"
                           class="form-control w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="예금주 이름" required>
                </div>
            </div>

            <div class="mt-6 flex gap-3 justify-end">
                <a href="{{ route('mypage.point') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition">
                    취소
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition duration-150">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    저장
                </button>
            </div>
        </form>
    </div>

    {{-- 안내 사항 --}}
    <div class="card mt-6 bg-gradient-to-r from-yellow-50 to-amber-50 border-yellow-200 p-5 md:p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3 text-sm">
                <h4 class="font-bold text-yellow-900 mb-3">계좌 정보 안내</h4>
                <ul class="space-y-2 text-yellow-800">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>등록한 계좌 정보는 <span class="font-semibold">출금 요청 시 자동으로 입력</span>됩니다.</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>계좌 정보는 언제든지 수정할 수 있습니다.</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>반드시 본인 명의의 계좌를 등록해주세요.</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>잘못된 계좌 정보로 인한 문제는 책임지지 않습니다.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-mypage-layout>
