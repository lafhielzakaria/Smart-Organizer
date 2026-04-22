<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Organizer - Welcome</title>
    <link href="https://fonts.bunny.net/css?family=antonio:400,500,600,700&family=barlow-condensed:400,500,600,700,800,900&family=barlow:400,500,600" rel="stylesheet">
    <style>
        :root{--gold:#C9A84C;--gold-bright:#F0C040;--gold-dim:rgba(201,168,76,0.12);--gold-line:rgba(201,168,76,0.35);--black:#060608;--dark:#0D0D10;--panel:#12121A;--panel2:#1A1A26;--white:#FFFFFF;--muted:rgba(255,255,255,0.38)}*{box-sizing:border-box;margin:0;padding:0}body{background:var(--black);font-family:'Barlow Condensed',sans-serif;color:var(--white);overflow-x:hidden}.header{position:fixed;top:0;left:0;right:0;z-index:1000;background:rgba(6,6,8,0.95);backdrop-filter:blur(10px);border-bottom:1px solid rgba(255,255,255,0.05);animation:slideDown 0.6s ease both}@keyframes slideDown{from{opacity:0;transform:translateY(-20px)}to{opacity:1;transform:translateY(0)}}.header-inner{max-width:1400px;margin:0 auto;padding:18px 28px;display:flex;align-items:center;justify-content:space-between}.header-logo{display:flex;align-items:center;gap:12px;text-decoration:none}.header-logo-icon{width:38px;height:38px;background:linear-gradient(135deg,#1A1A26,#0D0D10);border:1px solid var(--gold);border-radius:8px;display:flex;align-items:center;justify-content:center;box-shadow:0 0 15px rgba(201,168,76,0.1);transition:all 0.3s}.header-logo-text{font-family:'Antonio',sans-serif;font-size:20px;font-weight:700;color:#fff;text-transform:uppercase;letter-spacing:1px}.header-logo:hover .header-logo-icon{box-shadow:0 0 25px rgba(201,168,76,0.3);transform:scale(1.05)}.header-nav{display:flex;gap:8px;align-items:center}.nav-link{padding:10px 20px;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;text-decoration:none;color:var(--muted);border-radius:3px;transition:all 0.3s;border:1px solid transparent}.nav-link:hover{color:var(--gold-bright);background:var(--gold-dim);border-color:var(--gold-line)}.nav-link.primary{background:var(--gold);color:#000;border:none}.nav-link.primary:hover{background:var(--gold-bright);box-shadow:0 4px 20px rgba(201,168,76,0.3)}.hero-section{min-height:100vh;position:relative;display:flex;align-items:center;justify-content:center;overflow:hidden;padding-top:80px}.beams{position:absolute;top:-10%;left:50%;transform:translateX(-50%);width:120%;height:100%;pointer-events:none;z-index:0}.beam{position:absolute;top:0;transform-origin:top center;opacity:0;animation:beamSweep 8s infinite ease-in-out}.beam::after{content:'';position:absolute;top:0;left:50%;transform:translateX(-50%);width:200px;height:100vh;background:linear-gradient(180deg,rgba(201,168,76,0.18) 0%,transparent 75%);clip-path:polygon(50% 0%,100% 100%,0% 100%)}.beam:nth-child(1){left:15%;animation-delay:0s;animation-duration:7s}.beam:nth-child(2){left:30%;animation-delay:1.5s;animation-duration:9s}.beam:nth-child(3){left:50%;animation-delay:0.8s;animation-duration:8s}.beam:nth-child(4){left:70%;animation-delay:2.2s;animation-duration:7.5s}.beam:nth-child(5){left:85%;animation-delay:0.4s;animation-duration:10s}@keyframes beamSweep{0%{opacity:0;transform:rotate(-18deg)}20%{opacity:1}50%{opacity:0.55;transform:rotate(18deg)}80%{opacity:1}100%{opacity:0;transform:rotate(-18deg)}}.stripe-bg{position:absolute;inset:0;background-image:repeating-linear-gradient(-55deg,transparent,transparent 40px,rgba(201,168,76,0.018) 40px,rgba(201,168,76,0.018) 41px);pointer-events:none;z-index:0}.hero-content{position:relative;z-index:2;text-align:center;padding:40px 20px;max-width:900px;animation:revealUp 1s ease both}.logo-section{margin-bottom:30px;animation:revealUp 0.8s ease both}.logo{display:flex;align-items:center;gap:16px;justify-content:center}.logo-icon{width:50px;height:50px;background:linear-gradient(135deg,#1A1A26,#0D0D10);border:1px solid var(--gold);border-radius:8px;display:flex;align-items:center;justify-content:center;box-shadow:0 0 20px rgba(201,168,76,0.2)}.logo-text{font-family:'Antonio',sans-serif;font-size:clamp(24px,4vw,32px);font-weight:700;color:#fff;text-transform:uppercase;letter-spacing:1px}.hero-title{font-family:'Antonio',sans-serif;font-size:clamp(48px,10vw,96px);font-weight:700;color:var(--white);text-transform:uppercase;letter-spacing:-2px;line-height:1;margin-bottom:20px;animation:revealUp 1s 0.2s ease both}.hero-title span{color:var(--gold-bright);position:relative;display:inline-block}.hero-title span::after{content:'';position:absolute;bottom:-8px;left:0;right:0;height:4px;background:linear-gradient(90deg,var(--gold-bright),var(--gold));animation:underlineGrow 1s 0.8s ease both;transform-origin:left;transform:scaleX(0)}@keyframes underlineGrow{to{transform:scaleX(1)}}.hero-subtitle{font-size:clamp(16px,3vw,22px);color:var(--muted);line-height:1.6;margin-bottom:40px;letter-spacing:1px;animation:revealUp 1s 0.4s ease both}.hero-buttons{display:flex;gap:16px;justify-content:center;flex-wrap:wrap;animation:revealUp 1s 0.6s ease both}.btn{padding:16px 32px;font-family:'Antonio',sans-serif;font-size:13px;font-weight:700;letter-spacing:3px;text-transform:uppercase;text-decoration:none;border-radius:3px;transition:all 0.3s;cursor:pointer;position:relative;overflow:hidden;display:inline-block}.btn-primary{background:var(--gold);color:#000;border:none}.btn-primary::before{content:'';position:absolute;top:0;left:-100%;width:60%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,0.3),transparent);transition:left 0s}.btn-primary:hover::before{left:160%;transition:left 0.5s ease}.btn-primary:hover{background:var(--gold-bright);box-shadow:0 8px 30px rgba(201,168,76,0.4);transform:translateY(-3px)}.btn-secondary{background:transparent;color:var(--white);border:2px solid var(--gold-line)}.btn-secondary:hover{border-color:var(--gold);background:var(--gold-dim);transform:translateY(-3px)}.features-section{position:relative;z-index:2;padding:100px 20px;background:linear-gradient(180deg,var(--black),var(--dark))}.features-container{max-width:1200px;margin:0 auto}.section-header{text-align:center;margin-bottom:60px}.section-eyebrow{display:block;font-size:11px;font-weight:700;letter-spacing:5px;text-transform:uppercase;color:var(--gold);margin-bottom:12px}.section-title{font-family:'Antonio',sans-serif;font-size:clamp(32px,6vw,52px);font-weight:700;color:var(--white);text-transform:uppercase;letter-spacing:-1px}.features-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:24px}.feature-card{background:var(--panel);border:1px solid rgba(255,255,255,0.07);border-radius:3px;padding:32px;transition:all 0.3s;cursor:pointer;animation:revealUp 0.6s ease both}.feature-card:nth-child(1){animation-delay:0.1s}.feature-card:nth-child(2){animation-delay:0.2s}.feature-card:nth-child(3){animation-delay:0.3s}.feature-card:hover{border-color:var(--gold);transform:translateY(-8px);box-shadow:0 12px 40px rgba(0,0,0,0.6)}.feature-icon{width:70px;height:70px;background:var(--gold-dim);border:1px solid var(--gold-line);border-radius:3px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;transition:all 0.3s;padding:12px}.feature-icon img{width:100%;height:100%;object-fit:contain;filter:brightness(0) saturate(100%) invert(73%) sepia(28%) saturate(612%) hue-rotate(8deg) brightness(95%) contrast(87%);transition:all 0.3s}.feature-card:hover .feature-icon{background:var(--gold);transform:scale(1.1) rotate(5deg)}.feature-card:hover .feature-icon img{filter:brightness(0) saturate(100%) invert(0%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(0%) contrast(100%)}.feature-title{font-family:'Antonio',sans-serif;font-size:20px;font-weight:700;color:var(--white);text-transform:uppercase;letter-spacing:1px;margin-bottom:12px}.feature-desc{font-size:14px;color:var(--muted);line-height:1.6}.footer{position:relative;z-index:2;padding:40px 20px;text-align:center;border-top:1px solid rgba(255,255,255,0.05);background:var(--black)}.footer-text{font-size:12px;color:var(--muted);letter-spacing:2px}@keyframes revealUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}@keyframes logoShimmer{to{left:200%}}@keyframes logoFloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}.mobile-menu-btn{display:none;background:none;border:1px solid var(--gold-line);color:var(--gold);padding:8px 12px;border-radius:3px;cursor:pointer;font-size:18px;transition:all 0.3s}.mobile-menu-btn:hover{background:var(--gold-dim);border-color:var(--gold)}@media (max-width:768px){.hero-buttons{flex-direction:column;align-items:center}.btn{width:100%;max-width:300px}.header-nav{position:fixed;top:70px;left:0;right:0;background:rgba(6,6,8,0.98);backdrop-filter:blur(10px);flex-direction:column;padding:20px;border-bottom:1px solid rgba(255,255,255,0.05);transform:translateY(-100%);opacity:0;pointer-events:none;transition:all 0.3s}.header-nav.active{transform:translateY(0);opacity:1;pointer-events:all}.mobile-menu-btn{display:block}.nav-link{width:100%;text-align:center}}
    </style>
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

    <script>
        function toggleMenu() {
            const nav = document.getElementById('headerNav');
            nav.classList.toggle('active');
        }
    </script>
</body>
</html>
