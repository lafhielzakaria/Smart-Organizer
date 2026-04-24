@extends('layouts.app')
@section('title', 'Membership Benefits')
@section('head')
<link href="https://fonts.bunny.net/css?family=antonio:400,500,600,700&family=barlow-condensed:400,500,600,700,800,900&family=barlow:400,500,600" rel="stylesheet">
@vite(['resources/css/back-button.css', 'resources/css/membership-benefits.css'])
@endsection
@section('content')
<div class="membership-page">
<div class="beams"><div class="beam"></div><div class="beam"></div><div class="beam"></div><div class="beam"></div><div class="beam"></div></div>
<div class="stripe-bg"></div>
<div class="membership-inner">
@include('components.back-button', ['route' => route('lessor.dashboard')])
<div class="membership-card">
<div class="membership-icon"><img src="https://img.icons8.com/ios-filled/50/C9A84C/vip.png" alt="vip"></div>
<h1 class="membership-title">Premium Membership</h1>
<p class="membership-subtitle">Unlock exclusive benefits and save on every booking</p>
<div class="benefit-box">
<h3 class="benefit-title">50% Off All Bookings</h3>
<p class="benefit-desc">Save big on every reservation you make. Members enjoy an exclusive 50% discount on all local offers and events.</p>
</div>
<form method="POST" action="{{ route('membership.subscribe') }}">
@csrf
<button type="submit" class="btn-member">Become a Member</button>
</form>
</div>
</div>
</div>
@endsection
