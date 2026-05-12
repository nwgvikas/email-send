@extends('layouts.app')

@php
    $siteBranding = $siteBranding ?? [
        'site_name' => config('app.name', 'Laravel'),
        'logo_url' => null,
        'favicon_url' => null,
    ];
@endphp

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-lg-10 col-xl-9">
            <div class="row g-0 bo-login-card">
                <div class="col-md-5 d-none d-md-flex flex-column justify-content-center p-5 text-white" style="background: linear-gradient(160deg, #1e3a8a 0%, #4c1d95 100%);">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        @if (! empty($siteBranding['logo_url']))
                            <img src="{{ $siteBranding['logo_url'] }}" alt="" style="height: 44px; width: auto; max-width: 160px; object-fit: contain;">
                        @endif
                        <span class="fw-bold fs-5" style="letter-spacing: -0.02em;">{{ $siteBranding['site_name'] }}</span>
                    </div>
                    <h2 class="fw-bold mb-3" style="letter-spacing: -0.03em;">Welcome back</h2>
                    <p class="mb-0" style="color: rgba(255,255,255,0.78);">Sign in to manage your bulk email backoffice — contacts, templates, and campaigns in one place.</p>
                </div>
                <div class="col-md-7 p-4 p-md-5 bg-white">
                    <div class="d-flex d-md-none align-items-center gap-2 mb-3 pb-3 border-bottom">
                        @if (! empty($siteBranding['logo_url']))
                            <img src="{{ $siteBranding['logo_url'] }}" alt="" style="height: 36px; width: auto; max-width: 140px; object-fit: contain;">
                        @endif
                        <span class="fw-bold text-secondary">{{ $siteBranding['site_name'] }}</span>
                    </div>
                    <div class="mb-4">
                        <h3 class="fw-bold mb-1" style="letter-spacing: -0.03em;">{{ __('Login') }}</h3>
                        <p class="text-muted mb-0 small">Enter your credentials to continue.</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="you@company.com">

                            @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">

                            @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label small" for="remember">{{ __('Remember Me') }}</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="small text-decoration-none fw-semibold" style="color: var(--bo-primary);" href="{{ route('password.request') }}">{{ __('Forgot Password?') }}</a>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 py-2">{{ __('Login') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
