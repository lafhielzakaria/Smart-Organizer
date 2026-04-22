@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('head')
<link href="https://fonts.bunny.net/css?family=antonio:400,500,600,700&family=barlow-condensed:400,500,600,700,800,900&family=barlow:400,500,600" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<style>
:root{--gold:#C9A84C;--gold-bright:#F0C040;--gold-dim:rgba(201,168,76,0.12);--gold-line:rgba(201,168,76,0.35);--black:#060608;--dark:#0D0D10;--panel:#12121A;--panel2:#1A1A26;--white:#FFFFFF;--muted:rgba(255,255,255,0.38);--red:#FF4444}*{box-sizing:border-box;margin:0;padding:0}body{background:var(--black)}.dashboard-page{min-height:calc(100vh - 65px);background:var(--black);font-family:'Barlow Condensed',sans-serif;position:relative;overflow:hidden}.beams{position:fixed;top:-10%;left:50%;transform:translateX(-50%);width:120%;height:80vh;pointer-events:none;z-index:0}.beam{position:absolute;top:0;transform-origin:top center;opacity:0;animation:beamSweep 8s infinite ease-in-out}.beam::after{content:'';position:absolute;top:0;left:50%;transform:translateX(-50%);width:200px;height:70vh;background:linear-gradient(180deg,rgba(201,168,76,0.18) 0%,transparent 75%);clip-path:polygon(50% 0%,100% 100%,0% 100%)}.beam:nth-child(1){left:18%;animation-delay:0s;animation-duration:7s}.beam:nth-child(2){left:33%;animation-delay:1.5s;animation-duration:9s}.beam:nth-child(3){left:50%;animation-delay:0.8s;animation-duration:8s}.beam:nth-child(4){left:67%;animation-delay:2.2s;animation-duration:7.5s}.beam:nth-child(5){left:82%;animation-delay:0.4s;animation-duration:10s}@keyframes beamSweep{0%{opacity:0;transform:rotate(-18deg)}20%{opacity:1}50%{opacity:0.55;transform:rotate(18deg)}80%{opacity:1}100%{opacity:0;transform:rotate(-18deg)}}.stripe-bg{position:fixed;inset:0;background-image:repeating-linear-gradient(-55deg,transparent,transparent 40px,rgba(201,168,76,0.018) 40px,rgba(201,168,76,0.018) 41px);pointer-events:none;z-index:0}.dashboard-inner{position:relative;z-index:2;max-width:1400px;margin:0 auto;padding:52px 28px 100px}.dash-header{display:grid;grid-template-columns:1fr auto 1fr;align-items:center;margin-bottom:40px;animation:revealUp 0.7s ease both}.hdr-line{height:1px;background:linear-gradient(90deg,transparent,var(--gold-line))}.hdr-line.r{background:linear-gradient(90deg,var(--gold-line),transparent)}.hdr-center{text-align:center;padding:0 36px}.hdr-eyebrow{display:block;font-size:10px;font-weight:700;letter-spacing:5px;text-transform:uppercase;color:var(--gold);margin-bottom:8px}.hdr-title{font-family:'Antonio',sans-serif;font-size:clamp(28px,5vw,48px);font-weight:700;color:var(--white);text-transform:uppercase;letter-spacing:-1px;line-height:1}.hdr-title span{color:var(--gold-bright)}.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:20px;margin-bottom:32px;animation:revealUp 0.6s 0.2s ease both}.stat-card{background:var(--panel);border:1px solid rgba(255,255,255,0.07);border-radius:3px;padding:24px;transition:all 0.3s}.stat-card:hover{border-color:var(--gold-line);transform:translateY(-4px)}.stat-label{font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--muted);margin-bottom:12px}.stat-value{font-family:'Antonio',sans-serif;font-size:42px;font-weight:700;color:var(--white);line-height:1;margin-bottom:8px}.stat-desc{font-size:11px;color:var(--muted)}.card{background:var(--panel);border:1px solid rgba(255,255,255,0.07);border-radius:3px;overflow:hidden;animation:revealUp 0.6s 0.3s ease both;transition:border-color 0.3s;margin-bottom:20px}.card:hover{border-color:var(--gold-line)}.card-header{padding:18px 20px;border-bottom:1px solid rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:space-between}.card-header h2{font-family:'Antonio',sans-serif;font-size:13px;font-weight:600;letter-spacing:3px;text-transform:uppercase;color:var(--white);margin:0}.table-wrapper{overflow-x:auto}.table{width:100%;border-collapse:collapse}.table thead{background:rgba(255,255,255,0.02)}.table th{padding:14px 20px;text-align:left;font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--muted);border-bottom:1px solid rgba(255,255,255,0.05)}.table td{padding:16px 20px;font-size:13px;color:var(--white);border-bottom:1px solid rgba(255,255,255,0.03)}.table tbody tr{transition:all 0.2s}.table tbody tr:hover{background:var(--gold-dim)}.user-avatar{width:40px;height:40px;background:var(--gold);border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Antonio',sans-serif;font-size:16px;font-weight:700;color:#000}.user-info{display:flex;align-items:center;gap:12px}.user-name{font-weight:600;color:var(--white)}.badge{padding:4px 10px;font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;border-radius:2px;display:inline-block}.badge-active{background:var(--gold);color:#000}.badge-banned{background:rgba(255,255,255,0.1);color:var(--muted)}.btn-action{padding:8px 14px;font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;border:none;border-radius:2px;cursor:pointer;transition:all 0.2s}.btn-ban{background:rgba(255,255,255,0.1);color:var(--muted)}.btn-ban:hover{background:rgba(255,255,255,0.15)}.btn-unban{background:var(--gold);color:#000}.btn-unban:hover{background:var(--gold-bright)}.empty-state{padding:60px 20px;text-align:center;color:var(--muted);font-size:14px}@keyframes revealUp{from{opacity:0;transform:translateY(22px)}to{opacity:1;transform:translateY(0)}}@media (max-width:900px){.stats-grid{grid-template-columns:1fr}.dash-header{grid-template-columns:1fr}.hdr-line{display:none}}
</style>
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
<button type="button" onclick="banUser({{ $user->id }},this)" class="btn-action btn-ban">Ban</button>
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
<script>
function banUser(userId,btn){$.ajax({url:`/admin/users/${userId}/ban`,type:'POST',data:{_token:'{{ csrf_token() }}'},success:function(){const row=$(btn).closest('tr');row.find('.badge').removeClass('badge-active').addClass('badge-banned').text('Banned');$(btn).removeClass('btn-ban').addClass('btn-unban').text('Unban').attr('onclick',`unbanUser(${userId},this)`)},error:function(){alert('Error banning user')}})}function unbanUser(userId,btn){$.ajax({url:`/admin/users/${userId}/unban`,type:'POST',data:{_token:'{{ csrf_token() }}'},success:function(){const row=$(btn).closest('tr');row.find('.badge').removeClass('badge-banned').addClass('badge-active').text('Active');$(btn).removeClass('btn-unban').addClass('btn-ban').text('Ban').attr('onclick',`banUser(${userId},this)`)},error:function(){alert('Error unbanning user')}})}function banLocal(localId,btn){$.ajax({url:`/admin/locals/${localId}/ban`,type:'POST',data:{_token:'{{ csrf_token() }}'},success:function(){const row=$(btn).closest('tr');row.find('.badge').removeClass('badge-active').addClass('badge-banned').text('Banned');$(btn).removeClass('btn-ban').addClass('btn-unban').text('Unban').attr('onclick',`unbanLocal(${localId},this)`)},error:function(){alert('Error banning local')}})}function unbanLocal(localId,btn){$.ajax({url:`/admin/locals/${localId}/unban`,type:'POST',data:{_token:'{{ csrf_token() }}'},success:function(){const row=$(btn).closest('tr');row.find('.badge').removeClass('badge-banned').addClass('badge-active').text('Active');$(btn).removeClass('btn-unban').addClass('btn-ban').text('Ban').attr('onclick',`banLocal(${localId},this)`)},error:function(){alert('Error unbanning local')}})}}
</script>
@endsection
