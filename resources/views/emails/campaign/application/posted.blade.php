<x-mail::message>
    <div>
        <p>{{ $application->user->name }} 님</p>
        <p>{{ $application->campaign->title }} 캠페인 컨텐츠가 등록되었습니다</p>
    </div>
    <x-mail::button :url="route('campaign.show', $application->campaign)">
        캠페인 바로가기
    </x-mail::button>
</x-mail::message>
