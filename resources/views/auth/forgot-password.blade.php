@include('home.header')

<style>
    /* Style adjustments can be made here */
</style>
</head>
<body>
    <!-- Navbar -->
   
    <div class="d-flex align-items-center justify-content-center mt-5">
        <div class="login-container">
            <h2>Forgot Your Password?</h2>
            <p>Enter your email address to receive a password reset link.</p>
            
            <!-- Success Message -->
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <!-- Error Message for Rate Limiting -->
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" type="email" name="email" class="form-control" required autofocus>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-3">Send Password Reset Link</button>
            </form>
        </div>
    </div>

@include('home.footer')
