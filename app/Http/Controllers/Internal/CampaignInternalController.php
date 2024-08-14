<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Http\Resources\Response;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignInternalController extends Controller
{
    public function destroy(Campaign $campaign)
    {
        try {
            $campaign->delete();
            return response()->json(new Response(Response::SUCCESS, '캠페인 삭제 성공'));
        } catch (\Exception $e) {
            return response()->json(new Response(Response::ERROR, '컴페인 삭제 시랲', $e->getMessage()), 500);
        }
    }
}
