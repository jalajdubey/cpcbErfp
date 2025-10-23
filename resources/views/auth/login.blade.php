@extends('layouts.app')

@section('title', 'Login')
@section('body-class', 'login-page')

@section('content')
<style>
    #captchaWrapper {
        transition: opacity 0.2s ease-in-out;
        display: inline-block;
    }
    .login-container {
        background: #ffffff;
        border-radius: 8px;
        padding: 2rem;
        max-width: 420px;
        width: 100%;
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.15);
    }
    body.login-page {
        background: #f5f7fa;
    }
</style>

<div class="d-flex align-items-center justify-content-center my-5 py-4">
    <div class="login-container">
        {{-- Flash Messages --}}
        @include('layouts.flash-message')

        @if($errors->has('email'))
            <div class="alert alert-danger">
                {{ $errors->first('email') }}
            </div>
        @endif

        <h4 class="text-center mb-3 fw-semibold text-primary">
            <i class="fas fa-user-lock"></i> Sign In
        </h4>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('login') }}" method="POST" autocomplete="off">
            @csrf

            {{-- Email --}}
            <div class="form-group mb-3">
                <label for="email" class="form-label">
                    <i class="fas fa-user me-1"></i> Email
                    <span class="text-danger">*</span>
                </label>
                <input type="email" name="email" id="email"
                       class="form-control" placeholder="Enter your email"
                       value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group mb-3">
                <label for="password" class="form-label">
                    <i class="fas fa-lock me-1"></i> Password
                    <span class="text-danger">*</span>
                </label>
                <input type="password" name="password" id="password"
                       class="form-control" placeholder="Enter Password"
                       autocomplete="new-password" required>
                @error('password')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Captcha --}}
            @if(!env('DEV_ENVIRONMENT'))
                <div class="form-group mb-3">
                    <label>Captcha</label>
                    <div class="d-flex align-items-center" id="captchaWrapper">
                        <span id="captchaImage">{!! captcha_img('flat') !!}</span>
                        <button type="button" class="btn btn-outline-warning ms-2" id="reloadCaptcha">Refresh</button>
                    </div>
                    <input type="text" name="captcha" class="form-control mt-2" placeholder="Enter Captcha" required>
                    @error('captcha')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            @else
                <div class="text-muted small mb-3">
                    Application is in <strong>DEV MODE</strong>, captcha and OTP disabled.
                </div>
            @endif

            {{-- Submit --}}
            <div class="d-flex justify-content-between align-items-center mt-4">
                <button type="submit" class="btn btn-success px-4 text-white">Sign In</button>
                <a href="{{ url('forgot-password') }}" class="text-decoration-none">Forgot Password?</a>
            </div>
        </form>
    </div>
</div>

{{-- Page-Specific Script --}}
<script>
    // Auto fade out flash alerts
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            alert.style.transition = "opacity 0.5s ease-out";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);

    // Captcha reload logic
    const reloadBtn = document.getElementById('reloadCaptcha');
    const captchaImage = document.getElementById('captchaImage');

    if (reloadBtn && captchaImage) {
        reloadBtn.addEventListener('click', () => {
            fetch('{{ route('refresh.capctha') }}')
                .then(res => res.json())
                .then(data => {
                    const temp = document.createElement('div');
                    temp.innerHTML = data.captcha;
                    const newImg = temp.querySelector('img');
                    const oldImg = captchaImage.querySelector('img');
                    if (newImg && oldImg) oldImg.src = newImg.src;
                });
        });
    }
</script>
@endsection
