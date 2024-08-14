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

    <section class="mb-10">
        <h1 class="mt-3 mb-6 text-2xl font-bold">누적성과</h1>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
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
                    <div class="text-gray-700">등록된 컨텐츠</div>
                    <div class="font-bold text-2xl">{{ number_format($summary['contentCount']) }}</div>
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
                    <div class="font-bold text-2xl">{{ number_format($summary['viewCount']) }}</div>
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
                    <div class="font-bold text-2xl">{{ number_format($summary['mobileCount']) }}</div>
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
                    <div class="font-bold text-2xl">{{ number_format($summary['pcCount']) }}</div>
                </div>
            </div>
            <div class="card col-span-2 lg:col-span-4" x-data="viewCountData">
                <div class="flex mb-3 justify-between">
                    <div class="font-bold">조회수 현황</div>
                    <div class="flex gap-3">
                        <input type="date" name="start_date" x-model="startDate" class="form-control">
                        <input type="date" name="end_date" x-model="endDate" class="form-control">
                        <button @click="setChart()" class="button button-gray shrink-0">검색</button>
                    </div>
                </div>
                <canvas id="chart-view-stat"></canvas>
                <script>
                  viewChart = null;
                  const viewCountData = {
                    labels: [],
                    datasets: [],
                    startDate: '{{ date('Y-m-d', strtotime('-30 days')) }}',
                    endDate: '{{ date('Y-m-d') }}',
                    campaign_id: {{ $campaign->id }},
                    async init(){
                      this.setChart();
                    },
                    async setChart(){
                      const response = await this.getViewCount();
                      const ctxView = document.getElementById('chart-view-stat');
                      var labels = response.labels;
                      var datasets = response.datasets;
                      if(viewChart){
                        viewChart.data.labels = labels;
                        viewChart.data.datasets = datasets;
                        viewChart.update();
                      } else {
                        viewChart = initChart(ctxView, 'line',  labels, datasets);
                      }
                    },
                    async getViewCount(){
                      let params = {
                        start_date: this.startDate,
                        end_date: this.endDate,
                        campaign_id: this.campaign_id,
                      }
                      const response = await axios.get('{{ route('business.statistics.campaign.view') }}', {
                        params: params
                      });
                      return response.data.data;
                    }
                  }
                </script>
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
                @foreach($contents as $content)
                    <tr>
                        <td>
                            <x-user.avatar :user="$content->user"></x-user.avatar>
                        </td>
                        <td>
                            <x-media-icon :media="$content->media->media"></x-media-icon>
                        </td>
                        <td>
                            <a href="{{ $content->content_url }}" target="_blank">{{ $content->content_url }}</a>
                        </td>
                        <td>{{ $content->created_at->format('y.m.d') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <section class="mb-10">
        <h1 class="mb-3 text-2xl font-bold">캠페인 분석</h1>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="card" x-data="sexData">
                <div class="font-bold mb-3">성별 신청 현황</div>
                <canvas id="chart-sex-stat"></canvas>
                <script>
                  ctxSex = document.getElementById('chart-sex-stat');
                  const sexData = {
                    labels: [],
                    datasets: [],
                    campaign_id: {{ $campaign->id }},
                    async init(){
                      let response = await this.getData();
                      sexChart = initChart(ctxSex, 'doughnut', response.labels, response.datasets);
                    },
                    async getData(){
                      let params = {
                        campaign_id: this.campaign_id,
                      }
                      const response = await axios.get('{{ route('business.statistics.campaign.sex') }}', {
                        params: params
                      });
                      return response.data.data;
                    }
                  }
                </script>
            </div>
            <div class="card" x-data="ageData">
                <div class="font-bold mb-3">연령별 신청 현황</div>
                <canvas id="chart-age-stat"></canvas>
                <script>
                  ctxAge = document.getElementById('chart-age-stat');
                  const ageData = {
                    labels: [],
                    datasets: [],
                    campaign_id: {{ $campaign->id }},
                    async init(){
                      let response = await this.getData();
                      ctxAge = initChart(ctxAge, 'bar', response.labels, response.datasets);
                    },
                    async getData(){
                      let params = {
                        campaign_id: this.campaign_id,
                      }
                      const response = await axios.get('{{ route('business.statistics.campaign.age') }}', {
                        params: params
                      });
                      return response.data.data;
                    }
                  }
                </script>
            </div>
            <div class="card">
                <div class="font-bold mb-3">[준비중] 유입경로</div>
                <canvas id="chart-referer-stat"></canvas>
            </div>
        </div>
    </section>

    <section>
        <h1 class="mb-3 text-2xl font-bold">키워드</h1>
        <div class="grid grid-cols-2 gap-6">
            <div class="card">
                <div class="font-bold mb-3">[준비중] 키워드 노출현황(상세)</div>
            </div>
            <div class="card">
                <div class="font-bold mb-3">[준비중] 유입 키워드 TOP 20</div>
            </div>
            <div class="card col-span-2">
                <div class="font-bold mb-3">[준비중] 키워드 노출현황</div>
            </div>
        </div>
    </section>

</x-business-layout>
