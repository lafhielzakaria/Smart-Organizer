<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Smart Organizer')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=antonio:400,700&family=barlow-condensed:400,600,700&family=inter:400,500,600,700" rel="stylesheet" />
    @yield('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --gold: #C9A84C;
            --gold-bright: #F0C040;
            --black-nav: #0D0D10;
            --border: rgba(201, 168, 76, 0.2);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #060608;
            min-height: 100vh;
            color: #fff;
        }

        /* ─── NEW LUXURY NAVBAR ─── */
        .navbar {
            background: var(--black-nav);
            padding: 0 40px;
            height: 75px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid var(--border);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .navbar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .navbar-logo-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #1A1A26, #0D0D10);
            border: 1px solid var(--gold);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 15px rgba(201, 168, 76, 0.1);
        }

        .navbar-logo-text {
            font-family: 'Antonio', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* ─── CHARGE BTN (STADIUM STYLE) ─── */
        .btn-charge {
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(201, 168, 76, 0.1);
            border: 1px solid var(--gold-line);
            width: 44px;
            height: 44px;
            border-radius: 4px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-charge:hover {
            background: var(--gold);
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(201, 168, 76, 0.4);
        }

        .btn-charge:hover img {
            filter: brightness(0);
        }

        /* Icon turns black on hover */

        .balance-display {
            display: flex;
            align-items: center;
            padding: 8px 16px;
            background: #16161E;
            border: 1px solid var(--border);
            border-radius: 4px;
            gap: 8px;
        }

        .balance-text {
            color: var(--gold-bright);
            font-family: 'Antonio', sans-serif;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .btn-logout {
            padding: 10px 20px;
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            color: rgba(255, 255, 255, 0.6);
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all .3s;
        }

        .btn-logout:hover {
            border-color: #ff4444;
            color: #ff4444;
            background: rgba(255, 68, 68, 0.05);
        }

        /* ─── BACK ARROW STYLE ─── */
        .nav-back-link {
            color: var(--muted);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: 0.3s;
        }

        .nav-back-link:hover {
            color: var(--gold);
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="navbar-left">
            <a href="{{ url('/') }}" class="navbar-logo">
                <div class="navbar-logo-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C9A84C" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </div>
                <span class="navbar-logo-text">SMART<span style="color:var(--gold)">.</span>ORGANIZER</span>
            </a>
        </div>

        <div class="navbar-right">
            @yield('nav-actions')
            @auth
            @if(Auth::user()->role && Auth::user()->role->name !== 'Admin')
            <a href="{{ route('points.charge') }}" class="btn-charge" title="Charge Points">
                <img src="https://img.icons8.com/ios-filled/50/C9A84C/coins.png" width="22" height="22" alt="coins">
            </a>

            <div class="balance-display">
                <span class="balance-text">{{ Auth::user()->balance ?? 0 }} <small style="font-size: 10px; color:rgba(255,255,255,0.4)">SP</small></span>
            </div>
            @endif

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
            @endauth
        </div>
    </nav>

    @yield('content')
</body>

</html>