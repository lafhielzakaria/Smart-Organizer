<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Smart Organizer')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet"/>
    @yield('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #F5F5F5; min-height: 100vh; color: #111; }
        .navbar {
            background: #111;
            padding: 0 32px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .navbar-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .navbar-logo-icon { width: 34px; height: 34px; background: #333; border: 2px solid #fff; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
        .navbar-logo-text { font-size: 18px; font-weight: 800; color: #fff; }
        .navbar-right { display: flex; align-items: center; gap: 16px; }
        .balance-display { display: flex; align-items: center; gap: 8px; padding: 8px 12px; background: rgba(255,255,255,0.1); border-radius: 8px; }
        .balance-icon { width: 20px; height: 20px; }
        .balance-text { color: #fff; font-size: 14px; font-weight: 600; }
        .btn-logout { padding: 7px 16px; background: transparent; border: 1.5px solid rgba(255,255,255,0.2); border-radius: 8px; color: #fff; font-size: 13px; font-weight: 600; cursor: pointer; transition: all .2s; }
        .btn-logout:hover { background: rgba(255,255,255,0.1); }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="#" class="navbar-logo">
        <div class="navbar-logo-icon">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/home.png" width="18" height="18" alt="logo">
        </div>
        <span class="navbar-logo-text">Smart<span style="color:rgba(255,255,255,0.5)">.</span>Organizer</span>
    </a>
    <div class="navbar-right">
        @yield('nav-actions')
        @auth
        <div class="balance-display">
            <img src="https://img.icons8.com/ios-filled/50/FFD700/coins.png" class="balance-icon" alt="coins">
            <span class="balance-text">{{ Auth::user()->balance ?? 0 }}</span>
        </div>
        @endauth
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>
</nav>

@yield('content')

</body>
</html>
