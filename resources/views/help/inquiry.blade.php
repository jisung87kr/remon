<x-help-layout>
    <x-slot name="mainTop">
        <div class="container mx-auto p-6">
            <div class="grid grid-cols-5 p-10 items-center divide-x shadow-lg rounded-lg my-3">
                <div class="col-span-2 flex items-center">
                    <img src="https://placeholder.co/70x70" alt="" class="rounded-full">
                    <div class="mx-8 text-2xl font-bold">거북이와두루</div>
                    <button class="px-5 py-2 text-sm text-white font-bold bg-sky-400 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check inline" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M5 12l5 5l10 -10" />
                        </svg>
                        <span class="ml-1">출석 체크</span>
                    </button>
                </div>
                <div class="px-6">
                    <div class="mb-3">멤버십</div>
                    <div>NEW</div>
                </div>
                <div class="px-6">
                    <div class="mb-3">포인트</div>
                    <div><span class="text-lg font-bold">1,000</span>P</div>
                </div>
                <div class="px-6">
                    <div class="mb-3">미디어연결</div>
                    <div class="flex gap-x-4">
                        <img src="{{ Vite::asset('resources/images/media/ic-mypage-blog-off.svg') }}" alt="">
                        <img src="{{ Vite::asset('resources/images/media/ic-mypage-insta-off.svg') }}" alt="">
                        <img src="{{ Vite::asset('resources/images/media/ic-mypage-youtube-off.svg') }}" alt="" class="w-[20px]">
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    <x-slot name="header">1:1문의</x-slot>
    <div>1:1 문의</div>
</x-help-layout>

