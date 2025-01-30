<footer class="border-t px-6  mb-16 md:mb-20">
    <div class="container mx-auto py-6">
        <div class="text-center">
            <div class="mr-6">
                <a href="" class="text-[20px] text-gray-500">{{ config('app.name') }}</a>
                <div class="text-gray-500 text-sm">
                    <div class="">
                        <a href="mailto:{{ config('app.cooperation.helpEmail') }}">{{ config('app.cooperation.helpEmail') }}</a>
                    </div>
                </div>
                <div class="mt-3 md:mt-6 font-bold">
                    @ {{ config('app.name') }}. All Rights Reserved.
                </div>
            </div>
        </div>
    </div>
    <div class="border-t py-3">
        <div class="container mx-auto py-3">
            <div class="flex gap-6 justify-center">
                <div class="break-keep">
                    <a href="{{ route('page.terms') }}" class="pr-2 text-sm md:text-base text-gray-500">이용약관</a>
                    <a href="{{ route('page.policy') }}" class="pr-2 text-sm md:text-base text-gray-500 font-bold">개인정보처리방침</a>
                    <a href="{{ route('page.terms_location') }}" class="pr-2 text-sm md:text-base text-gray-500">위치기반서비스이용약관</a>
                </div>
            </div>
        </div>
    </div>
</footer>
