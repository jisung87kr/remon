<x-mypage-layout>
    <x-slot name="header">링크 만들기</x-slot>
    <div x-data="linkData">
        <div class="my-3 text-right">
            <button type="button" class="button button-default" @click="modal.show()">링크 생성</button>
        </div>
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                <tr>
                    <th>원본 링크</th>
                    <th>레몬 링크</th>
                    <th>클릭수</th>
                    <th>등록일</th>
                    <th>관리</th>
                </tr>
                </thead>
                <tbody>
                @forelse($links as $link)
                    <tr>
                        <td>
                            <a href="{{ $link->original_url }}" target="_blank">{{ $link->original_url }}</a>
                        </td>
                        <td>
                            {{ $link->shortened_url ? $link->shortened_url : $link->redirect_url }}
                            <button type="button" class="badge badge-green border border-green-400" @click="copyLink('{{ $link->shortened_url ? $link->shortened_url : $link->redirect_url }}')">링크복사</button>
                        </td>
                        <td>
                            <a href="{{ route('link.log.index', $link) }}">{{ number_format($link->log_count) }}</a>
                        </td>
                        <td>
                            <div>{{ $link->created_at }}</div>
                        </td>
                        <td>
                            <div class="flex gap-1">
                                <button type="button" class="button button-default-outline !text-xs !px-3 !py-2" @click="editLink({{ $link->id }}, '{{ $link->original_url }}')">수정</button>
                                <button type="button" class="button button-gray-outline !text-xs !px-3 !py-2" @click="deleteLink({{ $link->id }})">삭제</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <td colspan="5">등록된 링크가 없습니다.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            @if($links->links())
                <div class="mt-3">{{$links->links()}}</div>
            @endif
        </div>

        <div id="modalEl" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
            <div class="relative max-h-full w-full max-w-2xl">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white shadow">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between rounded-t border-b p-5">
                        <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl">링크 생성</h3>
                        <button type="button" class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900">
                            <svg
                                    class="h-3 w-3"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 14 14"
                            >
                                <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                                />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="space-y-6 p-6">
                        <input type="text" name="original_url" x-model="original_url" class="form-control">
                        <small>* 링크를 입력하세요</small>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center space-x-2 rtl:space-x-reverse rounded-b border-t border-gray-200 p-6">
                        <button type="button" class="rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300" @click="createLink">저장</button>
                        <button type="button" class="rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:outline-none focus:ring-4 focus:ring-blue-300" @click="modal.hide()">닫기</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="drawer" class="fixed z-40 h-screen w-80 overflow-y-auto bg-white p-4 transition-transform right-0 top-0 translate-x-full" tabindex="-1" aria-labelledby="drawer-js-label">
            <h5 id="drawer-js-label" class="mb-4 inline-flex items-center text-base font-semibold text-gray-500 dark:text-gray-400"></h5>
            <button id="drawer-hide-button"
                    type="button"
                    aria-controls="drawer-example"
                    class="absolute right-2.5 top-2.5 inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900">
                <svg class="h-3 w-3"
                     aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 14 14">
                    <path stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close menu</span>
            </button>
            <p class="mt-3 mb-6 text-sm text-gray-500 dark:text-gray-400">
                <input type="text" name="original_url" x-model="original_url" class="form-control">
            </p>
            <div class="grid grid-cols-2 gap-4">
                <button type="button"
                        class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-center text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-200"
                        @click="drawer.hide()">닫기</button>
                <button type="button"
                        class="rounded-lg bg-blue-700 px-4 py-2 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300"
                        @click="updateLink"
                >저장</button>
            </div>
        </div>
    </div>
    <script>
        const linkData = {
          original_url: '',
          current_id: null,
          modal: null,
          drawer: null,
          init(){
            this.initModal();
            this.initDrawer();
          },
          initModal(){
            // set the modal menu element
            const $targetEl = document.getElementById('modalEl');
            const options = {
              placement: 'center',
              backdrop: 'dynamic',
              backdropClasses:
                'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
              closable: true,
              onHide: () => {
              },
              onShow: () => {
              },
              onToggle: () => {
              },
            };
            const instanceOptions = {
              id: 'modalEl',
              override: true
            };

            this.modal = new Modal($targetEl, options, instanceOptions);
          },
          initDrawer(){
            const $targetEl = document.getElementById('drawer');
            const options = {
              placement: 'right',
              backdrop: true,
              bodyScrolling: false,
              edge: false,
              edgeOffset: '',
              backdropClasses:
                'bg-gray-900/50 fixed inset-0 z-30',
              onHide: () => {
                console.log('drawer is hidden');
              },
              onShow: () => {
                console.log('drawer is shown');
              },
              onToggle: () => {
                console.log('drawer has been toggled');
              },
            };

            const instanceOptions = {
              id: 'drawer',
              override: true
            };

            this.drawer = new Drawer($targetEl, options, instanceOptions);
            // this.drawer.hide();
          },
          createLink(){
            let params = {
              original_url: this.original_url,
            };

            axios.post('/internal/links', params).then(res => {
              if(res.data.status === 'ERROR'){
                throw new Error(res.data.message);
              }
              alert('등록 완료.');
              window.location.reload();
            }).catch(error => {
              alert(error.message);
            });
          },
          editLink(id, link){
            this.original_url = link;
            this.current_id = id;
            this.drawer.show();
          },
          updateLink(){
            let params = {
              original_url: this.original_url
            }
            axios.put(`/internal/links/${this.current_id}`, params).then(res => {
              if(res.data.status === 'ERROR'){
                throw new Error(res.data.message);
              }
              alert('수정 완료');
              window.location.reload();
            }).catch(error => {
              alert(error.message);
            });
          },
          deleteLink(id){
            axios.delete(`/internal/links/${id}`).then(res => {
              if(res.data.status === 'ERROR'){
                throw new Error(res.data.message);
              }
              alert('삭제 완료');
              window.location.reload();
            }).catch(error => {
              alert(error.message);
            })
          },
          copyLink(text){
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            alert('링크복사 완료');
          }
        }
    </script>
</x-mypage-layout>
