<x-app-layout>
    @isset($mainTop)
    {{ $mainTop }}
    @endisset
    <div class="container mx-auto p-6">
        <div class="flex">
            <div id="lnb"
                 class="shrink-0 w-[200px] mr-20 bg-white"
                 :class="{'open fixed left-0 top-0 bottom-0 z-[990] px-6 overflow-auto border-r' : $store.lnbModal.open}"
                 x-show="$store.lnbModal.show"
                 @click.away="if(window.innerWidth < 1024){$store.lnbModal.show = false; $store.lnbModal.open = false}">
                {{ $lnb }}
            </div>
            <div class="w-full">
                <div class="flex items-center border-b border-gray-800 py-4">
                    <button type="button" class="mr-3"
                            x-show="!$store.lnbModal.show"
                            @click="$store.lnbModal.show = true; $store.lnbModal.open = true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M4 6l16 0" />
                            <path d="M4 12l16 0" />
                            <path d="M4 18l16 0" />
                        </svg>
                    </button>
                    <div class="text-2xl font-bold">
                        {{ $header }}
                    </div>
                </div>
                {{ $slot }}
            </div>
        </div>
    </div>
</x-app-layout>
