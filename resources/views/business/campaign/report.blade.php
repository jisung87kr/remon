<x-business-layout>
    <div class="card flex mb-10">
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

    <section class="mb-10">
        <h1 class="mb-3 text-2xl font-bold">누적성과</h1>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="card flex items-center">
                <div class="bg-red-50 rounded-full mr-6" style="width: 80px; height: 80px;"></div>
                <div>
                    <div class="text-gray-700">등록된 리뷰</div>
                    <div class="font-bold text-2xl">{{ number_format(10000) }}</div>
                </div>
            </div>
            <div class="card flex items-center">
                <div class="bg-red-50 rounded-full mr-6" style="width: 80px; height: 80px;"></div>
                <div>
                    <div class="text-gray-700">총조회수</div>
                    <div class="font-bold text-2xl">{{ number_format(10000) }}</div>
                </div>
            </div>
            <div class="card flex items-center">
                <div class="bg-red-50 rounded-full mr-6" style="width: 80px; height: 80px;"></div>
                <div>
                    <div class="text-gray-700">모바일 조회수</div>
                    <div class="font-bold text-2xl">{{ number_format(10000) }}</div>
                </div>
            </div>
            <div class="card flex items-center">
                <div class="bg-red-50 rounded-full mr-6" style="width: 80px; height: 80px;"></div>
                <div>
                    <div class="text-gray-700">PC 조회수</div>
                    <div class="font-bold text-2xl">{{ number_format(10000) }}</div>
                </div>
            </div>
            <div class="card col-span-2 lg:col-span-4">
                <div class="font-bold mb-3">조회수 현황</div>
            </div>
        </div>
    </section>

    <div class="card mb-10">
        <div class="mb-3">
            <div class="font-bold">리뷰목록</div>
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

    <section class="mb-10">
        <h1 class="mb-3 text-2xl font-bold">캠페인 분석</h1>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="card">
                <div class="font-bold mb-3">성별 신청 현황</div>
            </div>
            <div class="card">
                <div class="font-bold mb-3">연령별 신청 현황</div>
            </div>
            <div class="card">
                <div class="font-bold mb-3">유입경로</div>
            </div>
        </div>
    </section>

    <section>
        <h1 class="mb-3 text-2xl font-bold">키워드</h1>
        <div class="grid grid-cols-2 gap-6">
            <div class="card">
                <div class="font-bold mb-3">키워드 노출현황(상세)</div>
            </div>
            <div class="card">
                <div class="font-bold mb-3">유입 키워드 TOP 20</div>
            </div>
            <div class="card col-span-2">
                <div class="font-bold mb-3">키워드 노출현황</div>
            </div>
        </div>
    </section>

</x-business-layout>
