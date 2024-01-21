<x-app-layout>
    <div class="container mx-auto px-6" x-data="campaignData">
        <div class="grid grid-cols-8 gap-6 relative">
            <div class="col-span-8 lg:col-span-6 lg:border-r lg:pr-6">
                <div>
                    <h1 class="font-bold text-[32px] my-3">[전국] 명륜진사갈비</h1>
                </div>
                <div class="mt-6 border-b mb-6 flex">
                    <a href="{{ route('campaigns.show', 1) }}" class="block px-5 py-3 text-gray-500">캠페인 정보</a>
                    <a href="{{ route('campaigns.applicants', 1) }}" class="block px-5 py-3 border-b-2 border-indigo-400">
                        <span class="font-bold">신청자 </span><span class="font-bold">4,000</span><span>/</span><span>100</span>
                    </a>
                </div>
                <div>
                    <div class="grid grid-cols-4 gap-6 pb-6">
                        @foreach(range(1, 100) as $key)
                            <div class="flex items-center">
                                <img src="https://placeholder.co/40x40" alt="" class="rounded-full">
                                <div class="text-sm ml-3 text-gray-600">푸른하늘</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-span-8 lg:col-span-2">
                <div class="lg:sticky lg:top-0">
                    <div class="py-6 border-b">
                        <img src="https://placeholder.co/1000x1000" alt="">
                        <div class="mt-3">
                            <div class="font-bold text-xl">[전국] 명륜진사갈비</div>
                            <div class="font-bold text-gray-500">확-달라진 명륜진사갈비 NEW버전을 소개해주세요!</div>
                            <div class="flex gap-3 mt-3">
                                <img src="{{ Vite::asset('resources/images/media/blog.svg') }}" alt="">
                                <div class="p-1 text-xs border text-gray-600">예약없음</div>
                            </div>
                        </div>
                    </div>
                    <div class="py-6 border-b">
                        <div class="flex font-bold my-2">
                            <div class="shrink-0 w-[110px] mr-1">캠페인 신청기간</div>
                            <div>01.16 ~ 01.23</div>
                        </div>
                        <div class="flex text-gray-500 my-2">
                            <div class="shrink-0 w-[110px] mr-1">인플루언서 발표</div>
                            <div>01.16 ~ 01.23</div>
                        </div>
                        <div class="flex text-gray-500 my-2">
                            <div class="shrink-0 w-[110px] mr-1">콘텐츠 등록기간</div>
                            <div>01.16 ~ 01.23</div>
                        </div>
                        <div class="flex text-gray-500 my-2">
                            <div class="shrink-0 w-[110px] mr-1">콘텐츠 결과발표</div>
                            <div>01.16 ~ 01.23</div>
                        </div>
                    </div>
                    <div class="py-6">
                        <a href="" class="bg-gray-900 text-white px-5 py-4 block text-center font-bold">캠페인 신청하기</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
      const campaignData = {
        currentTab: 'info',
        showMore: false,
        clickTabHandle(name){
          this.currentTab = name;
        }
      }
    </script>
</x-app-layout>
