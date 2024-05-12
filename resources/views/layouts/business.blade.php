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
    @vite(['resources/scss/admin.scss', 'resources/js/app.js'])
    @vite(['resources/css/select2.min.css', 'resources/js/jquery-3.7.1.js', 'resources/js/select2.min.js'])
    <script src="{{ Vite::asset('resources/js/functions.js') }}"></script>
    @stack('script')
    <!-- Styles -->
    @livewireStyles
</head>
<body class="font-sans antialiased" x-data>

<div class="flex flex-col min-h-screen min-h-screen bg-gray-50">
    <div id="content-wrap"
         class="grow min-h-full" :class="{'active' : asideOpen}"
         x-data="contentData">
        <!-- Page Content -->
        <aside id="aside" class="!lg-block" x-show="asideOpen" @click.away="closeAside">
            <div class="mb-6">
                <a href="{{ route('business.dashboard') }}" class="text-2xl font-bold">REMON</a>
            </div>
            <ul class="nav">
                <x-nav.item href="{{ route('business.campaign.index') }}" :active="request()->routeIs('admin.campaign.index')">캠페인 목록</x-nav.item>
                <x-nav.item href="{{ route('admin.campaign.index') }}" :active="request()->routeIs('admin.campaign.index')">공지사항</x-nav.item>
                <x-nav.item href="{{ route('admin.campaign.index') }}" :active="request()->routeIs('admin.campaign.index')">1:1문의</x-nav.item>
                <x-nav.item href="{{ route('admin.campaign.index') }}" :active="request()->routeIs('admin.campaign.index')">가이드</x-nav.item>
            </ul>
        </aside>
        <main id="main" class="container mx-auto h-full p-6 relative">
            <div class="bg-white w-full p-3 shadow rounded-lg sticky top-6 mb-6 z-50">
                <div class="flex items-center justify-between">
                    <div>
                        <button type="button" @click="asideOpen = true" class="block xl:hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-align-justified" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4 6l16 0" />
                                <path d="M4 12l16 0" />
                                <path d="M4 18l12 0" />
                            </svg>
                        </button>
                    </div>
                    <div>
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

                                        <x-dropdown-link href="{{ route('index') }}">
                                            {{ __('사이트 바로가기') }}
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
                        @endif
                    </div>
                </div>
            </div>
                {{ $slot }}
            </div>
        </main>
    </div>
    <script>
        const contentData = {
          asideOpen: false,
          windowSize: null,
          init(){
            this.windowSize = window.innerWidth;
            this.checkWindowSize();
            window.addEventListener('resize', () => {
              this.handleResize();
            });
          },
          checkWindowSize(){
            if(this.windowSize >= 1280){
              this.asideOpen = true;
            } else {
              this.asideOpen = false;
            }
          },
          handleResize(){
            this.windowSize = window.innerWidth;
            this.checkWindowSize();
          },
          closeAside(){
            if(this.windowSize < 1280){
              this.asideOpen = false;
            }
          }
        }
    </script>
</div>

@stack('modals')

@livewireScripts
</body>
</html>
