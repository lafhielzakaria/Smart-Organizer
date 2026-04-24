@extends('layouts.app')
@section('title', 'Tenant Dashboard')
@section('head')
<link href="https://fonts.bunny.net/css?family=antonio:400,500,600,700&family=barlow-condensed:400,500,600,700,800,900&family=barlow:400,500,600" rel="stylesheet">
@vite(['resources/css/tenant-dashboard.css', 'resources/js/tenant-dashboard.js'])
@endsection
@section('content')
<div class="dashboard-page">
<div class="beams"><div class="beam"></div><div class="beam"></div><div class="beam"></div><div class="beam"></div><div class="beam"></div></div>
<div class="stripe-bg"></div>
<div class="dashboard-inner">
@if(session('success'))
<div style="padding:16px 20px;margin-bottom:24px;background:rgba(0,200,83,0.1);border:1px solid rgba(0,200,83,0.3);border-radius:3px;animation:revealUp 0.5s ease;">
<p style="color:var(--green);font-size:13px;font-weight:600;margin:0;">✓ {{ session('success') }}</p>
</div>
@endif
@if(session('error'))
<div style="padding:16px 20px;margin-bottom:24px;background:rgba(255,0,0,0.1);border:1px solid rgba(255,0,0,0.3);border-radius:3px;animation:revealUp 0.5s ease;">
<p style="color:#ff6b6b;font-size:13px;font-weight:600;margin:0;">✕ {{ session('error') }}</p>
</div>
@endif
<div class="dash-header"><div class="hdr-line"></div><div class="hdr-center"><span class="hdr-eyebrow">Smart Organizer</span><div class="hdr-title">Tenant <span>Dashboard</span></div></div><div class="hdr-line r"></div></div>
<div class="action-bar"><button type="button" onclick="openModal('local-modal')" class="btn-gold">+ Create Local</button><button type="button" onclick="openModal('offer-modal')" class="btn-gold">+ Create Offer</button></div>
<div class="stats-grid">
<div class="stat-card"><div class="stat-label">My Locals</div><div class="stat-value">{{ $myLocals->count() }}</div><div class="stat-desc">properties</div></div>
<div class="stat-card"><div class="stat-label">Active Offers</div><div class="stat-value">{{ $activeOffers }}</div><div class="stat-desc">of {{ $totalOffers }} total</div></div>
<div class="stat-card"><div class="stat-label">Total Participants</div><div class="stat-value">{{ $totalParticipants }}</div><div class="stat-desc">across all offers</div></div>
</div>
<div class="card">
<div class="card-header"><h2>My Locals</h2><span class="card-badge">{{ $myLocals->count() }} total</span></div>
@forelse($myLocals as $local)
<div class="local-item">
@if($local->image)
<img src="{{ str_starts_with($local->image, 'http') ? $local->image : asset('storage/' . $local->image) }}" alt="{{ $local->name }}" style="width:80px;height:80px;object-fit:cover;border-radius:3px;margin-right:16px;">
@else
<div style="width:80px;height:80px;background:var(--panel2);border-radius:3px;margin-right:16px;display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:10px;">No image</div>
@endif
<div class="local-info"><h4>{{ $local->name }}</h4><p>{{ $local->city }} • {{ ucfirst($local->type) }} • Capacity: {{ $local->capacity }} • {{ $local->price }} pts</p></div>
<div class="local-meta"><span class="status-badge {{ $local->status === 'active' ? '' : 'inactive' }}">{{ ucfirst($local->status) }}</span><span style="font-size:11px;color:var(--muted)">{{ $local->local_offers_count }} offer(s)</span></div>
</div>
@empty
<div class="empty-state"><div class="empty-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path></svg></div><p class="empty-text">You have no locals yet</p></div>
@endforelse
</div>
<div class="card">
<div class="card-header"><h2>My Offers</h2><span class="card-badge">{{ $totalOffers }} total</span></div>
@php $allOffers = $myLocals->flatMap(fn($l) => $l->localOffers->each(fn($o) => $o->localName = $l->name)); @endphp
@if($allOffers->count() > 0)
<div class="offers-grid">
@foreach($allOffers as $offer)
<div class="offer-card">
<div class="offer-header"><span class="offer-local">{{ $offer->localName }}</span><span class="offer-status {{ $offer->status === 'available' ? '' : 'completed' }}">{{ ucfirst($offer->status) }}</span></div>
<div class="offer-date">{{ $offer->startTime->format('d M Y') }}</div>
<div class="offer-time">{{ $offer->startTime->format('H:i') }} → {{ $offer->endTime->format('H:i') }}</div>
<div class="offer-footer"><span class="offer-price">{{ $offer->totalPrice }} pts</span><span class="offer-participants">{{ $offer->participations->count() }} / {{ $offer->maxParticipants }}</span></div>
<div class="progress-bar"><div class="progress-fill" style="width:{{ $offer->maxParticipants > 0 ? round(($offer->participations->count() / $offer->maxParticipants) * 100) : 0 }}%"></div></div>
</div>
@endforeach
</div>
@else
<div class="empty-state"><div class="empty-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div><p class="empty-text">No offers yet</p></div>
@endif
</div>
</div>
</div>
<div id="local-modal" class="modal-overlay">
<div class="modal-content">
<div class="modal-header"><h3>Create Local</h3><button onclick="closeModal('local-modal')" class="modal-close">&times;</button></div>
<div class="modal-body">
<form method="POST" action="{{ route('tenant.locals.store') }}" enctype="multipart/form-data">
@csrf
@if(session('success'))
<div style="padding:12px;margin-bottom:16px;background:rgba(0,200,83,0.1);border:1px solid rgba(0,200,83,0.3);border-radius:3px;">
<p style="color:var(--green);font-size:12px;font-weight:600;margin:0;">✓ {{ session('success') }}</p>
</div>
@endif
@if(session('error'))
<div style="padding:12px;margin-bottom:16px;background:rgba(255,0,0,0.1);border:1px solid rgba(255,0,0,0.3);border-radius:3px;">
<p style="color:#ff6b6b;font-size:12px;font-weight:600;margin:0;">✕ {{ session('error') }}</p>
</div>
@endif
<div class="form-group"><label class="form-label">Name</label><input type="text" name="name" class="form-input" required></div>
<div class="form-group"><label class="form-label">Type</label><select name="type" class="form-select" required><option value="">Select type</option><option value="restaurant">Restaurant</option><option value="café">Café</option><option value="club">Club</option><option value="bar">Bar</option><option value="lounge">Lounge</option></select></div>
<div class="form-group"><label class="form-label">Capacity</label><input type="number" name="capacity" class="form-input" min="1" required></div>
<div class="form-group"><label class="form-label">City</label><input type="text" name="city" class="form-input" required></div>
<div class="form-group"><label class="form-label">Address</label><input type="text" name="andreas" class="form-input" required></div>
<div class="form-group"><label class="form-label">Price (pts)</label><input type="number" name="price" class="form-input" min="1" required></div>
<div class="form-group"><label class="form-label">Description</label><input type="text" name="description" class="form-input"></div>
<div class="form-group"><label class="form-label">Image</label><div class="file-upload-wrapper" id="fileUploadWrapper"><svg class="file-upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg><div class="file-upload-text">Click to upload image</div><div class="file-upload-hint">PNG, JPG, GIF up to 2MB</div><div class="file-upload-name" id="fileName"></div><input type="file" name="image" id="imageInput" accept="image/*" onchange="handleFileSelect(this)"></div></div>
<button type="submit" class="btn-submit">Create Local</button>
</form>
</div>
</div>
</div>
<div id="offer-modal" class="modal-overlay">
<div class="modal-content">
<div class="modal-header"><h3>Create Offer</h3><button onclick="closeModal('offer-modal')" class="modal-close">&times;</button></div>
<div class="modal-body">
<form method="POST" action="">
@csrf
@if(session('offer_success'))
<div style="padding:12px;margin-bottom:16px;background:rgba(0,200,83,0.1);border:1px solid rgba(0,200,83,0.3);border-radius:3px;">
<p style="color:var(--green);font-size:12px;font-weight:600;margin:0;">✓ {{ session('offer_success') }}</p>
</div>
@endif
@if(session('offer_error'))
<div style="padding:12px;margin-bottom:16px;background:rgba(255,0,0,0.1);border:1px solid rgba(255,0,0,0.3);border-radius:3px;">
<p style="color:#ff6b6b;font-size:12px;font-weight:600;margin:0;">✕ {{ session('offer_error') }}</p>
</div>
@endif
<div class="form-group"><label class="form-label">Local</label><select name="local_id" class="form-select">@foreach($myLocals as $local)<option value="{{ $local->id }}">{{ $local->name }}</option>@endforeach</select></div>
<div class="form-group"><label class="form-label">Start Time</label><input type="datetime-local" name="startTime" class="form-input"></div>
<div class="form-group"><label class="form-label">End Time</label><input type="datetime-local" name="endTime" class="form-input"></div>
<div class="form-group"><label class="form-label">Total Price (pts)</label><input type="number" name="totalPrice" class="form-input" min="1"></div>
<div class="form-group"><label class="form-label">Max Participants</label><input type="number" name="maxParticipants" class="form-input" min="1"></div>
<button type="submit" class="btn-submit">Create Offer</button>
</form>
</div>
</div>
</div>
@endsection
