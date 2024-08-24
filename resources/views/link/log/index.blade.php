<x-mypage-layout>
    <x-slot name="header">링크 로그</x-slot>
    <div>
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                <tr>
                    <th>레퍼러</th>
                    <th>아이피</th>
                    <th>유저에이전트</th>
                    <th>클릭일</th>
                </tr>
                </thead>
                <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->referer ?? '-' }}</td>
                        <td>{{ $log->ip }}</td>
                        <td>{{ $log->user_agent }}</td>
                        <td>{{ $log->created_at }}</td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <td colspan="5">로그가 존재하지 않습니다.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('link.index') }}" class="button bg-gray-100 border">목록</a>
        </div>

        @if($logs->links())
            <div class="mt-3">{{$logs->links()}}</div>
        @endif
    </div>
</x-mypage-layout>
