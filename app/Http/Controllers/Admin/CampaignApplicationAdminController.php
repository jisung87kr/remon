<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CampaignApplication;

class CampaignApplicationAdminController extends Controller
{
    public function index()
    {
        $applications = CampaignApplication::orderBy('id', 'desc')->paginate(10);
        return view('admin.application.index', compact('applications'));
    }
}
