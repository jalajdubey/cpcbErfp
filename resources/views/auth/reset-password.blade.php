@include('home.header')
<style>

    </style>
</head>
<body>
     <!-- Navbar -->
   
    
     <div  class="d-flex align-items-center justify-content-center mt-5">
        <!-- <div class="box h-75 "><img src="{% static 'img/finance2.png' %}" alt="" class="rounded  blur-image"></div> -->
        <div class="login-container">
        <h2>Reset Password</h2>
    <form method="POST" action="{{ route('password.forgot') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group">
            <label for="email">Email Address</label>
            <input id="email" type="email" name="email" class="form-control" value="{{ $email ?? old('email') }}" required autofocus>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group mt-3">
            <label for="password">New Password</label>
            <input id="password" type="password" name="password" class="form-control" required>
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group mt-3">
            <label for="password_confirmation">Confirm New Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
        </div>
        <div id="loader" style="display: none;">
            <img src="loader.gif" alt="Loading..." /> <!-- You can use a GIF or CSS-based spinner -->
        </div>
        <button type="submit" class="btn btn-primary mt-3">Reset Password</button>
    </form>
        </div>
    </div>
@include('home.footer')

<script>
document.getElementById('submitBtn').addEventListener('click', function() {
    document.getElementById('loader').style.display = 'block'; // Show loader
    // Optionally disable the submit button to prevent multiple submits
    this.disabled = true;
});

// If needed, hide loader when the request completes
// You might handle this in your AJAX callback if using AJAX to submit the form
</script>
   
    
    