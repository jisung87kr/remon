<x-business-layout>
    <section class="mb-10">
        <h1 class="mb-3 text-2xl font-bold">대시보드</h1>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="card flex items-center">
                <div class="bg-red-50 rounded-full mr-6" style="width: 80px; height: 80px;"></div>
                <div>
                    <div class="text-gray-700">전체 캠페인</div>
                    <div class="font-bold text-2xl">{{ number_format(10000) }}</div>
                </div>
            </div>
            <div class="card flex items-center">
                <div class="bg-red-50 rounded-full mr-6" style="width: 80px; height: 80px;"></div>
                <div>
                    <div class="text-gray-700">선정 대기 캠페인</div>
                    <div class="font-bold text-2xl">{{ number_format(10000) }}</div>
                </div>
            </div>
            <div class="card flex items-center">
                <div class="bg-red-50 rounded-full mr-6" style="width: 80px; height: 80px;"></div>
                <div>
                    <div class="text-gray-700">모집 중 캠페인</div>
                    <div class="font-bold text-2xl">{{ number_format(10000) }}</div>
                </div>
            </div>
            <div class="card flex items-center">
                <div class="bg-red-50 rounded-full mr-6" style="width: 80px; height: 80px;"></div>
                <div>
                    <div class="text-gray-700">완료 캠페인</div>
                    <div class="font-bold text-2xl">{{ number_format(10000) }}</div>
                </div>
            </div>
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
                    <div class="text-gray-700">총 조회수</div>
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
