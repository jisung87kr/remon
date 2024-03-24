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
            <header class="p-6 flex container mx-auto justify-between items-center">
                <div class="flex content-center items-baseline">
                    <a href="/" class="mr-5 font-bold">REMON</a>
                    <form action="{{ route('campaigns.index') }}">
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
                    <div class="ms-3 relative">
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

                                <x-dropdown-link href="{{ route('mypage.campaigns') }}">
                                    {{ __('나의 캠페인') }}
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('mypage.favorites') }}">
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
                                <x-dropdown-link href="{{ route('admin.index') }}">
                                    {{ __('관리자 사이트') }}
                                </x-dropdown-link>


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
                @else
                    <div class="flex gap-1 items-baseline">
                        <a href="{{ route('login') }}" class="text-gray-600 text-sm">로그인</a>
                        <span>∙</span>
                        <a href="{{ route('register') }}" class="text-gray-600 text-sm">회원가입</a>
                    </div>
                @endif
            </header>
            <div class="border-b">
                <div class="container mx-auto p-6">
                    <nav>
                        <ul class="flex gap-y-5 gap-x-8">
                            <li class="font-bold">
                                <a href="{{ route('campaigns.index') }}" class="{{ request()->routeIs('campaigns.index') && (empty(request()->input('campaign_type')) || count(request()->input('campaign_type', [])) == 2) ? 'text-indigo-500' : '' }}">전체 캠페인</a>
                            </li>
                            <li class="font-bold">
                                <a href="{{ route('campaigns.index', ['campaign_type' => ['방문형']]) }}" class="{{ request()->routeIs('campaigns.index') && count(request()->input('campaign_type', [])) == 1 && in_array('방문형', request()->input('campaign_type')) ? 'text-indigo-500' : '' }}">방문형 캠페인</a>
                            </li>
                            <li class="font-bold">
                                <a href="{{ route('campaigns.index', ['campaign_type' => ['배송형']]) }}" class="{{ request()->routeIs('campaigns.index') && count(request()->input('campaign_type', [])) == 1 && in_array('배송형', request()->input('campaign_type')) ? 'text-indigo-500' : '' }}">배송형 캠페인</a>
                            </li>

                            <li class="font-bold"><a href="{{ route('event') }}" class="{{ request()->routeIs('event') ? 'text-indigo-500' : '' }}">이벤트</a></li>
                            <li class="font-bold"><a href="{{ route('community.free') }}" class="{{ request()->routeIs('community.free') ? 'text-indigo-500' : '' }}">커뮤니티</a></li>
                            <li class="font-bold"><a href="{{ route('help.inquiry') }}" class="{{ request()->routeIs('help.inquiry') ? 'text-indigo-500' : '' }}">고객센터</a></li>
                            <li class="font-bold"><a href="{{ route('help.contact') }}" class="{{ request()->routeIs('help.contact') ? 'text-indigo-500' : '' }}">광고문의</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Page Content -->
            <main class="grow min-h-full">
                {{ $slot }}
            </main>

            <footer class="border-t px-6">
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
                                    <div class="font-bold">1,000,000</div>
                                </div>
                                <div class="flex gap-3">
                                    <div class="text-gray-500">Campaign</div>
                                    <div class="font-bold">1,000,000</div>
                                </div>
                                <div class="flex gap-3">
                                    <div class="text-gray-500">Contents</div>
                                    <div class="font-bold">1,000,000</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
