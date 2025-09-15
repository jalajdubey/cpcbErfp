

@include('home.header')


<form method="POST" action="{{ route('register') }}">
    @csrf
    <div>
        <label>Name</label>
        <input type="text" name="name" required class="form-control">
    </div>
    <div>
        <label>Email</label>
        <input type="email" name="email" required class="form-control">
    </div>
    <div>
        <label>Password</label>
        <input type="password" name="password" required class="form-control">
    </div>
    <div>
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" required class="form-control">
    </div>
    <div>
        <button type="submit">Register</button>
    </div>
</form>

@include('home.footer')