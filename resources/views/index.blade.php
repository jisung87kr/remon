<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <section id="main-banner" class="container-full py-6">
        <div class="swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="aspect-video bg-gray-50 rounded-lg flex items-center justify-center">banner1</div>
                </div>
                <div class="swiper-slide">
                    <div class="aspect-video bg-gray-50 rounded-lg flex items-center justify-center">banner2</div>
                </div>
                <div class="swiper-slide">
                    <div class="aspect-video bg-gray-50 rounded-lg flex items-center justify-center">banner3</div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-scrollbar"></div>
        </div>
        <script>
          const swiper = new Swiper('.swiper', {
            loop: true,
            // pagination: {
            //   el: '.swiper-pagination',
            // },
            scrollbar: {
              el: '.swiper-scrollbar',
            },
            slidesPerView: 1.3,
            spaceBetween: 15,
            breakpoints:{
              768: {
                slidesPerView: 2,
                spaceBetween: 15,
              },
              1024: {
                slidesPerView: 3,
                spaceBetween: 15,
              },
            }
          });
        </script>
    </section>
    <section id="category" class="container mx-auto p-6 my-12">
        <div class="grid grid-cols-5 gap-6 lg:grid-cols-10 xl:gap-12">
            <a href="{{ route('board.show', 'guide') }}" class="text-center">
                <img src="{{ Vite::asset('resources/images/category/category-guide.png') }}" alt="">
                <div class="mt-2">이용가이드</div>
            </a>
            <a href="{{ route('campaign.index', ['type' => ['맛집']]) }}" class="text-center">
                <img src="{{ Vite::asset('resources/images/category/category-restaurant.png') }}" alt="">
                <div class="mt-2">맛집</div>
            </a>
            <a href="{{ route('campaign.index', ['type' => ['뷰티']]) }}" class="text-center">
                <img src="{{ Vite::asset('resources/images/category/category-beauty.png') }}" alt="">
                <div class="mt-2">뷰티</div>
            </a>
            <a href="{{ route('campaign.index', ['type' => ['숙박']]) }}" class="text-center">
                <img src="{{ Vite::asset('resources/images/category/category-travel.png') }}" alt="">
                <div class="mt-2">여행</div>
            </a>
            <a href="{{ route('campaign.index', ['type' => ['문화']]) }}" class="text-center">
                <img src="{{ Vite::asset('resources/images/category/category-culture.png') }}" alt="">
                <div class="mt-2">문화</div>
            </a>
            <a href="{{ route('campaign.index', ['product' => ['식품']]) }}" class="text-center">
                <img src="{{ Vite::asset('resources/images/category/category-food.png') }}" alt="">
                <div class="mt-2">식품</div>
            </a>
            <a href="{{ route('campaign.index', ['product' => ['생활']]) }}" class="text-center">
                <img src="{{ Vite::asset('resources/images/category/category-life.png') }}" alt="">
                <div class="mt-2">생활</div>
            </a>
            <a href="{{ route('campaign.index', ['product' => ['디지털']]) }}" class="text-center">
                <img src="{{ Vite::asset('resources/images/category/category-digital.png') }}" alt="">
                <div class="mt-2">디지털</div>
            </a>
            <a href="{{ route('board.show', 'free') }}" class="text-center">
                <img src="{{ Vite::asset('resources/images/category/category-community.png') }}" alt="">
                <div class="mt-2">커뮤니티</div>
            </a>
            <a href="{{ route('board.show', 'ad') }}" class="text-center">
                <img src="{{ Vite::asset('resources/images/category/category-ad.png') }}" alt="">
                <div class="mt-2">광고문의</div>
            </a>
        </div>
    </section>
    <section id="popular_campaign" class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-3">지금 인기 캠페인</h1>
        <div class="grid gap-6 grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7">
            @forelse($bestCampaigns as $key => $campaign)
                <x-campaign.card :campaign="$campaign"></x-campaign.card>
            @empty
                <div class="card col-span-3 xl:col-span-7">
                    준비된 캠페인이 없습니다.
                </div>
            @endforelse
        </div>
    </section>
{{--    <section id="fleet_pick" class="container mx-auto p-6">--}}
{{--        <h1 class="text-2xl font-bold mb-3">플릿's PICK</h1>--}}
{{--        <div class="grid grid-cols-2 xl:grid-cols-4 gap-6">--}}
{{--            @foreach(range(1, 4) as $key)--}}
{{--                <div>--}}
{{--                    <div>--}}
{{--                        <div class="bg-gray-50 aspect-video"></div>--}}
{{--                        <div class="font-bold mt-3 mb-1 text-lg">Happy new Year! 이니까</div>--}}
{{--                        <div class="font-bold text-gray-500">맛집 캠페인</div>--}}
{{--                    </div>--}}
{{--                    <div class="mt-10">--}}
{{--                        @foreach(range(1, 3) as $key2)--}}
{{--                            <x-campaign.card-horizontal class="mt-3" :campaign="$campaign"></x-campaign.card-horizontal>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--    </section>--}}
    <section id="kakaobanner" class="container mx-auto my-10 p-6">
        <a href="">
            <div class="bg-gray-50 flex items-center justify-center p-10">
                <div>
                    <div class="text-2xl font-bold mb-3">플릿 카카오 채널톡</div>
                    <div>카카오톡으로 찾아오는 플릿 캠페인을 만나보실래요?</div>
                </div>
            </div>
        </a>
    </section>
{{--    <section id="pendding_campaign" class="bg-gray-50">--}}
{{--        <div class="container mx-auto px-6 py-32">--}}
{{--            <div class="grid grid-cols-3 md:grid-cols-4 xl:grid-cols-6">--}}
{{--                <div>--}}
{{--                    <div class="mb-10">--}}
{{--                        <div class="text-indigo-700 font-bold text-[32px]">777개</div>--}}
{{--                        <div class="text-2xl">오픈예정 캠페인</div>--}}
{{--                    </div>--}}
{{--                    <div class="text-gray-500">❤️ 좋아요로 미리<br>찜해두고 신청해보세요.</div>--}}
{{--                </div>--}}
{{--                <div class="col-span-2 md:col-span-3 xl:col-span-5">--}}
{{--                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-6">--}}
{{--                        @foreach(range(1, 5) as $key)--}}
{{--                            <x-campaign.card-simple :campaign="$campaign"></x-campaign.card-simple>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    <section id="brandzone" class="container mx-auto my-12 p-6">--}}
{{--        <h1 class="text-2xl font-bold mb-3">브랜드 존</h1>--}}
{{--        <div class="grid grid-cols-2 xl:grid-cols-4 gap-6">--}}
{{--            @foreach(range(1, 4) as $key)--}}
{{--                <a href="{{ route('brandzone.show', 1) }}" class="relative">--}}
{{--                    <div class="relative rounded-lg overflow-hidden">--}}
{{--                        <div class="absolute left-0 top-0 bg-gray-900 opacity-75 w-full h-full"></div>--}}
{{--                        <img src="https://placehold.co/600x600" alt="">--}}
{{--                    </div>--}}
{{--                    <div class="text-white absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">--}}
{{--                        <div class="font-bold text-2xl lg:text-[32px] mb-3">명륜진사 갈비</div>--}}
{{--                        <div class="flex border border-white py-2 px-3 justify-center w-[120px] mx-auto">--}}
{{--                            <span class="mr-2 text-sm">캠페인</span> <img--}}
{{--                                    src="{{ Vite::asset('resources/images/icons/more.svg') }}" alt="">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--    </section>--}}
    <section id="best_campaign" class="container mx-auto my-12 p-6">
        <h1 class="text-2xl font-bold mb-3">베스트 콘텐츠</h1>
        <div class="grid grid-cols-3 xl:grid-cols-5 gap-6">
            @foreach($bestContents as $content)
                <a href="">
                    <div class="rounded overflow-hidden">
                        @if($content->thumbnail)
                            <img src="{{ $content->thumbnail }}" alt="">
                        @else
                            <img src="https://placehold.co/400x400" alt="">
                        @endif
                    </div>
                    <div class="my-3">
                        <div class="mb-2">{{ $content->title }}</div>
                        <div class="text-xs text-gray-500">{{ $content->campaign->title }}</div>
                    </div>
                    <div class="flex items-center border-t mt-6 py-3">
                        @if($content->campaignMedia)
                        <x-media-icon :media="$content->campaignMedia->media"></x-media-icon>
                        @endif
                        <div class="flex items-center">
                            <div class="mx-3 border-l pl-3">
                                <img src="{{ $content->user->profile_photo_url }}" alt="" class="rounded-full w-[20px]">
                            </div>
                            <div class="text-xs">{{ $content->user->name }}</div>
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
                    <div>플릿 캠페인문의? 비용문의? 지금 광고주 센터에 문의를 해보세요!</div>
                </div>
            </div>
        </a>
    </section>
</x-app-layout>
