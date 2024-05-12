<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use App\Models\CampaignApplication;
use App\Services\StatisticsService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Response;
use App\Models\BannerLog;
use App\Helper\CommonHelper;

class BusinessStatisticsController extends Controller
{
    public $service;
    public function __construct(StatisticsService $service)
    {
        $this->service = $service;
    }

    public function age(Request $request)
    {
        $result = $this->service->age($request);
        return response()->json(new Response(Response::SUCCESS, '', $result));
    }

    public function sex(Request $request)
    {
        $result = $this->service->sex($request);
        return response()->json(new Response(Response::SUCCESS, '', $result));
    }

    public function view(Request $request)
    {
        $result = $this->service->view($request);
        return response()->json(new Response(Response::SUCCESS, '', $result));
    }
}
