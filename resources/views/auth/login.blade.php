@extends('layouts.auth')
@section('title', 'Login - Smart Organizer')
@section('content')
<div class="auth-container">
    <a href="/" class="back-link">← Back to Home</a>
    
    <div class="auth-split">
        <div class="auth-left">
            <div class="auth-left-content">
                <div class="auth-logo-container">
                    <div class="auth-logo">Smart Organizer</div>
                </div>
                <h2 class="auth-welcome">Welcome Back</h2>
                <p class="auth-tagline">Sign in to access your dashboard and manage your spaces efficiently.</p>
                <div class="auth-features">
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Access your dashboard</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Manage local offers</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Real-time group chat</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="auth-right">
            <div class="auth-form-container">
                <div class="auth-header">
                    <h1 class="auth-title">Sign In</h1>
                    <p class="auth-subtitle">Enter your credentials to continue</p>
                </div>
                
                <form method="POST" action="{{ route('login') }}" class="auth-form">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email" class="label">Email Address</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="input" 
                            value="{{ old('email') }}" 
                            placeholder="Enter your email"
                            required 
                            autofocus
                        >
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="label">Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="input" 
                            placeholder="Enter your password"
                            required
                        >
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn-submit">Sign In</button>
                    
                    <div class="auth-footer-link">
                        <span class="auth-link">Don't have an account? <a href="{{ route('register') }}" class="auth-link-highlight">Sign Up</a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
