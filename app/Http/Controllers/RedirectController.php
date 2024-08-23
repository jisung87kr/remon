<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function redirect(Request $request, Link $link)
    {
        $link->logs()->create([
            'ip' => $request->ip(),
            'referer' => $request->header('referer'),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect($link->original_url);
    }
}
