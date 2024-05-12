<x-business-layout>
    <section>
        <h1 class="mb-3 text-2xl font-bold">캠페인 목록</h1>
        <div class="card">
            @include('campaign.search_form')
        </div>
        <div class="flex gap-3 my-6 justify-end">
            <x-campaign.snsfilter :category="$category"></x-campaign.snsfilter>
        </div>
        <div class="relative overflow-auto">
            <table class="table border" style="min-width: 1200px">
                <colgroup>
                    <col width="150x">
                    <col width="100x">
                    <col width="*">
                    <col width="200x">
                    <col width="120x">
                    <col width="120x">
                    <col width="150x">
                </colgroup>
                <thead class="!bg-white border-y text-center">
                <tr>
                    <th>이미지</th>
                    <th>상태값</th>
                    <th>캠페인정보</th>
                    <th>캠페인 기간</th>
                    <th>선정/모집</th>
                    <th>배너조회수</th>
                    <th>관리</th>
                </tr>
                </thead>
                <tbody>
                @foreach($campaigns as $campaign)
                <tr>
                    <td class="text-center">
                        <img src="{{ Storage::url($campaign->thumbnails[0]['file_path']) }}" alt="" class="rounded-lg">
                    </td>
                    <td class="text-center">
                        <x-campaign.badge :status="$campaign->progress_status" class="break-keep"></x-campaign.badge>
                    </td>
                    <td>
                        @foreach($campaign->media as $media)
                            <x-media-icon :media="$media->media"></x-media-icon>
                        @endforeach
                        <div class="mt-1">
                            <div class="font-bold">
                                @if($campaign->locationCategories->count() > 0)[{{ $campaign->locationCategories[0]->name }}]@endif
                                {{ $campaign->title }}
                            </div>
                            @if($campaign->benefit)
                            <small class="text-gray-500 line-clamp-2">{{ $campaign->benefit }}</small>
                            @endif
                        </div>
                    </td>
                    <td class="text-center">
                        {{ $campaign->application_start_at->format('m.d') }} ~ {{ $campaign->result_announcement_date_at->format('m.d') }}
                    </td>
                    <td class="text-center">
                        {{ number_format($campaign->applications()->activeCount()->count()) }} / {{ number_format($campaign->applicant_limit) }}
                    </td>
                    <td class="text-center">
                        {{ number_format($campaign->banner_log_count) }}
                    </td>
                    <td class="text-center">
                        <a href="{{ route('business.campaign.show', $campaign) }}" class="button button-light text-center shrink-0 block">보기</a>
                        <a href="{{ route('business.campaign.report', $campaign) }}" class="button button-light text-center shrink-0 block mt-1">보고서</a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
</x-business-layout>
