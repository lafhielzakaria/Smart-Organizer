<x-guest-layout>
    <a href="{{ url('/') }}" class="auth-back">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back to Home
    </a>

    <h1>Welcome back</h1>
    <p class="auth-sub">Sign in to your Smart Organizer account</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="/login">
        @csrf

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="off" placeholder="you@example.com">
        <x-input-error :messages="$errors->get('email')" class="mb-3" />

        <label for="password">Password</label>
        <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
        <x-input-error :messages="$errors->get('password')" class="mb-3" />

        <div class="auth-remember">
            <label>
                <input type="checkbox" name="remember" style="width:auto;margin:0">
                Remember me
            </label>
            @if (Route::has('password.request'))
                <a href="#">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="btn-submit">Sign In</button>

        <div class="auth-footer">
            Don't have an account? <a href="/register">Sign up</a>
        </div>
    </form>
</x-guest-layout>
