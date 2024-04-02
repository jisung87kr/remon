<x-app-layout>
    <section id="hero" class="bg-red-50 flex items-center mb-10" style="height: 400px">
        <div class="container mx-auto  p-6">
            <div class="text-[32px] font-bold mb-6">베베숲</div>
            <div>아기 피부를 위한 초고의 선택, 베베숲</div>
        </div>
    </section>
    <section id="popular_campaign" class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-3">베베숲의 캠페인</h1>
        <form action="">
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
                    <div class="relative">
                        <a href="{{ route('campaign.show', 1) }}" class="overflow-hidden rounded block">
                            <img src="https://placeholder.co/300x300" alt="">
                        </a>
                        <button class="absolute right-3 top-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-heart" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                            </svg>
                        </button>
                    </div>
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

    <section id="best_campaign" class="container mx-auto my-12 p-6">
        <h1 class="text-2xl font-bold mb-3">베베숲의 콘텐츠</h1>
        <div class="grid grid-cols-3 xl:grid-cols-5 gap-6">
            @foreach(range(1, 5) as $key)
                <a href="">
                    <div class="rounded overflow-hidden">
                        <img src="https://placehold.co/400x300" alt="">
                    </div>
                    <div class="my-3">
                        <div class="mb-2">기분 좋은 사색으로의 여행</div>
                        <div class="text-xs text-gray-500">[경주] 사색공간 풀빌라</div>
                    </div>
                    <div class="flex items-center border-t mt-6 py-3">
                        <img src="{{ Vite::asset('resources/images/media/blog.svg') }}" alt="" class="w-[20px]">
                        <div class="flex items-center">
                            <div class="mx-3 border-l pl-3">
                                <img src="https://placeholder.co/20x20" alt="" class="rounded-full">
                            </div>
                            <div class="text-xs">부르르르르</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
</x-app-layout>
