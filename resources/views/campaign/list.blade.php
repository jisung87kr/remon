@props(['campaigns' => $campaigns, 'category' => $category, 'mode' => null])
<section id="popular_campaign" class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-3">{{ $category->name }} 캠페인</h1>
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
    <form action="" x-data="campaignListData">
        @if($category->name)
            <div class="my-10 border-b flex">
                <a href="{{ route("category.show", $category->name) }}" class="block px-4 py-2 {{ $category->name == '전체' ? 'border-b-2 border-indigo-400' : '' }}">전체</a>
                @foreach($category->categories as $child)
                    <a href="{{ route("category.show", $child->name) }}" class="block px-4 py-2 {{ $child->name == $category->name ? 'border-b-2 border-indigo-400' : '' }}">{{ $child->name }}</a>
                @endforeach
            </div>
        @else
            <div class="border px-6 rounded-lg my-6">
                <div class="flex flex-col divide-y overflow-hidden h-[160px]"
                     :class="{'open' : open, '!h-auto' : open}">
                    <div class="md:flex py-3 items-center">
                        <div class="mb-2 md:mb-0 md:w-[100px] md:shrink-0 md:mr-6">검색어</div>
                        <div class="md:grow">
                            <x-input name="keyword" :value="request()->input('keyword')" class="w-full"></x-input>
                        </div>
                    </div>
                    <div class="md:flex py-3 items-center">
                        <div class="mb-2 md:mb-0 md:w-[100px] md:shrink-0 md:mr-6">캠페인 타입</div>
                        <div class="md:grow">
                            <ul class="flex flex-wrap gap-3">
                                @foreach($campaignTypes as $type)
                                    <li class="">
                                        <x-checkbox-button id="campaign_type_{{$type->id}}"
                                                           name="campaign_type[]"
                                                           value="{{$type->name}}"
                                                           xmodel="campaignType"
                                        >{{ $type->name }}</x-checkbox-button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="md:flex py-3 items-center">
                        <div class="mb-2 md:mb-0 md:w-[100px] md:shrink-0 md:mr-6">제품별</div>
                        <div class="md:grow">
                            <ul class="flex flex-wrap gap-3">
                                @foreach($productCategory->categories as $category2)
                                    <li class="">
                                        <x-checkbox-button id="product_{{$category2->id}}"
                                                           name="product[]"
                                                           value="{{$category2->name}}"
                                                           :checked="in_array($category2->name, request()->input('product', []))">{{ $category2->name }}</x-checkbox-button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="md:flex py-3 items-center">
                        <div class="mb-2 md:mb-0 md:w-[100px] md:shrink-0 md:mr-6">유형별</div>
                        <div class="md:grow">
                            <ul class="flex flex-wrap gap-3">
                                @foreach($typeCategory->categories as $category2)
                                    <li class="">
                                        <x-checkbox-button id="type_{{$category2->id}}"
                                                           name="type[]"
                                                           value="{{$category2->name}}"
                                                           :checked="in_array($category2->name, request()->input('type', []))">{{ $category2->name }}</x-checkbox-button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <template x-if="hasShippingType">
                        <div class="md:flex py-3 items-center">
                            <div class="mb-2 md:mb-0 md:w-[100px] md:shrink-0 md:mr-6">지역별</div>
                            <div class="md:grow">
                                <ul class="flex flex-wrap gap-3">
                                    @foreach($locationCategory->categories as $location)
                                        @foreach($location->categories as $locationChild)
                                            <li>
                                                <x-checkbox-button id="type_{{$locationChild->id}}"
                                                                   name="type[]"
                                                                   value="{{$locationChild->name}}"
                                                                   :checked="in_array($locationChild->name, request()->input('type', []))">{{ $locationChild->name }}</x-checkbox-button>
                                            </li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="py-3 text-center relative">
                    <div class="bg-gradient-to-t from-[#fff] h-[20px] absolute left-0 top-o right-0 top-[-20px]"></div>
                    <button type="button" @click="toggle">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="icon icon-tabler icon-tabler-chevron-compact-down"
                             :class="{'rotate-180' : !open}"
                             width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M4 11l8 3l8 -3" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="text-center mb-12">
                <a href="{{ route(request()->route()->getName()) }}" class="button button-gray">초기화</a>
                <button class="button button-default">검색</button>
            </div>
        @endif

        <div class="flex gap-3 mb-6 justify-end">
            <x-campaign.snsfilter :category="$category"></x-campaign.snsfilter>
        </div>
    </form>
    <script>
        const campaignListData = {
          campaignType: @json(request()->input('campaign_type', [])),
          open: false,
          hasShippingType(){
            const filtered = this.campaignType.filter(item => item === '방문형');
            return filtered.length > 0;
          },
          toggle(){
            this.open = !this.open;
            console.log(this.open);
          }
        };
    </script>

    <div class="grid grid-cols-3 gap-6 xl:grid-cols-5">
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
