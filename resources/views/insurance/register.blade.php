@extends('layouts.app')

<<<<<<< Updated upstream
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Insurance Company Registration</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('insurance.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Company Name</label>
                            <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}">
                            @error('company_name') <div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control">{{ old('address') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Registration Number</label>
                            <input type="text" name="registration_number" class="form-control @error('registration_number') is-invalid @enderror" value="{{ old('registration_number') }}">
                            @error('registration_number') <div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                </div>
            </div>
        </div>
=======
@section('title', 'Industry Registration')
@section('body-class', 'industry-register-page')

@section('content')

<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-12 col-xl-12 col-xxl-10">
      <h3 class="mb-4 text-center fw-semibold text-primary">Insurance Company Registration</h3>

      {{-- ===================== GST Verification Block ===================== --}}
      <div class="card shadow-sm mb-4" id="gstVerificationBlock">
        <div class="card-body">
          <h5 class="fw-semibold mb-3 text-primary">Step 1: Verify Your GST Number</h5>
          <div class="row align-items-center g-2">
            <div class="col-md-4">
              <input type="text" id="gst_input" class="form-control text-uppercase" maxlength="15"
                     placeholder="Enter your 15-digit GSTIN">
              <div id="gst_error" class="text-danger small mt-1" style="display:none;"></div>
            </div>
            <div class="col-md-8 d-flex gap-2">
              <button type="button" id="verifyGstBtn" class="btn btn-primary">Verify GST</button>
              <button type="button" id="manualEntryBtn" class="btn btn-outline-secondary">Enter Manually</button>
            </div>
          </div>
          <p class="small text-muted mt-2 mb-0">
            Your GST details will be verified and used to auto-fill company information.
          </p>
        </div>
      </div>

      {{-- ===================== Registration Form ===================== --}}
      <form method="POST" action="{{ route('register.process') }}" id="registrationForm"
            autocomplete="off" novalidate style="display:none;">
        @csrf

        {{-- ===================== Company Details ===================== --}}
        <div class="card form-section">
          <div class="card-header">
            <h5 class="mb-0">Company Details</h5>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label required">Company Name</label>
                <input type="text" name="industry_name" id="industry_name" class="form-control underline-only"
                       placeholder="Name of Industry" maxlength="400" value="{{ old('industry_name') }}">
              </div>

              <div class="col-md-4">
                <label class="form-label required">PAN Number</label>
                <input type="text" name="pan_no" id="pan_no" class="form-control underline-only"
                       maxlength="10" placeholder="Enter PAN No.">
              </div>

              <div class="col-md-4">
                <label class="form-label">GST Number</label>
                <input type="text" name="company_gst" id="company_gst" class="form-control underline-only text-uppercase"
                       maxlength="15" placeholder="Enter GST No.">
              </div>

              <div class="col-md-4">
                <label class="form-label required">Address</label>
                <input type="text" name="company_address" id="company_address" class="form-control underline-only"
                       placeholder="Address " maxlength="6">
              </div>
            </div>
          </div>
        </div>

        {{-- ===================== Address Section ===================== --}}
        <div class="card form-section">
          <div class="card-header">
            <h5 class="mb-0">Company Address</h5>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label required">Locality</label>
                <input type="text" name="locality" id="locality" class="form-control underline-only"
                       placeholder="Enter Locality" maxlength="200">
              </div>

              <div class="col-md-4">
                <label class="form-label required">State/UT</label>
                <select name="state" id="stateDropdown" class="form-select" required>
                  <option value="">-- Select State --</option>
                  @foreach ($states as $state)
                    <option value="{{ $state->state_code }}">{{ $state->state_name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-4">
                <label class="form-label required">District</label>
                <select name="district" id="districtDropdown" class="form-select" required>
                  <option value="">-- Select District --</option>
                </select>
              </div>

              <div class="col-md-4">
                <label class="form-label required">Pincode</label>
                <input type="number" name="industry_pincode" id="industry_pincode" class="form-control underline-only"
                       placeholder="Enter Pincode" maxlength="6">
              </div>
            </div>
          </div>
        </div>

        {{-- ===================== Authorised Person ===================== --}}
        <div class="card form-section">
          <div class="card-header"><h5 class="mb-0">Authorised Person Info</h5></div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label required">Name</label>
                <input type="text" name="authorised_person_name" id="authorised_person_name" class="form-control underline-only"
                       placeholder="Enter Name" maxlength="200">
              </div>

              <div class="col-md-4">
                <label class="form-label required">Designation</label>
                <input type="text" name="authorised_person_designation" id="authorised_person_designation" class="form-control underline-only"
                       placeholder="Enter Designation" maxlength="100">
              </div>

              <div class="col-md-4">
                <label class="form-label required">Email</label>
                <input type="email" name="authorised_person_email" id="authorised_person_email" class="form-control underline-only"
                       placeholder="Enter Email" maxlength="100">
              </div>

              <div class="col-md-4">
                <label class="form-label required">Mobile</label>
                <input type="number" name="mobile_no" id="mobile_no" class="form-control underline-only"
                       placeholder="Enter Mobile" maxlength="15">
                <div class="form-text small-muted">10-digit mobile number</div>
              </div>
            </div>
          </div>
        </div>

        {{-- ===================== Login & Compliance ===================== --}}
        <div class="card form-section">
          <div class="card-header"><h5 class="mb-0">Login & Compliance Details</h5></div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label required">Company Email Address</label>
                <input type="email" name="industry_email" id="industry_email" class="form-control underline-only"
                       placeholder="Enter Email" maxlength="100">
              </div>

              <div class="col-md-4">
                <label class="form-label required">Password</label>
                <div class="input-group">
                  <input type="password" name="password" id="password" class="form-control underline-only"
                         placeholder="Enter Password" autocomplete="new-password">
                  <span class="input-group-text toggle-password" id="togglePassword">Show</span>
                </div>
                <div class="form-text small-muted">Min 8 characters with letters, numbers & symbols</div>
              </div>

              <div class="col-md-4">
                <label class="form-label required">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       placeholder="Confirm Password" class="form-control underline-only">
              </div>

              {{-- Captcha --}}
              <div class="col-md-4">
                <label for="captcha">Enter the text from the image:</label>
                <div class="d-flex align-items-center gap-2">
                  <img src="{{ captcha_src('flat') }}" id="captcha-img" alt="captcha" class="img-fluid" style="height: 40px;">
                  <button type="button" class="btn btn-outline-secondary btn-md" id="reload-captcha">↻ Refresh</button>
                </div>
                <input type="text" id="captcha_input" name="captcha" class="form-control underline-only" placeholder="Enter CAPTCHA">
              </div>

              {{-- OTP --}}
              <div class="col-md-4">
                <label class="form-label required">OTP</label>
                <div class="d-flex flex-wrap gap-2 otp-controls">
                  <input type="number" id="otp_input" class="form-control underline-only" placeholder="Enter OTP">
                  <button type="button" id="send_otp_btn" class="btn btn-outline-primary">Send OTP</button>
                  <button type="button" id="verify_otp_btn" class="btn btn-primary" disabled>Verify OTP</button>
                </div>
                <small id="otp_msg" class="form-text mt-2"></small>
              </div>
            </div>
          </div>
        </div>

        {{-- ===================== Submit ===================== --}}
        <div class="d-flex justify-content-between align-items-center mt-4">
          <div class="small-muted">
            Already have an account?
            <a href="{{ route('login') }}" class="text-decoration-none">Sign in</a>
          </div>
          <button id="create_account_btn" class="btn btn-success px-4" type="submit" disabled>
            Create Account
          </button>
        </div>
      </form>
>>>>>>> Stashed changes
    </div>
</div>
@endsection
