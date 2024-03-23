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
    <form action="">
        @if($category->name)
            <div class="my-10 border-b flex">
                <a href="{{ route("category.show", $category->name) }}" class="block px-4 py-2 {{ $category->name == '전체' ? 'border-b-2 border-indigo-400' : '' }}">전체</a>
                @foreach($category->categories as $child)
                    <a href="{{ route("category.show", $child->name) }}" class="block px-4 py-2 {{ $child->name == $category->name ? 'border-b-2 border-indigo-400' : '' }}">{{ $child->name }}</a>
                @endforeach
            </div>
        @else
            <div class="border px-6 rounded-lg my-6 flex flex-col divide-y">
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
                                                       :checked="in_array($type->name, request()->input('campaign_type', []))">{{ $type->name }}</x-checkbox-button>
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
            </div>

            <div class="text-center mb-12">
                <a href="{{ route(request()->route()->getName()) }}" class="button button-gray">초기화</a>
                <button class="button button-default">검색</button>
            </div>
        @endif

        <div class="flex gap-3 mb-6 justify-end">
            <a href="{{ route(request()->route()->getName(), array_merge(request()->query(), [$category, 'media' => \App\Helper\CommonHelper::toggleArrayQueryString('media', \App\Enums\Campaign\MediaEnum::NAVER_BLOG->value)])) }}"
               class="border rounded-2xl px-3 py-1 text-sm {{ in_array(\App\Enums\Campaign\MediaEnum::NAVER_BLOG->value, request()->input('media', [])) ? 'border-indigo-400' : '' }}">블로그</a>

            <a href="{{ route(request()->route()->getName(), array_merge(request()->query(), [$category, 'media' => \App\Helper\CommonHelper::toggleArrayQueryString('media', \App\Enums\Campaign\MediaEnum::INSTAGRAM->value)])) }}"
               class="border rounded-2xl px-3 py-1 text-sm {{ in_array(\App\Enums\Campaign\MediaEnum::INSTAGRAM->value, request()->input('media', [])) ? 'border-indigo-400' : '' }}">인스타그램</a>

            <a href="{{ route(request()->route()->getName(), array_merge(request()->query(), [$category, 'media' => \App\Helper\CommonHelper::toggleArrayQueryString('media', \App\Enums\Campaign\MediaEnum::YOUTUBE->value)])) }}"
               class="border rounded-2xl px-3 py-1 text-sm {{ in_array(\App\Enums\Campaign\MediaEnum::YOUTUBE->value, request()->input('media', [])) ? 'border-indigo-400' : '' }}">유튜부</a>


            <div class="relative border rounded-2xl px-3 py-1 text-sm">
                <x-dropdown align="right">
                    <x-slot name="trigger">
                        <div class="flex">
                                <span class="mr-2">
                                    @switch(request()->input('sort'))
                                        @case('latest')최신순@break
                                        @case('popular')인기순@break
                                        @case('deadline')선정 마감순@break
                                        @default최신순@break
                                    @endswitch
                                </span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-caret-down-filled" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M18 9c.852 0 1.297 .986 .783 1.623l-.076 .084l-6 6a1 1 0 0 1 -1.32 .083l-.094 -.083l-6 -6l-.083 -.094l-.054 -.077l-.054 -.096l-.017 -.036l-.027 -.067l-.032 -.108l-.01 -.053l-.01 -.06l-.004 -.057v-.118l.005 -.058l.009 -.06l.01 -.052l.032 -.108l.027 -.067l.07 -.132l.065 -.09l.073 -.081l.094 -.083l.077 -.054l.096 -.054l.036 -.017l.067 -.027l.108 -.032l.053 -.01l.06 -.01l.057 -.004l12.059 -.002z" stroke-width="0" fill="currentColor" />
                            </svg>
                        </div>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route(request()->route()->getName(), array_merge(request()->query(), [$category, 'sort' => 'latest']))" :class="request()->input('sort') == 'latest' ? '!text-indigo-700' : ''">
                            <div class="flex items-center">
                                <div class="border rounded-full p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="10" height="10" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M5 12l5 5l10 -10" />
                                    </svg>
                                </div>
                                <span class="ml-2">최신순</span>
                            </div>
                        </x-dropdown-link>
                        <x-dropdown-link :href="route(request()->route()->getName(), array_merge(request()->query(), [$category, 'sort' => 'popular']))" :class="request()->input('sort') == 'popular' ? '!text-indigo-700' : ''">
                            <div class="flex items-center">
                                <div class="border rounded-full p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="10" height="10" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M5 12l5 5l10 -10" />
                                    </svg>
                                </div>
                                <span class="ml-2">인기순</span>
                            </div>
                        </x-dropdown-link>
                        <x-dropdown-link :href="route(request()->route()->getName(), array_merge(request()->query(), [$category, 'sort' => 'deadline']))" :class="request()->input('sort') == 'deadline' ? '!text-indigo-700' : ''">
                            <div class="flex items-center">
                                <div class="border rounded-full p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="10" height="10" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M5 12l5 5l10 -10" />
                                    </svg>
                                </div>
                                <span class="ml-2">선정 마감순</span>
                            </div>
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </form>

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
