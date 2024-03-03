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
            <x-campaign.sidecar :campaign="$campaign" :useThumbnail="true"></x-campaign.sidecar>
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
