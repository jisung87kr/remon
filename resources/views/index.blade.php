<x-app-layout>
    <section id="main-banner" class="container mx-auto p-6">
        <div class="grid grid-cols-3 gap-6">
            <div class="aspect-video bg-gray-50 rounded-lg flex items-center justify-center">banner1</div>
            <div class="aspect-video bg-gray-50 rounded-lg flex items-center justify-center">banner2</div>
            <div class="aspect-video bg-gray-50 rounded-lg flex items-center justify-center">banner3</div>
        </div>
    </section>
    <section id="category" class="container mx-auto p-6 my-12">
        <div class="grid grid-cols-5 gap-6 xl:grid-cols-10 xl:gap-12">
            <div class="text-center">
                <div class="bg-gray-50 rounded-2xl aspect-square"></div>
                <div class="mt-4">이용가이드</div>
            </div>
            @foreach(range(1, 9) as $key)
                <a href="{{ route('category.show', 1) }}" class="text-center">
                    <div class="bg-gray-50 rounded-2xl aspect-square"></div>
                    <div class="mt-4">카테고리{{$key}}</div>
                </a>
            @endforeach
        </div>
    </section>
    <section id="popular_campaign" class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-3">지금 인기 캠페인</h1>
        <div class="grid grid-cols-3 gap-6 xl:grid-cols-7">
            @foreach($bestCampaigns as $key => $campaign)
            <div class="card">
                <div class="card-body">
                    <div class="relative">
                        <a href="{{ route('campaigns.show', $campaign) }}" class="overflow-hidden rounded block">
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
                        @foreach($campaign->media as $media)
                            @switch($media->meta_value)
                                @case(App\Enums\Campaign\Media::NAVER_BLOG->value)
                                    <img src="{{ Vite::asset('resources/images/media/blog.svg') }}" alt="">
                                    @break
                                @case(App\Enums\Campaign\Media::INSTAGRAM->value)
                                    <img src="{{ Vite::asset('resources/images/media/instagram.svg') }}" alt="">
                                    @break
                                @case(App\Enums\Campaign\Media::YOUTUBE->value)
                                    <img src="{{ Vite::asset('resources/images/media/youtube.svg') }}" alt="">
                                    @break
                            @endswitch
                        @endforeach
                        <div class="ml-2 font-bold">{{ $campaign->application_end_at->diffForHumans() }} 마감</div>
                    </div>
                    <div>
                        <div>[{{ $campaign->locations[0]->name }}] {{ $campaign->product_name }}</div>
                        <small class="text-gray-500 line-clamp-2">{{ $campaign->benefit }}</small>
                    </div>
                    <div class="my-2">
                        <small>신청 3,000</small><small class="text-gray-500"> / </small><small class="text-gray-500">{{ number_format($campaign->application_limit) }}명</small>
                    </div>
                    <div class="flex gap-1">
                        @foreach($campaign->options as $option)
                        <div class="p-1 text-xs border text-gray-600">{{ $option->name }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    <section id="remon_pick" class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-3">레몬's PICK</h1>
        <div class="grid grid-cols-2 xl:grid-cols-4 gap-6">
            @foreach(range(1, 4) as $key)
                <div>
                    <div>
                        <div class="bg-gray-50 aspect-video"></div>
                        <div class="font-bold mt-3 mb-1 text-lg">Happy new Year! 이니까</div>
                        <div class="font-bold text-gray-500">맛집 캠페인</div>
                    </div>
                    <div class="mt-10">
                        @foreach(range(1, 3) as $key2)
                            <a href="{{ route('campaigns.show', 1) }}" class="flex my-3">
                                <div class="shrink-0 mr-3 w-[100px]">
                                    <div class="relative">
                                        <img src="https://placeholder.co/300x300" alt="" class="w-full overflow-hidden rounded block">
                                        <button class="absolute right-2 top-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-heart" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <div class="mb-2 flex">
                                        <img src="{{ Vite::asset('resources/images/media/blog.svg') }}" alt="">
                                        <div class="ml-2 text-sm font-bold">3일 남음</div>
                                    </div>
                                    <div>[의정부] 요미우돈교자 의정부점</div>
                                    <div>
                                        <small class="text-gray-500">우동2+오니기리1</small>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <section id="kakaobanner" class="container mx-auto my-10 p-6">
        <a href="">
            <div class="bg-gray-50 flex items-center justify-center p-10">
                <div>
                    <div class="text-2xl font-bold mb-3">레몬 카카오 채널톡</div>
                    <div>카카오톡으로 찾아오는 레몬 캠페인을 만나보실래요?</div>
                </div>
            </div>
        </a>
    </section>
    <section id="pendding_campaign" class="bg-gray-50">
        <div class="container mx-auto px-6 py-32">
            <div class="grid grid-cols-3 md:grid-cols-4 xl:grid-cols-6">
                <div>
                    <div class="mb-10">
                        <div class="text-indigo-700 font-bold text-[32px]">777개</div>
                        <div class="text-2xl">오픈예정 캠페인</div>
                    </div>
                    <div class="text-gray-500">❤️ 좋아요로 미리<br>찜해두고 신청해보세요.</div>
                </div>
                <div class="col-span-2 md:col-span-3 xl:col-span-5">
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-6">
                        @foreach(range(1, 5) as $key)
                            <div class=relative>
                                <div class="relative">
                                    <div class="absolute left-0 top-0 bg-gray-900 opacity-75 w-full h-full"></div>
                                    <img src="https://files.weble.net/campaign/data/868930/thumb200.jpg?bust=1705817017068" alt="">
                                    <button class="absolute right-3 top-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-heart" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 opacity-0">
                                    <div>미리찝하고</div>
                                    <div>신청하기</div>
                                </div>
                                <div class="absolute left-0 bottom-0 p-3 text-white">
                                    <img src="{{ Vite::asset('/resources/images/media/blog_white.svg') }}" alt="">
                                    <div class="mt-2">
                                        <div class="font-bold">[김포] 동래정 김포풍무점</div>
                                        <div class="text-xs">50,000원 이용권</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="brandzone" class="container mx-auto my-12 p-6">
        <h1 class="text-2xl font-bold mb-3">브랜드 존</h1>
        <div class="grid grid-cols-2 xl:grid-cols-4 gap-6">
            @foreach(range(1, 4) as $key)
                <a href="{{ route('brandzone.show', 1) }}" class="relative">
                    <div class="relative rounded-lg overflow-hidden">
                        <div class="absolute left-0 top-0 bg-gray-900 opacity-75 w-full h-full"></div>
                        <img src="https://placehold.co/600x600" alt="">
                    </div>
                    <div class="text-white absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
                        <div class="font-bold text-2xl lg:text-[32px] mb-3">명륜진사 갈비</div>
                        <div class="flex border border-white py-2 px-3 justify-center w-[120px] mx-auto">
                            <span class="mr-2 text-sm">캠페인</span> <img src="{{ Vite::asset('resources/images/icons/more.svg') }}" alt="">
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    <section id="best_campaign" class="container mx-auto my-12 p-6">
        <h1 class="text-2xl font-bold mb-3">베스트 콘텐츠</h1>
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
    <section id="bizbanner" class="container mx-auto my-10 p-6">
        <a href="">
            <div class="bg-gray-50 flex items-center justify-center p-10">
                <div>
                    <div class="text-2xl font-bold mb-3">광고주 이신가요?</div>
                    <div>레몬 캠페인문의? 비용문의? 지금 광고주 센터에 문의를 해보세요!</div>
                </div>
            </div>
        </a>
    </section>
</x-app-layout>
