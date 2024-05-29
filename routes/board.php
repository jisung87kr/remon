<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::post('upload', function(Request $request){
    if ($request->hasFile('upload')) {
        $file = $request->file('upload');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $path = "board/".date('Y').'/'.date('m').'/'.date('d');
        $uploadedPath = $file->store($path, 'public');
        $url = Storage::url($uploadedPath);

        return response()->json([
            'uploaded' => true,
            'url' => $url,
        ]);
    }

    return response()->json(['error' => 'No file uploaded'], 400);
})->name('upload');

//Route::resource('/', BoardController::class)->parameters(['board' => 'board:slug']);
Route::get('{board:slug}', [BoardController::class, 'show'])->name('show');

Route::middleware('auth')->group(function () {
    Route::get('{board:slug}/posts/create', [PostController::class, 'create'])->name('post.create');
    Route::get('{board:slug}/posts/edit', [PostController::class, 'create'])->name('post.edit');
});
Route::resource('/{board:slug}/posts', PostController::class)->names('post')->except(['create', 'edit']);
