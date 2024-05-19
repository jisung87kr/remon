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
        return view('post.create', compact('board', 'post'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Board $board, Post $post)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Board $board, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board, Post $post)
    {
        //
    }
}
