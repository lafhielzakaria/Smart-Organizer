<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Local;
use App\Models\LocalOffer;
use App\Http\Requests\StoreLocalOfferRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocalOfferController extends Controller
{
    public function completeOffer($id)
    {
        return DB::transaction(function () use ($id) {
            $offer = LocalOffer::with(['participations.user', 'local.creator'])->findOrFail($id);

            if ($offer->status === 'completed') {
                return response()->json(['message' => 'Offer already completed'], 200);
            }

            $offer->update(['status' => 'completed']);

            foreach ($offer->participations as $participation) {
                $price = $offer->sharePrice;
                if ($participation->user->isMember) {
                    $price = $price / 2;
                }
                $participation->user->decrement('balance', $price);
            }

            if ($offer->local && $offer->local->creator) {
                $offer->local->creator->increment('balance', $offer->totalPrice);
            }

            return response()->json([
                'success' => true,
                'message' => 'Offer completed and balances updated.'
            ]);
        });
    }
    public function store(StoreLocalOfferRequest $request, Local $local)
    {
        abort_if($local->creator_id !== Auth::id(), 403);
        
        $local->localOffers()->create(array_merge(
            $request->validated(),
            ['status' => 'available']
        ));
        return redirect()->route('tenant.dashboard')->with('success', 'Offer created successfully.');
    }
}
