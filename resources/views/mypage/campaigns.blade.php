<x-mypage-layout>
    <x-slot name="header">나의 캠페인</x-slot>
    <div>
        <form action="">
            <div class="flex justify-center gap-3 py-6">
                <button type="submit"
                        class="button @if(request()->input('status') == \App\Enums\Campaign\ApplicantStatus::APPLIED->value) button-default @else button-light @endif"
                        name="status"
                        value="{{ \App\Enums\Campaign\ApplicantStatus::APPLIED->value }}">
                    <span>신청한 캠페인</span>
                    <span>0</span>
                </button>
                <button type="submit"
                        class="button @if(request()->input('status') == \App\Enums\Campaign\ApplicantStatus::APPROVED->value) button-default @else button-light @endif""
                        name="status"
                        value="{{ \App\Enums\Campaign\ApplicantStatus::APPROVED->value }}">
                    <span>선정된 캠페인</span>
                    <span>0</span>
                </button>
                <button type="submit"
                        class="button @if(request()->input('status') == \App\Enums\Campaign\ApplicantStatus::POSTED->value) button-default @else button-light @endif""
                        name="status"
                        value="{{ \App\Enums\Campaign\ApplicantStatus::POSTED->value }}">
                    <span>등록한 캠페인</span>
                    <span>0</span>
                </button>
                <button type="submit"
                        class="button @if(request()->input('status') == \App\Enums\Campaign\ApplicantStatus::COMPLETED->value) button-default @else button-light @endif""
                        name="status"
                        value="{{ \App\Enums\Campaign\ApplicantStatus::COMPLETED->value }}">
                    <span>종료된 캠페인</span>
                    <span>0</span>
                </button>
            </div>
        </form>
        <div>
            <div class="text-right mb-6">
                <a href="{{ route(request()->route()->getName(), array_merge(request()->query(), ['media' => \App\Helper\CommonHelper::toggleArrayQueryString('media', \App\Enums\Campaign\MediaEnum::NAVER_BLOG->value)])) }}"
                   class="border rounded-2xl px-3 py-1 text-sm {{ in_array(\App\Enums\Campaign\MediaEnum::NAVER_BLOG->value, request()->input('media', [])) ? 'border-indigo-400' : '' }}">블로그</a>

                <a href="{{ route(request()->route()->getName(), array_merge(request()->query(), ['media' => \App\Helper\CommonHelper::toggleArrayQueryString('media', \App\Enums\Campaign\MediaEnum::INSTAGRAM->value)])) }}"
                   class="border rounded-2xl px-3 py-1 text-sm {{ in_array(\App\Enums\Campaign\MediaEnum::INSTAGRAM->value, request()->input('media', [])) ? 'border-indigo-400' : '' }}">인스타그램</a>

                <a href="{{ route(request()->route()->getName(), array_merge(request()->query(), ['media' => \App\Helper\CommonHelper::toggleArrayQueryString('media', \App\Enums\Campaign\MediaEnum::YOUTUBE->value)])) }}"
                   class="border rounded-2xl px-3 py-1 text-sm {{ in_array(\App\Enums\Campaign\MediaEnum::YOUTUBE->value, request()->input('media', [])) ? 'border-indigo-400' : '' }}">유튜부</a>
            </div>
            <div class="grid grid-cols-3 gap-6 xl:grid-cols-5">
                @forelse($campaigns as $key => $campaign)
                    <x-campaign.card :campaign="$campaign"></x-campaign.card>
                @empty
                    <div class="card col-span-3 xl:col-span-5 text-center">
                        준비된 캠페인이 없습니다.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-mypage-layout>
