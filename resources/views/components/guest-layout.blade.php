<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Smart Organizer') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; min-height: 100vh; display: flex; }

        .auth-left {
            width: 45%;
            background: #000000;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 48px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow: hidden;
        }
        .auth-left::before {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            background: #333333;
            border-radius: 50%;
            top: -100px; left: -100px;
            opacity: .15;
        }
        .auth-left::after {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            background: #555555;
            border-radius: 50%;
            bottom: -80px; right: -80px;
            opacity: .12;
        }
        .auth-left-content { position: relative; z-index: 1; text-align: center; }
        .auth-logo { display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 48px; text-decoration: none; }
        .auth-logo-icon { width: 44px; height: 44px; background: #333333; border: 2px solid #fff; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
        .auth-logo-text { font-size: 24px; font-weight: 800; color: #fff; letter-spacing: -0.5px; }
        .auth-logo-dot { color: #fff; }
        .auth-left h2 { font-size: 32px; font-weight: 800; color: #fff; line-height: 1.2; margin-bottom: 16px; }
        .auth-left p { font-size: 15px; color: rgba(255,255,255,0.6); line-height: 1.7; max-width: 320px; }
        .auth-features { margin-top: 48px; display: flex; flex-direction: column; gap: 16px; text-align: left; }
        .auth-feature { display: flex; align-items: center; gap: 12px; }
        .auth-feature-dot { width: 8px; height: 8px; background: #fff; border-radius: 50%; flex-shrink: 0; }
        .auth-feature span { font-size: 14px; color: rgba(255,255,255,0.7); }

        .auth-right {
            flex: 1;
            background: #F5F5F5;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 48px;
            overflow-y: auto;
        }
        .auth-card {
            background: #fff;
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }
        .auth-card h1 { font-size: 26px; font-weight: 800; color: #111111; margin-bottom: 6px; }
        .auth-card .auth-sub { font-size: 14px; color: #8892A4; margin-bottom: 28px; }

        .auth-card label { display: block; font-size: 13px; font-weight: 600; color: #111111; margin-bottom: 6px; }
        .auth-card input, .auth-card select {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #E0E0E0;
            border-radius: 10px;
            font-size: 14px;
            color: #111111;
            background: #F5F5F5;
            outline: none;
            transition: border-color .2s;
            margin-bottom: 18px;
        }
        .auth-card input:focus, .auth-card select:focus { border-color: #111111; background: #fff; }
        .auth-card .btn-submit {
            width: 100%;
            padding: 13px;
            background: #111111;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity .2s;
            margin-top: 4px;
        }
        .auth-card .btn-submit:hover { opacity: .85; }
        .auth-card .auth-footer { text-align: center; margin-top: 20px; font-size: 13px; color: #8892A4; }
        .auth-card .auth-footer a { color: #111111; font-weight: 600; text-decoration: none; }
        .auth-card .auth-footer a:hover { text-decoration: underline; }
        .auth-back { font-size: 13px; color: #111111; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 24px; }
        .auth-back:hover { color: #555555; }
        .auth-remember { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
        .auth-remember label { font-size: 13px; color: #8892A4; font-weight: 400; margin: 0; display: flex; align-items: center; gap: 6px; }
        .auth-remember a { font-size: 13px; color: #111111; text-decoration: none; }
        .auth-remember a:hover { text-decoration: underline; }

        @media (max-width: 768px) {
            .auth-left { display: none; }
            .auth-right { padding: 32px 20px; }
        }
    </style>
</head>
<body>
    <div class="auth-left">
        <div class="auth-left-content">
            <a href="/" class="auth-logo">
                <div class="auth-logo-icon">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/home.png" width="22" height="22" alt="logo">
                </div>
                <span class="auth-logo-text">Smart<span class="auth-logo-dot">.</span>Organizer</span>
            </a>
            <h2>Organize Shared<br>Spaces Smartly</h2>
            <p>Book sports fields, study rooms, and coworking spaces collaboratively. Split costs fairly.</p>
            <div class="auth-features">
                <div class="auth-feature"><div class="auth-feature-dot"></div><span>Collaborative group bookings</span></div>
                <div class="auth-feature"><div class="auth-feature-dot"></div><span>Points system with 50% member discount</span></div>
                <div class="auth-feature"><div class="auth-feature-dot"></div><span>Real-time availability & analytics</span></div>
                <div class="auth-feature"><div class="auth-feature-dot"></div><span>Built-in group chat per reservation</span></div>
            </div>
        </div>
    </div>

    <div class="auth-right">
        <div class="auth-card">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
