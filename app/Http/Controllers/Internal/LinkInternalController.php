<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Http\Resources\Response;
use App\Models\Link;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LinkInternalController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'original_url' => 'required|url:http,https'
            ]);

            DB::beginTransaction();
            $link = $request->user()->links()->create($validated);
            $link->update(['redirect_url' => $link->redirectUrl]);
            DB::commit();
            return response()->json(new Response(Response::SUCCESS, '', $link));
        } catch (QueryException $e) {
            if($e->getCode() == 23000){
                return response()->json(new Response(Response::ERROR, '이미 등록한 url 입니다.', $e->getMessage()));
            }
            return response()->json(new Response(Response::ERROR, '링크생성 오류', $e->getMessage()));
        } catch (\Exception $e) {
            return response()->json(new Response(Response::ERROR, '링크생성 오류', $e->getMessage()));
        }
    }

    public function update(Request $request, Link $link)
    {
        try {
            $validated = $request->validate([
                'original_url' => 'required|url:http,https'
            ]);

            $link->update($validated);
            return response()->json(new Response(Response::SUCCESS, '', $link));
        } catch (\Exception $e) {
            return response()->json(new Response(Response::ERROR, '링크수정 오류', $e->getMessage()));
        }
    }

    public function destroy(Request $request, Link $link)
    {
        try {
            $link->delete();
            return response()->json(new Response(Response::SUCCESS, ''));
        } catch (\Exception $e) {
            return response()->json(new Response(Response::ERROR, '링크삭제 오류', $e->getMessage()));
        }
    }
}
