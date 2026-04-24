<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Organizer - Welcome</title>
    <link href="https://fonts.bunny.net/css?family=antonio:400,500,600,700&family=barlow-condensed:400,500,600,700,800,900&family=barlow:400,500,600" rel="stylesheet">
    @vite(['resources/css/welcome.css', 'resources/js/welcome.js'])
</head>
<body>
    <header class="header">
        <div class="header-inner">
            <a href="/" class="header-logo">
                <div class="header-logo-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C9A84C" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </div>
                <span class="header-logo-text">SMART<span style="color:var(--gold)">.</span>ORGANIZER</span>
            </a>
            <button class="mobile-menu-btn" onclick="toggleMenu()">☰</button>
            <nav class="header-nav" id="headerNav">
                @auth
                    <a href="{{ route('lessor.dashboard') }}" class="nav-link primary">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline">
                        @csrf
                        <button type="submit" class="nav-link" style="background:none;cursor:pointer">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                    <a href="{{ route('register') }}" class="nav-link primary">Sign Up</a>
                @endauth
            </nav>
        </div>
    </header>

    <section class="hero-section">
        <div class="beams">
            <div class="beam"></div>
            <div class="beam"></div>
            <div class="beam"></div>
            <div class="beam"></div>
            <div class="beam"></div>
        </div>
        <div class="stripe-bg"></div>
        <div class="hero-content">
            <div class="logo-section">
                <div class="logo">
                    <div class="logo-icon">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#C9A84C" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </div>
                    <span class="logo-text">SMART<span style="color:var(--gold)">.</span>ORGANIZER</span>
                </div>
            </div>
            <h1 class="hero-title">Organize Your <span>Space</span></h1>
            <p class="hero-subtitle">Connect with local spaces, manage offers, and collaborate with friends in real-time. Your smart solution for space management.</p>
            <div class="hero-buttons">
                @auth
                    <a href="{{ route('lessor.dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Get Started</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">Sign Up</a>
                @endauth
            </div>
        </div>
    </section>

    <section class="features-section">
        <div class="features-container">
            <div class="section-header">
                <span class="section-eyebrow">Why Choose Us</span>
                <h2 class="section-title">Powerful Features</h2>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/3774/3774299.png" alt="Local Spaces">
                    </div>
                    <h3 class="feature-title">Local Spaces</h3>
                    <p class="feature-desc">Browse and apply to available local spaces with detailed information and real-time availability.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/1041/1041916.png" alt="Real-Time Chat">
                    </div>
                    <h3 class="feature-title">Real-Time Chat</h3>
                    <p class="feature-desc">Communicate instantly with group members through our integrated WebSocket-powered chat system.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/681/681494.png" alt="Friend System">
                    </div>
                    <h3 class="feature-title">Friend System</h3>
                    <p class="feature-desc">Connect with friends, send invitations, and collaborate on offers together seamlessly.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <p class="footer-text">© 2024 Smart Organizer · All Rights Reserved</p>
    </footer>
</body>
</html>
