<?php

namespace App\Http\Controllers;

use App\Helper\CommonHelper;
use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $links = $request->user()->links()->latest()->paginate(20);
        return view('link.index', compact('links'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Link $link)
    {
        return view('link.show', compact('link'));
    }
}
