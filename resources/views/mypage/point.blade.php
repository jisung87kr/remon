<x-mypage-layout>
    <x-slot name="header">나의 포인트</x-slot>

    {{-- 포인트 요약 --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
        <div class="card bg-gradient-to-br from-blue-50 to-blue-100 border-blue-200 p-5 md:p-6">
            <div class="flex items-center justify-between gap-3">
                <div class="flex-1">
                    <div class="text-xs md:text-sm text-blue-600 font-medium mb-3">총 적립 포인트</div>
                    <div class="text-xl md:text-3xl font-bold text-blue-900">{{ number_format($summary['total_point']) }}<span class="text-lg md:text-xl">P</span></div>
                </div>
                <div class="text-blue-400 flex-shrink-0">
                    <svg class="w-10 h-10 md:w-12 md:h-12" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="card bg-gradient-to-br from-red-50 to-red-100 border-red-200 p-5 md:p-6">
            <div class="flex items-center justify-between gap-3">
                <div class="flex-1">
                    <div class="text-xs md:text-sm text-red-600 font-medium mb-3">사용 포인트</div>
                    <div class="text-xl md:text-3xl font-bold text-red-900">{{ number_format($summary['used_point']) }}<span class="text-lg md:text-xl">P</span></div>
                </div>
                <div class="text-red-400 flex-shrink-0">
                    <svg class="w-10 h-10 md:w-12 md:h-12" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="card bg-gradient-to-br from-green-50 to-green-100 border-green-200 p-5 md:p-6">
            <div class="flex items-center justify-between gap-3">
                <div class="flex-1">
                    <div class="text-xs md:text-sm text-green-600 font-medium mb-3">잔여 포인트</div>
                    <div class="text-xl md:text-3xl font-bold text-green-900">{{ number_format($summary['available_point']) }}<span class="text-lg md:text-xl">P</span></div>
                </div>
                <div class="text-green-400 flex-shrink-0">
                    <svg class="w-10 h-10 md:w-12 md:h-12" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="card bg-gradient-to-br from-yellow-50 to-yellow-100 border-yellow-200 p-5 md:p-6">
            <div class="flex items-center justify-between gap-3">
                <div class="flex-1">
                    <div class="text-xs md:text-sm text-yellow-600 font-medium mb-3">만료 예정</div>
                    <div class="text-xl md:text-3xl font-bold text-yellow-900">{{ number_format($summary['expiring_soon_point']) }}<span class="text-lg md:text-xl">P</span></div>
                    <div class="text-xs text-yellow-600 mt-2">30일 이내</div>
                </div>
                <div class="text-yellow-400 flex-shrink-0">
                    <svg class="w-10 h-10 md:w-12 md:h-12" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- 필터 --}}
    <div class="card mb-6 bg-gray-50 p-3">
        <div class="flex items-center mb-4">
            <svg class="w-5 h-5 text-gray-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"/>
            </svg>
            <h3 class="text-sm font-semibold text-gray-700">필터</h3>
        </div>
        <form action="{{ route('mypage.point') }}" method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">구분</label>
                <select name="type" class="form-select w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                    <option value="">전체</option>
                    <option value="{{ \App\Enums\User\PointTypeEnum::INCREMENT->value }}" {{ request('type') == \App\Enums\User\PointTypeEnum::INCREMENT->value ? 'selected' : '' }}>적립</option>
                    <option value="{{ \App\Enums\User\PointTypeEnum::DECREMENT->value }}" {{ request('type') == \App\Enums\User\PointTypeEnum::DECREMENT->value ? 'selected' : '' }}>차감</option>
                </select>
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">시작일</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">종료일</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="button button-default inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                    </svg>
                    조회
                </button>
                <a href="{{ route('mypage.point') }}" class="button button-light inline-flex items-center px-4 py-2 bg-white hover:bg-gray-100 text-gray-700 font-medium rounded-lg border border-gray-300 transition">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                    </svg>
                    초기화
                </a>
            </div>
        </form>
    </div>

    {{-- 포인트 내역 테이블 --}}
    <div class="card overflow-hidden p-3">
        <div class="overflow-x-auto">
            <table class="table">
                <thead class="border-y">
                    <tr>
                        <th class="w-32">일시</th>
                        <th class="w-24">구분</th>
                        <th class="w-32 text-right">포인트</th>
                        <th>설명</th>
                        <th class="w-48">캠페인</th>
                        <th class="w-32">만료일</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($points as $point)
                        <tr>
                            <td class="text-sm text-gray-600">
                                {{ $point->created_at->format('Y-m-d H:i') }}
                            </td>
                            <td>
                                @if($point->type === \App\Enums\User\PointTypeEnum::INCREMENT)
                                    <span class="badge badge-green">{{ $point->type->label() }}</span>
                                @else
                                    <span class="badge badge-red">{{ $point->type->label() }}</span>
                                @endif
                            </td>
                            <td class="text-right font-medium">
                                @if($point->type === \App\Enums\User\PointTypeEnum::INCREMENT)
                                    <span class="text-green-600">+{{ number_format($point->point) }}</span>
                                @else
                                    <span class="text-red-600">-{{ number_format($point->point) }}</span>
                                @endif
                            </td>
                            <td>{{ $point->description }}</td>
                            <td>
                                @if($point->campaign)
                                    <a href="{{ route('campaign.show', $point->campaign) }}" class="text-blue-600 hover:underline">
                                        {{ Str::limit($point->campaign->title, 30) }}
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="text-sm">
                                @if($point->expired_at)
                                    @if($point->expired_at->isPast())
                                        <span class="text-gray-400">만료됨</span>
                                    @elseif($point->expired_at->diffInDays() <= 30)
                                        <span class="text-red-600">{{ $point->expired_at->format('Y-m-d') }}</span>
                                    @else
                                        <span class="text-gray-600">{{ $point->expired_at->format('Y-m-d') }}</span>
                                    @endif
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-gray-500">
                                포인트 내역이 없습니다.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 페이지네이션 --}}
    <div class="mt-6">
        {{ $points->appends(request()->query())->links() }}
    </div>

    {{-- 안내 사항 --}}
    <div class="card mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-blue-200 p-3">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3 text-sm">
                <h4 class="font-bold text-blue-900 mb-3">포인트 안내</h4>
                <ul class="space-y-2 text-blue-800">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>캠페인 완료 시 설정된 포인트가 자동으로 적립됩니다.</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>포인트는 만료일까지 사용 가능하며, 만료 시 자동으로 소멸됩니다.</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>만료 예정 포인트는 30일 이내 만료 예정인 포인트입니다.</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>포인트는 <a href="{{ route('mypage.withdrawal-request') }}" class="font-semibold text-blue-700 hover:text-blue-900 underline">출금 요청</a>을 통해 현금으로 전환할 수 있습니다. (최소 10,000P)</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-mypage-layout>
