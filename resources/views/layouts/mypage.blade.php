<x-default-layout>
    <x-slot name="mainTop">
        <div class="container mx-auto p-6">
            <div class="lg:flex p-10 items-center shadow-lg rounded-lg my-3">
                <div class="flex items-center lg:w-1/2">
                    <img src="{{ auth()->user()->profile_photo_url }}" alt="" class="rounded-full">
                    <div class="mx-8 text-2xl font-bold">{{ auth()->user()->name }}</div>
                    @if(false)
                    <button class="px-5 py-2 text-sm text-white font-bold bg-sky-400 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check inline" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M5 12l5 5l10 -10" />
                        </svg>
                        <span class="ml-1">출석 체크</span>
                    </button>
                    @endif
                </div>
                <div class="grid grid-cols-3 mt-8 lg:mt-0 lg:w-1/2">
                    <div class="px-6">
                        <div class="mb-3">회원레벨</div>
                        <div>lv. {{ auth()->user()->level }}</div>
                    </div>
                    <div class="px-6">
                        <div class="mb-3">포인트</div>
                        <div><span class="text-lg font-bold">{{ number_format(auth()->user()->point) }}</span>P</div>
                    </div>
                    <div class="px-6">
                        <a href="{{ route('mypage.media') }}">
                            <div class="mb-3">미디어연결</div>
                            <div class="flex gap-x-4">
                                @if(in_array(\App\Enums\Campaign\MediaEnum::NAVER_BLOG->value, auth()->user()->media->pluck('media')->toArray()))
                                    <img src="{{ Vite::asset('resources/images/media/ic-mypage-blog-on.svg') }}" alt="">
                                @else
                                    <img src="{{ Vite::asset('resources/images/media/ic-mypage-blog-off.svg') }}" alt="">
                                @endif

                                @if(in_array(\App\Enums\Campaign\MediaEnum::INSTAGRAM->value, auth()->user()->media->pluck('media')->toArray()))
                                    <img src="{{ Vite::asset('resources/images/media/ic-mypage-insta-on.svg') }}" alt="">
                                @else
                                    <img src="{{ Vite::asset('resources/images/media/ic-mypage-insta-off.svg') }}" alt="">
                                @endif

                                @if(in_array(\App\Enums\Campaign\MediaEnum::YOUTUBE->value, auth()->user()->media->pluck('media')->toArray()))
                                    <img src="{{ Vite::asset('resources/images/media/ic-mypage-youtube-on.svg') }}" alt="" class="w-[20px]">
                                @else
                                    <img src="{{ Vite::asset('resources/images/media/ic-mypage-youtube-off.svg') }}" alt="" class="w-[20px]">
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="lnb">
        <div class="mb-6">
            <div class="font-bold text-lg py-4 border-b">활동관리</div>
            <ul>
                <li class="py-4 border-b"><a href="{{ route('mypage.campaign') }}" class="{{ request()->routeIs('mypage.campaign') ? 'active font-bold' : '' }}">나의 캠페인</a></li>
                <li class="py-4 border-b"><a href="{{ route('mypage.favorite') }}" class="{{ request()->routeIs('mypage.favorite') ? 'active font-bold' : '' }}">관심 캠페인</a></li>
                <li class="py-4 border-b"><a href="{{ route('mypage.review') }}" class="{{ request()->routeIs('mypage.review') ? 'active font-bold' : '' }}">등록 콘텐츠</a></li>
                <li class="py-4 border-b"><a href="{{ route('mypage.message') }}" class="{{ request()->routeIs('mypage.message') ? 'active font-bold' : '' }}">받은 메세지</a></li>
                <li class="py-4 border-b"><a href="{{ route('link.index') }}" class="{{ request()->routeIs('link.index') ? 'active font-bold' : '' }}">링크 만들기</a></li>
            </ul>
        </div>
        <div class=" mb-6">
            <div class="font-bold text-lg py-4 border-b">계정관리</div>
            <ul>
                <li class="py-4 border-b"><a href="{{ route('mypage.profile') }}" class="{{ request()->routeIs('mypage.profile') ? 'active font-bold' : '' }}">내 정보</a></li>
                <li class="py-4 border-b"><a href="{{ route('mypage.media') }}" class="{{ request()->routeIs('mypage.media') ? 'active font-bold' : '' }}">미디어 연결</a></li>
                <li class="py-4 border-b"><a href="{{ route('mypage.penalty') }}" class="{{ request()->routeIs('mypage.penalty') ? 'active font-bold' : '' }}">패널티 현황</a></li>
                <li class="py-4 border-b"><a href="{{ route('mypage.point') }}" class="{{ request()->routeIs('mypage.point') ? 'active font-bold' : '' }}">나의 포인트</a></li>
            </ul>
        </div>
{{--        <div class="mb-6">--}}
{{--            <div class="font-bold text-lg py-4 border-b">고객센터</div>--}}
{{--            <ul>--}}
{{--                <li class="py-4 border-b"><a href="{{ route('board.show', 'inquiry') }}" class="{{ request()->routeIs('board.show') && request()->route('board')['slug'] == 'inquiry' ? 'active font-bold' : '' }}">1:1 문의</a></li>--}}
{{--                <li class="py-4 border-b"><a href="{{ route('board.show', 'guide') }}" class="{{ request()->routeIs('board.buil') && request()->route('board')['slug'] == 'guide' ? 'active font-bold' : '' }}">서비스 가이드</a></li>--}}
{{--            </ul>--}}
{{--        </div>--}}
    </x-slot>

    <x-slot name="header">
        {{ $header }}
    </x-slot>
    {{ $slot }}
</x-default-layout>
