<?php

namespace App\Http\Controllers\Api;

use App\Enums\Campaign\MediaEnum;
use App\Enums\MediaConnectedStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Response;
use App\Models\UserMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UserMediaApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            return response()->json(new Response(Response::SUCCESS, '미디어 목록 조회 성공', $request->user()->medias));
        } catch (\Exception $e){
            return response()->json(new Response(Response::ERROR, '미디어 목록 조회 실패', $e->getMessage()), 500);
        }
    }

    public function show(Request $request, UserMedia $userMedia)
    {
        try {
            if(! $request->user()->can('view', $userMedia)){
                return response()->json(new Response(Response::ERROR, '권한이 없습니다.', ''), 401);
            }

            return response()->json(new Response(Response::SUCCESS, '미디어 조회 성공', $userMedia));
        } catch (\Exception $e){
            return response()->json(new Response(Response::ERROR, '미디어 조회 실패', $e->getMessage()), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'media' => ['required', Rule::enum(MediaEnum::class)],
                'url' => ['required', 'url'],
                'connected_status' => ['required', Rule::enum(MediaConnectedStatusEnum::class)],
            ]);

            $result = $request->user()->medias()->create($validated);
            return response()->json(new Response(Response::SUCCESS, '미디어 목록 등록 성공', $result));
        } catch (\Exception $e){
            return response()->json(new Response(Response::ERROR, '미디어 목록 등록 실패', $e->getMessage()), 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserMedia $userMedia)
    {
        try {
            if(! $request->user()->can('update', $userMedia)){
                return response()->json(new Response(Response::ERROR, '권한이 없습니다.', ''), 401);
            }

            $validated = $request->validate([
                'url' => ['required', 'url'],
            ]);

            $userMedia->update($validated);
            return response()->json(new Response(Response::SUCCESS, '미디어 목록 수정 성공', $userMedia));
        } catch (\Exception $e){
            return response()->json(new Response(Response::ERROR, '미디어 목록 수정 실패', $e->getMessage()), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, UserMedia $userMedia)
    {
        try {
            if(! $request->user()->can('delete', $userMedia)){
                return response()->json(new Response(Response::ERROR, '권한이 없습니다.', ''), 401);
            }

            $result = $userMedia->delete();
            return response()->json(new Response(Response::SUCCESS, '미디어 삭제 성공', $result));
        } catch (\Exception $e){
            return response()->json(new Response(Response::ERROR, '미디어 삭제 실패', $e->getMessage()), 500);
        }
    }
}
