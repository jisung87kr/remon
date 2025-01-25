<x-mypage-layout>
    <x-slot name="header">나의 캠페인</x-slot>
    <div>
        <form action="">
            <div class="overflow-x-auto">
                <div class="flex md:justify-center gap-3 py-3 md:py-6 min-w-[600px]">
                    <button type="submit"
                            class="button @if(request()->input('status') == \App\Enums\Campaign\ApplicationStatus::APPLIED->value) button-default @else button-light @endif"
                            name="status"
                            value="{{ \App\Enums\Campaign\ApplicationStatus::APPLIED->value }}">
                        <span>신청한 캠페인</span>
                        <span>{{ number_format($countData['appliedCount']) }}</span>
                    </button>
                    <button type="submit"
                            class="button @if(request()->input('status') == \App\Enums\Campaign\ApplicationStatus::APPROVED->value) button-default @else button-light @endif""
                            name="status"
                            value="{{ \App\Enums\Campaign\ApplicationStatus::APPROVED->value }}">
                        <span>선정된 캠페인</span>
                        <span>{{ number_format($countData['approvedCount']) }}</span>
                    </button>
                    <button type="submit"
                            class="button @if(request()->input('status') == \App\Enums\Campaign\ApplicationStatus::POSTED->value) button-default @else button-light @endif""
                            name="status"
                            value="{{ \App\Enums\Campaign\ApplicationStatus::POSTED->value }}">
                        <span>등록한 캠페인</span>
                        <span>{{ number_format($countData['postedCount']) }}</span>
                    </button>
                    <button type="submit"
                            class="button @if(request()->input('status') == \App\Enums\Campaign\ApplicationStatus::COMPLETED->value) button-default @else button-light @endif""
                            name="status"
                            value="{{ \App\Enums\Campaign\ApplicationStatus::COMPLETED->value }}">
                        <span>종료된 캠페인</span>
                        <span>{{ number_format($countData['completedCount']) }}</span>
                    </button>
                </div>
            </div>
        </form>
        <div>
            <x-campaign.snsfilter class="mt-6 justify-end mb-6" :category="null"></x-campaign.snsfilter>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-6 xl:grid-cols-5">
                @forelse($campaigns as $key => $campaign)
                    <x-campaign.card :campaign="$campaign"></x-campaign.card>
                @empty
                    <div class="card col-span-3 xl:col-span-5 text-center">
                        준비된 캠페인이 없습니다.
                    </div>
                @endforelse
            </div>
            {{ $campaigns->links() }}
        </div>
    </div>
</x-mypage-layout>
