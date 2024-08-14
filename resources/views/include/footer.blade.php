<footer class="border-t px-6 mb-20">
    <div class="container mx-auto py-6">
        <div class="md:flex md:justify-between md:items-center">
            <div class="mr-6">
                <a href="" class="text-[20px] text-gray-500">{{ config('app.name') }}</a>
                <div class="text-gray-500 text-sm">
                    <div>
                        <span>{{ config('app.cooperation.name') }}</span><span class="mx-2">|</span><span>대표이사 : {{ config('app.cooperation.ceo_name') }}</span><span class="mx-2">|</span><span>개인정보 보호 최고책임자 : {{ config('app.policy.manager_name') }}</span>
                    </div>
                    <div>
                        <span>사업자등록번호: {{ config('app.cooperation.businessRegistrationNumber') }}</span><span class="mx-2">|</span><span>통신판매신고업번호 {{ config('app.cooperation.mailOrderLicenseNumber') }}</span>
                    </div>
                    <div>
                        <span>주소: {{ config('app.cooperation.address') }}</span>
                    </div>
                    <div>
                        <span>메일: {{ config('app.cooperation.helpEmail') }}</span><span class="mx-2">|</span><span>전화: {{ config('app.cooperation.callNumber') }}</span><span class="mx-2">|</span><span>팩스: {{ config('app.cooperation.fax') }}</span>
                    </div>
                </div>
                <div class="mt-6 font-bold">
                    @ {{ config('app.name') }}. All Rights Reserved.
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
                    <a href="{{ route('page.terms') }}" class="pr-2 text-gray-500">이용약관</a>
                    <a href="{{ route('page.policy') }}" class="pr-2 text-gray-500 font-bold">개인정보처리방침</a>
                    <a href="{{ route('page.terms_location') }}" class="pr-2 text-gray-500">위치기반서비스이용약관</a>
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
