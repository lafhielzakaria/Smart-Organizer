<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Organizer - Shared Local Management Platform</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: #111111;
            --blue: #111111;
            --yellow: #111111;
            --gray-bg: #F5F5F5;
            --radius: 20px;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--gray-bg); color: var(--primary); }

        .navbar { background: #fff; border-bottom: 1px solid #E8EAF0; position: fixed; top: 0; width: 100%; z-index: 100; transition: background .3s, border-color .3s; }
        .navbar-inner { max-width: 1200px; margin: 0 auto; padding: 0 32px; display: flex; justify-content: space-between; align-items: center; height: 68px; }
        .logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo-icon { width: 36px; height: 36px; background: #0B1B3F; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
        .logo-text { font-size: 20px; font-weight: 800; color: var(--primary); letter-spacing: -0.5px; transition: color .3s; }
        .logo-dot { color: #111111; }
        .nav-links { display: flex; align-items: center; gap: 8px; }
        .nav-link { font-size: 14px; font-weight: 500; color: #8892A4; text-decoration: none; padding: 8px 14px; border-radius: 999px; transition: all .2s; }
        .nav-link:hover { color: #111111; background: var(--gray-bg); }
        .btn-nav { background: var(--primary); color: #fff; border-radius: 999px; padding: 9px 22px; font-size: 14px; font-weight: 600; text-decoration: none; transition: opacity .2s; }
        .btn-nav:hover { opacity: .85; }
        .btn-nav-outline { background: transparent; color: var(--primary); border: 1.5px solid #E8EAF0; border-radius: 999px; padding: 9px 22px; font-size: 14px; font-weight: 600; text-decoration: none; transition: all .2s; }
        .btn-nav-outline:hover { border-color: #111111; color: #111111; }

        .hero { padding: 140px 32px 80px; max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; gap: 60px; }
        .hero-left { flex: 1; }
        .hero-title { font-size: 56px; font-weight: 800; color: var(--primary); line-height: 1.1; margin-bottom: 20px; }
        .hero-title span { color: #111111; }
        .hero-subtitle { font-size: 16px; color: #8892A4; line-height: 1.7; max-width: 480px; margin-bottom: 36px; }
        .hero-btns { display: flex; gap: 12px; flex-wrap: wrap; }
        .btn-primary { background: var(--primary); color: #fff; border-radius: 999px; padding: 14px 28px; font-size: 15px; font-weight: 700; text-decoration: none; transition: opacity .2s; display: inline-block; }
        .btn-primary:hover { opacity: .85; }
        .btn-secondary { background: #fff; color: var(--primary); border: 1.5px solid #E8EAF0; border-radius: 999px; padding: 14px 28px; font-size: 15px; font-weight: 700; text-decoration: none; transition: all .2s; display: inline-block; }
        .btn-secondary:hover { border-color: #111111; color: #111111; }

        .hero-right { flex-shrink: 0; position: relative; width: 380px; height: 380px; }
        .blob { position: absolute; border-radius: 60% 40% 55% 45% / 50% 60% 40% 50%; }
        .blob-blue { width: 280px; height: 280px; background: #111111; top: 40px; left: 40px; opacity: .08; }
        .blob-yellow { width: 180px; height: 180px; background: #555555; bottom: 20px; right: 20px; opacity: .1; border-radius: 50% 60% 40% 55% / 55% 45% 60% 40%; }
        .circle { position: absolute; border-radius: 50%; }
        .circle-dark { width: 90px; height: 90px; background: var(--primary); top: 20px; right: 60px; display: flex; align-items: center; justify-content: center; }
        .circle-blue { width: 120px; height: 120px; background: #333333; bottom: 60px; left: 30px; display: flex; align-items: center; justify-content: center; }
        .circle-yellow { width: 70px; height: 70px; background: #888888; top: 140px; left: 140px; display: flex; align-items: center; justify-content: center; }
        .circle-sm { width: 50px; height: 50px; background: #fff; border: 3px solid var(--gray-bg); bottom: 30px; right: 40px; box-shadow: 0 4px 16px rgba(11,27,63,0.12); display: flex; align-items: center; justify-content: center; }
        .stat-bubble { position: absolute; background: #fff; border-radius: 16px; padding: 12px 16px; box-shadow: 0 4px 20px rgba(11,27,63,0.1); }
        .stat-bubble-1 { top: 0; left: 0; }
        .stat-bubble-2 { bottom: 0; right: 0; }
        .stat-num { font-size: 22px; font-weight: 800; color: var(--primary); }
        .stat-lbl { font-size: 11px; color: #8892A4; font-weight: 500; }

        .section { padding: 80px 32px; }
        .section-inner { max-width: 1200px; margin: 0 auto; }
        .section-header { text-align: center; margin-bottom: 56px; }
        .section-tag { display: inline-block; background: rgba(0,0,0,0.07); color: #111111; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 999px; margin-bottom: 12px; letter-spacing: .5px; text-transform: uppercase; }
        .section-title { font-size: 36px; font-weight: 800; color: var(--primary); }
        .section-title span { color: #111111; }
        .section-sub { font-size: 15px; color: #8892A4; margin-top: 10px; }

        .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .feature-card { background: #fff; border-radius: var(--radius); padding: 28px; box-shadow: 0 2px 12px rgba(11,27,63,0.06); transition: transform .2s, box-shadow .2s; display: flex; flex-direction: column; }
        .feature-card img { display: block; margin-bottom: 18px; }
        .feature-card:hover { transform: translateY(-4px); box-shadow: 0 8px 28px rgba(11,27,63,0.1); }
        .feature-icon { width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; }
        .feature-icon.blue { background: rgba(59,110,245,0.12); }
        .feature-icon.green { background: rgba(34,197,94,0.12); }
        .feature-icon.yellow { background: rgba(244,183,64,0.15); }
        .feature-icon.dark { background: rgba(11,27,63,0.08); }
        .feature-icon.purple { background: rgba(139,92,246,0.12); }
        .feature-icon.cyan { background: rgba(6,182,212,0.12); }
        .feature-title { font-size: 16px; font-weight: 700; color: var(--primary); margin-bottom: 8px; }
        .feature-desc { font-size: 13px; color: #8892A4; line-height: 1.65; }

        .roles-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
        .role-card { background: #fff; border-radius: var(--radius); padding: 28px 20px; text-align: center; box-shadow: 0 2px 12px rgba(11,27,63,0.06); transition: transform .2s; display: flex; flex-direction: column; align-items: center; }
        .role-card img { display: block; margin-bottom: 16px; }
        .role-card:hover { transform: translateY(-4px); }
        .role-icon { width: 60px; height: 60px; border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
        .role-icon.red { background: rgba(239,68,68,0.1); }
        .role-icon.blue { background: rgba(59,110,245,0.1); }
        .role-icon.green { background: rgba(34,197,94,0.1); }
        .role-icon.purple { background: rgba(139,92,246,0.1); }
        .role-name { font-size: 16px; font-weight: 700; color: var(--primary); margin-bottom: 6px; }
        .role-desc { font-size: 13px; color: #8892A4; }

        .cta-section { background: var(--primary); padding: 80px 32px; }
        .cta-inner { max-width: 700px; margin: 0 auto; text-align: center; }
        .cta-title { font-size: 40px; font-weight: 800; color: #fff; margin-bottom: 16px; }
        .cta-sub { font-size: 16px; color: rgba(255,255,255,0.6); margin-bottom: 36px; }
        .btn-cta { background: #fff; color: #111111; border-radius: 999px; padding: 14px 32px; font-size: 15px; font-weight: 800; text-decoration: none; display: inline-block; transition: opacity .2s; }
        .btn-cta:hover { opacity: .9; }

        footer { background: #fff; border-top: 1px solid #E8EAF0; padding: 32px; text-align: center; }
        body.dark { background: #111111; color: #fff; }
        body.dark .navbar { background: #1a1a1a; border-color: #2a2a2a; }
        body.dark .nav-link { color: #8892A4; }
        body.dark .nav-link:hover { background: #2a2a2a; color: #fff; }
        body.dark .btn-nav-outline { border-color: #2a2a2a; color: #fff; }
        body.dark .feature-card,
        body.dark .role-card,
        body.dark .stat-bubble { background: #1a1a1a; box-shadow: 0 2px 12px rgba(0,0,0,0.3); }
        body.dark .feature-title,
        body.dark .role-name,
        body.dark .stat-num { color: #fff; }
        body.dark section.section { background: #111111 !important; }
        body.dark footer { background: #1a1a1a; border-color: #2a2a2a; }
        body.dark .logo-text { color: #fff; }
        body.dark .footer-text { color: #8892A4; }
        body:not(.dark) .logo-icon { background: #0B1B3F; }
        body:not(.dark) .logo-text { color: var(--primary); }
        body:not(.dark) .nav-link { color: #8892A4; }
        .footer-logo { display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 10px; }
        .footer-text { font-size: 13px; color: #8892A4; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="navbar-inner">
            <a href="/" class="logo">
                <div class="logo-icon">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/home.png" width="18" height="18" alt="logo">
                </div>
                <span class="logo-text">Smart<span class="logo-dot">.</span>Organizer</span>
            </a>
            <div class="nav-links">
                <a href="#features" class="nav-link">Features</a>
                <a href="#roles" class="nav-link">Who It's For</a>
                <button id="theme-toggle" style="background:#F5F6FA;border:none;border-radius:10px;padding:8px;cursor:pointer;display:flex;align-items:center;justify-content:center">
                    <img id="theme-toggle-dark-icon" src="https://img.icons8.com/fluency/48/moon-symbol.png" width="22" height="22" alt="dark" style="display:none">
                    <img id="theme-toggle-light-icon" src="https://img.icons8.com/ios-filled/50/0b1b3f/sun.png" width="18" height="18" alt="light" style="display:none">
                </button>
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-nav">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-nav-outline">Login</a>
                    <a href="{{ route('register') }}" class="btn-nav">Let's do it</a>
                @endauth
            </div>
        </div>
    </nav>

    <section style="padding-top:68px">
        <div class="hero">
            <div class="hero-left">
                <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 dark:text-white mb-6">
                    Share Locals,<br>
                    <span>Split Costs</span><br>
                    Smartly
                </h1>
                <p class="hero-subtitle">
                    Smart Organizer helps you book sports fields, study rooms, and coworking spaces collaboratively. Join groups, divide costs fairly, and optimize space usage with our intelligent reservation system.
                </p>
                <div class="hero-btns">
                    <a href="{{ route('register') }}" class="btn-primary">Start Organizing</a>
                    <a href="#features" class="btn-secondary">Learn More</a>
                </div>
            </div>
            <div class="hero-right">
                <div class="blob blob-blue"></div>
                <div class="blob blob-yellow"></div>
                <div class="circle circle-dark">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/home.png" width="36" height="36" alt="home">
                </div>
                <div class="circle circle-blue">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/conference-call.png" width="48" height="48" alt="group">
                </div>
                <div class="circle circle-yellow">
                    <img src="https://img.icons8.com/ios-filled/50/0b1b3f/coins.png" width="28" height="28" alt="coins">
                </div>
                <div class="stat-bubble stat-bubble-1">
                    <div class="stat-num">500+</div>
                    <div class="stat-lbl">Active Locals</div>
                </div>
                <div class="stat-bubble stat-bubble-2">
                    <div class="stat-num">2k+</div>
                    <div class="stat-lbl">Users</div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="section" style="background:#fff">
        <div class="section-inner">
            <div class="section-header">
                <div class="section-tag">Features</div>
                <h2 class="section-title"><span>Key</span> Features</h2>
                <p class="section-sub">Everything you need to organize shared spaces efficiently</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div >
                        <img src="https://img.icons8.com/ios-filled/50/3B6EF5/conference-call.png" width="22" height="22" alt="collaborative booking">
                    </div>
                    <div class="feature-title">Collaborative Booking</div>
                    <div class="feature-desc">Create or join group reservations. Share costs automatically with participants and optimize space usage.</div>
                </div>
                <div class="feature-card">
                    <div >
                        <img src="https://img.icons8.com/ios-filled/50/22C55E/coins.png" width="22" height="22" alt="points">
                    </div>
                    <div class="feature-title">Points System</div>
                    <div class="feature-desc">Internal currency for seamless transactions. Members get 50% discount on all reservations.</div>
                </div>
                <div class="feature-card">
                    <div >
                        <img src="https://img.icons8.com/ios-filled/50/8B5CF6/bar-chart.png" width="22" height="22" alt="analytics">
                    </div>
                    <div class="feature-title">Smart Analytics</div>
                    <div class="feature-desc">Track user interest and optimize offerings. Real-time availability dashboard for better decisions.</div>
                </div>
                <div class="feature-card">
                    <div>
                        <img src="https://img.icons8.com/ios-filled/50/0B1B3F/chat.png" width="22" height="22" alt="chat">
                    </div>
                    <div class="feature-title">Group Chat</div>
                    <div class="feature-desc">Coordinate with participants through dedicated chat rooms for each reservation.</div>
                </div>
                <div class="feature-card">
                    <div >
                        <img src="https://img.icons8.com/ios-filled/50/D97706/search.png" width="22" height="22" alt="search">
                    </div>
                    <div class="feature-title">Advanced Search</div>
                    <div class="feature-desc">Filter by city, type, and capacity. Find the perfect space quickly and easily.</div>
                </div>
                <div class="feature-card">
                    <div>
                        <img src="https://img.icons8.com/ios-filled/50/06B6D4/user-group-man-man.png" width="22" height="22" alt="social">
                    </div>
                    <div class="feature-title">Social Network</div>
                    <div class="feature-desc">Build your network, add friends, and transfer points between users seamlessly.</div>
                </div>
            </div>
        </div>
    </section>

    <section id="roles" class="section">
        <div class="section-inner">
            <div class="section-header">
                <div class="section-tag">Roles</div>
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Who Can Use Smart Organizer?</h2>
                <p class="section-sub">A platform built for every type of user</p>
            </div>
            <div class="roles-grid">
                <div class="role-card">
                    <div>
                        <img src="https://img.icons8.com/ios-filled/50/EF4444/admin-settings-male.png" width="28" height="28" alt="admin">
                    </div>
                    <div class="role-name">Admin</div>
                    <div class="role-desc">Manage users and view analytics</div>
                </div>
                <div class="role-card">
                    <div >
                        <img src="https://img.icons8.com/ios-filled/50/3B6EF5/home.png" width="28" height="28" alt="tenant">
                    </div>
                    <div class="role-name">Tenant</div>
                    <div class="role-desc">Manage reservation offers</div>
                </div>
                <div class="role-card">
                    <div >
                        <img src="https://img.icons8.com/ios-filled/50/22C55E/user-male-circle.png" width="28" height="28" alt="lessor">
                    </div>
                    <div class="role-name">Lessor</div>
                    <div class="role-desc">Join groups and book spaces</div>
                </div>
                <div class="role-card">
                    <div >
                        <img src="https://img.icons8.com/ios-filled/50/8B5CF6/star.png" width="28" height="28" alt="member">
                    </div>
                    <div class="role-name">Member</div>
                    <div class="role-desc">Get 50% discount on all bookings</div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="cta-inner">
            <h2 class="cta-title">Ready to Start Organizing?</h2>
            <p class="cta-sub">Join thousands of users who are already sharing locals and saving money.</p>
            <a href="{{ route('register') }}" class="btn-cta">Create Free Account</a>
        </div>
    </section>

    <footer>
        <div class="footer-logo">
            <div class="logo-icon">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/home.png" width="16" height="16" alt="logo">
            </div>
            <span class="logo-text">Smart<span class="logo-dot">.</span>Organizer</span>
        </div>
        <p class="footer-text">&copy; {{ date('Y') }} Smart Organizer. All rights reserved.</p>
        <p class="footer-text" style="margin-top:4px">Share Locals. Split Costs. Organize Smartly.</p>
    </footer>

<script>
    const themeToggle = document.getElementById('theme-toggle');
    const darkIcon    = document.getElementById('theme-toggle-dark-icon');
    const lightIcon   = document.getElementById('theme-toggle-light-icon');

    if (localStorage.getItem('theme') === 'dark') {
        document.body.classList.add('dark');
        darkIcon.style.display = 'block';
    } else {
        lightIcon.style.display = 'block';
    }

    themeToggle.addEventListener('click', function () {
        const current = localStorage.getItem('theme');
        if (current === 'dark') {
            localStorage.setItem('theme', 'light');
            document.body.classList.remove('dark');
            darkIcon.style.display = 'block';
            lightIcon.style.display = 'none';
        } else {
            localStorage.setItem('theme', 'dark');
            document.body.classList.add('dark');
            lightIcon.style.display = 'block';
            darkIcon.style.display = 'none';
        }
    });
</script>
</body>
</html>
