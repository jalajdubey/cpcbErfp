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
    <div class="col-lg-12 col-xl-12 col-xxl-11">
      <h3 class="mb-4 text-center fw-semibold text-primary">Insurance Company Registration</h3>

      <div class="form-wrapper">
        <form method="POST" action="{{ route('register.process') }}" id="registrationForm"
              autocomplete="off" novalidate>
          @csrf

          {{-- ===================== Industry Details ===================== --}}
          <div class="card form-section">
            <div class="card-header">
              <h5 class="mb-0">Company Details</h5>
            </div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-4">
                  <label class="form-label required">Company Name</label>
                  <input type="text" name="industry_name" class="form-control underline-only"
                         placeholder="Name of Industry" maxlength="400" autocomplete="off"
                         value="{{ old('industry_name') }}">
                  @error('industry_name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                  <label class="form-label required">PAN Number</label>
                  <input type="text" name="pan_no" id="pan_no" class="form-control underline-only"
                         required value="{{ old('pan_no') }}" placeholder="Enter PAN No." maxlength="10" autocomplete="off">
                  @error('pan_no') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                  <label class="form-label">GST Number (Optional)</label>
                  <input type="text" name="company_gst" class="form-control underline-only"
                         value="{{ old('company_gst') }}" maxlength="15" placeholder="Enter GST No." autocomplete="off">
                  @error('company_gst') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                  <label class="form-label required">Established Year</label>
                  <input type="number" name="estd_year" class="form-control underline-only"
                         required value="{{ old('estd_year') }}" placeholder="Year of Establishment" maxlength="6" autocomplete="off">
                  @error('estd_year') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
              </div>
            </div>
          </div>

          {{-- ===================== Industry Address ===================== --}}
          <div class="card form-section">
            <div class="card-header">
              <h5 class="mb-0">Company Address</h5>
            </div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-4">
                  <label class="form-label required">Locality</label>
                  <input type="text" name="locality" class="form-control underline-only"
                         required value="{{ old('locality') }}" placeholder="Enter Locality" maxlength="200" autocomplete="off">
                  @error('locality') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                  <label class="form-label required">State/UT</label>
                  <select name="state" id="stateDropdown" class="form-select" required>
                    <option value="">-- Select State --</option>
                    @foreach ($states as $state)
                      <option value="{{ $state->state_code }}" {{ old('state') == $state->state_code ? 'selected' : '' }}>
                        {{ $state->state_name }}
                      </option>
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
                  <input type="number" name="industry_pincode" class="form-control underline-only"
                         required value="{{ old('industry_pincode') }}" placeholder="Enter Pincode" maxlength="6" autocomplete="off">
                  @error('industry_pincode') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
              </div>
            </div>
          </div>

          

          {{-- ===================== Authorised Person ===================== --}}
          <div class="card form-section">
            <div class="card-header">
              <h5 class="mb-0">Authorised Person Info</h5>
            </div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-4">
                  <label class="form-label required">Name</label>
                  <input type="text" name="authorised_person_name" class="form-control underline-only"
                         required value="{{ old('authorised_person_name') }}" placeholder="Enter Authorised Person Name" maxlength="200" autocomplete="off">
                  @error('authorised_person_name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                  <label class="form-label required">Designation</label>
                  <input type="text" name="authorised_person_designation" class="form-control underline-only"
                         required value="{{ old('authorised_person_designation') }}" placeholder="Enter Designation" maxlength="100" autocomplete="off">
                  @error('authorised_person_designation') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                  <label class="form-label required">Email</label>
                  <input type="email" name="authorised_person_email" class="form-control underline-only"
                         required value="{{ old('authorised_person_email') }}" placeholder="Enter Email" maxlength="100" autocomplete="off">
                  @error('authorised_person_email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                  <label class="form-label required">Mobile</label>
                  <input type="number" name="mobile_no" class="form-control underline-only"
                         required value="{{ old('mobile_no') }}" inputmode="numeric" pattern="[0-9]{10}"
                         placeholder="Enter Mobile" maxlength="15" autocomplete="off">
                  <div class="form-text small-muted">10-digit mobile number</div>
                  @error('mobile_no') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
              </div>
            </div>
          </div>

          {{-- ===================== Login & Compliance ===================== --}}
          <div class="card form-section">
            <div class="card-header">
              <h5 class="mb-0">Login & Compliance Details</h5>
            </div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-4">
                  <label class="form-label required">Company Email Address</label>
                  <input type="email" name="industry_email" class="form-control underline-only"
                         required value="{{ old('industry_email') }}" placeholder="Enter Email" maxlength="100" autocomplete="off">
                  @error('industry_email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                  <label class="form-label required">Password</label>
                  <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control underline-only"
                           placeholder="Enter Password" autocomplete="new-password" required>
                    <span class="input-group-text toggle-password" id="togglePassword">Show</span>
                  </div>
                  <div class="form-text small-muted">Min 8 characters with letters, numbers & symbols</div>
                </div>

                <div class="col-md-4">
                  <label class="form-label required">Confirm Password</label>
                  <input type="password" name="password_confirmation" id="password_confirmation"
                         placeholder="Confirm Password" class="form-control underline-only" required>
                </div>

                {{-- Captcha --}}
                <div class="col-md-4">
                  <label for="captcha">Enter the text from the image:</label>
                  <div class="d-flex align-items-center gap-2">
                    <img src="{{ captcha_src('flat') }}" id="captcha-img" alt="captcha" class="img-fluid" style="height: 40px;">
                    <button type="button" class="btn btn-outline-secondary btn-md" id="reload-captcha">↻ Refresh</button>
                  </div>
                  <input type="text" id="captcha_input" name="captcha" class="form-control underline-only" placeholder="Enter CAPTCHA">
                  @error('captcha') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- OTP Section --}}
                <div class="col-md-4">
                  <label class="form-label required">OTP</label>
                  <div class="d-flex flex-wrap gap-2 otp-controls">
                    <input type="number" id="otp_input" class="form-control underline-only" placeholder="Enter OTP"
                           autocomplete="one-time-code" inputmode="numeric">
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
      </div>
    </div>
  </div>
</div>

@vite(['resources/css/app.css', 'resources/js/app.js'])

</body>
