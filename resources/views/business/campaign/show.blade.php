<x-business-layout>
    <div class="card flex flex-wrap lg:flex-nowrap">
        <div class="sm:flex w-full">
            <div class="sm:shrink-0 sm:w-[200px]">
                @isset($campaign->thumbnails[0])
                    <img src="{{ Storage::url($campaign->thumbnails[0]['file_path']) }}" alt="" class="rounded-lg">
                @else
                    <img src="https://placehold.co/400x400?text=no+image" alt="" class="rounded-lg">
                @endisset
            </div>
            <div class="sm:mx-6 w-full mt-3">
                <x-campaign.info :campaign="$campaign"></x-campaign.info>
            </div>
        </div>
        <div class="flex w-full gap-3 sm:block text-center mt-3 sm:text-left sm:mt-0 sm:shrink-0 sm:w-[200px] ">
            <a href="{{ route('campaign.show', $campaign) }}" class="w-1/2 block text-center button button-light sm:w-auto sm:mb-3">캠페인 상세보기</a>
            <a href="" class="w-1/2 block text-center button button-default-outline sm:w-auto" @click.prevent="alert('준비중인 기능입니다.')">문의하기</a>
        </div>
    </div>

    <div class="card mt-6">
        <div class="mb-3 flex items-center justify-between">
            <div class="font-bold">리뷰목록</div>
            <div class="flex gap-1">
                <a href="" class="!text-xs button button-light" @click.prevent="alert('준비중인 기능입니다')">엑셀다운</a>
                <a href="{{ route('business.dashboard.campaign.report', $campaign) }}" class="!text-xs button button-default-outline">결과보고서</a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="table">
                <thead class="bg-white border-b">
                <tr>
                    <th>회원</th>
                    <th>채널</th>
                    <th>내용</th>
                    <th>등록일</th>
                </tr>
                </thead>
                <tbody>
                @foreach($contents as $content)
                <tr>
                    <td>
                        <x-user.avatar :user="$content->user"></x-user.avatar>
                    </td>
                    <td>
                        <x-media-icon :media="$content->media->media"></x-media-icon>
                    </td>
                    <td>
                        <a href="{{ $content->content_url }}" target="_blank">{{ $content->description }}</a>
                    </td>
                    <td>{{ $content->created_at->format('y.m.d') }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mt-6">
        <div class="mb-3 font-bold">선정목록</div>
        <div class="overflow-x-auto">
            <table class="table">
                <thead class="bg-white border-b">
                <tr>
                    <th>번호</th>
                    <th>회원</th>
                    <th>채널</th>
                    <th>신청일</th>
                    <th>비고</th>
                    <th>상태</th>
                </tr>
                </thead>
                <tbody>
                @foreach($applicants as $applicant)
                <tr>
                    <td>{{ $applicant->id }}</td>
                    <td>
                        <x-user.avatar :user="$applicant->user"></x-user.avatar>
                    </td>
                    <td>
                        <div class="flex gap-2">
                            @foreach($applicant->user->medias as $media)
                                <x-media-icon :media="$media->media"></x-media-icon>
                            @endforeach
                        </div>
                    </td>
                    <td>{{ $applicant->created_at ? $applicant->created_at->format('y.m.d') : '-' }}</td>
                    <td>-</td>
                    <td>
                        <x-badge.application :status="$applicant->status">{{ \App\Enums\Campaign\ApplicationStatus::tryFrom($applicant->status)->label() }}</x-badge.application>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-business-layout>
