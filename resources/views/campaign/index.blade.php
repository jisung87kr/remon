<x-app-layout>
    <section id="popular_campaign" class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-3">{{ $category->name }} 캠페인</h1>
        <form action="">
            @if($category->name)
            <div class="my-10 border-b flex">
                <a href="{{ route("category.show", '전체') }}" class="block px-4 py-2 {{ $category->name == '전체' ? 'border-b-2 border-indigo-400' : '' }}">전체</a>
                <a href="{{ route("category.show", '생활') }}" class="block px-4 py-2 {{ $category->name == '생활' ? 'border-b-2 border-indigo-400' : '' }}">생활</a>
                <a href="{{ route("category.show", '서비스') }}" class="block px-4 py-2 {{ $category->name == '서비스' ? 'border-b-2 border-indigo-400' : '' }}">서비스</a>
                <a href="{{ route("category.show", '유아동') }}" class="block px-4 py-2 {{ $category->name == '유아동' ? 'border-b-2 border-indigo-400' : '' }}">유아동</a>
                <a href="{{ route("category.show", '디지털') }}" class="block px-4 py-2 {{ $category->name == '디지털' ? 'border-b-2 border-indigo-400' : '' }}">디지털</a>
                <a href="{{ route("category.show", '뷰티') }}" class="block px-4 py-2 {{ $category->name == '뷰티' ? 'border-b-2 border-indigo-400' : '' }}">뷰티</a>
                <a href="{{ route("category.show", '패션') }}" class="block px-4 py-2 {{ $category->name == '패션' ? 'border-b-2 border-indigo-400' : '' }}">패션</a>
                <a href="{{ route("category.show", '도서') }}" class="block px-4 py-2 {{ $category->name == '도서' ? 'border-b-2 border-indigo-400' : '' }}">도서</a>
                <a href="{{ route("category.show", '식품') }}" class="block px-4 py-2 {{ $category->name == '식품' ? 'border-b-2 border-indigo-400' : '' }}">식품</a>
                <a href="{{ route("category.show", '반려동물') }}" class="block px-4 py-2 {{ $category->name == '반려동물' ? 'border-b-2 border-indigo-400' : '' }}">반려동물</a>
            </div>
            @endif

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
                    <div class="mb-2 md:mb-0 md:w-[100px] md:shrink-0 md:mr-6">유형별</div>
                    <div class="md:grow">
                        <ul class="flex flex-wrap gap-3">
                            @foreach($typeCategory->categories as $category)
                                <li class="">
                                    <x-checkbox-button id="type_{{$category->id}}"
                                                       name="type[]"
                                                       value="{{$category->name}}"
                                                       :checked="in_array($category->name, request()->input('type', []))">{{ $category->name }}</x-checkbox-button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="md:flex py-3 items-center">
                    <div class="mb-2 md:mb-0 md:w-[100px] md:shrink-0 md:mr-6">제품별</div>
                    <div class="md:grow">
                        <ul class="flex flex-wrap gap-3">
                            @foreach($productCategory->categories as $category)
                                <li class="">
                                    <x-checkbox-button id="product_{{$category->id}}"
                                                       name="product[]"
                                                       value="{{$category->name}}"
                                                       :checked="in_array($category->name, request()->input('product', []))">{{ $category->name }}</x-checkbox-button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="md:flex py-3 items-center">
                    <div class="mb-2 md:mb-0 md:w-[100px] md:shrink-0 md:mr-6">지역별</div>
                    <div class="md:grow">
                        <ul class="flex flex-wrap gap-3">
                            @foreach($locationCategory->categories as $category)
                                <li class="">
                                    <x-checkbox-button id="location_{{$category->id}}"
                                                       name="location[]"
                                                       value="{{$category->name}}"
                                                       :checked="in_array($category->name, request()->input('location', []))">{{ $category->name }}</x-checkbox-button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="text-center mb-12">
                <a href="{{ route('campaigns.index') }}" class="button button-gray">초기화</a>
                <button class="button button-default">검색</button>
            </div>

            <div class="flex gap-3 mb-6 justify-end">
                <a href="{{ route('campaigns.index', array_merge(request()->query(), ['media' => \App\Enums\Campaign\MediaEnum::NAVER_BLOG])) }}"
                   class="border rounded-2xl px-3 py-1 text-sm {{ request()->input('media') == \App\Enums\Campaign\MediaEnum::NAVER_BLOG->name ? 'border-indigo-400' : '' }}">블로그</a>
                <a href="{{ route('campaigns.index', array_merge(request()->query(), ['media' => \App\Enums\Campaign\MediaEnum::INSTAGRAM])) }}"
                   class="border rounded-2xl px-3 py-1 text-sm {{ request()->input('media') == \App\Enums\Campaign\MediaEnum::INSTAGRAM->name ? 'border-indigo-400' : '' }}">인스타그램</a>
                <a href="{{ route('campaigns.index', array_merge(request()->query(), ['media' => \App\Enums\Campaign\MediaEnum::YOUTUBE])) }}"
                   class="border rounded-2xl px-3 py-1 text-sm {{ request()->input('media') == \App\Enums\Campaign\MediaEnum::YOUTUBE->name ? 'border-indigo-400' : '' }}">유튜부</a>
                <div class="relative border rounded-2xl px-3 py-1 text-sm">
                    <x-dropdown align="right">
                        <x-slot name="trigger">
                            <div class="flex">
                                <span class="mr-2">최신순</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-caret-down-filled" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M18 9c.852 0 1.297 .986 .783 1.623l-.076 .084l-6 6a1 1 0 0 1 -1.32 .083l-.094 -.083l-6 -6l-.083 -.094l-.054 -.077l-.054 -.096l-.017 -.036l-.027 -.067l-.032 -.108l-.01 -.053l-.01 -.06l-.004 -.057v-.118l.005 -.058l.009 -.06l.01 -.052l.032 -.108l.027 -.067l.07 -.132l.065 -.09l.073 -.081l.094 -.083l.077 -.054l.096 -.054l.036 -.017l.067 -.027l.108 -.032l.053 -.01l.06 -.01l.057 -.004l12.059 -.002z" stroke-width="0" fill="currentColor" />
                                </svg>
                            </div>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link>
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
                            <x-dropdown-link>
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
                            <x-dropdown-link>
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
                <div class="card">
                    <div class="card-body">
                        <div class="relative">
                            <a href="{{ route('campaigns.show', $campaign) }}" class="overflow-hidden rounded block">
                                <img src="https://placeholder.co/300x300" alt="" class="w-full">
                            </a>
                            <button class="absolute right-3 top-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-heart"
                                     width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff"
                                     fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"/>
                                </svg>
                            </button>
                        </div>
                        <div class="my-3 flex gap-x-2">
                            @foreach($campaign->media as $media)
                                @switch($media->media)
                                    @case(App\Enums\Campaign\MediaEnum::NAVER_BLOG->value)
                                        <img src="{{ Vite::asset('resources/images/media/blog.svg') }}" alt="">
                                        @break
                                    @case(App\Enums\Campaign\MediaEnum::INSTAGRAM->value)
                                        <img src="{{ Vite::asset('resources/images/media/instagram.svg') }}" alt="">
                                        @break
                                    @case(App\Enums\Campaign\MediaEnum::YOUTUBE->value)
                                        <img src="{{ Vite::asset('resources/images/media/youtube.svg') }}" alt="">
                                        @break
                                @endswitch
                            @endforeach
                            <div class="ml-2 font-bold">{{ $campaign->applicant_end_at->diffForHumans() }} 마감</div>
                        </div>
                        <div>
                            <div>[{{ $campaign->locationCategories[0]->name }}] {{ $campaign->product_name }}</div>
                            <small class="text-gray-500 line-clamp-2">{{ $campaign->benefit }}</small>
                        </div>
                        <div class="my-2">
                            <small>신청 {{ number_format($campaign->applicants()->count()) }}</small><small class="text-gray-500"> / </small><small
                                    class="text-gray-500">{{ number_format($campaign->applicant_limit) }}명</small>
                        </div>
                        <div class="flex gap-1">
                            @foreach($campaign->options as $option)
                                <div class="p-1 text-xs border text-gray-600">{{ $option->name }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
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
</x-app-layout>
