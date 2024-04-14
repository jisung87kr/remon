<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Response;
use App\Models\User;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function destroy(Request $request, User $user)
    {

        try {
//            if(! $request->user()->can('delete', $user)){
//                return response()->json(new Response(Response::ERROR, '권한이 없습니다.', ''), 401);
//            }
            $result = $user->delete();
            return response()->json(new Response(Response::SUCCESS, '회원 삭제 성공', $result));
        } catch (\Exception $e){
            return response()->json(new Response(Response::ERROR, '회원 삭제 실패', $e->getMessage()), 500);
        }
    }
}
