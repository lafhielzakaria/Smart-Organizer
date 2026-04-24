@extends('layouts.app')
@section('title', 'Offer Details')
@section('head')
<link href="https://fonts.bunny.net/css?family=antonio:400,500,600,700&family=barlow-condensed:400,500,600,700,800,900" rel="stylesheet">
@vite(['resources/css/offer-details.css'])
@endsection
@section('content')
<div class="details-page">
<div class="beams"><div class="beam"></div><div class="beam"></div><div class="beam"></div><div class="beam"></div><div class="beam"></div></div>
<div class="stripe-bg"></div>
<div class="details-inner">
<a href="{{ route('lessor.dashboard') }}" class="back-btn">← Back to Dashboard</a>
<div class="details-card">
@if($availableOffer->local->image)
<img src="{{ str_starts_with($availableOffer->local->image, 'http') ? $availableOffer->local->image : asset('storage/' . $availableOffer->local->image) }}" alt="{{ $availableOffer->local->name }}" class="hero-img">
@else
<div style="width:100%;height:400px;background:var(--panel2);display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:14px;">No image available</div>
@endif
<div class="details-content">
<div class="offer-header">
<h1 class="offer-title">{{ $availableOffer->local->name }}</h1>
<p class="offer-subtitle">{{ $availableOffer->local->type }} · {{ $availableOffer->local->city }}</p>
</div>
<div class="info-grid">
<div class="info-item"><span class="info-label">Your Share Price</span><div class="info-value" style="color:var(--gold-bright);">{{ number_format(Auth::user()->isMember ? $availableOffer->sharePrice / 2 : $availableOffer->sharePrice, 2) }} SP @if(Auth::user()->isMember)<span style="font-size:11px;color:var(--green);margin-left:6px;">50% OFF</span>@endif</div></div>
<div class="info-item"><span class="info-label">Total Price</span><div class="info-value">{{ number_format($availableOffer->totalPrice, 2) }} MAD</div></div>
<div class="info-item"><span class="info-label">Capacity</span><div class="info-value">{{ $availableOffer->local->capacity }} people</div></div>
<div class="info-item"><span class="info-label">Status</span><div class="info-value" style="color:var(--gold-bright);">{{ ucfirst($availableOffer->status) }}</div></div>
<div class="info-item"><span class="info-label">Location</span><div class="info-value" style="font-size:14px;">{{ $availableOffer->local->andreas }}</div></div>
</div>
@if($availableOffer->local->description)
<div class="desc-section"><h2 class="desc-title">Description</h2><p class="desc-text">{{ $availableOffer->local->description }}</p></div>
@endif
<div class="action-bar"><a href="{{ route('lessor.apply', $availableOffer) }}" class="btn-apply">Apply Now</a></div>
</div>
</div>
</div>
</div>
@endsection