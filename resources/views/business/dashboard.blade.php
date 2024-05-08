<x-business-layout>
    <section class="mb-10">
        <h1 class="mb-3 text-2xl font-bold">대시보드</h1>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="card flex items-center">
                <div class="bg-blue-600 rounded-full mr-6 relative" style="width: 80px; height: 80px;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-database absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 12.75m-4 0a4 1.75 0 1 0 8 0a4 1.75 0 1 0 -8 0" />
                        <path d="M8 12.5v3.75c0 .966 1.79 1.75 4 1.75s4 -.784 4 -1.75v-3.75" />
                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    </svg>
                </div>
                <div>
                    <div class="text-gray-700">전체 캠페인</div>
                    <div class="font-bold text-2xl">{{ number_format(10000) }}</div>
                </div>
            </div>
            <div class="card flex items-center">
                <div class="bg-yellow-400 rounded-full mr-6 relative" style="width: 80px; height: 80px;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-dots absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                        <path d="M9 14v.01" />
                        <path d="M12 14v.01" />
                        <path d="M15 14v.01" />
                    </svg>
                </div>
                <div>
                    <div class="text-gray-700">선정 대기 캠페인</div>
                    <div class="font-bold text-2xl">{{ number_format(10000) }}</div>
                </div>
            </div>
            <div class="card flex items-center">
                <div class="bg-sky-400 rounded-full mr-6 relative" style="width: 80px; height: 80px;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-report absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M17 17m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path d="M17 13v4h4" />
                        <path d="M12 3v4a1 1 0 0 0 1 1h4" />
                        <path d="M11.5 21h-6.5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v2m0 3v4" />
                    </svg>
                </div>
                <div>
                    <div class="text-gray-700">모집 중 캠페인</div>
                    <div class="font-bold text-2xl">{{ number_format(10000) }}</div>
                </div>
            </div>
            <div class="card flex items-center">
                <div class="bg-indigo-400 rounded-full mr-6 relative" style="width: 80px; height: 80px;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-analytics  absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                        <path d="M9 17l0 -5" />
                        <path d="M12 17l0 -1" />
                        <path d="M15 17l0 -3" />
                    </svg>
                </div>
                <div>
                    <div class="text-gray-700">완료 캠페인</div>
                    <div class="font-bold text-2xl">{{ number_format(10000) }}</div>
                </div>
            </div>
            <div class="card flex items-center">
                <div class="bg-cyan-300 rounded-full mr-6 relative" style="width: 80px; height: 80px;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-pencil  absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                        <path d="M10 18l5 -5a1.414 1.414 0 0 0 -2 -2l-5 5v2h2z" />
                    </svg>
                </div>
                <div>
                    <div class="text-gray-700">등록된 리뷰</div>
                    <div class="font-bold text-2xl">{{ number_format(10000) }}</div>
                </div>
            </div>
            <div class="card flex items-center">
                <div class="bg-green-400 rounded-full mr-6 relative" style="width: 80px; height: 80px;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                    </svg>
                </div>
                <div>
                    <div class="text-gray-700">총 조회수</div>
                    <div class="font-bold text-2xl">{{ number_format(10000) }}</div>
                </div>
            </div>
            <div class="card flex items-center">
                <div class="bg-violet-400 rounded-full mr-6 relative" style="width: 80px; height: 80px;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-mobile absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14z" />
                        <path d="M11 4h2" />
                        <path d="M12 17v.01" />
                    </svg>
                </div>
                <div>
                    <div class="text-gray-700">모바일 조회수</div>
                    <div class="font-bold text-2xl">{{ number_format(10000) }}</div>
                </div>
            </div>
            <div class="card flex items-center">
                <div class="bg-purple-400 rounded-full mr-6 relative" style="width: 80px; height: 80px;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-imac absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M3 4a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v12a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-12z" />
                        <path d="M3 13h18" />
                        <path d="M8 21h8" />
                        <path d="M10 17l-.5 4" />
                        <path d="M14 17l.5 4" />
                    </svg>
                </div>
                <div>
                    <div class="text-gray-700">PC 조회수</div>
                    <div class="font-bold text-2xl">{{ number_format(10000) }}</div>
                </div>
            </div>
            <div class="card col-span-2 lg:col-span-4">
                <div class="font-bold mb-3">조회수 현황</div>
                <canvas id="chart-view-stat"></canvas>
            </div>
        </div>
    </section>
    <section class="mb-10">
        <h1 class="mb-3 text-2xl font-bold">캠페인 분석</h1>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="card">
                <div class="font-bold mb-3">성별 신청 현황</div>
                <canvas id="chart-sex-stat"></canvas>
            </div>
            <div class="card">
                <div class="font-bold mb-3">연령별 신청 현황</div>
                <canvas id="chart-age-stat"></canvas>
            </div>
            <div class="card">
                <div class="font-bold mb-3">유입경로</div>
                <canvas id="chart-referer-stat"></canvas>
            </div>
        </div>
    </section>
    <section>
        <h1 class="mb-3 text-2xl font-bold">키워드</h1>
        <div class="grid grid-cols-2 gap-6">
            <div class="card">
                <div class="font-bold mb-3">키워드 노출현황(상세)</div>
                <div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>구분</th>
                            <th>키워드</th>
                            <th>노출</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="font-bold mb-3">유입 키워드 TOP 20</div>
                <div>#123 #123 #123</div>
            </div>
            <div class="card col-span-2">
                <div class="font-bold mb-3">키워드 노출현황</div>
                <canvas id="chart-keyword-stat"></canvas>
            </div>
        </div>
    </section>
    @push('script')
        <script type="text/javascript">
            window.addEventListener('load', () => {
              const ctxView = document.getElementById('chart-view-stat');
              var labels = ['24-01', '24-02', '24-03', '24-04', '24-05', '24-06', '24-07'];
              var datasets = [
                {
                  label: '총 조회수',
                  data: [3, 4, 5, 6, 7, 8, 9],
                  borderColor: 'red',
                  backgroundColor: 'red',
                },
                {
                  label: 'PC 조회수',
                  data: [2, 3, 4, 5, 6, 7, 8],
                  borderColor: 'blue',
                  backgroundColor: 'blue',
                },
                {
                  label: '모바일 조회수',
                  data: [1, 2, 3, 4, 5, 6, 7],
                  borderColor: 'blue',
                  backgroundColor: 'blue',
                }
              ];

              var viewCart = initChart(ctxView, 'line',  labels, datasets);


              const ctxSex = document.getElementById('chart-sex-stat');
              var labels = ['남성', '여성'];
              var datasets = [
                {
                  data: [40, 60],
                  backgroundColor: ['blue', 'red'],
                  hoverOffset: 4
                },
              ]

              var SexChart = initChart(ctxSex, 'doughnut', labels, datasets);


              const ctxAge = document.getElementById('chart-age-stat');
              var labels = ['20대', '30대', '40대', '기타'];
              var datasets = [
                {
                  label: '연령',
                  data: [1, 2, 3, 4],
                  borderColor: 'red',
                  backgroundColor: 'red',
                },
              ]

              var ageChart = initChart(ctxAge, 'bar', labels, datasets);

              const ctxReferer = document.getElementById('chart-referer-stat');
              var labels = ['네이버검색', '네이버플레이스', '다음카카오', '기타'];
              var datasets = [
                {
                  label: '유입경로',
                  data: [1, 2, 3, 4],
                  borderColor: 'red',
                  backgroundColor: 'red',
                },
              ]

              var refererChart = initChart(ctxReferer, 'bar', labels, datasets);

              const ctxKeyword = document.getElementById('chart-keyword-stat');
              var labels = [1, 2, 3, 4, 5, 6, 7];
              var datasets = [
                {
                  label: '키워드노출',
                  data: [1, 2, 3, 4, 5, 6, 7],
                  borderColor: 'red',
                  backgroundColor: 'red',
                },
              ];

              var keywordChart = initChart(ctxKeyword, 'line', labels, datasets);
            });
        </script>
    @endpush
</x-business-layout>
