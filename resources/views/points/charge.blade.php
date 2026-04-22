@extends('layouts.app')

@section('title', 'Points Store')

@section('head')
<link href="https://fonts.bunny.net/css?family=antonio:400,500,600,700&family=barlow-condensed:400,500,600,700,800,900&family=barlow:400,500,600" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<style>
    :root {
        --gold: #C9A84C;
        --gold-bright: #F0C040;
        --gold-dim: rgba(201, 168, 76, 0.12);
        --gold-line: rgba(201, 168, 76, 0.35);
        --black: #060608;
        --dark: #0D0D10;
        --panel: #12121A;
        --panel2: #1A1A26;
        --white: #FFFFFF;
        --muted: rgba(255, 255, 255, 0.38);
        --green: #00C853;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        background: var(--black);
    }

    /* ─── PAGE ─── */
    .store-page {
        min-height: calc(100vh - 65px);
        background: var(--black);
        font-family: 'Barlow Condensed', sans-serif;
        position: relative;
        overflow: hidden;
    }

    /* ─── ANIMATED STADIUM LIGHT BEAMS ─── */
    .beams {
        position: fixed;
        top: -10%;
        left: 50%;
        transform: translateX(-50%);
        width: 120%;
        height: 80vh;
        pointer-events: none;
        z-index: 0;
    }

    .beam {
        position: absolute;
        top: 0;
        transform-origin: top center;
        opacity: 0;
        animation: beamSweep 8s infinite ease-in-out;
    }

    .beam::after {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 200px;
        height: 70vh;
        background: linear-gradient(180deg, rgba(201, 168, 76, 0.18) 0%, transparent 75%);
        clip-path: polygon(50% 0%, 100% 100%, 0% 100%);
    }

    .beam:nth-child(1) {
        left: 18%;
        animation-delay: 0s;
        animation-duration: 7s;
    }

    .beam:nth-child(2) {
        left: 33%;
        animation-delay: 1.5s;
        animation-duration: 9s;
    }

    .beam:nth-child(3) {
        left: 50%;
        animation-delay: 0.8s;
        animation-duration: 8s;
    }

    .beam:nth-child(4) {
        left: 67%;
        animation-delay: 2.2s;
        animation-duration: 7.5s;
    }

    .beam:nth-child(5) {
        left: 82%;
        animation-delay: 0.4s;
        animation-duration: 10s;
    }

    @keyframes beamSweep {
        0% {
            opacity: 0;
            transform: rotate(-18deg);
        }

        20% {
            opacity: 1;
        }

        50% {
            opacity: 0.55;
            transform: rotate(18deg);
        }

        80% {
            opacity: 1;
        }

        100% {
            opacity: 0;
            transform: rotate(-18deg);
        }
    }

    /* ─── DIAGONAL STRIPES ─── */
    .stripe-bg {
        position: fixed;
        inset: 0;
        background-image: repeating-linear-gradient(-55deg,
                transparent, transparent 40px,
                rgba(201, 168, 76, 0.018) 40px, rgba(201, 168, 76, 0.018) 41px);
        pointer-events: none;
        z-index: 0;
    }

    /* ─── PITCH LINES (bottom decoration) ─── */
    .pitch-deco {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 220px;
        pointer-events: none;
        z-index: 0;
        opacity: 0.1;
        overflow: hidden;
    }

    .pitch-deco svg {
        width: 100%;
        height: 100%;
    }

    /* ─── INNER ─── */
    .store-inner {
        position: relative;
        z-index: 2;
        max-width: 1200px;
        margin: 0 auto;
        padding: 52px 28px 100px;
    }

    /* ─── HEADER ─── */
    .store-header {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        margin-bottom: 56px;
        animation: revealUp 0.7s ease both;
    }

    .hdr-line {
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--gold-line));
    }

    .hdr-line.r {
        background: linear-gradient(90deg, var(--gold-line), transparent);
    }

    .hdr-center {
        text-align: center;
        padding: 0 36px;
    }

    .hdr-eyebrow {
        display: block;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 5px;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 8px;
    }

    .hdr-title {
        font-family: 'Antonio', sans-serif;
        font-size: clamp(34px, 6vw, 62px);
        font-weight: 700;
        color: var(--white);
        text-transform: uppercase;
        letter-spacing: -1px;
        line-height: 1;
    }

    .hdr-title span {
        color: var(--gold-bright);
        position: relative;
    }

    .hdr-title span::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--gold-bright), var(--gold));
        transform: scaleX(0);
        transform-origin: left;
        animation: scaleIn 0.9s 0.5s ease both;
    }

    @keyframes scaleIn {
        to {
            transform: scaleX(1);
        }
    }

    /* ─── BALANCE STRIP ─── */
    .balance-strip {
        display: flex;
        border: 1px solid var(--gold-line);
        border-radius: 3px;
        overflow: hidden;
        margin-bottom: 52px;
        position: relative;
        animation: revealUp 0.7s 0.1s ease both;
    }

    .balance-strip::after {
        content: '';
        position: absolute;
        top: 0;
        left: -60%;
        width: 60%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(201, 168, 76, 0.06), transparent);
        animation: stripShimmer 5s 1s infinite;
    }

    @keyframes stripShimmer {
        to {
            left: 140%;
        }
    }

    .bc {
        flex: 1;
        padding: 18px 24px;
        background: var(--panel);
        border-right: 1px solid var(--gold-line);
        transition: background 0.2s;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .bc:last-child {
        border-right: none;
    }

    .bc:hover {
        background: var(--panel2);
    }

    .bc-lbl {
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--muted);
    }

    .bc-val {
        font-family: 'Antonio', sans-serif;
        font-size: 28px;
        font-weight: 700;
        color: var(--gold-bright);
        letter-spacing: -0.5px;
        line-height: 1;
    }

    .bc-val .unit {
        font-size: 13px;
        font-weight: 600;
        color: var(--muted);
        margin-left: 3px;
        font-family: 'Barlow Condensed', sans-serif;
    }

    /* ─── SECTION LABEL ─── */
    .sec-label {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 20px;
    }

    .sec-label-txt {
        font-family: 'Antonio', sans-serif;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--gold);
        white-space: nowrap;
    }

    .sec-label-bar {
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, var(--gold-line), transparent);
    }

    .sec-label-count {
        font-family: 'Antonio', sans-serif;
        font-size: 11px;
        letter-spacing: 2px;
        color: var(--muted);
    }

    /* ─── PACKS ─── */
    .packs-row {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 10px;
        margin-bottom: 48px;
    }

    .pack {
        position: relative;
        background: var(--panel);
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 3px;
        overflow: hidden;
        cursor: pointer;
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.25s, border-color 0.25s;
        animation: revealUp 0.5s ease both;
        display: flex;
        flex-direction: column;
    }

    .pack:nth-child(1) {
        animation-delay: .08s
    }

    .pack:nth-child(2) {
        animation-delay: .14s
    }

    .pack:nth-child(3) {
        animation-delay: .20s
    }

    .pack:nth-child(4) {
        animation-delay: .26s
    }

    .pack:nth-child(5) {
        animation-delay: .32s
    }

    .pack:nth-child(6) {
        animation-delay: .38s
    }

    .pack:hover {
        transform: translateY(-8px) scale(1.02);
        border-color: var(--gold);
        box-shadow: 0 24px 48px rgba(0, 0, 0, 0.7), 0 0 0 1px var(--gold), inset 0 1px 0 rgba(255, 255, 255, 0.07);
    }

    .pack.active {
        border-color: var(--gold-bright);
        box-shadow: 0 0 0 2px var(--gold-bright), 0 20px 50px rgba(0, 0, 0, 0.6), 0 0 60px rgba(201, 168, 76, 0.15);
    }

    /* ── Pack Visual (pure CSS, no icons) ── */
    .pack-visual {
        height: 130px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pack:nth-child(1) .pack-visual {
        background: linear-gradient(145deg, #131320, #1D1D30);
    }

    .pack:nth-child(2) .pack-visual {
        background: linear-gradient(145deg, #0E1828, #182840);
    }

    .pack:nth-child(3) .pack-visual {
        background: linear-gradient(145deg, #191200, #2E2000);
    }

    .pack:nth-child(4) .pack-visual {
        background: linear-gradient(145deg, #1A0A00, #2E1400);
    }

    .pack:nth-child(5) .pack-visual {
        background: linear-gradient(145deg, #0D0A1A, #1C1430);
    }

    .pack:nth-child(6) .pack-visual {
        background: linear-gradient(145deg, #100808, #220E0E);
    }

    /* Rotating diamond frames */
    .pack-geo {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pack-geo-inner {
        position: relative;
        width: 80px;
        height: 80px;
    }
.back-nav {
    margin-bottom: 30px;
    animation: revealUp 0.7s ease both;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    color: var(--muted);
    text-decoration: none;
    font-family: 'Antonio', sans-serif;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 3px;
    padding: 10px 18px;
    border: 1px solid transparent;
    border-radius: 2px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: rgba(255,255,255,0.03);
}

.btn-back svg {
    transition: transform 0.3s ease;
}

.btn-back:hover {
    color: var(--gold-bright);
    border-color: var(--gold-line);
    background: var(--gold-dim);
    box-shadow: 0 0 20px rgba(201,168,76,0.1);
}

.btn-back:hover svg {
    transform: translateX(-5px); /* Arrow animation */
}
    .geo-ring {
        position: absolute;
        border-style: solid;
        border-radius: 2px;
        transform: rotate(45deg);
        transition: transform 0.5s ease, opacity 0.4s;
    }

    .geo-ring-1 {
        inset: 0;
        border-width: 1px;
        opacity: 0.22;
    }

    .geo-ring-2 {
        inset: 16px;
        border-width: 1px;
        opacity: 0.35;
    }

    .geo-ring-3 {
        inset: 30px;
        border-width: 2px;
        opacity: 0.5;
    }

    .pack:hover .geo-ring-1 {
        transform: rotate(55deg) scale(1.08);
        opacity: 0.4;
    }

    .pack:hover .geo-ring-2 {
        transform: rotate(30deg) scale(0.9);
        opacity: 0.5;
    }

    .pack:hover .geo-ring-3 {
        transform: rotate(55deg) scale(1.15);
        opacity: 0.7;
    }

    .pack.active .geo-ring-1 {
        opacity: 0.5;
    }

    .pack.active .geo-ring-2 {
        opacity: 0.65;
    }

    .pack.active .geo-ring-3 {
        opacity: 0.85;
    }

    /* Tier colors for geo rings */
    .pack:nth-child(1) .geo-ring {
        border-color: #7799BB;
    }

    .pack:nth-child(2) .geo-ring {
        border-color: #4488DD;
    }

    .pack:nth-child(3) .geo-ring {
        border-color: #C9A84C;
    }

    .pack:nth-child(4) .geo-ring {
        border-color: #DD7722;
    }

    .pack:nth-child(5) .geo-ring {
        border-color: #9944DD;
    }

    .pack:nth-child(6) .geo-ring {
        border-color: #DD2222;
    }

    /* Horizontal scan line animation */
    .pack-scanline {
        position: absolute;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
        top: -1px;
        opacity: 0;
        transition: none;
    }

    .pack:hover .pack-scanline {
        animation: scanDown 0.6s ease forwards;
    }

    @keyframes scanDown {
        0% {
            top: 0%;
            opacity: 1;
        }

        100% {
            top: 100%;
            opacity: 0;
        }
    }

    /* Corner brackets */
    .corner {
        position: absolute;
        width: 10px;
        height: 10px;
        border-color: var(--gold-bright);
        border-style: solid;
        opacity: 0;
        transition: opacity 0.25s;
    }

    .pack:hover .corner,
    .pack.active .corner {
        opacity: 1;
    }

    .corner.tl {
        top: 7px;
        left: 7px;
        border-width: 1px 0 0 1px;
    }

    .corner.tr {
        top: 7px;
        right: 7px;
        border-width: 1px 1px 0 0;
    }

    .corner.bl {
        bottom: 7px;
        left: 7px;
        border-width: 0 0 1px 1px;
    }

    .corner.br {
        bottom: 7px;
        right: 7px;
        border-width: 0 1px 1px 0;
    }

    /* Points number on visual */
    .pack-num-wrap {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .pack-num {
        font-family: 'Antonio', sans-serif;
        font-size: 34px;
        font-weight: 700;
        color: var(--white);
        letter-spacing: -1px;
        line-height: 1;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.6);
        transition: color 0.3s, text-shadow 0.3s;
    }

    .pack:hover .pack-num,
    .pack.active .pack-num {
        color: var(--gold-bright);
        text-shadow: 0 0 18px rgba(240, 192, 64, 0.5);
    }

    .pack-unit {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--muted);
        margin-top: 2px;
    }

    /* Badge */
    .pack-badge {
        position: absolute;
        top: 0;
        right: 0;
        background: var(--gold);
        color: #000;
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 8px;
        font-weight: 900;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 4px 10px;
        clip-path: polygon(10px 0%, 100% 0%, 100% 100%, 0% 100%);
    }

    /* Bonus tag */
    .pack-bonus {
        position: absolute;
        bottom: 9px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0, 200, 83, 0.14);
        border: 1px solid rgba(0, 200, 83, 0.4);
        color: var(--green);
        font-size: 8px;
        font-weight: 700;
        letter-spacing: 1px;
        padding: 2px 8px;
        white-space: nowrap;
        border-radius: 1px;
    }

    /* Pack info */
    .pack-info {
        padding: 12px 14px 14px;
        background: var(--panel);
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
        transition: background 0.2s;
    }

    .pack:hover .pack-info,
    .pack.active .pack-info {
        background: var(--panel2);
    }

    .pack-name {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--muted);
    }

    .pack-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .pack-price {
        font-family: 'Antonio', sans-serif;
        font-size: 22px;
        font-weight: 700;
        color: var(--white);
        letter-spacing: -0.5px;
    }

    .pack-pick {
        background: none;
        border: 1px solid rgba(255, 255, 255, 0.14);
        color: var(--muted);
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        padding: 5px 9px;
        cursor: pointer;
        border-radius: 2px;
        transition: all 0.2s;
    }

    .pack:hover .pack-pick {
        border-color: var(--gold);
        color: var(--gold);
        background: var(--gold-dim);
    }

    .pack.active .pack-pick {
        background: var(--gold);
        color: #000;
        border-color: var(--gold);
        font-weight: 900;
    }

    /* ─── CHECKOUT ─── */
    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 330px;
        gap: 14px;
        animation: revealUp 0.6s 0.3s ease both;
    }

    .co-panel {
        background: var(--panel);
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 3px;
        overflow: hidden;
    }

    .co-head {
        padding: 15px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .co-head-bar {
        width: 3px;
        height: 16px;
        background: var(--gold);
        border-radius: 2px;
    }

    .co-head-title {
        font-family: 'Antonio', sans-serif;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--white);
    }

    .co-body {
        padding: 16px 20px;
    }

    /* Methods */
    .methods {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
    }

    .method {
        padding: 14px;
        background: var(--panel2);
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 2px;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
        overflow: hidden;
    }

    /* Tiny corner triangle */
    .method::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 0 20px 20px 0;
        border-color: transparent rgba(255, 255, 255, 0.04) transparent transparent;
        transition: border-color 0.2s;
    }

    .method:hover,
    .method.sel {
        border-color: var(--gold-line);
        background: #1D1D2C;
    }

    .method.sel::before {
        border-color: transparent var(--gold) transparent transparent;
    }

    /* Card art strip */
    .card-art {
        width: 30px;
        height: 18px;
        border-radius: 2px;
        margin-bottom: 8px;
    }

    .card-art.visa {
        background: linear-gradient(135deg, #1A1F71, #2563EB);
    }

    .card-art.paypal {
        background: linear-gradient(135deg, #003087, #009CDE);
    }

    .card-art.mobile {
        background: linear-gradient(135deg, #1C1C1E, #3A3A3C);
    }

    .card-art.bank {
        background: linear-gradient(135deg, #0F4C1C, #1A8032);
    }

    .method-name {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1px;
        color: var(--white);
    }

    .method-sub {
        font-size: 10px;
        font-weight: 500;
        color: var(--muted);
    }

    /* Summary */
    .sum-rows {
        padding: 16px 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .sum-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 11px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    }

    .sum-row:last-child {
        border-bottom: none;
    }

    .sum-lbl {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--muted);
    }

    .sum-val {
        font-family: 'Antonio', sans-serif;
        font-size: 15px;
        font-weight: 600;
        color: var(--white);
    }

    .sum-val.g {
        color: var(--gold-bright);
        font-size: 19px;
        text-shadow: 0 0 12px rgba(240, 192, 64, 0.3);
    }

    .sum-total {
        padding: 15px 20px;
        background: rgba(201, 168, 76, 0.06);
        border-top: 1px solid var(--gold-line);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .sum-total-lbl {
        font-family: 'Antonio', sans-serif;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--gold);
    }

    .sum-total-price {
        font-family: 'Antonio', sans-serif;
        font-size: 30px;
        font-weight: 700;
        color: var(--gold-bright);
        text-shadow: 0 0 18px rgba(240, 192, 64, 0.35);
        letter-spacing: -1px;
    }

    /* Buy btn */
    .buy-wrap {
        padding: 14px 20px;
    }

    .buy-btn {
        width: 100%;
        padding: 17px;
        background: var(--gold);
        color: #000;
        border: none;
        border-radius: 2px;
        font-family: 'Antonio', sans-serif;
        font-size: 15px;
        font-weight: 700;
        letter-spacing: 5px;
        text-transform: uppercase;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: all 0.25s;
    }

    .buy-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 60%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
        transition: left 0s;
    }

    .buy-btn:hover::before {
        left: 160%;
        transition: left 0.5s ease;
    }

    .buy-btn:hover {
        background: var(--gold-bright);
        box-shadow: 0 6px 30px rgba(201, 168, 76, 0.35);
        letter-spacing: 7px;
    }

    .buy-btn:active {
        transform: scale(0.98);
    }

    .buy-btn:disabled {
        background: #1E1E2C;
        color: rgba(255, 255, 255, 0.2);
        cursor: not-allowed;
        letter-spacing: 5px;
        box-shadow: none;
    }

    .buy-btn:disabled::before {
        display: none;
    }

    .buy-note {
        text-align: center;
        color: var(--muted);
        font-size: 9px;
        margin-top: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    /* ─── TOAST ─── */
    .toast {
        position: fixed;
        bottom: 32px;
        left: 50%;
        transform: translateX(-50%) translateY(80px);
        background: var(--panel2);
        border: 1px solid var(--gold-line);
        border-left: 3px solid var(--gold-bright);
        padding: 13px 24px;
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 1px;
        color: var(--white);
        opacity: 0;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 9999;
        white-space: nowrap;
        border-radius: 2px;
    }

    .toast.show {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }

    /* ─── ANIMATION ─── */
    @keyframes revealUp {
        from {
            opacity: 0;
            transform: translateY(22px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 1000px) {
        .packs-row {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 700px) {
        .packs-row {
            grid-template-columns: repeat(2, 1fr);
        }

        .checkout-grid {
            grid-template-columns: 1fr;
        }

        .store-header {
            grid-template-columns: 1fr;
        }

        .hdr-line {
            display: none;
        }

        .methods {
            grid-template-columns: 1fr;
        }
    }
</style>
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
        <div class="back-nav">
            <a href="{{ route('lessor.dashboard') }}" class="btn-back">
                <svg width="18" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Back to Dashboard
            </a>
        </div>
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
    let selPts = 0,
        selPrice = 0;

    function selectPack(el, pts, price, name, ptsLabel) {
        document.querySelectorAll('.pack').forEach(p => p.classList.remove('active'));
        el.classList.add('active');
        selPts = pts;
        selPrice = price;

        document.getElementById('sumPack').textContent = name + ' Pack';
        document.getElementById('sumPack').style.color = '#fff';
        document.getElementById('sumPts').textContent = ptsLabel + ' PTS';
        document.getElementById('sumPrice').textContent = '$' + price.toFixed(2);
        document.getElementById('fPts').value = pts;
        document.getElementById('fPrice').value = price;
        document.getElementById('fLabel').value = name;

        document.getElementById('buyBtn').disabled = false;
        showToast(name + ' Pack selected');
    }

    function selectMethod(el) {
        document.querySelectorAll('.method').forEach(m => m.classList.remove('sel'));
        el.classList.add('sel');
    }

    function checkPack(e) {
        e.preventDefault();
        if (!selPts) {
            showToast('Select a pack first');
            return false;
        }
        const btn = document.getElementById('buyBtn');
        const originalText = btn.textContent;
        btn.disabled = true;
        btn.textContent = 'Processing...';
        
        $.ajax({
            url: '{{ route("points.purchase") }}',
            type: 'POST',
            data: {
                pack_points: selPts,
                pack_price: selPrice,
                pack_label: document.getElementById('fLabel').value,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                showToast('Purchase successful! Balance updated.');
                setTimeout(() => {
                    window.location.href = '{{ route("lessor.dashboard") }}';
                }, 1500);
            },
            error: function(xhr) {
                showToast('Purchase failed. Please try again.');
                btn.disabled = false;
                btn.textContent = originalText;
            }
        });
        return false;
    }

    function showToast(msg) {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.classList.add('show');
        clearTimeout(t._t);
        t._t = setTimeout(() => t.classList.remove('show'), 2800);
    }
</script>
@endsection