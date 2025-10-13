<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid px-3">
        <span class="navbar-brand text-primary fw-bold">ERF Admin Panel</span>
        <div class="ms-auto d-flex align-items-center gap-3">
            <span class="text-secondary">Welcome, {{ Auth::user()->name ?? 'User' }}</span>
            <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </div>
</nav>
