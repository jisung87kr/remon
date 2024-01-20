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
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased" x-data>
        <x-banner />

        <div class="flex flex-col min-h-screen min-h-screen bg-gray-100">

            <header class="p-5 flex container mx-auto justify-between items-baseline">
                <div class="flex content-center items-baseline">
                    <a href="/" class="mr-5 font-bold">REMON</a>
                    <form action="{{ route('index') }}">
                        <div class="relative">
                            <input type="text"
                                   name="search"
                                   class="block w-full p-4 pe-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
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

                                <x-dropdown-link href="{{ route('mypage') }}">
                                    {{ __('마이페이지') }}
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
                <div class="container mx-auto p-5">
                    <nav>
                        <ul class="flex gap-5">
                            <li class="font-bold"><a href="{{ route('category.index') }}">전체 카테고리</a></li>
                            <li class="font-bold"><a href="{{ route('category.index') }}">오늘오픈</a></li>
                            <li class="font-bold"><a href="{{ route('category.index') }}">제품별</a></li>
                            <li class="font-bold"><a href="{{ route('category.index') }}">지역별</a></li>
                            <li class="font-bold"><a href="{{ route('event') }}">이벤트</a></li>
                            <li class="font-bold"><a href="{{ route('community.free') }}">커뮤니티</a></li>
                            <li class="font-bold"><a href="{{ route('help.faq') }}">고객센터</a></li>
                            <li class="font-bold"><a href="{{ route('help.contact') }}">광고문의</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Page Content -->
            <main class="grow min-h-full">
                {{ $slot }}
            </main>

            <footer>
                footer
            </footer>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
