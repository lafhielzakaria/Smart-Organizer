<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Local;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $bannedUsers = User::where('status', 'blocked')->count();
        $activeUsers = $totalUsers - $bannedUsers;

        $totalLocals = Local::count();
        $bannedLocals = Local::where('status', 'blocked')->count();
        $activeLocals = $totalLocals - $bannedLocals;

        $tenants = User::where('role_id', 2)->count();
        $lessors = User::where('role_id', 3)->count();
        $tenantPercentage = $totalUsers > 0 ? round(($tenants / $totalUsers) * 100, 1) : 0;
        $lessorPercentage = $totalUsers > 0 ? round(($lessors / $totalUsers) * 100, 1) : 0;

        $users = User::with('role')->latest()->limit(10)->get();
        $locals = Local::latest()->limit(10)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'bannedUsers',
            'activeUsers',
            'totalLocals',
            'bannedLocals',
            'activeLocals',
            'tenants',
            'lessors',
            'tenantPercentage',
            'lessorPercentage',
            'users',
            'locals'
        ));
    }

    public function banUser(User $user)
    {
        $user->update(['status' => 'blocked']);
        return response()->json(['success' => true]);
    }

    public function unbanUser(User $user)
    {
        $user->update(['status' => 'active']);
        return response()->json(['success' => true]);
    }

    public function banLocal(Local $local)
    {
        $local->update(['status' => 'blocked']);
        return response()->json(['success' => true]);
    }

    public function unbanLocal(Local $local)
    {
        $local->update(['status' => 'active']);
        return response()->json(['success' => true]);
    }
}
