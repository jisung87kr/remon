<x-app-layout>
    <div class="container mx-auto px-6" x-data="campaignData">
        <div class="grid grid-cols-8 gap-6 relative">
            <div class="col-span-8 lg:col-span-6 lg:border-r lg:pr-6">
                <div>
                    <h1 class="font-bold text-xl md:text-[32px] my-3">@if($campaign->locationCategories->count() > 0)[{{ $campaign->locationCategories[0]->name }}]@endif {{ $campaign->product_name }}</h1>
                    <div class="font-bold text-gray-500">{{ $campaign->title }}</div>
                    <div class="flex items-center gap-2 mt-3">
                        @foreach($campaign->media as $media)
                            <x-media-icon :media="$media"></x-media-icon>
                        @endforeach

                        @foreach($campaign->options as $option)
                            <div class="p-1 text-xs border text-gray-600">{{ $option->name }}</div>
                        @endforeach
                    </div>
                </div>
                <div class="mt-6 border-b mb-6 flex">
                    <a href="{{ route('campaign.show', $campaign) }}" class="block px-5 py-3 text-gray-500">캠페인 정보</a>
                    <a href="{{ route('campaign.application.index', $campaign) }}" class="block px-5 py-3 border-b-2 border-indigo-400">
                        <span class="font-bold">신청자 </span><span class="font-bold">{{ number_format($campaign->applications()->active()->count()) }}</span><span>/</span><span>{{ number_format($campaign->application_limit) }}</span>

                    </a>
                </div>
                <div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-6 pb-6">
                        @forelse($campaign->applications()->active()->get() as $application)
                            <div class="flex items-center">
                                <img src="{{ $application->user->profile_photo_url }}" alt="" class="rounded-full w-[30px]">
                                <div class="text-xs md:text-sm ml-3 text-gray-600">{{ $application->user->name }}</div>
                            </div>
                            <div class="flex items-center">
                                <img src="{{ $application->user->profile_photo_url }}" alt="" class="rounded-full w-[30px]">
                                <div class="text-xs md:text-sm ml-3 text-gray-600">{{ $application->user->name }}</div>
                            </div>
                            <div class="flex items-center">
                                <img src="{{ $application->user->profile_photo_url }}" alt="" class="rounded-full w-[30px]">
                                <div class="text-xs md:text-sm ml-3 text-gray-600">{{ $application->user->name }}</div>
                            </div>
                            <div class="flex items-center">
                                <img src="{{ $application->user->profile_photo_url }}" alt="" class="rounded-full w-[30px]">
                                <div class="text-xs md:text-sm ml-3 text-gray-600">{{ $application->user->name }}</div>
                            </div>
                            <div class="flex items-center">
                                <img src="{{ $application->user->profile_photo_url }}" alt="" class="rounded-full w-[30px]">
                                <div class="text-xs md:text-sm ml-3 text-gray-600">{{ $application->user->name }}</div>
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
