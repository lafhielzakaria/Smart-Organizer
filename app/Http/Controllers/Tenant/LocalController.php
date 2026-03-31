<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Local;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocalController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'type'     => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
            'city'     => 'required|string|max:100',
            'andreas'  => 'required|string|max:255',
            'price'    => 'required|integer|min:1',
        ]);

        Local::create(array_merge(
            $request->only('name', 'type', 'capacity', 'city', 'andreas', 'price'),
            ['creator_id' => Auth::id(), 'status' => 'active']
        ));

        return redirect()->route('tenant.dashboard')->with('success', 'Local created successfully.');
    }
}
