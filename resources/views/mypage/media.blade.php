<x-mypage-layout>
    <x-slot name="header">미디어 연결</x-slot>
    <div class="mt-6">
        <div>{{ auth()->user()->name }}님, <strong>미디어를 연결</strong>해주세요.</div>
        <div class="text-gray-500 text-sm">미디어를 연결하면 다양한 체험을 신청할 수 있어요!</div>
    </div>
    <div class="grid md:grid-cols-3 gap-3 mt-8" x-data="mediaData">
        <div class="text-center p-12 border rounded-2xl">
            <img src="{{ Vite::asset('resources/images/media/ic-connect-blog.svg') }}" alt="" class="mx-auto">
            <div class="my-6 font-bold text-gray-700">블로그 연결하기</div>
            <x-rootmodal>
                <x-slot name="trigger">
                    <button type="button"
                            class="button button-light mt-6"
                            :class="{ 'button-green': blog.id, 'button-light' : !blog.id}"
                            @click="openModal('blog')" x-text="blog.id ? '연결됨' : '연결하기'">연결하기</button>
                </x-slot>
                <x-slot name="header"></x-slot>
                <div class="text-left">
                    <label for="blog" class="label">네이버 블로그 주소</label>
                    <div class="flex gap-3 mt-3 mb-1">
                        <input type="text" name="url" x-model="blog.url" class="form-control" id="blog" placeholder="http://example.com">
                        <template x-if="blog.id">
                            <button type="button" class="shrink-0 button button-light" @click="deleteUrl(blog.id)">연결끊기</button>
                        </template>
                    </div>
                    <small>주소를 정확히 입력해주세요</small>
                </div>
                <x-slot name="footer">
                    <button type="button" class="button button-default" @click="save('blog')">저장</button>
                </x-slot>
            </x-rootmodal>
        </div>
        <div class="text-center p-12 border rounded-2xl">
            <img src="{{ Vite::asset('resources/images/media/ic-connect-instagram.svg') }}" alt="" class="mx-auto">
            <div class="my-6 font-bold text-gray-700">인스타그램 연결하기</div>
            <x-rootmodal>
                <x-slot name="trigger">
                    <button type="button"
                            class="button button-light mt-6"
                            :class="{ 'button-green': instagram.id, 'button-light' : !instagram.id}"
                            @click="openModal('instagram')" x-text="instagram.id ? '연결됨' : '연결하기' "></button>
                </x-slot>
                <x-slot name="header"></x-slot>
                <div class="text-left">
                    <label for="instagram" class="label">인스타그렘 주소</label>
                    <div class="flex gap-3 mt-3 mb-1">
                        <input type="text" name="url" x-model="instagram.url" class="form-control" id="instagram" placeholder="http://example.com">
                        <template x-if="instagram.id">
                            <button type="button" class="shrink-0 button button-light" @click="deleteUrl(instagram.id)">연결끊기</button>
                        </template>
                    </div>
                    <small>주소를 정확히 입력해주세요</small>
                </div>
                <x-slot name="footer">
                    <button type="button" class="button button-default" @click="save('instagram')">저장</button>
                </x-slot>
            </x-rootmodal>
        </div>
        <div class="text-center p-12 border rounded-2xl">
            <img src="{{ Vite::asset('resources/images/media/ic-connect-youtube.svg') }}" alt="" class="mx-auto">
            <div class="my-6 font-bold text-gray-700">유튜브 연결하기</div>
            <x-rootmodal>
                <x-slot name="trigger">
                    <button type="button"
                            class="button button-light mt-6"
                            :class="{ 'button-green': youtube.id, 'button-light' : !youtube.id}"
                            @click="openModal('youtube')" x-text="youtube.id ? '연결됨' : '연결하기'"></button>
                </x-slot>
                <x-slot name="header"></x-slot>
                <div class="text-left">
                    <label for="youtube" class="label">유튜브 주소</label>
                    <div class="flex gap-3 mt-3 mb-1">
                        <input type="text" name="url" x-model="youtube.url" class="form-control" id="youtube" placeholder="http://example.com">
                        <template x-if="youtube.id">
                            <button type="button" class="shrink-0 button button-light" @click="deleteUrl(youtube.id)">연결끊기</button>
                        </template>
                    </div>
                    <small>주소를 정확히 입력해주세요</small>
                </div>
                <x-slot name="footer">
                    <button type="button" class="button button-default" @click="save('youtube')">저장</button>
                </x-slot>
            </x-rootmodal>
        </div>
    </div>
    <script>
        const mediaData = {
          blog:{
            id: '{{ $blog->id ?? null }}',
            media: '{{ \App\Enums\Campaign\MediaEnum::NAVER_BLOG->value }}',
            url : '{{ $blog->url ?? null }}',
            connected_status: 'connected',
          },
          instagram:{
            id: '{{ $instagram->id ?? null }}',
            media: '{{ \App\Enums\Campaign\MediaEnum::INSTAGRAM->value }}',
            url : '{{ $instagram->url ?? null }}',
            connected_status: 'connected',
          },
          youtube:{
            id: '{{ $youtube->id ?? null }}',
            media: '{{ \App\Enums\Campaign\MediaEnum::YOUTUBE->value }}',
            url : '{{ $youtube->url ?? null }}',
            connected_status: 'connected',
          },
          deleteUrl(id){
            Swal.fire({
              title: '미디어의 연결을 끊겠습니까?',
              text: '연결을 끊게 되면 이전 상태로 되돌릴 수 없습니다.',
              icon: 'warning',
              showCancelButton: true,
              cancelButtonText: '취소',
              confirmButtonText: '확인',
            }).then(result => {
              if (result.isConfirmed){
                  axios.delete(`/api/user/media/${id}`).then(res => {
                    Swal.fire({
                      icon: 'success',
                      title: res.data.message,
                      didClose: () => {
                        window.location.reload();
                      }
                    });
                  }).catch(error => {
                    Swal.fire({
                      icon: 'error',
                      title: error.response.data.message,
                      text: error.response.data.data,
                    });
                  });
              }
            });
          },
          save(media){
            let params = {};
            switch (media){
              case 'blog':
                params = this.blog;
                break;
              case 'instagram':
                params = this.instagram;
                break;
              case 'youtube':
                params = this.youtube;
                break;
            }

            if(params.id){
              axios.put(`/api/user/media/${params.id}`, params).then(res => {
                Swal.fire({
                  icon: 'success',
                  title: res.data.message,
                  didClose: () => {
                    window.location.reload();
                  }
                });
              }).catch(error => {
                Swal.fire({
                  icon: 'error',
                  title: error.response.data.message,
                  text: error.response.data.data,
                });
              })
            } else {
              axios.post('/api/user/media', params).then(res => {
                Swal.fire({
                  icon: 'success',
                  title: res.data.message,
                  didClose: () => {
                    window.location.reload();
                  }
                });
              }).catch(error => {
                Swal.fire({
                  icon: 'error',
                  title: error.response.data.message,
                  text: error.response.data.data,
                });
              })
            }
          },
          openModal(type){
            this.$data.open = true;
          }
        }
    </script>
</x-mypage-layout>
