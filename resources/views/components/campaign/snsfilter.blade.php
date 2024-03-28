<div {{ $attributes->merge(['class' => 'flex gap-3']) }}>
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
