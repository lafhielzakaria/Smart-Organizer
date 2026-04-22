@extends('layouts.auth')
@section('title', 'Sign Up - Smart Organizer')
@section('content')
<div class="auth-container">
    <a href="/" class="back-link">← Back to Home</a>
    
    <div class="auth-split">
        <div class="auth-left">
            <div class="auth-left-content">
                <div class="auth-logo-container">
                    <div class="auth-logo">Smart Organizer</div>
                </div>
                <h2 class="auth-welcome">Join Us Today</h2>
                <p class="auth-tagline">Create your account and start organizing your spaces with our powerful platform.</p>
                <div class="auth-features">
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Browse local spaces</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Connect with friends</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Real-time collaboration</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="auth-right">
            <div class="auth-form-container">
                <div class="auth-header">
                    <h1 class="auth-title">Create Account</h1>
                    <p class="auth-subtitle">Fill in your details to get started</p>
                </div>
                
                <form method="POST" action="{{ route('register') }}" class="auth-form">
                    @csrf
                    
                    <div class="form-group">
                        <label for="name" class="label">Full Name</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            class="input" 
                            value="{{ old('name') }}" 
                            placeholder="Enter your full name"
                            required 
                            autofocus
                        >
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
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
                            placeholder="Create a password"
                            required
                        >
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation" class="label">Confirm Password</label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            class="input" 
                            placeholder="Confirm your password"
                            required
                        >
                    </div>
                    
                    <button type="submit" class="btn-submit">Create Account</button>
                    
                    <div class="auth-footer-link">
                        <span class="auth-link">Already have an account? <a href="{{ route('login') }}" class="auth-link-highlight">Sign In</a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
