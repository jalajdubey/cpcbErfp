@extends('layouts.app')

@section('title', 'Verify OTP')
@section('body-class', 'verify-otp-page')

@section('content')
<div class="container d-flex align-items-center justify-content-center mt-5 mb-5">
    <div class="login-container shadow-sm p-4 rounded bg-white" style="max-width: 450px; width: 100%;">
        <h4 class="text-center fw-semibold text-primary mb-4">
            <i class="bi bi-shield-lock-fill me-2"></i> Verify OTP
        </h4>

        <form action="{{ route('verify-otp') }}" method="POST" id="verifyOtpForm">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') }}">
            <input type="hidden" name="userId" value="{{ session('userId') }}">

            <div class="form-group mb-3">
                <label for="otp" class="form-label fw-semibold">Enter OTP</label>
                <input type="text" class="form-control form-control-lg text-center" id="otp" name="otp"
                       maxlength="6" placeholder="Enter 6-digit OTP" required>
            </div>

            <div class="d-flex align-items-center gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check2-circle me-1"></i> Verify OTP
                </button>

                <button id="resendOtp" type="button" class="btn btn-outline-warning px-4">
                    <span class="spinner-border spinner-border-sm me-2 d-none" id="resendSpinner" role="status" aria-hidden="true"></span>
                    <span id="resendText">Resend OTP</span>
                </button>

                <small id="otpTimer" class="text-muted ms-2"></small>
            </div>
        </form>
    </div>
</div>
@if (app()->environment('local') && session('dev_otp'))
    <div style="color:green; font-weight:bold;">
        Test OTP: {{ session('dev_otp') }}
    </div>
@endif

@if ($errors->has('otp'))
<script>
document.addEventListener('DOMContentLoaded', () => {
    Swal.fire({
        title: 'OTP Error',
        html: `<ul>@foreach ($errors->get('otp') as $error)<li>{{ $error }}</li>@endforeach</ul>`,
        icon: 'error',
        confirmButtonText: 'Close'
    });
});
</script>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const resendBtn = document.getElementById('resendOtp');
    const resendSpinner = document.getElementById('resendSpinner');
    const resendText = document.getElementById('resendText');
    const timerSpan = document.getElementById('otpTimer');
    let cooldownInterval;

    function startOtpCooldown(seconds) {
        clearInterval(cooldownInterval);
        resendBtn.disabled = true;
        timerSpan.innerText = `Please wait ${seconds}s`;

        cooldownInterval = setInterval(() => {
            seconds--;
            timerSpan.innerText = `Please wait ${seconds}s`;
            if (seconds <= 0) {
                clearInterval(cooldownInterval);
                resendBtn.disabled = false;
                timerSpan.innerText = '';
            }
        }, 1000);
    }

    resendBtn.addEventListener('click', async (e) => {
        e.preventDefault();
        resendBtn.disabled = true;
        resendSpinner.classList.remove('d-none');
        resendText.textContent = 'Sending...';

        try {
            const response = await fetch("{{ route('resend-otp') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            });

            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'Failed to resend OTP');

            Swal.fire('OTP Sent', data.message || 'OTP has been resent successfully.', 'success');
            startOtpCooldown(30);

        } catch (error) {
            Swal.fire('Error', error.message || 'Failed to resend OTP. Please try again.', 'error');
            resendBtn.disabled = false;
        } finally {
            resendSpinner.classList.add('d-none');
            resendText.textContent = 'Resend OTP';
        }
    });
});
</script>
@endpush
