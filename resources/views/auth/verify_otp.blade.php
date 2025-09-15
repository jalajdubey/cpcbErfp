@include('home.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="d-flex align-items-center justify-content-center mt-5">
        <div class="login-container">
            <h1 class="mb-4 text-center">Verify OTP</h1>

            <form action="{{ route('verify-otp') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ session('email') }}">
                <input type="hidden" name="userId" value="{{ session('userId') }}">

                <div class="form-group mb-3">
                    <input type="text" class="form-control form-control-lg" id="otp" name="otp" placeholder="Enter OTP" required>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-shield-lock-fill me-1"></i> Verify OTP
                    </button>

                    <button id="resendOtp" type="button" class="btn btn-warning px-4">
                        <span class="spinner-border spinner-border-sm me-2 d-none" id="resendSpinner" role="status" aria-hidden="true"></span>
                        <span id="resendText">Resend OTP</span>
                    </button>

                    <span id="otpTimer" class="ms-2 small text-muted"></span>
                </div>
            </form>
        </div>
    </div>

    @if ($errors->has('otp'))
        <script>
            Swal.fire({
                title: 'OTP Error',
                html: `<ul>@foreach ($errors->get('otp') as $error)<li>{{ $error }}</li>@endforeach</ul>`,
                icon: 'error',
                confirmButtonText: 'Close'
            });
        </script>
    @endif

    <script>
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

        resendBtn.addEventListener('click', function (e) {
    e.preventDefault();

    resendBtn.disabled = true;
    resendSpinner.classList.remove('d-none');
    resendText.textContent = 'Sending...';

    fetch("{{ route('resend-otp') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        credentials: 'same-origin',  // Important for session cookies!
        body: JSON.stringify({})
    })
    .then(res => {
        return res.json().then(data => {
            if (!res.ok) throw new Error(data.message || 'Failed to resend OTP');
            return data;
        });
    })
    .then(data => {
        Swal.fire('OTP Sent', data.message || 'OTP has been resent successfully.', 'success');
        startOtpCooldown(30);
    })
    .catch(error => {
        Swal.fire('Error', error.message || 'Failed to resend OTP. Please try again.', 'error');
        resendBtn.disabled = false;
    })
    .finally(() => {
        resendSpinner.classList.add('d-none');
        resendText.textContent = 'Resend OTP';
    });
});

        // Optional: pre-lock if needed
        // startOtpCooldown(30);
    </script>
</body>
