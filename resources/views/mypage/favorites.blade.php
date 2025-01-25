<x-mypage-layout>
    <x-slot name="header">관심 캠페인</x-slot>
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
</x-mypage-layout>
