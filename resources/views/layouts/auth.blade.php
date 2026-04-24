<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Smart Organizer')</title>
    <link href="https://fonts.bunny.net/css?family=antonio:400,500,600,700&family=barlow-condensed:400,500,600,700,800,900&family=barlow:400,500,600" rel="stylesheet">
    @vite(['resources/css/layout-auth.css', 'resources/js/layout-auth.js'])
</head>
<body>
    <div class="beams">
        <div class="beam"></div>
        <div class="beam"></div>
        <div class="beam"></div>
    </div>
    <div class="stripe-bg"></div>
    <div class="auth-wrapper">
        @yield('content')
    </div>
</body>
</html>
