<x-app-layout>
    @isset($mainTop)
    {{ $mainTop }}
    @endisset
    <div class="container mx-auto p-6">
        <div class="flex">
            <div class="shrink-0 w-[200px] mr-20">
                {{ $lnb }}
            </div>
            <div class="w-full">
                <div class="text-2xl font-bold border-b border-gray-800 py-4">
                    {{ $header }}
                </div>
                {{ $slot }}
            </div>
        </div>
    </div>
</x-app-layout>
