<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/scss/app.scss', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased" x-data>
        <x-banner />

        <div class="flex flex-col min-h-screen min-h-screen">
            <header class="container mx-auto p-6 flex flex-col md:flex-row md:flex-row-reverse mx-auto md:justify-between md:items-center">
                @if(!Auth::check())
                    <div class="mb-3 text-right md:flex md:gap-1 md:items-baseline md:mb-0 md:text-left shrink-0">
                        <a href="{{ route('login') }}" class="text-gray-600 text-sm">로그인</a>
                        <span>∙</span>
                        <a href="{{ route('register') }}" class="text-gray-600 text-sm">회원가입</a>
                    </div>
                @endif
                <div class="flex justify-between items-center w-full">
                    <div class="flex items-center">
                        <a href="/" class="mr-5 font-bold">REMON</a>
                        <form action="{{ route('campaign.index') }}">
                            <div class="relative">
                                <input type="text"
                                       name="search"
                                       class="block w-[260px] p-4 pe-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="원하는 캠페인을 검색해보세요" value="{{ request()->input('search') }}">
                                <div class="absolute inset-y-0 end-0 flex items-center pe-3">
                                    <button type="submit">
                                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                             fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if(Auth::check())
                        <div class="ms-3 relative flex gap-3 items-center">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                        <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                        </button>
                                    @else
                                        <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                                    @endif
                                </x-slot>

                                <x-slot name="content">
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Account') }}
                                    </div>

                                    @if(auth()->user()->hasRole(\App\Enums\RoleEnum::GENERAL_USER->value))
                                        <x-dropdown-link href="{{ route('mypage.campaign') }}">
                                            {{ __('나의 캠페인') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('mypage.favorite') }}">
                                            {{ __('관심 캠페인') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('mypage.point') }}">
                                            {{ __('나의 포인트') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('mypage.media') }}">
                                            {{ __('미디어 연결') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('mypage.profile') }}">
                                            {{ __('내 정보') }}
                                        </x-dropdown-link>
                                    @endif
                                    @if(auth()->user()->hasRole(\App\Enums\AdminRoleEnum::SUPER_ADMIN->value) || auth()->user()->hasRole(\App\Enums\AdminRoleEnum::ADMIN->value))
                                        <x-dropdown-link href="{{ route('admin.index') }}">
                                            {{ __('관리자 사이트') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('mypage.profile') }}">
                                            {{ __('내 정보') }}
                                        </x-dropdown-link>
                                    @endif
                                    @if(auth()->user()->hasRole(\App\Enums\RoleEnum::BUSINESS_USER->value))
                                        <x-dropdown-link href="{{ route('business.dashboard') }}">
                                            {{ __('비즈니스 대시보드') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('business.dashboard.campaign.index') }}">
                                            {{ __('캠페인') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('mypage.profile') }}">
                                            {{ __('내 정보') }}
                                        </x-dropdown-link>
                                    @endif



                                    <div class="border-t border-gray-200"></div>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf

                                        <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                            {{ __('로그아웃') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif
                </div>
            </header>
            <div class="border-b">
                <div class="container mx-auto">
                    <nav>
                        <ul class="flex flex-nowrap gap-y-5 gap-x-8 overflow-x-auto p-6">
                            <li class="font-bold shrink-0">
                                <a href="{{ route('campaign.index') }}" class="{{ request()->routeIs('campaign.index') && (empty(request()->input('campaign_type')) || count(request()->input('campaign_type', [])) == 2) ? 'text-indigo-500' : '' }}">전체 캠페인</a>
                            </li>
                            <li class="font-bold shrink-0">
                                <a href="{{ route('campaign.index', ['campaign_type' => ['방문형']]) }}" class="{{ request()->routeIs('campaign.index') && count(request()->input('campaign_type', [])) == 1 && in_array('방문형', request()->input('campaign_type')) ? 'text-indigo-500' : '' }}">방문형 캠페인</a>
                            </li>
                            <li class="font-bold shrink-0">
                                <a href="{{ route('campaign.index', ['campaign_type' => ['배송형']]) }}" class="{{ request()->routeIs('campaign.index') && count(request()->input('campaign_type', [])) == 1 && in_array('배송형', request()->input('campaign_type')) ? 'text-indigo-500' : '' }}">배송형 캠페인</a>
                            </li>

                            <li class="font-bold shrink-0"><a href="{{ route('board.show', 'event') }}" class="{{ request()->routeIs('board.show') && request()->route('board')['slug'] == 'event' ? 'active font-bold' : '' }}">이벤트</a></li>
                            <li class="font-bold shrink-0"><a href="{{ route('board.show', 'news') }}" class="{{ request()->routeIs('board.show') && request()->route('board')['slug'] == 'news' ? 'active font-bold' : '' }}">커뮤니티</a></li>
                            <li class="font-bold shrink-0"><a href="{{ route('board.show', 'inquiry') }}" class="{{ request()->routeIs('board.show') && request()->route('board')['slug'] == 'inquiry' ? 'active font-bold' : '' }}">고객센터</a></li>
                            <li class="font-bold shrink-0"><a href="{{ route('board.show', 'ad') }}" class="{{ request()->routeIs('board.show') && request()->route('board')['slug'] == 'ad' ? 'active font-bold' : '' }}">광고문의</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Page Content -->
            <main class="grow min-h-full">
                {{ $slot }}
            </main>

            <footer class="border-t px-6 mb-20">
                <div class="container mx-auto py-6">
                    <div class="md:flex md:justify-between md:items-center">
                        <div class="mr-6">
                            <a href="" class="text-[20px] text-gray-500">REMON</a>
                            <div class="text-gray-500 text-sm">
                                <div>
                                    <span>레몬</span><span class="mx-2">|</span><span>대표이사 : 홍길동</span><span class="mx-2">|</span><span>개인정보 보호 최고책임자 : 홍길동</span>
                                </div>
                                <div>
                                    <span>사업자등록번호: 000-00-00000</span><span class="mx-2">|</span><span>통신판매신고업번호 제0000-서울강남-00000호</span>
                                </div>
                                <div>
                                    <span>주소: 강원도 춘천시 0000000</span>
                                </div>
                                <div>
                                    <span>메일: help@remon.com</span><span class="mx-2">|</span><span>전화: 0000-0000</span><span class="mx-2">|</span><span>팩스: 00-000-0000</span>
                                </div>
                            </div>
                            <div class="mt-6 font-bold">
                                @REMON. All Rights Reserved.
                            </div>
                        </div>
                        <div class="text-right mt-3 md:mt-0">
                            <div>
                                <a href="" class="text-gray-800 font-bold text-[28px]">0000-0000</a>
                            </div>
                            <small>월-금 09:00-18:00 / 주말,공휴일 제외</small>
                        </div>
                    </div>
                </div>
                <div class="border-t py-6">
                    <div class="container mx-auto py-6">
                        <div class="lg:flex gap-6">
                            <div class="break-keep">
                                <a href="" class="pr-2 text-gray-500">레몬소개</a>
                                <a href="" class="pr-2 text-gray-500">이용약관</a>
                                <a href="" class="pr-2 text-gray-500 font-bold">개인정보처리방침</a>
                                <a href="" class="pr-2 text-gray-500">위치기반서비스이용약관</a>
                                <a href="" class="pr-2 text-gray-500">운영정책</a>
                            </div>
                            <span class="hidden lg:block text-gray-300">|</span>
                            <div class="mt-6 lg:mt-0 lg:flex gap-6">
                                <div class="flex gap-3">
                                    <div class="text-gray-500">Influencer</div>
                                    <div class="font-bold">{{ number_format($influencerCount) }}</div>
                                </div>
                                <div class="flex gap-3">
                                    <div class="text-gray-500">Campaign</div>
                                    <div class="font-bold">{{ number_format($campaignCount) }}</div>
                                </div>
                                <div class="flex gap-3">
                                    <div class="text-gray-500">Contents</div>
                                    <div class="font-bold">{{ number_format($contentCount) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <div class="modal menu-modal z-[999]" x-show="$store.menuModal.show" style="display: none">
            <div class="modal-bg"></div>
            <div class="modal-wrapper" @click.away="$store.menuModal.show = false">
                <div class="modal-header">
                    <div class="relative">
                        <button type="button"
                                class="absolute right-1 top-1/2 -translate-y-1/2"
                                @click="$store.menuModal.show = false">x</button>
                    </div>
                </div>
                <div class="modal-content">
                    <ul>
                        <li class="my-3">
                            <a href="{{ route('campaign.index') }}" class="{{ request()->routeIs('campaign.index') && (empty(request()->input('campaign_type')) || count(request()->input('campaign_type', [])) == 2) ? 'text-indigo-500' : '' }}">전체 캠페인</a>
                        </li>
                        <li class="my-3">
                            <a href="{{ route('campaign.index', ['campaign_type' => ['방문형']]) }}" class="{{ request()->routeIs('campaign.index') && count(request()->input('campaign_type', [])) == 1 && in_array('방문형', request()->input('campaign_type')) ? 'text-indigo-500' : '' }}">방문형 캠페인</a>
                        </li>
                        <li class="my-3">
                            <a href="{{ route('campaign.index', ['campaign_type' => ['배송형']]) }}" class="{{ request()->routeIs('campaign.index') && count(request()->input('campaign_type', [])) == 1 && in_array('배송형', request()->input('campaign_type')) ? 'text-indigo-500' : '' }}">배송형 캠페인</a>
                        </li>
                        <li class="my-3"><a href="{{ route('board.show', 'event') }}" class="{{ request()->routeIs('board.show') && request()->route('board')['slug'] == 'event' ? 'text-indigo-500' : '' }}">이벤트</a></li>
                        <li class="my-3"><a href="{{ route('board.show', 'news') }}" class="{{ request()->routeIs('board.show') && request()->route('board')['slug'] == 'news' ? 'text-indigo-500' : '' }}">커뮤니티</a></li>
                        <li class="my-3"><a href="{{ route('board.show', 'inquiry') }}" class="{{ request()->routeIs('board.show') && request()->route('board')['slug'] == 'inquiry' ? 'text-indigo-500' : '' }}">고객센터</a></li>
                        <li class="my-3"><a href="{{ route('board.show', 'ad') }}" class="{{ request()->routeIs('board.show') && request()->route('board')['slug'] == 'ad' ? 'text-indigo-500' : '' }}">광고문의</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="fixed z-50 w-full h-16 max-w-lg -translate-x-1/2 bg-white border border-gray-200 rounded-full bottom-4 left-1/2" x-data>
            <div class="grid h-full max-w-lg grid-cols-5 mx-auto">
                <a href="{{ route('index') }}" class="inline-flex flex-col items-center justify-center px-5 rounded-s-full hover:bg-gray-50 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home-2" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                        <path d="M10 12h4v4h-4z" />
                    </svg>
                    <span class="text-xs mt-1">홈</span>
                </a>
                <button type="button"
                        class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group"
                        @click="$store.menuModal.show = true;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M4 6l16 0" />
                        <path d="M4 12l16 0" />
                        <path d="M4 18l16 0" />
                    </svg>
                    <span class="text-xs mt-1">메뉴</span>
                </button>
                <a href="{{ route('board.show', 'free') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-chatbot" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z" />
                        <path d="M9.5 9h.01" />
                        <path d="M14.5 9h.01" />
                        <path d="M9.5 13a3.5 3.5 0 0 0 5 0" />
                    </svg>
                    <span class="text-xs mt-1">커뮤니티</span>
                </a>
                <a href="{{ route('board.show', 'inquiry') }}" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-desktop-bolt" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M14.5 16h-10.5a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v7.5" />
                        <path d="M7 20h6" />
                        <path d="M9 16v4" />
                        <path d="M19 16l-2 3h4l-2 3" />
                    </svg>
                    <span class="text-xs mt-1">고객센터</span>
                </a>
                <a href="{{ route('mypage.campaign') }}" type="button" class="inline-flex flex-col items-center justify-center px-5 rounded-e-full hover:bg-gray-50 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-hexagon" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z" />
                        <path d="M6.201 18.744a4 4 0 0 1 3.799 -2.744h4a4 4 0 0 1 3.798 2.741" />
                        <path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" />
                    </svg>
                    <span class="text-xs mt-1">마이페이지</span>
                </a>
            </div>
        </div>


        @stack('modals')

        @livewireScripts
    </body>
</html>
