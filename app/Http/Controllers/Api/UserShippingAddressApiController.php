<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Response;
use App\Models\UserShippingAddress;
use App\Services\UserShippingService;
use Illuminate\Http\Request;

class UserShippingAddressApiController extends Controller
{
    private UserShippingService $userShippingService;

    public function __construct(UserShippingService $userShippingService)
    {
        $this->userShippingService = $userShippingService;
    }

    public function index(Request $request)
    {
        try {
            $result = $request->user()->shippingAddresses;
            return response()->json(new Response(Response::SUCCESS, '배송지목록 조회 성공.', $result));
        } catch (\Exception $e) {
            return response()->json(new Response(Response::ERROR, '배송지목록을 조회 실패', $e->getMessage()), 500);
        }
    }

    public function show(Request $request, UserShippingAddress $userShippingAddress)
    {
        if($request->user()->can('show-userShippingAddress', $userShippingAddress)){
            return response()->json(new Response(Response::SUCCESS, '배송지 조회 성공', $userShippingAddress));
        } else {
            return response()->json(new Response(Response::ERROR, '권한이 없습니다.', ''), 503);
        }
    }

    public function store(Request $request)
    {
        try {
            $result = $this->userShippingService->store($request->all());
            return response()->json(new Response(Response::SUCCESS, '배송지를 추가했습니다.', $result));
        } catch (\Exception $e) {
            return response()->json(new Response(Response::ERROR, '배송지를 추가할 수 없습니다.', $e->getMessage()), 500);
        }
    }

    public function update(Request $request, UserShippingAddress $userShippingAddress)
    {
        try {
            $result = $this->userShippingService->update($userShippingAddress, $request->all());
            return response()->json(new Response(Response::SUCCESS, '배송지를 수정했습니다.', $result));
        } catch (\Exception $e) {
            return response()->json(new Response(Response::ERROR, '배송지를 수정할 수 없습니다.', $e->getMessage()), 500);
        }
    }

    public function destroy(Request $request, UserShippingAddress $userShippingAddress)
    {
        try {
            $result = $userShippingAddress->delete();
            return response()->json(new Response(Response::SUCCESS, '배송지를 삭제했습니다..', $result));
        } catch (\Exception $e) {
            return response()->json(new Response(Response::ERROR, '배송지를 삭제할 수 없습니다.', $e->getMessage()), 500);
        }
    }
}
