<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use App\Models\CampaignApplication;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Response;
use App\Models\BannerLog;
use App\Helper\CommonHelper;

class BusinessStatisticsController extends Controller
{
    public function age(Request $request)
    {
        $campaignIds = $request->user()->businessCampaigns()->pluck('id')->toArray();
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

        return response()->json(new Response(Response::SUCCESS, '', $result));
    }

    public function sex(Request $request)
    {
        $campaignIds = $request->user()->businessCampaigns()->pluck('id')->toArray();
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

        return response()->json(new Response(Response::SUCCESS, '', $result));
    }

    public function view(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $filter = [];
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
        return response()->json(new Response(Response::SUCCESS, '', $result));
    }
}
