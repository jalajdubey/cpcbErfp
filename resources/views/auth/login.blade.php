@include('home.header')
<style>
#captchaWrapper {
    transition: opacity 0.2s ease-in-out;
    display: inline-block;
}
    </style>
</head>
<body>
     <!-- Navbar -->
   
    

    <div  class="d-flex align-items-center justify-content-center mt-5">
        <!-- <div class="box h-75 "><img src="{% static 'img/finance2.png' %}" alt="" class="rounded  blur-image"></div> -->
         
        <div class="login-container">
            @include('layouts.flash-message')
        @if($errors->has('email'))
                <div class="alert alert-danger">
                    {{ $errors->first('email') }}
                </div>
            @endif
            <h4 class="text-center mref"><i class="fas fa-user-lock"></i> Sign In 
            </h4>
            @if(session('error'))
                    <div style="color: red; background: #f8d7da; padding: 10px; margin-bottom: 10px;">
                        {{ session('error') }}
                    </div>
             @endif
            <form action="{{route('login') }}" method="POST" autocomplete="off">
               @csrf
                
                <div class="form-group text-light my-3">
                    <label for="username" class="my-1"><i class="fas fa-user mx-1"></i> Email <span class="text-warning">*</span></label>
                    <input type="email" name="email" id="email" class="form-control px-2 py-1 fst-italic"   placeholder="Enter Username" autocomplete="off" required>
                   @error('email')
                        <div style="color: red;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group text-light my-3">
                    <label for="password" class="my-1"><i class="fas fa-lock mx-1"></i> Password <span class="text-warning">*</span></label>
                    <input type="password" name="password" id="password"class="form-control px-2 py-1.5 fst-italic" placeholder="Enter Password" autocomplete="new-password" required>
                    @error('password')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                </div>
             <div class="form-group">
    <label>Captcha</label>
    <div class="d-flex align-items-center">
        <span id="captchaImage">{!! captcha_img('flat') !!}</span>
        <button type="button" class="btn btn-warning ms-2" id="reloadCaptcha">Refresh</button>
    </div>
    <input type="text" name="captcha" class="form-control mt-2" placeholder="Enter Captcha" required>
    @error('captcha')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
              
                <div class=" mt-4">
                    <button type="submit" class="btn btn-signin text-white">Sign In</button>
                    <a  class="mref" href="{{ 'forgot-password' }}">Forgot Password?</a>
                </div>
            </form>
        </div>
    </div>
</div>
@include('home.footer')
   
    <script>
        setTimeout(function() {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.transition = "opacity 0.5s ease-out";
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 500); // Remove from DOM after fade-out
            });
        }, 5000); // Disappears after 5 seconds (adjust time if needed)

        setTimeout(function() {
            var errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }, 5000);

        
    </script>
 <script>
    const reloadBtn = document.getElementById('reloadCaptcha');
    const captchaImage = document.getElementById('captchaImage');

    reloadBtn.addEventListener('click', () => {
        fetch('/reload-captcha')
            .then(res => res.json())
            .then(data => {
                // Create a temporary <div> to parse the new HTML
                const temp = document.createElement('div');
                temp.innerHTML = data.captcha;

                const newImg = temp.querySelector('img');
                const oldImg = captchaImage.querySelector('img');

                if (newImg && oldImg) {
                    // Only replace the `src` to avoid flicker
                    oldImg.src = newImg.src;
                }
            });
    });
</script>

