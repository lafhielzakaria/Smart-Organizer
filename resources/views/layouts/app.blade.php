<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Smart Organizer')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=antonio:400,700&family=barlow-condensed:400,600,700&family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/layout-app.css', 'resources/css/app.css', 'resources/js/app.js'])
    @yield('head')
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
            @if(Auth::user()->role && Auth::user()->role->name === 'Lessor')
                @if(!Auth::user()->isMember)
                <a href="{{ route('membership.benefits') }}" class="btn-charge" title="Membership Benefits">
                    <img src="https://img.icons8.com/ios-filled/50/C9A84C/vip.png" width="22" height="22" alt="member">
                </a>
                @endif
            @endif
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