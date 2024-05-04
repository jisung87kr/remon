<x-admin-layout>
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
                       @forelse($campaigns as $campaign)
                           <tr>
                               <td>
                                   <a href="{{ route('campaign.show', $campaign) }}" target="_blank">{{ $campaign->title }}</a>
                               </td>
                               <td>{{ $campaign->applications->count() }} / {{ $campaign->application_limit }}</td>
                               <td>{{ $campaign->progressStatus }} </td>
                               <td>{{ $campaign->created_at->format('y-m-d') }}</td>
                           </tr>
                       @empty
                           <tr>
                               <td>-</td>
                               <td>-</td>
                               <td>-</td>
                               <td>-</td>
                           </tr>
                       @endforelse
                       </tbody>
                   </table>
                   @if($campaigns->links())
                       <div class="p-5">
                           {{ $campaigns->links() }}
                       </div>
                   @endif
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
       </div>
    </div>
</x-admin-layout>
