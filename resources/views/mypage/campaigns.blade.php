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
                    <span>{{ number_format($countData['appliedCount']) }}</span>
                </button>
                <button type="submit"
                        class="button @if(request()->input('status') == \App\Enums\Campaign\ApplicantStatus::APPROVED->value) button-default @else button-light @endif""
                        name="status"
                        value="{{ \App\Enums\Campaign\ApplicantStatus::APPROVED->value }}">
                    <span>선정된 캠페인</span>
                    <span>{{ number_format($countData['approvedCount']) }}</span>
                </button>
                <button type="submit"
                        class="button @if(request()->input('status') == \App\Enums\Campaign\ApplicantStatus::POSTED->value) button-default @else button-light @endif""
                        name="status"
                        value="{{ \App\Enums\Campaign\ApplicantStatus::POSTED->value }}">
                    <span>등록한 캠페인</span>
                    <span>{{ number_format($countData['postedCount']) }}</span>
                </button>
                <button type="submit"
                        class="button @if(request()->input('status') == \App\Enums\Campaign\ApplicantStatus::COMPLETED->value) button-default @else button-light @endif""
                        name="status"
                        value="{{ \App\Enums\Campaign\ApplicantStatus::COMPLETED->value }}">
                    <span>종료된 캠페인</span>
                    <span>{{ number_format($countData['completedCount']) }}</span>
                </button>
            </div>
        </form>
        <div>
            <x-campaign.snsfilter class="mt-6 justify-end mb-6" :category="null"></x-campaign.snsfilter>
            <div class="grid grid-cols-3 gap-6 xl:grid-cols-5">
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
