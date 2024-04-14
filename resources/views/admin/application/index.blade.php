<x-admin-layout>
    <div>
        <table class="table">
            <thead>
            <tr class="border-y">
                <th>id</th>
                <th>캠페인</th>
                <th>신청자</th>
                <th>상태</th>
                <th>신청일</th>
            </tr>
            </thead>
            <tbody>
            @foreach($applications as $application)
            <tr>
                <td>{{ $application->id }}</td>
                <td>{{ $application->campaign->title }}</td>
                <td>{{ $application->name }}</td>
                <td>
                    <x-badge.application :status="$application->status">{{ \App\Enums\Campaign\ApplicationStatus::tryFrom($application->status)->label() }}</x-badge.application>
                </td>
                <td>{{ $application->created_at->format('m-d') }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @if($applications->links())
            <div class="mt-3">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
