<x-business-layout>
    <div class="card flex">
        <div class="shrink-0 w-[200px]">
            <img src="{{ Storage::url($campaign->thumbnails[0]['file_path']) }}" alt="" class="rounded-lg">
        </div>
        <div class="mx-6 w-full">
            <div class="mb-3">
                <div class="mb-2">상태</div>
                <div class="mb-2">sns</div>
                <div class="text-2xl mb-1 font-bold">제목</div>
                <div>benefit</div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div class="flex items-center">
                    <div class="mr-1 font-bold shrink-0 w-[120px]">캼페인 신청기간</div>
                    <div class="text-gray-800">24-04-01 ~ 24-04-06</div>
                </div>
                <div class="flex items-center">
                    <div class="mr-1 font-bold shrink-0 w-[120px]">캼페인 신청기간</div>
                    <div class="text-gray-800">24-04-01 ~ 24-04-06</div>
                </div>
                <div class="flex items-center">
                    <div class="mr-1 font-bold shrink-0 w-[120px]">캼페인 신청기간</div>
                    <div class="text-gray-800">24-04-01 ~ 24-04-06</div>
                </div>
                <div class="flex items-center">
                    <div class="mr-1 font-bold shrink-0 w-[120px]">캼페인 신청기간</div>
                    <div class="text-gray-800">24-04-01 ~ 24-04-06</div>
                </div>
            </div>
        </div>
        <div class="shrink-0 w-[200px]">
            <a href="" class="block text-center mb-3 button button-light">캠페인 상세보기</a>
            <a href="" class="block text-center button button-default-outline">문의하기</a>
        </div>
    </div>

    <div class="card mt-6">
        <div class="mb-3 flex items-center justify-between">
            <div class="font-bold">리뷰목록</div>
            <div class="flex gap-1">
                <a href="" class="!text-xs button button-light">엑셀다운</a>
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
                <tr>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
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
                <tr>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-business-layout>
