{{-- =====================================================
     Change Password Page – ERF Dashboard Layout
====================================================== --}}
@extends('layouts.dashboard-layout')

@section('title', 'Change Password')

@section('dashboard-content')
<div class="container-fluid py-4">
  
  {{-- 🔹 Page Title --}}
  <h4 class="text-center fw-bold mb-4" style="color:#084095;">
    Change Your Password
  </h4>

  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white fw-bold">
          <i class="bi bi-key me-2"></i> Update Password
        </div>

        <div class="card-body">

          {{-- ✅ Success Message --}}
          @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          {{-- ❌ Validation Errors --}}
          @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="bi bi-exclamation-triangle-fill me-2"></i> Please fix the following errors:
              <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          {{-- 🔐 Password Form --}}
          <form method="POST" action="{{ route('password.update') }}" class="needs-validation" novalidate>
            @csrf

            <div class="mb-3">
              <label for="current_password" class="form-label fw-semibold">Current Password</label>
              <input type="password" class="form-control" id="current_password" name="current_password" required>
              <div class="invalid-feedback">Please enter your current password.</div>
            </div>

            <div class="mb-3">
              <label for="new_password" class="form-label fw-semibold">New Password</label>
              <input type="password" class="form-control" id="new_password" name="new_password" required>
              <div class="invalid-feedback">Please enter a new password.</div>
            </div>

            <div class="mb-3">
              <label for="new_password_confirmation" class="form-label fw-semibold">Confirm New Password</label>
              <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
              <div class="invalid-feedback">Please confirm your new password.</div>
            </div>

            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-primary fw-semibold">
                <i class="bi bi-lock-fill me-1"></i> Change Password
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Optional small inline JS for Bootstrap validation --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
  const forms = document.querySelectorAll('.needs-validation');
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
});
</script>
@endsection
