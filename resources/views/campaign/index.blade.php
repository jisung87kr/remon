<x-app-layout>
    <section id="popular_campaign" class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-3">제품 캠페인</h1>

        <form action="">
            <div class="my-10 border-b flex">
                <a href="{{ route("category.show", '전체') }}" class="block px-4 py-2 border-b-2 border-indigo-400">전체</a>
                <a href="{{ route("category.show", '서비스') }}" class="block px-4 py-2">서비스</a>
                <a href="{{ route("category.show", '유아동') }}" class="block px-4 py-2">유아동</a>
                <a href="{{ route("category.show", '디지털') }}" class="block px-4 py-2">디지털</a>
                <a href="{{ route("category.show", '뷰티') }}" class="block px-4 py-2">뷰티</a>
                <a href="{{ route("category.show", '패션') }}" class="block px-4 py-2">패션</a>
                <a href="{{ route("category.show", '도서') }}" class="block px-4 py-2">도서</a>
                <a href="{{ route("category.show", '식품') }}" class="block px-4 py-2">식품</a>
                <a href="{{ route("category.show", '반려동물') }}" class="block px-4 py-2">반려동물</a>
            </div>

            <div class="flex gap-3 mb-6 justify-end">
                <a href="" class="border rounded-2xl px-3 py-1 text-sm">블로그</a>
                <a href="" class="border rounded-2xl px-3 py-1 text-sm">인스타그램</a>
                <a href="" class="border rounded-2xl px-3 py-1 text-sm">유튜브</a>
                <div class="relative border rounded-2xl px-3 py-1 text-sm">
                    <x-dropdown align="right">
                        <x-slot name="trigger">
                            <div class="flex">
                                <span class="mr-2">최신순</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-caret-down-filled" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M18 9c.852 0 1.297 .986 .783 1.623l-.076 .084l-6 6a1 1 0 0 1 -1.32 .083l-.094 -.083l-6 -6l-.083 -.094l-.054 -.077l-.054 -.096l-.017 -.036l-.027 -.067l-.032 -.108l-.01 -.053l-.01 -.06l-.004 -.057v-.118l.005 -.058l.009 -.06l.01 -.052l.032 -.108l.027 -.067l.07 -.132l.065 -.09l.073 -.081l.094 -.083l.077 -.054l.096 -.054l.036 -.017l.067 -.027l.108 -.032l.053 -.01l.06 -.01l.057 -.004l12.059 -.002z" stroke-width="0" fill="currentColor" />
                                </svg>
                            </div>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link>
                                <div class="flex items-center">
                                    <div class="border rounded-full p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="10" height="10" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M5 12l5 5l10 -10" />
                                        </svg>
                                    </div>
                                    <span class="ml-2">최신순</span>
                                </div>
                            </x-dropdown-link>
                            <x-dropdown-link>
                                <div class="flex items-center">
                                    <div class="border rounded-full p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="10" height="10" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M5 12l5 5l10 -10" />
                                        </svg>
                                    </div>
                                    <span class="ml-2">인기순</span>
                                </div>
                            </x-dropdown-link>
                            <x-dropdown-link>
                                <div class="flex items-center">
                                    <div class="border rounded-full p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="10" height="10" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M5 12l5 5l10 -10" />
                                        </svg>
                                    </div>
                                    <span class="ml-2">선정 마감순</span>
                                </div>
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </form>

        <div class="grid grid-cols-3 gap-6 xl:grid-cols-5">
            @foreach(range(1, 50) as $key)
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('campaigns.show', 1) }}">
                        <div class="aspect-square bg-gray-50 rounded"></div>
                    </a>
                    <div class="my-3 flex">
                        <img src="{{ Vite::asset('resources/images/media/blog.svg') }}" alt="">
                        <div class="ml-2 font-bold">3일 남음</div>
                    </div>
                    <div>
                        <div>[전국] 명륜진사갈비</div>
                        <small class="text-gray-500">4만원 이용권</small>
                    </div>
                    <div class="my-2">
                        <small>신청 3,000</small><small class="text-gray-500"> / </small><small class="text-gray-500">100명</small>
                    </div>
                    <div class="flex gap-1">
                        <div class="p-1 text-xs border text-gray-600">예약없음</div>
                        <div class="p-1 text-xs border text-gray-600">재함여 가능</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</x-app-layout>
