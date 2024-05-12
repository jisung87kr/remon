<?php
namespace App\Services;

use App\Enums\Campaign\ProgressStatusEnum;
use App\Helper\CommonHelper;
use App\Http\Resources\Response;
use App\Models\BannerLog;
use App\Models\CampaignApplication;
use App\Models\CampaignMediaContent;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticsService{
    public function summary(Request $request)
    {
        $filter      = [
            'campaign_id' => $request->input('campaign_id'),
        ];
        $campaignIds = $request->user()->businessCampaigns()->filter($filter)->pluck('id')->toArray();
        $manCount    = CampaignApplication::whereIn('campaign_id', $campaignIds)->where('sex', 'man')->count();
        $womanCount  = CampaignApplication::whereIn('campaign_id', $campaignIds)->where('sex', 'woman')->count();
        $ageGroup    = CampaignApplication::selectRaw('age_group, COUNT(age_group) as cnt')->whereIn('campaign_id', $campaignIds)->groupBy('age_group')->get();

        $summary = [
            'allCount'       => $request->user()->businessCampaigns()->filter($filter)->count() ?? 0,
            'readyCount'     => $request->user()->businessCampaigns()->filter($filter)->filter(['progress_status' => [ProgressStatusEnum::READY->value]])->count() ?? 0,
            'applyingCount'  => $request->user()->businessCampaigns()->filter($filter)->filter(['progress_status' => [ProgressStatusEnum::Applying->value]])->count() ?? 0,
            'approvingCount' => $request->user()->businessCampaigns()->filter($filter)->filter(['progress_status' => [ProgressStatusEnum::Approving->value]])->count() ?? 0,
            'completedCount' => $request->user()->businessCampaigns()->filter($filter)->filter(['progress_status' => [ProgressStatusEnum::COMPLETED->value]])->count() ?? 0,
            'contentCount'   => CampaignMediaContent::whereIn('campaign_id', $campaignIds)->count('id') ?? 0,
            'viewCount'      => $request->user()->businessCampaigns()->filter($filter)->sum('banner_log_count') ?? 0,
            'mobileCount'    => $request->user()->businessCampaigns()->filter($filter)->sum('banner_log_mobile_count') ?? 0,
            'pcCount'        => $request->user()->businessCampaigns()->filter($filter)->sum('banner_log_pc_count') ?? 0,
            'manCount'       => $manCount,
            'womanCount'     => $womanCount,
            'ageGroup'       => $ageGroup,
        ];

        return $summary;
    }

    public function age(Request $request)
    {
        $filter = [
            'campaign_id' => $request->input('campaign_id'),
        ];
        $campaignIds = $request->user()->businessCampaigns()->filter($filter)->pluck('id')->toArray();
        $ageGroup = CampaignApplication::selectRaw('age_group, COUNT(age_group) as cnt')->whereIn('campaign_id', $campaignIds)->groupBy('age_group')->get();
        $labels =  $ageGroup->pluck('age_group')->toArray();
        $datasets = [
            [
                'label' => '연령',
                'data' => $ageGroup->pluck('cnt')->toArray(),
                'borderColor' => 'red',
                'backgroundColor' => 'red',
            ]
        ];

        $result = [
            'labels' => $labels,
            'datasets' => $datasets,
        ];

        return $result;
    }

    public function sex(Request $request)
    {
        $filter = [
            'campaign_id' => $request->input('campaign_id'),
        ];
        $campaignIds = $request->user()->businessCampaigns()->filter($filter)->pluck('id')->toArray();
        $manCount = CampaignApplication::whereIn('campaign_id', $campaignIds)->where('sex', 'man')->count();
        $womanCount = CampaignApplication::whereIn('campaign_id', $campaignIds)->where('sex', 'woman')->count();
        $labels = ['남성', '여성'];
        $datasets = [
            [
                'data' => [$manCount, $womanCount],
                'borderColor' => ['blue', 'red'],
                'backgroundColor' => ['blue', 'red'],
            ]
        ];

        $result = [
            'labels' => $labels,
            'datasets' => $datasets,
        ];

        return $result;
    }

    public function view(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $filter = [
            'campaign_id' => $request->input('campaign_id'),
        ];
        $campaignIds = $request->user()->businessCampaigns()->filter($filter)->pluck('id')->toArray();

        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $dateRange = [];
        $datasets = [];
        for ($date = $start; $date->lte($end); $date->addDay()) {
            $dateRange[] = $date->toDateString();
        }

        // 총 조회수
        $allData = BannerLog::selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') AS 'ymd', COUNT(*) AS 'cnt'")->whereHas('application', function($query) use ($campaignIds){
            $query->whereIn('campaign_id', $campaignIds);
        })->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') BETWEEN ? AND ?", [$startDate, $endDate])->groupByRaw("DATE_FORMAT(created_at, '%Y-%m-%d')")->get();

        $datasets[] = [
            'label' => '총조회수',
            'data' => CommonHelper::makeViewCountChartData($dateRange, $allData),
            'borderColor' => 'red',
            'backgroundColor' => 'red'
        ];

        // pc 조회수
        $pcData = BannerLog::selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') AS 'ymd', COUNT(*) AS 'cnt'")->whereHas('application', function($query) use ($campaignIds){
            $query->whereIn('campaign_id', $campaignIds);
        })->where('is_mobile', '!=', '1')->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') BETWEEN ? AND ?", [$startDate, $endDate])->groupByRaw("DATE_FORMAT(created_at, '%Y-%m-%d')")->get();

        $datasets[] = [
            'label' => 'pc 조회수',
            'data' => CommonHelper::makeViewCountChartData($dateRange, $pcData),
            'borderColor' => 'blue',
            'backgroundColor' => 'blue'
        ];

        // mobile 조회수
        $mobileData = BannerLog::selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') AS 'ymd', COUNT(*) AS 'cnt'")->whereHas('application', function($query) use ($campaignIds){
            $query->whereIn('campaign_id', $campaignIds);
        })->where('is_mobile', '=', '1')->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') BETWEEN ? AND ?", [$startDate, $endDate])->groupByRaw("DATE_FORMAT(created_at, '%Y-%m-%d')")->get();

        $datasets[] = [
            'label' => 'mobile 조회수',
            'data' => CommonHelper::makeViewCountChartData($dateRange, $mobileData),
            'borderColor' => 'green',
            'backgroundColor' => 'green'
        ];

        $result = [
            'labels' => $dateRange,
            'datasets' => $datasets,
        ];

        return $result;
    }
}
