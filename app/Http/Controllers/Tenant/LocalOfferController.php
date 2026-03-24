<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Local;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocalOfferController extends Controller
{
    public function store(Request $request, Local $local)
    {
        abort_if($local->creator_id !== Auth::id(), 403);

        $request->validate([
            'startTime'       => 'required|date',
            'endTime'         => 'required|date|after:startTime',
            'totalPrice'      => 'required|integer|min:1',
            'maxParticipants' => 'required|integer|min:1',
        ]);

        $local->localOffers()->create(array_merge(
            $request->only('startTime', 'endTime', 'totalPrice', 'maxParticipants'),
            ['status' => 'available']
        ));

        return redirect()->route('tenant.dashboard')->with('success', 'Offer created successfully.');
    }
}
