<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Board $board)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Board $board)
    {
        $post = new Post();
        if(!auth()->user() || !auth()->user()->can('create', Post::Class)){
            abort(403);
        }
        return view('post.create', compact('board', 'post'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Board $board)
    {
        if(!auth()->user() || !auth()->user()->can('create', Post::class)){
            abort(403);
        }

        $validated = $request->validate([
           'status' => 'required',
           'title' => 'required',
           'content' => 'required',
        ]);

        $validated['board_id'] = $board->id;

        $post = $request->user()->posts()->create($validated);
        return redirect()->route('board.post.show', [$board, $post]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board, Post $post)
    {
        $comments = $post->comments()->paginate(5);
        return view('post.show', compact('board', 'post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Board $board, Post $post)
    {
        return view('post.edit', compact('board', 'post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Board $board, Post $post)
    {
        if(!auth()->user() && !auth()->user()->can('update', $post)){
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required',
            'title' => 'required',
            'content' => 'required',
        ]);

        $validated['board_id'] = $board->id;

        $post->update($validated);
        return redirect()->route('board.post.show', [$board, $post]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Board $board, Post $post)
    {
        if(!auth()->user() && !auth()->user()->can('delete', [Board::class, Post::class])){
            abort(403);
        }
        $post->delete();
        return redirect()->route('board.show', $board);
    }
}
