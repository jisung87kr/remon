<x-board-layout>
    <x-slot name="header">{{ $board->name }}</x-slot>
    <div class="mt-6">
        <section>
            <div class="mb-2">
                <span class="badge badge-green">공지</span>
            </div>
            <div class="font-bold text-2xl mb-6">{{ $post->title }}</div>
            <div>
                {!! $post->content !!}
            </div>
        </section>
        <div class="my-6">
            @can('delete', $post)
                <div class="float-start">
                    <form action="{{ route('board.post.destroy', [$board, $post]) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="button button-red" @click="deletePost">삭제</button>
                    </form>
                    <script>
                      function deletePost(){
                        if(!confirm('삭제 하시겠습니까?')){
                          event.preventDefault();
                        }
                      }
                    </script>
                </div>
            @endcan
            <a href="{{ route('board.show', $board) }}" class="button button-gray float-end">목록</a>
            <div class="clear-both"></div>
        </div>
        <div class="mt-10">
            <div class="flex justify-between items-center">
                <div class="avatar mt-3 flex items-center mr-3">
                    <img src="{{ $post->user->profile_photo_url }}" alt="" class="rounded-full w-[20px] overflow-hidden mr-3">
                    <div class="flex gap-2 items-center">
                        <div>{{ $post->user->name }}</div>
                        <div class="text-gray-500 text-sm">{{ $post->created_at->format('Y.m.d') }}</div>
                    </div>
                </div>
                <div class="flex gap-3 items-center">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-thumb-up" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M7 11v8a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-7a1 1 0 0 1 1 -1h3a4 4 0 0 0 4 -4v-1a2 2 0 0 1 4 0v5h3a2 2 0 0 1 2 2l-1 5a2 3 0 0 1 -2 2h-7a3 3 0 0 1 -3 -3" />
                        </svg>
                        <span>공감 11</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M8 9h8" />
                            <path d="M8 13h6" />
                            <path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z" />
                        </svg>
                        <span>댓글 {{ $post->comments_count }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                        </svg>
                        <span>조회 11</span>
                    </div>
                </div>
            </div>
            <div x-data="commentsComponent()" x-init="loadComments()">
                @if(auth()->check())
                <div class="relative mt-6">
                    <textarea name="" id="" cols="30" rows="5" class="w-full border border-gray-400 pb-6 rounded-lg" x-model="new_comment"></textarea>
                    <button type="button" class="button button-gray absolute right-2 bottom-5" @click="createComment">등록</button>
                </div>
                @endcan
                <div class="mt-6 divide-y">
                    <template x-for="comment in comments.data" :key="comment.id">
                        <div>
                            <div class="p-6 flex gap-3">
                                <div>
                                    <img :src="comment.user.profile_photo_url" alt="" class="rounded-full w-[30px] overflow-hidden mr-3">
                                </div>
                                <div class="w-full">
                                    <div class="flex gap-2 w-full justify-between items-center">
                                        <div class="flex gap-2 items-center">
                                            <div class="text-lg font-bold" x-text="comment.user.name"></div>
                                            <div class="text-sm text-gray-500" x-text="new Date(comment.created_at).toLocaleDateString()"></div>
                                        </div>
                                        <div class="flex gap-2 items-center text-sm text-gray-500" x-show="comment.can_update && !comment.isReplying">
                                            <button type="button" @click="editComment(comment)">수정</button>
                                            <div>|</div>
                                            <button type="button" @click="deleteComment(comment.id)">삭제</button>
                                        </div>
                                    </div>

                                    <div x-show="!comment.isUpdate">
                                        <div class="mt-1" x-text="comment.content"></div>
                                        @if(auth()->check())
                                        <div class="mt-3">
                                            <button type="button" class="flex gap-2 items-center text-sm" @click="replyComment(comment)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message" width="14" height="14" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M8 9h8" />
                                                    <path d="M8 13h6" />
                                                    <path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z" />
                                                </svg>
                                                <span>답글쓰기</span>
                                            </button>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="relative mt-6" x-show="comment.isUpdate">
                                        <textarea name="" id="" cols="30" rows="5"
                                                  x-model="comment.content"
                                                  class="w-full border border-gray-400 pb-6 rounded-lg"></textarea>
                                        <div class=" absolute right-2 bottom-5">
                                            <button type="button" class="button button-gray-outline mr-1" @click="comment.isUpdate = false">취소</button>
                                            <button type="button" class="button button-gray" @click="updateComment(comment)">등록</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="relative mt-6" x-show="comment.isReplying">
                                        <textarea name="" id="" cols="30" rows="5"
                                                  x-model="reply_comment"
                                                  class="w-full border border-gray-400 pb-6 rounded-lg"></textarea>
                                <div class=" absolute right-2 bottom-5">
                                    <button type="button" class="button button-gray-outline mr-1" @click="comment.isReplying = false">취소</button>
                                    <button type="button" class="button button-gray" @click="createComment(comment)">등록</button>
                                </div>
                            </div>
                            <div class="ml-10">
                                <template x-for="child in comment.children" :key="child.id">
                                    <div class="p-6 flex gap-3">
                                        <div>
                                            <img :src="child.user.profile_photo_url" alt="" class="rounded-full w-[30px] overflow-hidden mr-3">
                                        </div>
                                        <div class="w-full">
                                            <div class="flex gap-2 w-full justify-between items-center">
                                                <div class="flex gap-2 items-center">
                                                    <div class="text-lg font-bold" x-text="child.user.name"></div>
                                                    <div class="text-sm text-gray-500" x-text="new Date(child.created_at).toLocaleDateString()"></div>
                                                </div>
                                                <div class="flex gap-2 items-center text-sm text-gray-500" x-show="child.can_update && !child.isReplying">
                                                    <button type="button" @click="editComment(child)">수정</button>
                                                    <div>|</div>
                                                    <button type="button" @click="deleteComment(child.id)">삭제</button>
                                                </div>
                                            </div>
                                            <div x-show="!child.isUpdate">
                                                <div class="mt-1" x-text="child.content"></div>
                                            </div>
                                            <div class="relative mt-6" x-show="child.isUpdate">
                                        <textarea name="" id="" cols="30" rows="5"
                                                  x-model="child.content"
                                                  class="w-full border border-gray-400 pb-6 rounded-lg"></textarea>
                                                <div class=" absolute right-2 bottom-5">
                                                    <button type="button" class="button button-gray-outline mr-1" @click="child.isUpdate = false">취소</button>
                                                    <button type="button" class="button button-gray" @click="updateComment(child)">등록</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="mt-5 text-center">
                    <nav x-show="comments.links && comments.links.length > 0" class="pagination">
                        <template x-for="link in comments.links" :key="link.label">
                            <span>
                                <button @click="loadComments(link.url)" :disabled="!link.url" x-html="link.label" :class="{'text-gray-500': !link.url, 'font-bold': link.active, 'px-2': true, 'py-1': true}"></button>
                            </span>
                        </template>
                    </nav>
                </div>
            </div>

            <script>
              function commentsComponent() {
                return {
                  new_comment: '',
                  reply_comment: '',
                  comments: [],
                  loadComments(pageUrl = '/api/comments/post/{{ $post->id }}') {
                    axios.get(pageUrl)
                      .then(response => {
                        this.comments = response.data.data;
                      })
                      .catch(error => {
                        console.error('Error loading comments:', error);
                      });
                  },
                  createComment(comment=null){
                    var params;
                    if(comment.id){
                      params = {
                        content: this.reply_comment,
                        parent_id: comment.id,
                      }
                    } else {
                      params = {
                        content: this.new_comment,
                      }
                    }

                    axios.post('/api/comments/post/{{ $post->id }}', params).then(res => {
                      alert('등록 되었습니다.');
                      window.location.reload();
                    }).catch(error => {
                      console.error('Error loading comments:', error);
                    });
                  },
                  replyComment(comment){
                    comment.isReplying = true;
                  },
                  editComment(comment) {
                    // 댓글 수정 로직을 여기에 추가하세요
                    comment.isUpdate = true;
                    // comment.isReplying = true;
                    console.log('Edit comment:', comment);
                  },
                  updateComment(comment){
                    let params = {
                        content: comment.content,
                    };

                    axios.put(`/api/comments/${comment.id}`, params).then(res => {
                      this.updateClose();
                    }).catch(error => {
                      console.log(error);
                    });
                  },
                  deleteComment(commentId) {
                    if (confirm('정말로 이 댓글을 삭제하시겠습니까?')) {
                      axios.delete(`/api/comments/${commentId}`)
                        .then(response => {
                          this.comments.data = this.comments.data.filter(comment => comment.id !== commentId);
                        })
                        .catch(error => {
                          console.error('Error deleting comment:', error);
                        });
                    }
                  },
                  updateClose(){
                    const comments = this.comments.data.map(comment => {
                      // 댓글의 isUpdate 속성을 false로 설정
                      comment.isUpdate = false;
                      // 자식 댓글의 isUpdate 속성을 false로 설정
                      if (comment.children && comment.children.length > 0) {
                        comment.children = comment.children.map(child => {
                          child.isUpdate = false;
                          return child;
                        });
                      }
                      return comment;
                    });

                    this.comments.data = comments;
                  }
                }
              }
            </script>
{{--            <div class="mt-6 divide-y">--}}
{{--                @foreach($comments as $comment)--}}
{{--                <div>--}}
{{--                    <div class="p-6 flex gap-3">--}}
{{--                        <div>--}}
{{--                            <img src="{{ $comment->user->profile_photo_url }}" alt="" class="rounded-full w-[30px] overflow-hidden mr-3">--}}
{{--                        </div>--}}
{{--                        <div class="w-full">--}}
{{--                            <div class="flex gap-2 w-full justify-between items-center">--}}
{{--                                <div class="flex gap-2 items-center">--}}
{{--                                    <div class="text-lg font-bold">{{ $comment->user->name }}</div>--}}
{{--                                    <div class="text-sm text-gray-500">{{ $comment->created_at->format('Y.m.d') }}</div>--}}
{{--                                </div>--}}
{{--                                <div class="flex gap-2 items-center">--}}
{{--                                    <button type="button">수정</button>--}}
{{--                                    <div>|</div>--}}
{{--                                    <button type="button">삭제</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="mt-1">--}}
{{--                                {{ $comment->content }}--}}
{{--                            </div>--}}
{{--                            <div class="mt-3">--}}
{{--                                <button type="button" class="flex gap-2 items-center text-sm">--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message" width="14" height="14" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">--}}
{{--                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>--}}
{{--                                        <path d="M8 9h8" />--}}
{{--                                        <path d="M8 13h6" />--}}
{{--                                        <path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z" />--}}
{{--                                    </svg>--}}
{{--                                    <span>답글쓰기</span>--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="relative mt-6">--}}
{{--                        <textarea name="" id="" cols="30" rows="5" class="w-full border border-gray-400 pb-6 rounded-lg"></textarea>--}}
{{--                        <button type="button" class="button button-gray absolute right-2 bottom-5">등록</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                @endforeach--}}
{{--                @if($comments->links())--}}
{{--                    <div class="mt-5">{{ $comments->links() }}</div>--}}
{{--                @endif--}}
{{--            </div>--}}
        </div>
    </div>
</x-board-layout>
