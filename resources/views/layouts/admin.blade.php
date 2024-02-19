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
                <a href="" class="text-2xl font-bold">REMON</a>
            </div>
            <ul class="nav">
                <li class="nav-item nav-link">
                    <a href="">카테고리 관리</a>
                </li>
                <x-nav.index>
                    <x-slot name="label">
                        <x-nav.label>캠페인</x-nav.label>
                    </x-slot>
                    <x-slot name="group">
                        <x-nav.item href="./">캠페인 관리</x-nav.item>
                        <x-nav.item href="./">신청 관리</x-nav.item>
                    </x-slot>
                </x-nav.index>
                <li class="nav-title text-gray-500">회원</li>
                <li class="nav-item nav-link"><a href="">회원관리</a></li>
                <li class="nav-item nav-link"><a href="">메세지</a></li>
            </ul>
        </aside>
        <main id="main" class="container mx-auto h-full p-6 relative">
            <div class="bg-white w-full p-3 shadow rounded-lg sticky top-6">
                <div class="flex items-center">
                    <button type="button" @click="asideOpen = true" class="block xl:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-align-justified" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M4 6l16 0" />
                            <path d="M4 12l16 0" />
                            <path d="M4 18l12 0" />
                        </svg>
                    </button>
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
