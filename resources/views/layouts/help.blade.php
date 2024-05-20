<x-default-layout>
    @isset($mainTop)
    <x-slot name="mainTop">
        {{ $mainTop }}
    </x-slot>
    @endisset

    <x-slot name="lnb">
        <div class="mb-6">
            <div class="font-bold text-lg py-4 border-b">고객센터</div>
            <ul>
                <li class="py-4 border-b"><a href="{{ route('board.show', 'inquiry') }}" class="{{ request()->routeIs('board.show') && request()->route('board')['slug'] == 'inquiry' ? 'active font-bold' : '' }}">1:1문의</a></li>
                <li class="py-4 border-b"><a href="{{ route('board.show', 'notice') }}" class="{{ request()->routeIs('board.show') && request()->route('board')['slug'] == 'notice' ? 'active font-bold' : '' }}">공지사항</a></li>
                <li class="py-4 border-b"><a href="{{ route('board.show', 'guide') }}" class="{{ request()->routeIs('board.show') && request()->route('board')['slug'] == 'guide' ? 'active font-bold' : '' }}">서비스 가이드</a></li>
            </ul>
        </div>
        <div class=" mb-6">
            <div class="font-bold text-lg py-4 border-b">커뮤니티</div>
            <ul>
                <li class="py-4 border-b"><a href="{{ route('board.show', 'news') }}" class="{{ request()->routeIs('board.show') && request()->route('board')['slug'] == 'news' ? 'active font-bold' : '' }}">레몬소식</a></li>
                <li class="py-4 border-b"><a href="{{ route('board.show', 'free') }}" class="{{ request()->routeIs('board.show') && request()->route('board')['slug'] == 'free' ? 'active font-bold' : '' }}">레몬톡톡</a></li>
                <li class="py-4 border-b"><a href="{{ route('board.show', 'neighbor') }}" class="{{ request()->routeIs('board.show') && request()->route('board')['slug'] == 'neighbor' ? 'active font-bold' : '' }}">우리친구할까요?</a></li>
            </ul>
        </div>
    </x-slot>

    <x-slot name="header">
        {{ $header }}
    </x-slot>
    {{ $slot }}
</x-default-layout>
