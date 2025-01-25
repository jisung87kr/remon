<x-app-layout>
    <div class="container mx-auto px-6" x-data="campaignData">
        <div class="grid grid-cols-8 gap-6 relative">
            <div class="col-span-8 lg:col-span-6 lg:border-r lg:pr-6">
                <div>
                    <h1 class="font-bold text-[32px] my-3">{{ $campaign->title }}</h1>
                </div>
                <div class="mt-6 border-b mb-6 flex">
                    <a href="{{ route('campaign.show', $campaign) }}" class="block px-5 py-3 text-gray-500">캠페인 정보</a>
                    <a href="{{ route('campaign.application.index', $campaign) }}" class="block px-5 py-3 border-b-2 border-indigo-400">
                        <span class="font-bold">신청자 </span><span class="font-bold">{{ number_format($campaign->applications()->active()->count()) }}</span><span>/</span><span>{{ number_format($campaign->application_limit) }}</span>

                    </a>
                </div>
                <div>
                    <div class="grid grid-cols-4 gap-6 pb-6">
                        @forelse($campaign->applications()->active()->get() as $application)
                            <div class="flex items-center">
                                <img src="{{ $application->user->profile_photo_url }}" alt="" class="rounded-full">
                                <div class="text-sm ml-3 text-gray-600">{{ $application->user->name }}</div>
                            </div>
                        @empty
                            <div class="col-span-4">
                                <div class="text-center">신청자가 없습니다.</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            <x-campaign.sidecar :campaign="$campaign" :useThumbnail="true" :campaignApplication="$campaignApplication"></x-campaign.sidecar>
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
