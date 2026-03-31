<x-guest-layout>
    <a href="{{ url('/') }}" class="auth-back">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back to Home
    </a>

    <h1>Create account</h1>
    <p class="auth-sub">Join Smart Organizer and start organizing</p>

    <form method="POST" action="/register">
        @csrf

        <label for="name">Full Name</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe">
        <x-input-error :messages="$errors->get('name')" class="mb-3" />

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="you@example.com">
        <x-input-error :messages="$errors->get('email')" class="mb-3" />

        <label for="role_id">Role</label>
        <select id="role_id" name="role_id" required>
            <option value="">Select your role</option>
            <option value="2" {{ old('role_id') == '2' ? 'selected' : '' }}>Tenant</option>
            <option value="3" {{ old('role_id') == '3' ? 'selected' : '' }}>Lessor</option>
        </select>
        <x-input-error :messages="$errors->get('role_id')" class="mb-3" />

        <label for="password">Password</label>
        <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
        <x-input-error :messages="$errors->get('password')" class="mb-3" />

        <label for="password_confirmation">Confirm Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
        <x-input-error :messages="$errors->get('password_confirmation')" class="mb-3" />

        <button type="submit" class="btn-submit">Create Account</button>

        <div class="auth-footer">
            Already have an account? <a href="/login">Sign in</a>
        </div>
    </form>
</x-guest-layout>
