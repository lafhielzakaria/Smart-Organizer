@extends('layouts.app')

@section('title', 'Points Store')

@section('head')
<link href="https://fonts.bunny.net/css?family=antonio:400,500,600,700&family=barlow-condensed:400,500,600,700,800,900&family=barlow:400,500,600" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
@vite(['resources/css/back-button.css', 'resources/css/points-charge.css', 'resources/js/points-charge.js'])
@endsection

@section('content')
<div class="store-page">

    <div class="beams">
        <div class="beam"></div>
        <div class="beam"></div>
        <div class="beam"></div>
        <div class="beam"></div>
        <div class="beam"></div>
    </div>

    <div class="stripe-bg"></div>
    <div class="pitch-deco">
        <svg viewBox="0 0 1440 220" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <line x1="0" y1="219" x2="1440" y2="219" stroke="white" stroke-width="1.2" />
            <line x1="0" y1="178" x2="1440" y2="178" stroke="white" stroke-width="0.5" />
            <line x1="0" y1="137" x2="1440" y2="137" stroke="white" stroke-width="0.5" />
            <ellipse cx="720" cy="220" rx="290" ry="125" stroke="white" stroke-width="1.2" fill="none" />
            <circle cx="720" cy="220" r="5" fill="white" opacity="0.8" />
            <line x1="430" y1="220" x2="430" y2="95" stroke="white" stroke-width="0.6" />
            <line x1="1010" y1="220" x2="1010" y2="95" stroke="white" stroke-width="0.6" />
            <line x1="430" y1="95" x2="1010" y2="95" stroke="white" stroke-width="0.6" />
            <line x1="570" y1="220" x2="570" y2="155" stroke="white" stroke-width="0.6" />
            <line x1="870" y1="220" x2="870" y2="155" stroke="white" stroke-width="0.6" />
            <line x1="570" y1="155" x2="870" y2="155" stroke="white" stroke-width="0.6" />
        </svg>
    </div>

    <div class="store-inner">
        @include('components.back-button', ['route' => route('lessor.dashboard')])
        <div class="store-header">
            <div class="hdr-line"></div>
            <div class="hdr-center">
                <span class="hdr-eyebrow">Smart Organizer · Store</span>
                <div class="hdr-title">Points <span>Packs</span></div>
            </div>
            <div class="hdr-line r"></div>
        </div>
        <div class="sec-label">
            <span class="sec-label-txt">Select Pack</span>
            <div class="sec-label-bar"></div>
            <span class="sec-label-count">06 PACKS</span>
        </div>

        <div class="packs-row" id="packsRow">

            <div class="pack" onclick="selectPack(this,100,0.99,'Starter','100')">
                <div class="pack-visual">
                    <div class="pack-geo">
                        <div class="pack-geo-inner">
                            <div class="geo-ring geo-ring-1"></div>
                            <div class="geo-ring geo-ring-2"></div>
                            <div class="geo-ring geo-ring-3"></div>
                        </div>
                    </div>
                    <div class="pack-scanline"></div>
                    <div class="corner tl"></div>
                    <div class="corner tr"></div>
                    <div class="corner bl"></div>
                    <div class="corner br"></div>
                    <div class="pack-num-wrap">
                        <div class="pack-num">100</div>
                        <div class="pack-unit">Points</div>
                    </div>
                </div>
                <div class="pack-info">
                    <span class="pack-name">Starter Pack</span>
                    <div class="pack-bottom">
                        <span class="pack-price">$0.99</span>
                        <button class="pack-pick">Pick</button>
                    </div>
                </div>
            </div>

            <div class="pack" onclick="selectPack(this,500,3.99,'Rookie','500 +50')">
                <div class="pack-visual">
                    <div class="pack-geo">
                        <div class="pack-geo-inner">
                            <div class="geo-ring geo-ring-1"></div>
                            <div class="geo-ring geo-ring-2"></div>
                            <div class="geo-ring geo-ring-3"></div>
                        </div>
                    </div>
                    <div class="pack-scanline"></div>
                    <div class="corner tl"></div>
                    <div class="corner tr"></div>
                    <div class="corner bl"></div>
                    <div class="corner br"></div>
                    <div class="pack-num-wrap">
                        <div class="pack-num">500</div>
                        <div class="pack-unit">Points</div>
                    </div>
                    <div class="pack-bonus">+50 FREE</div>
                </div>
                <div class="pack-info">
                    <span class="pack-name">Rookie Pack</span>
                    <div class="pack-bottom">
                        <span class="pack-price">$3.99</span>
                        <button class="pack-pick">Pick</button>
                    </div>
                </div>
            </div>

            <div class="pack" onclick="selectPack(this,1200,7.99,'Pro','1200 +200')">
                <div class="pack-visual">
                    <div class="pack-geo">
                        <div class="pack-geo-inner">
                            <div class="geo-ring geo-ring-1"></div>
                            <div class="geo-ring geo-ring-2"></div>
                            <div class="geo-ring geo-ring-3"></div>
                        </div>
                    </div>
                    <div class="pack-scanline"></div>
                    <div class="pack-badge">Best Value</div>
                    <div class="corner tl"></div>
                    <div class="corner tr"></div>
                    <div class="corner bl"></div>
                    <div class="corner br"></div>
                    <div class="pack-num-wrap">
                        <div class="pack-num">1.2K</div>
                        <div class="pack-unit">Points</div>
                    </div>
                    <div class="pack-bonus">+200 FREE</div>
                </div>
                <div class="pack-info">
                    <span class="pack-name">Pro Pack</span>
                    <div class="pack-bottom">
                        <span class="pack-price">$7.99</span>
                        <button class="pack-pick">Pick</button>
                    </div>
                </div>
            </div>

            <div class="pack" onclick="selectPack(this,2500,14.99,'Elite','2500 +500')">
                <div class="pack-visual">
                    <div class="pack-geo">
                        <div class="pack-geo-inner">
                            <div class="geo-ring geo-ring-1"></div>
                            <div class="geo-ring geo-ring-2"></div>
                            <div class="geo-ring geo-ring-3"></div>
                        </div>
                    </div>
                    <div class="pack-scanline"></div>
                    <div class="corner tl"></div>
                    <div class="corner tr"></div>
                    <div class="corner bl"></div>
                    <div class="corner br"></div>
                    <div class="pack-num-wrap">
                        <div class="pack-num">2.5K</div>
                        <div class="pack-unit">Points</div>
                    </div>
                    <div class="pack-bonus">+500 FREE</div>
                </div>
                <div class="pack-info">
                    <span class="pack-name">Elite Pack</span>
                    <div class="pack-bottom">
                        <span class="pack-price">$14.99</span>
                        <button class="pack-pick">Pick</button>
                    </div>
                </div>
            </div>

            <div class="pack" onclick="selectPack(this,5000,24.99,'Legend','5000 +1000')">
                <div class="pack-visual">
                    <div class="pack-geo">
                        <div class="pack-geo-inner">
                            <div class="geo-ring geo-ring-1"></div>
                            <div class="geo-ring geo-ring-2"></div>
                            <div class="geo-ring geo-ring-3"></div>
                        </div>
                    </div>
                    <div class="pack-scanline"></div>
                    <div class="corner tl"></div>
                    <div class="corner tr"></div>
                    <div class="corner bl"></div>
                    <div class="corner br"></div>
                    <div class="pack-num-wrap">
                        <div class="pack-num">5K</div>
                        <div class="pack-unit">Points</div>
                    </div>
                    <div class="pack-bonus">+1,000 FREE</div>
                </div>
                <div class="pack-info">
                    <span class="pack-name">Legend Pack</span>
                    <div class="pack-bottom">
                        <span class="pack-price">$24.99</span>
                        <button class="pack-pick">Pick</button>
                    </div>
                </div>
            </div>

            <div class="pack" onclick="selectPack(this,12000,49.99,'Ultimate','12000 +3000')">
                <div class="pack-visual">
                    <div class="pack-geo">
                        <div class="pack-geo-inner">
                            <div class="geo-ring geo-ring-1"></div>
                            <div class="geo-ring geo-ring-2"></div>
                            <div class="geo-ring geo-ring-3"></div>
                        </div>
                    </div>
                    <div class="pack-scanline"></div>
                    <div class="pack-badge">Ultimate</div>
                    <div class="corner tl"></div>
                    <div class="corner tr"></div>
                    <div class="corner bl"></div>
                    <div class="corner br"></div>
                    <div class="pack-num-wrap">
                        <div class="pack-num">12K</div>
                        <div class="pack-unit">Points</div>
                    </div>
                    <div class="pack-bonus">+3,000 FREE</div>
                </div>
                <div class="pack-info">
                    <span class="pack-name">Ultimate Pack</span>
                    <div class="pack-bottom">
                        <span class="pack-price">$49.99</span>
                        <button class="pack-pick">Pick</button>
                    </div>
                </div>
            </div>

        </div>
        <div class="sec-label">
            <span class="sec-label-txt">Checkout</span>
            <div class="sec-label-bar"></div>
        </div>

        <div class="checkout-grid">
            <div class="co-panel">
                <div class="co-head">
                    <div class="co-head-bar"></div>
                    <span class="co-head-title">Payment Method</span>
                </div>
                <div class="co-body">
                    <div class="methods">
                        <div class="method sel" onclick="selectMethod(this)">
                            <div class="card-art visa"></div>
                            <div class="method-name">Credit Card</div>
                            <div class="method-sub">Visa · Mastercard · Amex</div>
                        </div>
                        <div class="method" onclick="selectMethod(this)">
                            <div class="card-art paypal"></div>
                            <div class="method-name">PayPal</div>
                            <div class="method-sub">Instant checkout</div>
                        </div>
                        <div class="method" onclick="selectMethod(this)">
                            <div class="card-art mobile"></div>
                            <div class="method-name">Mobile Pay</div>
                            <div class="method-sub">Apple Pay · Google Pay</div>
                        </div>
                        <div class="method" onclick="selectMethod(this)">
                            <div class="card-art bank"></div>
                            <div class="method-name">Bank Transfer</div>
                            <div class="method-sub">Direct payment</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="co-panel" style="display:flex;flex-direction:column;">
                <div class="co-head">
                    <div class="co-head-bar"></div>
                    <span class="co-head-title">Order Summary</span>
                </div>
                <div class="sum-rows">
                    <div class="sum-row">
                        <span class="sum-lbl">Pack</span>
                        <span class="sum-val" id="sumPack" style="font-size:12px;color:var(--muted);">Not selected</span>
                    </div>
                    <div class="sum-row">
                        <span class="sum-lbl">Points</span>
                        <span class="sum-val g" id="sumPts">—</span>
                    </div>
                    <div class="sum-row">
                        <span class="sum-lbl">Tax</span>
                        <span class="sum-val">$0.00</span>
                    </div>
                </div>
                <div class="sum-total">
                    <span class="sum-total-lbl">Total</span>
                    <span class="sum-total-price" id="sumPrice">$0.00</span>
                </div>
                <div class="buy-wrap">
                    <form method="POST" action="#" id="pForm">
                        @csrf
                        <input type="hidden" name="pack_points" id="fPts" value="0">
                        <input type="hidden" name="pack_price" id="fPrice" value="0">
                        <input type="hidden" name="pack_label" id="fLabel" value="">
                        <button type="submit" class="buy-btn" id="buyBtn" disabled onclick="return checkPack(event)">
                            Confirm Purchase
                        </button>
                    </form>
                    <p class="buy-note">Secured · Encrypted · Instant</p>
                </div>
            </div>

        </div>

    </div>
</div>

<div class="toast" id="toast"></div>

<script>
window.purchaseRoute = '{{ route("points.purchase") }}';
window.dashboardRoute = '{{ route("lessor.dashboard") }}';
window.csrfToken = '{{ csrf_token() }}';
</script>
@endsection
