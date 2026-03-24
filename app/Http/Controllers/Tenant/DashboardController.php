<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Friendship;
use App\Models\Local;
use App\Models\LocalOffer;
use App\Models\Participation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $myLocals = Local::where('creator_id', $user->id)
            ->withCount('localOffers')
            ->with(['localOffers' => function ($q) {
                $q->withCount('participations')->latest()->take(3);
            }])
            ->latest()
            ->get();

        $localsWithViews = Local::where('creator_id', $user->id)
            ->with(['localOffers' => fn($q) => $q->withMax('viewsAnalytics', 'viewTime')])
            ->get()
            ->map(fn($l) => [
                'name'            => $l->name,
                'total_view_time' => $l->localOffers->sum('views_analytics_max_viewTime') ?? 0,
            ])
            ->sortByDesc('total_view_time')
            ->values();

        $topLocals  = $localsWithViews->take(5);
        $allLocals  = $localsWithViews;

        $totalOffers = LocalOffer::whereHas('local', fn($q) => $q->where('creator_id', $user->id))->count();

        $activeOffers = LocalOffer::whereHas('local', fn($q) => $q->where('creator_id', $user->id))
            ->where('status', 'available')
            ->count();

        $totalParticipants = Participation::whereHas('localOffer.local', fn($q) => $q->where('creator_id', $user->id))->count();

        return view('tenant.dashboard', compact(
            'user',
            'myLocals',
            'topLocals',
            'allLocals',
            'totalOffers',
            'activeOffers',
            'totalParticipants'
        ));
    }
}
