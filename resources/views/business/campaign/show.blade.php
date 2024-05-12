<x-business-layout>
    <div class="card flex">
        <div class="shrink-0 w-[200px]">
            <img src="{{ Storage::url($campaign->thumbnails[0]['file_path']) }}" alt="" class="rounded-lg">
        </div>
        <div class="mx-6 w-full">
            <x-campaign.info :campaign="$campaign"></x-campaign.info>
        </div>
        <div class="shrink-0 w-[200px]">
            <a href="{{ route('campaign.show', $campaign) }}" class="block text-center mb-3 button button-light">캠페인 상세보기</a>
            <a href="" class="block text-center button button-default-outline">문의하기</a>
        </div>
    </div>

    <div class="card mt-6">
        <div class="mb-3 flex items-center justify-between">
            <div class="font-bold">리뷰목록</div>
            <div class="flex gap-1">
                <a href="" class="!text-xs button button-light" @click.prevent="alert('준비중인 기능입니다')">엑셀다운</a>
                <a href="{{ route('business.campaign.report', $campaign) }}" class="!text-xs button button-default-outline">결과보고서</a>
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
                        <x-user.avatar :user="$content->user"></x-user.avatar>
                    </td>
                    <td>
                        @foreach($content->user->medias as $media)
                            <x-media-icon :media="$media->media"></x-media-icon>
                        @endforeach
                    </td>
                    <td>{{ $applicant->created_at->format('y.m.d') }}</td>
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
