<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Local;
use App\Http\Requests\StoreLocalRequest;
use Illuminate\Support\Facades\Auth;

class LocalController extends Controller
{
    public function store(StoreLocalRequest $request)
    {
        try {
            $data = array_merge(
                $request->validated(),
                ['creator_id' => Auth::id(), 'status' => 'active']
            );

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('locals', 'public');
            }

            Local::create($data);

            return redirect()->route('tenant.dashboard')->with('success', 'Local created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('tenant.dashboard')->with('error', 'Error creating local: ' . $e->getMessage());
        }
    }
}
