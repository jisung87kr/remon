<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AdminRoleEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\RoleEnum;

class GeneralUserAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filter = ['role' => RoleEnum::GENERAL_USER->value];
        $users = User::filter($filter)->paginate(10);
        return view('admin.user.general.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = new User;
        return view('admin.user.general.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = '';
        return redirect()->route('admin.user.general.show', $user);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user)
    {
        return view('admin.user.general.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $user)
    {
        return view('admin.user.general.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        return redirect()->route('admin.user.general.show', $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.general.user.index');
    }
}
