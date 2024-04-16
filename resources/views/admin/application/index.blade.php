<x-admin-layout>
    <div class="absolute top-6 right-6">
        @if(session('status'))
            <x-toast toast="success">{{ session('status') }}</x-toast>
            <x-toast toast="danger">{{ session('status') }}</x-toast>
            <x-toast toast="error">{{ session('status') }}</x-toast>
        @elseif(session('error'))
            <x-toast toast="error">{{ session('status') }}</x-toast>
        @endif
    </div>
    <x-admin.card-default :action="route(Route::currentRouteName())">
        <x-slot name="filter">
            <div class="flex gap-3">
                <select name="status" id="status" class="form-select !bg-white">
                    <option value="">상태 선택</option>
                    @foreach(\App\Enums\Campaign\ApplicationStatus::cases() as $case)
                        <option value="{{ $case->value }}" @selected(request()->input('status') == $case->value)>{{ $case->label() }}</option>
                    @endforeach
                </select>
            </div>
        </x-slot>
        <x-slot name="search">
            <div class="flex gap-3 p-6 border-t justify-between">
                <select name="size" id="size" class="form-select !bg-white" style="width: 150px">
                    <option value="10" @selected(request()->input('size') == 10)>10</option>
                    <option value="30" @selected(request()->input('size') == 30)>30</option>
                    <option value="50" @selected(request()->input('size') == 50)>50</option>
                </select>
                <div class="w-full flex justify-end gap-3">
                    <input type="text" name="keyword" class="form-control" style="width: 200px" value="{{ request()->input('keyword') }}">
                    <input type="submit" value="검색" class="button button-default">
                    <a href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->query(), ['export' => 1])) }}" target="_blank" class="button shrink-0 flex gap-3 bg-gray-200 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                            <path d="M7 11l5 5l5 -5" />
                            <path d="M12 4l0 12" />
                        </svg>
                        <span>내보내기</span>
                    </a>
                </div>
            </div>
        </x-slot>
        <hr class="">
        <form action="{{ route('admin.application.updateStatus') }}" method="POST">
            @csrf
            <div class="p-6 text-right">
                <input type="submit" class="button button-purple" value="저장">
            </div>
            <div class="relative overflow-auto" x-data="userData">
                <table class="table">
                    <colgroup>
                        <col width="30px">
                        <col width="30px">
                        <col width="*">
                        <col width="120px">
                        <col width="150px">
                        <col width="150px">
                        <col width="70px">
                        <col width="150px">
                    </colgroup>
                    <thead class="!bg-white border-y">
                    <tr>
                        <th>#</th>
                        <th>id</th>
                        <th>캠페인</th>
                        <th>신청자</th>
                        <th>상태</th>
                        <th>신청일</th>
                        <th>행동</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($applications as $application)
                        <tr>
                            <td>
                                <input type="checkbox" name="application[{{ $loop->index }}][checked]" value="1" class="form-check"
                                        @disabled(in_array($application->status, [\App\Enums\Campaign\ApplicationStatus::POSTED->value, \App\Enums\Campaign\ApplicationStatus::COMPLETED->value]))>
                            </td>
                            <td>{{ $application->id }}</td>
                            <td>
                                <a href="{{ route('campaign.show', $application->campaign) }}" target="_blank">{{ $application->campaign->title }}</a>
                            </td>
                            <td>
                                <a href="{{ route('admin.user.general.show', ['user' => $application->user_id]) }}" target="_blank">{{ $application->name }}</a>
                            </td>
                            <td>
                                <x-badge.application :status="$application->status">{{ \App\Enums\Campaign\ApplicationStatus::tryFrom($application->status)->label() }}</x-badge.application>
                            </td>
                            <td>{{ $application->created_at ? $application->created_at->format('m-d') : '-' }}</td>
                            <td>
                                <div class="flex gap-3 items-center">
                                    <a href="{{ route('campaign.application.show', [$application->campaign, $application]) }}" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <input type="hidden" name="application[{{ $loop->index }}][id]" value="{{ $application->id }}">
                                <select name="application[{{ $loop->index }}][status]" class="form-select" @disabled(in_array($application->status, [\App\Enums\Campaign\ApplicationStatus::POSTED->value, \App\Enums\Campaign\ApplicationStatus::COMPLETED->value]))>>
                                    @foreach(\App\Enums\Campaign\ApplicationStatus::cases() as $case)
                                        <option value="{{ $case->value }}" @selected($application->status == $case->value)>{{ $case->label() }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </form>
        @if($applications->links())
            <div class="p-5">
                {{ $applications->appends(request()->query())->links() }}
            </div>
        @endif
    </x-admin.card-default>
    <script defer>
      window.onload = function(){
        $(document).ready(function(){
          $(".form-select").select2();
        });
      }
      const userData = {
        deleteUser(id){
          axios.delete(`/api/user/${id}`).then(res => {
            Swal.fire({
              icon: 'success',
              title: res.data.message,
              didClose: () => {
                window.location.reload();
              }
            });
          }).catch(res => {
            Swal.fire({
              icon: 'error',
              title: res.data.message,
              didClose: () => {
                window.location.reload();
              }
            });
          });
        }
      }
    </script>
</x-admin-layout>
