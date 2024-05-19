<x-help-layout>
    <x-slot name="header">레뷰소식</x-slot>
    <div class="mt-6">
        <section>
            <div class="mb-2">
                <span class="badge badge-green">공지</span>
            </div>
            <div class="font-bold text-2xl mb-6">제목 들어가는 자리</div>
            <div>
                내용 들어가는 자리
            </div>
        </section>
        <div class="">
            <div class="flex justify-between items-center">
                <div class="avatar mt-3 flex items-center mr-3">
                    <img src="https://ui-avatars.com/api/?name=%EC%9C%A0&color=7F9CF5&background=EBF4FF" alt="" class="rounded-full w-[20px] overflow-hidden mr-3">
                    <div class="flex gap-2 items-center">
                        <div>admin</div>
                        <div class="text-gray-500 text-sm">2024.05.19</div>
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
                        <span>댓글 11</span>
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
            <div class="relative mt-6">
                <textarea name="" id="" cols="30" rows="5" class="w-full border border-gray-400 pb-6 rounded-lg"></textarea>
                <button type="button" class="button button-gray absolute right-2 bottom-5">등록</button>
            </div>
            <div class="mt-6 divide-y">
                <div>
                    <div class="p-6 flex gap-3">
                        <div>
                            <img src="https://ui-avatars.com/api/?name=%EC%9C%A0&color=7F9CF5&background=EBF4FF" alt="" class="rounded-full w-[30px] overflow-hidden mr-3">
                        </div>
                        <div class="w-full">
                            <div class="flex gap-2 w-full justify-between items-center">
                                <div class="flex gap-2 items-center">
                                    <div class="text-lg font-bold">admin</div>
                                    <div class="text-sm text-gray-500">2024.05.19</div>
                                </div>
                                <div class="flex gap-2 items-center">
                                    <button type="button">수정</button>
                                    <div>|</div>
                                    <button type="button">삭제</button>
                                </div>
                            </div>
                            <div class="mt-1">
                                댓글내용 들어가는 자리
                            </div>
                            <div class="mt-3">
                                <button type="button" class="flex gap-2 items-center text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message" width="14" height="14" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M8 9h8" />
                                        <path d="M8 13h6" />
                                        <path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z" />
                                    </svg>
                                    <span>답글쓰기</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="p-6 flex gap-3">
                        <div>
                            <img src="https://ui-avatars.com/api/?name=%EC%9C%A0&color=7F9CF5&background=EBF4FF" alt="" class="rounded-full w-[30px] overflow-hidden mr-3">
                        </div>
                        <div>
                            <div class="flex gap-2 items-center">
                                <div class="text-lg font-bold">admin</div>
                                <div class="text-sm text-gray-500">2024.05.19</div>
                            </div>
                            <div class="mt-1">
                                댓글내용 들어가는 자리
                            </div>
                            <div class="mt-3">
                                <button type="button" class="flex gap-2 items-center text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message" width="14" height="14" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M8 9h8" />
                                        <path d="M8 13h6" />
                                        <path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z" />
                                    </svg>
                                    <span>답글쓰기</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="relative mt-6">
                        <textarea name="" id="" cols="30" rows="5" class="w-full border border-gray-400 pb-6 rounded-lg"></textarea>
                        <button type="button" class="button button-gray absolute right-2 bottom-5">등록</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-help-layout>
