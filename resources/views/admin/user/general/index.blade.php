<x-admin-layout>
    <x-admin.card-default :action="route(Route::currentRouteName())">
        <x-slot name="filter">
            <div class="flex gap-3">
                <select name="status" id="status" class="form-select !bg-white">
                    <option value="">상태 선택</option>
                    @foreach(App\Enums\User\StatusEnum::cases() as $case)
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
                    <a href="{{ route('admin.user.general.create') }}" class="button button-default shrink-0 flex gap-3 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        <span>회원 등록</span>
                    </a>
                </div>
            </div>
        </x-slot>
        <div class="relative overflow-auto" x-data="userData">
            <table class="table">
                <colgroup>
                    <col width="*">
                    <col width="150px">
                    <col width="150px">
                    <col width="150px">
                </colgroup>
                <thead class="!bg-white border-y">
                <tr>
                    <th>회원</th>
                    <th>이름</th>
                    <th>상태</th>
                    <th>행동</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            <x-user.avatar :user="$user"></x-user.avatar>
                        </td>
                        <td>{{ $user->name }}</td>
                        <td class="text-center">
                            <x-badge.user :status="$user->status">{{ App\Enums\User\StatusEnum::tryFrom($user->status)->label() }}</x-badge.user>
                        </td>
                        <td>
                            <div class="flex gap-3 items-center">
                                <a href="{{ route('admin.user.general.edit', $user) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                        <path d="M16 5l3 3" />
                                    </svg>
                                </a>
                                <a href="{{ route('admin.user.general.show', $user) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>
                                </a>
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dots-vertical" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link class="flex gap-3 items-center" href="{{ route('admin.user.general.show', $user) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                            </svg>
                                            <span>보기</span>
                                        </x-dropdown-link>
                                        <x-dropdown-link class="flex gap-3 items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                <path d="M16 5l3 3" />
                                            </svg>
                                            <span>수정</span>
                                        </x-dropdown-link>
                                        <x-dropdown-link class="flex gap-3 items-center" @click="deleteUser('{{ $user->id }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M4 7l16 0" />
                                                <path d="M10 11l0 6" />
                                                <path d="M14 11l0 6" />
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                            </svg>
                                            <span>삭제</span>
                                        </x-dropdown-link>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if($users->links())
            <div class="p-5">
                {{ $users->appends(request()->query())->links() }}
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
