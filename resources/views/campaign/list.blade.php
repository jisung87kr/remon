@props(['campaigns' => $campaigns, 'category' => $category, 'mode' => null])
<section id="popular_campaign" class="container mx-auto p-6">
    <h1 class="text-lg md:text-2xl font-bold mb:1 md:mb-3">{{ $category->name }} 캠페인</h1>
    @if(false)
    <div class="flex items-center relative" x-data="{open: false}">
        <div class="flex text-2xl items-center">
            <span>지역 선택</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M9 6l6 6l-6 6" />
            </svg>
        </div>
        <div>
            <button class="flex items-center" @click="open=true">
                <span class="text-2xl font-bold">{{ request()->input('location', '전체') }}</span>
                <span class="text-sm ml-1 mt-1">▼</span>
            </button>
            <div class="absolute left-0 top-10 w-full lg:w-3/5 bg-white border rounded-lg p-6 shadow z-50" x-show="open" style="display: none">
                <div>
                    <a href="{{ route(request()->route()->getName(), array_merge(request()->query(), [$category, 'location' => '전체'])) }}" class="text-lg @if(request()->input('location') == '전체') text-indigo-700 @endif">전체지역</a>
                </div>
                @foreach($locationCategory->categories as $location)
                    <div class="flex mt-6 pt-6 border-t" @click.away="open = false">
                        <div class="shrink-0 w-20 mr-3">
                            <a href="">{{ $location->name }}</a>
                        </div>
                        <div class="w-full grid grid-cols-4 gap-3 text-gray-500 text-sm">
                            <div>
                                <a href="{{ route(request()->route()->getName(), array_merge(request()->query(), [$category, 'location' => $location->name])) }}" class="@if(request()->input('location') == $location->name) text-indigo-700 @endif">전체</a>
                            </div>
                            @foreach($location->categories as $locationChild)
                                <div>
                                    <a href="{{ route(request()->route()->getName(), array_merge(request()->query(), [$category, 'location' => $locationChild->name])) }}" class="@if(request()->input('location') == $locationChild->name) text-indigo-700 @endif">{{ $locationChild->name }}</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
{{--    @include('campaign.search_form')--}}
    <div class="flex gap-3 my-6 justify-start md:justify-end">
        <x-campaign.snsfilter :category="$category" class="gap-1"></x-campaign.snsfilter>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-2 md:gap-6 xl:grid-cols-5">
        @forelse($campaigns as $key => $campaign)
            <x-campaign.card :campaign="$campaign" :mode="$mode"></x-campaign.card>
        @empty
            <div class="card col-span-3 xl:col-span-5">
                준비된 캠페인이 없습니다.
            </div>
        @endforelse
    </div>
    @if($campaigns)
        {{ $campaigns->links() }}
    @endif
</section>
