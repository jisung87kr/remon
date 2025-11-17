<x-admin-layout>
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
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

    <div class="clear">
        <div class="card lg:float-start lg:w-[30%]">
            <div class="avatar text-center">
                <img src="{{ $user->profile_photo_url }}" alt="" class="mx-auto">
                <div class="my-3 text-lg">{{ $user->name }}</div>
                @if($user->getRoleNames())
                    <div>
                        @foreach($user->getRoleNames() as $roleName)
                            <span class="badge badge-gray">{{ \App\Enums\RoleEnum::tryFrom($roleName)->label() }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
            <hr class="my-5">
            <div>
                <div class="mb-4 text-gray-500">정보</div>
                <div class="my-3">이름: {{ $user->name }}</div>
                <div class="my-3">이메일: <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></div>
                <div class="my-3">상태: <span class="badge badge-green">{{ $user->status }}</span></div>
                <div class="my-3">연락처: <a href="tel:{{ $user->phone ?? '-' }}">{{ $user->phone ?? '-' }}</a></div>
            </div>
            <div class="text-center">
                <a href="{{ route('admin.user.business.edit', $user) }}" class="button button-default">수정</a>
            </div>
        </div>
       <div class="flex flex-col gap-5 mt-5 lg:mt-0 lg:float-start lg:w-[70%] lg:pl-5">
           <div class="card !p-0">
               <div class="p-5 text-lg">캠페인 리스트</div>
               <div class="p-5 flex justify-between">
                   <div class="flex gap-3 items-center">
                       <span class="shrink-0">보기</span>
                       <select name="" id="" class="form-select !w-[100px]">
                           <option value="">10</option>
                           <option value="">20</option>
                           <option value="">30</option>
                       </select>
                   </div>
                   <div class="flex gap-3 items-center">
                       <span class="shrink-0">검색</span>
                       <input type="text" class="form-control">
                   </div>
               </div>
               <div>
                   <table class="table">
                       <thead class="border-y">
                       <tr>
                           <th>캠페인</th>
                           <th>신청</th>
                           <th>상태</th>
                           <th>등록일</th>
                       </tr>
                       </thead>
                       <tbody>
                       <tr>
                           <td>-</td>
                           <td>-</td>
                           <td>-</td>
                           <td>-</td>
                       </tr>
                       <tr>
                           <td>-</td>
                           <td>-</td>
                           <td>-</td>
                           <td>-</td>
                       </tr>
                       <tr>
                           <td>-</td>
                           <td>-</td>
                           <td>-</td>
                           <td>-</td>
                       </tr>
                       <tr>
                           <td>-</td>
                           <td>-</td>
                           <td>-</td>
                           <td>-</td>
                       </tr>
                       </tbody>
                   </table>
               </div>
           </div>
           <div class="card !p-0">
               <div class="p-5 text-lg">결제 내역</div>
               <div class="p-5 flex justify-between">
                   <div class="flex gap-3 items-center">
                       <span class="shrink-0">보기</span>
                       <select name="" id="" class="form-select !w-[100px]">
                           <option value="">10</option>
                           <option value="">20</option>
                           <option value="">30</option>
                       </select>
                   </div>
               </div>
               <div>
                   <table class="table">
                       <thead class="border-y">
                       <tr>
                           <th>ID</th>
                           <th>상품명</th>
                           <th>결제일</th>
                           <th>상태</th>
                           <th>행동</th>
                       </tr>
                       </thead>
                       <tbody>
                       <tr>
                           <td>-</td>
                           <td>-</td>
                           <td>-</td>
                           <td>-</td>
                           <td>-</td>
                       </tr>
                       </tbody>
                   </table>
               </div>
           </div>

           {{-- 포인트 내역 섹션 --}}
           <div class="card">
               <div class="flex justify-between items-center mb-4">
                   <div class="text-lg font-medium">포인트 요약</div>
                   <button type="button" onclick="openDeductPointModal()" class="button button-danger">
                       포인트 차감
                   </button>
               </div>
               <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                   <div class="p-4 bg-blue-50 rounded-lg">
                       <div class="text-sm text-gray-500 mb-1">총 적립</div>
                       <div class="text-xl font-bold text-gray-900">{{ number_format($pointSummary['total_point']) }}P</div>
                   </div>
                   <div class="p-4 bg-red-50 rounded-lg">
                       <div class="text-sm text-gray-500 mb-1">사용</div>
                       <div class="text-xl font-bold text-red-600">{{ number_format($pointSummary['used_point']) }}P</div>
                   </div>
                   <div class="p-4 bg-green-50 rounded-lg">
                       <div class="text-sm text-gray-500 mb-1">잔여</div>
                       <div class="text-xl font-bold text-green-600">{{ number_format($pointSummary['available_point']) }}P</div>
                   </div>
                   <div class="p-4 bg-yellow-50 rounded-lg">
                       <div class="text-sm text-gray-500 mb-1">만료 예정</div>
                       <div class="text-xl font-bold text-yellow-600">{{ number_format($pointSummary['expiring_soon_point']) }}P</div>
                       <div class="text-xs text-gray-400 mt-1">30일 이내</div>
                   </div>
               </div>
           </div>

           <div class="card !p-0">
               <div class="p-5 flex justify-between items-center">
                   <div class="text-lg">최근 포인트 내역</div>
                   <a href="{{ route('mypage.point', ['user_id' => $user->id]) }}" class="text-sm text-blue-600 hover:underline">전체 보기</a>
               </div>
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
                           @forelse($recentPoints as $point)
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
                                           <a href="{{ route('campaign.show', $point->campaign) }}" class="text-blue-600 hover:underline" target="_blank">
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
                                   <td colspan="6" class="text-center py-8 text-gray-500">
                                       포인트 내역이 없습니다.
                                   </td>
                               </tr>
                           @endforelse
                       </tbody>
                   </table>
               </div>
           </div>
       </div>
    </div>

    {{-- 포인트 차감 모달 --}}
    <div id="deductPointModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">포인트 차감</h3>
                <form id="deductPointForm" action="{{ route('admin.user.general.deduct-point', $user) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            차감 포인트 <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="point" id="deduct_point" min="1" max="{{ $pointSummary['available_point'] }}"
                               class="form-control w-full" placeholder="차감할 포인트를 입력하세요" required>
                        <p class="text-xs text-gray-500 mt-1">현재 잔여 포인트: {{ number_format($pointSummary['available_point']) }}P</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            차감 사유 <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" id="deduct_description" rows="3"
                                  class="form-control w-full" placeholder="차감 사유를 입력하세요" required></textarea>
                    </div>
                    <div class="flex gap-3 justify-end">
                        <button type="button" onclick="closeDeductPointModal()" class="button button-light">
                            취소
                        </button>
                        <button type="submit" class="button button-danger">
                            차감하기
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openDeductPointModal() {
            document.getElementById('deductPointModal').classList.remove('hidden');
            document.getElementById('deduct_point').value = '';
            document.getElementById('deduct_description').value = '';
        }

        function closeDeductPointModal() {
            document.getElementById('deductPointModal').classList.add('hidden');
        }

        // ESC 키로 모달 닫기
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeDeductPointModal();
            }
        });

        // 모달 외부 클릭 시 닫기
        document.getElementById('deductPointModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeDeductPointModal();
            }
        });
    </script>
</x-admin-layout>
