@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('head')
<link href="https://fonts.bunny.net/css?family=antonio:400,500,600,700&family=barlow-condensed:400,500,600,700,800,900&family=barlow:400,500,600" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
@vite(['resources/css/admin-dashboard.css', 'resources/js/admin-dashboard.js'])
@endsection
@section('content')
<div class="dashboard-page">
<div class="beams"><div class="beam"></div><div class="beam"></div><div class="beam"></div><div class="beam"></div><div class="beam"></div></div>
<div class="stripe-bg"></div>
<div class="dashboard-inner">
<div class="dash-header"><div class="hdr-line"></div><div class="hdr-center"><span class="hdr-eyebrow">Smart Organizer</span><div class="hdr-title">Admin <span>Dashboard</span></div></div><div class="hdr-line r"></div></div>
<div class="stats-grid">
<div class="stat-card"><div class="stat-label">Total Users</div><div class="stat-value">{{ $totalUsers }}</div><div class="stat-desc">registered accounts</div></div>
<div class="stat-card"><div class="stat-label">Total Locals</div><div class="stat-value">{{ $totalLocals }}</div><div class="stat-desc">properties listed</div></div>
<div class="stat-card"><div class="stat-label">Banned Users</div><div class="stat-value">{{ $bannedUsers }}</div><div class="stat-desc">blocked accounts</div></div>
<div class="stat-card"><div class="stat-label">Banned Locals</div><div class="stat-value">{{ $bannedLocals }}</div><div class="stat-desc">blocked properties</div></div>
<div class="stat-card"><div class="stat-label">Tenants</div><div class="stat-value">{{ $tenants }}</div><div class="stat-desc">{{ $tenantPercentage }}% of users</div></div>
<div class="stat-card"><div class="stat-label">Lessors</div><div class="stat-value">{{ $lessors }}</div><div class="stat-desc">{{ 100 - $tenantPercentage }}% of users</div></div>
</div>
<div class="card">
<div class="card-header"><h2>User Management</h2></div>
<div class="table-wrapper">
<table class="table">
<thead>
<tr>
<th>User</th>
<th>Email</th>
<th>Role</th>
<th>Balance</th>
<th>Status</th>
<th>Registration</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
@forelse($users as $user)
<tr>
<td>
<div class="user-info">
<div class="user-avatar">{{ substr($user->name, 0, 1) }}</div>
<span class="user-name">{{ $user->name }}</span>
</div>
</td>
<td>{{ $user->email }}</td>
<td>{{ $user->role->name ?? 'N/A' }}</td>
<td style="font-weight:700;color:var(--gold-bright)">{{ $user->balance }} pts</td>
<td>
@if($user->status === 'blocked')
<span class="badge badge-banned">Banned</span>
@else
<span class="badge badge-active">Active</span>
@endif
</td>
<td style="color:var(--muted)">{{ $user->created_at->format('d/m/Y') }}</td>
<td>
@if($user->status === 'blocked')
<button type="button" onclick="unbanUser({{ $user->id }},this)" class="btn-action btn-unban">Unban</button>
@else
<button type="button" onclick="banUser({{$user->id}},this)" class="btn-action btn-ban">Ban</button>
@endif
</td>
</tr>
@empty
<tr><td colspan="7" class="empty-state">No users found</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
<div class="card">
<div class="card-header"><h2>Recent Locals</h2></div>
<div class="table-wrapper">
<table class="table">
<thead>
<tr>
<th>Name</th>
<th>Type</th>
<th>City</th>
<th>Capacity</th>
<th>Status</th>
<th>Created On</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
@forelse($locals as $local)
<tr>
<td style="font-weight:600">{{ $local->name }}</td>
<td>{{ ucfirst($local->type) }}</td>
<td>{{ $local->city }}</td>
<td>{{ $local->capacity }}</td>
<td>
@if($local->status === 'blocked')
<span class="badge badge-banned">Banned</span>
@else
<span class="badge badge-active">Active</span>
@endif
</td>
<td style="color:var(--muted)">{{ $local->created_at->format('d/m/Y') }}</td>
<td>
@if($local->status === 'blocked')
<button type="button" onclick="unbanLocal({{ $local->id }},this)" class="btn-action btn-unban">Unban</button>
@else
<button type="button" onclick="banLocal({{ $local->id }},this)" class="btn-action btn-ban">Ban</button>
@endif
</td>
</tr>
@empty
<tr><td colspan="7" class="empty-state">No locals found</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
</div>
@endsection
