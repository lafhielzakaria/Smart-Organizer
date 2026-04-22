<?php

namespace App\Http\Controllers\points;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PointController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        return view('points.charge', compact('user'));
    }

    public function purchase(Request $request)
    {
        $user = Auth::user();
        $user->balance += $request->pack_points;
        $user->save();

        return response()->json(['success' => true, 'balance' => $user->balance]);
    }
}
