<?php

namespace App\Http\Controllers\points;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchasePointsRequest;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('points.charge', compact('user'));
    }

    public function purchase(PurchasePointsRequest $request)
    {
        $user = Auth::user();
        $user->balance += $request->validated()['pack_points'];
        $user->save();

        return response()->json(['success' => true, 'balance' => $user->balance]);
    }
}
