<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Response;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentApiController extends Controller
{
    private function getCommentable($type, $id)
    {
        switch ($type) {
            case 'post':
                return Post::find($id);
            default:
                return null;
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index($commentableType, $commentableId)
    {
        $commentable = $this->getCommentable($commentableType, $commentableId);
        $comments = $commentable->comments()->whereNull('parent_id')->paginate(10);
        $paginationLinks = $comments->links()->toHtml();

        return response()->json(new Response(Response::SUCCESS, '코멘트 조회 성공', $comments));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $commentableType, $commentableId)
    {
        $commentable = $this->getCommentable($commentableType, $commentableId);
        $validated = $request->validate([
            'content' => 'required',
            'parent_id' => 'nullable',
        ]);
        $validated['user_id'] = $request->user()->id;
        $comment = $commentable->comments()->create($validated);
        return response()->json(new Response(Response::SUCCESS, '코멘트 등록 성공', $comment));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'content' => 'required',
            'parent_id' => 'nullable',
        ]);
        $comment->update($validated);
        return response()->json(new Response(Response::SUCCESS, '코멘트 수정 성공', $comment));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Comment $comment)
    {
        $result = $comment->delete();
        return response()->json(new Response(Response::SUCCESS, '코멘트 삭제 성공', $result));
    }
}
