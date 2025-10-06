@include('home.header')
<style>
  body {
    background-color: #f1f2f3ff;
    font-family: 'Segoe UI', Roboto, sans-serif;
  }

  .card-body {
    padding: 1.5rem;
  }

  .form-label.required::after {
    content: " *";
    color: #dc3545;
  }

  input.form-control:focus,
  .input-group input:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.15rem rgba(1, 9, 20, 0.25);
  }

  .btn {
    border-radius: 8px;
  }

  .btn-primary,
  .btn-outline-primary {
    font-weight: 500;
  }

  .form-text.small-muted {
    color: #6c757d;
    font-size: 0.875rem;
  }

  #otp_input {
    max-width: 160px;
  }

  .toggle-password {
    cursor: pointer;
    user-select: none;
    font-weight: 500;
  }

  /* .policy-header {
    background: linear-gradient(90deg, #0d6efd11, #0dcaf011);
    border-bottom: 1px solid #dee2e6;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    padding: 1rem 1.5rem;
  }

  .policy-header h5 {
    margin-bottom: 0;
    font-weight: 600;
  } */

  .otp-controls .btn {
    min-width: 110px;
  }

  @media (max-width: 575px) {
    .otp-controls .btn {
      font-size: 0.85rem;
      padding: 0.35rem 0.5rem;
    }

    .card-body {
      padding: 1rem;
    }
  }

  @media (min-width: 992px) {
    .card {
      padding: 1.5rem;
    }
  }

  @media (min-width: 1200px) {
    .container {
      max-width: 95%;
    }

    .card {
      padding: 2rem;
    }
  }

  @media (min-width: 1400px) {
    .container {
      max-width: 1200px;
    }
  }

  @media (max-width: 576px) {
    .btn {
      font-size: 0.9rem;
      padding: 0.4rem 0.75rem;
    }

    .input-group .form-control,
    input.form-control {
      font-size: 0.95rem;
    }
  }

  .card {
  border: 1px solid #dee2e6;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
  background-color: #fff;
  margin-bottom: 1.5rem;
  padding: 0;
  overflow: hidden; /* Ensure curves are not hidden */
}

.card-header {
  /* background-image: linear-gradient(#023b0e, #086f1e); */
  background: linear-gradient(45deg, #108e16, #084095) !important;
  padding: 0.00005rem 0.25rem;
  border-top-left-radius: 12px;
  border-top-right-radius: 12px;
  border-bottom: 1px solid #dbeafe;
}
.card .card-header, .card-light .card-header {
    padding: 0.5rem 1.25rem;
    background-color: transparent;
    border-bottom: 1px solid #ebecec !important;
}

.card-header h5 {
  margin-bottom: 0;
  font-weight: 500;
  color: #f7f8fa;
}

.form-section {
  border: 2px solid #c2cfc4; /* Grey border */
  border-radius: 15px;
  /* border-top: 1px solid #e2e8f0; */
  /* padding-top: 2rem; */
  /* margin-top: 1.5rem; */
}

.form-section-number {
  background-color: #08921b
  color: #0a58ca;
  font-weight: bold;
  margin-right: 0.5rem;
}

@media (min-width: 768px) {
  .form-section {
    margin-left: 1rem;
    margin-right: 1rem;
  }
}

@media (max-width: 575px) {
 .card-body {
    padding: 1rem;
  }

  .card-header h5 {
    font-size: 1rem;
  }
  .card {
    padding: 1rem;
  }

  .form-label,
  .form-control,
  .form-select {
    font-size: 0.95rem;
  }
}
.form-wrapper {
  border: 2px solid #f1f5f2; /* Green border */
  border-radius: 15px;
  padding: 0.5rem;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  background-color: #ffffff;
  max-width: 1200px;
  margin: 2rem auto;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.form-control.underline-only {
    border: none;
    border-bottom: 0.01px solid #0d0d0e;
    border-radius: 0;
    background-color: transparent;
    box-shadow: none;
}
.form-check-input {
    width: 20px;
    height: 20px;
    cursor: pointer;
    border: 0.01px solid #007bff; /* Change to your preferred color */
    box-shadow: 0 0 2px rgba(0, 123, 255, 0.6); /* Light glow effect */
}
.mb-0 {
    font-size: 1.5rem;
}
.bg-success {
    background-color: #ce3179a3 !important;
}
.badge{
  font-size: 16px
}
</style>



<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-12 col-xl-12 col-xxl-11">
      <h3 class="mb-4 text-center fw-semibold text-primary">Registration</h3>
      <div class="form-wrapper">
      <form method="POST" action="{{ route('register.process') }}" id="registrationForm"
        autocomplete="off" novalidate>
        @csrf
        {{-- <input type="hidden" name="policy" value="{{ $policyData->policy_number }}">
        <input type="hidden" name="role_type" value="3">
        <input type="hidden" name="industry_id" value="{{ $policyData->id }}">
        <input type="hidden" name="policy_number" value="{{ $policyData->policy_number }}">
        <input type="hidden" name="otp_verified" id="otp_verified" value="0"> --}}

        <!-- Policy details card -->
        {{-- <div class="card mb-4">
          <div class="card-body policy-header p-3">
            <div class="d-flex align-items-center gap-3">
              <div>
                <h5 class="mb-0"><span class="form-section-number">Policy details</h5>
                <small class="small-muted">Auto-filled from policy</small>
              </div>
            </div>
          </div>

          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Policy Number</label>
                <input class="form-control underline-only" value="{{ $policyData->policy_number }}" readonly>
              </div>

              <div class="col-md-6">
                <label class="form-label">Industry Name</label>
                <input class="form-control underline-only" value="{{ $policyData->name_of_insured_owner }}" readonly>
              </div>

              <div class="col-md-4">
                <label class="form-label">Insured Company ID</label>
                <input class="form-control underline-only" value="{{ $policyData->insured_company_id }}" readonly>
              </div>

              <div class="col-md-8">
                <label class="form-label">Address</label>
                <input class="form-control underline-only"
                  value="{{ trim(($policyData->address ?? '') . ' ' . ($policyData->address_line2 ?? '')) }}" readonly>
              </div>

              <div class="col-md-6">
                <label class="form-label">City</label>
                <input class="form-control underline-only" value="{{ $policyData->territorial_limits_district }}" readonly>
              </div>

              <div class="col-md-6">
                <label class="form-label">State</label>
                <input class="form-control underline-only" value="{{ $policyData->territorial_limits_state }}" readonly>
              </div>
            </div>
          </div>
        </div> --}}

       <!-- 1. Industry Name Module -->
        <div class="card form-section">
          <div class="card-header">
            <h5 class="mb-0"><span class="form-section-number">Industry Details</h5>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label required">Industry Name</label>
                <input type="text" name="industry_name" class="form-control underline-only" placeholder="Name of Industry" maxlength="400" autocomplete="off" value="{{ old('industry_name') }}">
                @error('industry_name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              </div>
              
              <div class="col-md-4">
                <label class="form-label required">PAN Number</label>
                <input type="text" name="pan_no" id="pan_no" class="form-control underline-only" required value="{{ old('pan_no') }}" placeholder="Enter PAN No." maxlength="10" autocomplete="off">
                 @error('pan_no') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-4">
                <label class="form-label">GST Number (Optional)</label>
                <input type="text" name="company_gst" class="form-control underline-only" value="{{ old('company_gst') }}" maxlength="15" placeholder="Enter GST No." autocomplete="off">
                @error('company_gst') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              </div>
              <div class="col-md-4">
                <label class="form-label required">Established Year</label>
                <input type="number" name="estd_year" class="form-control underline-only" required value="{{ old('estd_year') }}" placeholder="Year of Establishment" maxlength="6" autocomplete="off" >
                @error('estd_year') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              </div>
            </div>
          </div>
        </div>

        <!-- 2. Industry Address Module -->
        <div class="card form-section">
          <div class="card-header">
            <h5 class="mb-0"><span class="form-section-number">Industry Address</h5>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label required">Locality</label>
                <input type="text" name="locality" class="form-control underline-only" required value="{{ old('locality') }}" placeholder="Enter Locality" maxlength="200" autocomplete="off">
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
                  {{-- District options will be populated here via AJAX --}}
                </select>
              </div>

              <div class="col-md-4">
                <label class="form-label required">Pincode</label>
                <input type="number" name="industry_pincode" class="form-control underline-only" required value="{{ old('industry_pincode') }}" placeholder="Enter Pincode" maxlength="6" autocomplete="off">
                @error('industry_pincode') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              </div>
            </div>
          </div>
        </div>

        <!-- 3. Chemical Stored List -->
        <div class="card form-section">
          <div class="card-header">
            <h5 class="mb-0">
              <span class="form-section-number">Chemical Stored List</span>
            </h5>
          </div>

          <div class="card-body">
            <div class="mb-3">
              <label class="form-label required">Select Chemicals</label>

              <!-- Selected chemicals tags container -->
              <div id="selected_chemicals" class="mb-3">
                <!-- Selected chemical badges will appear here -->
              </div>

              <!-- Search box -->
              <input
                type="text"
                id="chemical_search"
                class="form-control mb-3 underline-only"
                placeholder="Search chemicals..."
              />

              <!-- Select All Checkbox -->
              {{-- <div class="form-check mb-2">
                <input
                  type="checkbox"
                  class="form-check-input"
                  id="select_all_chemicals"
                />
                <label class="form-check-label fw-semibold" for="select_all_chemicals">
                  Select All Chemicals
                </label>
              </div> --}}

              <!-- Scrollable container for checkboxes -->
              <div
                id="chemical_list"
                style="max-height: 200px; overflow-y: auto; border: 1px solid #ced4da; border-radius: 4px; padding: 10px;"
              >
                @forelse ($chemicals as $chemical)
                <div class="form-check chemical-item">
                  <input
                    type="checkbox"
                    name="chemicals[]"
                    value="{{ $chemical->id }}"
                    id="chemical_{{ $chemical->id }}"
                    class="form-check-input chemical-checkbox"
                    {{ is_array(old('chemicals')) && in_array($chemical->id, old('chemicals')) ? 'checked' : '' }}
                  />
                  <label class="form-check-label" for="chemical_{{ $chemical->id }}">
                    {{ $chemical->chemical_name }}
                  </label>
                </div>
                @empty
                <p class="text-muted">No chemicals available to select.</p>
                @endforelse
              </div>

              @error('chemicals')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror

              <div class="form-text small-muted mt-2">
                Check all chemicals used at the facility
              </div>
            </div>
          </div>
        </div>


        <!-- 4. Authorised Person Info -->
        <div class="card form-section" >
          <div class="card-header">
            <h5 class="mb-0"><span class="form-section-number">Authorised Person Info</h5>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label required">Name</label>
                <input type="text" name="authorised_person_name" class="form-control underline-only" required value="{{ old(key: 'authorised_person_name') }}" placeholder="Enter Authorised Person Name" maxlength="200" autocomplete="off">
                @error('authorised_person_name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              </div>
              <div class="col-md-4">
                <label class="form-label required">Designation</label>
                <input type="text" name="authorised_person_designation" class="form-control underline-only" required value="{{ old('authorised_person_designation') }}" placeholder="Enter Authorised Person Designation" maxlength="100" autocomplete="off">
                @error('authorised_person_designation') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              </div>
              <div class="col-md-4">
                <label class="form-label required">Email</label>
                <input type="email" name="authorised_person_email" class="form-control underline-only" required value="{{ old('authorised_person_email') }}" placeholder="Enter Authorised Person Email" maxlength="100" autocomplete="off">
                @error('authorised_person_email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-4">
                <label class="form-label required">Mobile</label>
                <input type="number" name="mobile_no" class="form-control underline-only" required value="{{ old('mobile_no') }}"
                  inputmode="numeric" pattern="[0-9]{10}" placeholder="Enter Authorised Person Mobile" maxlength="15" autocomplete="off">
                <div class="form-text small-muted">10-digit mobile number</div>
                @error('mobile_no') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              </div>

            </div>
          </div>
        </div>

        <!-- 5. Login & Compliance Info -->
        <div class="card form-section" >
          <div class="card-header">
            <h5 class="mb-0"><span class="form-section-number">Login & Compliance Details</h5>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label required">Industry Email Address</label>
                <input type="email" name="industry_email" class="form-control underline-only" required value="{{ old('industry_email') }}" placeholder="Enter Industry Email" maxlength="100" autocomplete="off">
                @error('industry_email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-4">
                <label class="form-label required">Password</label>
                <div class="input-group">
                  <input type="password" name="password" id="password" class="form-control underline-only" placeholder="Enter Alphanumeric Password" autocomplete="new-password"
                    required>
                  <span class="input-group-text toggle-password" id="togglePassword">Show</span>
                </div>
                <div class="form-text small-muted">Min 8 characters and include letters, numbers, and special characters</div>
                @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-4">
                <label class="form-label required">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Please Confirm Password" class="form-control underline-only"
                  required>
              </div>
              <!---Captcha code-->
              <div class="col-md-4">
                  <label for="captcha">Enter the text from the image:</label>
                  <div class="d-flex align-items-center gap-2">
                      <img src="{{ captcha_src('flat') }}" id="captcha-img" alt="captcha" class="img-fluid" style="height: 40px;">
                      <button type="button" class="btn btn-outline-secondary btn-md" id="reload-captcha">
                          ↻ Refresh
                      </button>
                  </div>
                  <input type="text" id="captcha_input" name="captcha" class="form-control underline-only" placeholder="Enter CAPTCHA">
                  @error('captcha')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
              </div>
              <!-- OTP block -->
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
        <!-- Submit -->
        <div class="d-flex justify-content-between align-items-center mt-4">
          <div class="small-muted">Already have an account? <a href="{{ route('login') }}"
              class="text-decoration-none">Sign in</a></div>
          <button id="create_account_btn" class="btn btn-success px-4" type="submit" disabled>Create Account</button>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>

{{-- <script src="{{ asset('assets\js\jquery-3.7.1.min.js') }}"></script> --}}
{{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

{{-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/additional-methods.min.js"></script> --}}

<script>

  $(function () {
    var $sendBtn = $('#send_otp_btn');
    var $verifyBtn = $('#verify_otp_btn');
    var $otpInput = $('#otp_input');
    var $otpMsg = $('#otp_msg');
    var $createBtn = $('#create_account_btn');
    var $otpVerifiedField = $('#otp_verified');
    var $togglePassword = $('#togglePassword');

    // CSRF token for Laravel
    var csrfToken = $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}';

    // Routes
    var sendOtpUrl = "{{ route('send-otp') }}";
    var verifyOtpAjaxUrl = "{{ route('ajax.verify-otp') }}";

    // Message helper
    function showMsg(text, type) {
      var cls = 'text-muted';
      if (type === 'success') cls = 'text-success';
      if (type === 'error') cls = 'text-danger';
      $otpMsg.removeClass('text-muted text-success text-danger').addClass(cls).text(text);
    }

    //  Helper: validate required fields
    function validateFields(beforeAction = 'send') {
      var industry_name = $('input[name="industry_name"]').val().trim();
      // var lastname = $('input[name="lastname"]').val().trim();
      var authorised_person_email = $('input[name="authorised_person_email"]').val().trim();
      var industry_email = $('input[name="industry_email"]').val().trim();
      var mobile = $('input[name="mobile_no"]').val().trim();
      var pan = $('input[name="pan_no"]').val().trim();
      var gst = $('input[name="company_gst"]').val().trim();
      var pincode = $('input[name="industry_pincode"]').val().trim();
      var chemicals = [];
      $('input[name="chemicals[]"]:checked').each(function() {
        chemicals.push($(this).val());
      });
      var authorised_person_name = $('input[name="authorised_person_name"]').val().trim();
      var authorised_person_designation = $('input[name="authorised_person_designation"]').val().trim();
      var locality = $('input[name="locality"]').val().trim();
      var estd_year = $('input[name="estd_year"]').val().trim();
      var pass = $('input[name="password"]').val();
      var confirmPass = $('input[name="password_confirmation"]').val();
      var stateDropdown = $('input[name="state"]').val();
      var districtDropdown = $('input[name="district"]').val();
      // console.log(stateDropdown);

      // Generic required check
      if (!industry_name || !industry_email || !mobile || !pan || !pincode || !pass || !confirmPass || !authorised_person_name || !authorised_person_designation || !authorised_person_email || !locality || !estd_year || chemicals.length === 0) {
        showMsg('Please fill in all required fields before ' + (beforeAction === 'send' ? 'sending OTP.' : 'verifying OTP.'), 'error');
        return false;
      }

      // PAN check using regex
      var panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/i;
      if (!panRegex.test(pan)) {
        showMsg('Enter a valid 10-character PAN number (e.g. ABCDE1234F).', 'error');
        return false;
      }

      // GST check using regex
      var gstRegex = /^\d{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/i;
      // if (!gstRegex.test(gst)) {
      //  showMsg('Enter a valid 15-character GST number (e.g. 22ABCDE1234F1Z5).', 'error');
      //  return false;
      // }

       // state match
      if ($('#stateDropdown').val() == '') {
        showMsg('Please select state.', 'error');
        return false;
      }
      // district match
     if ($('#districtDropdown').val() === '') {
        showMsg('Please select district.', 'error');
        return false;
      }

      // Pincode check (6 digits)
      if (!/^[0-9]{6}$/.test(pincode)) {
        showMsg('Enter a valid 6-digit pincode.', 'error');
        return false;
      }

      // Email format
      var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(authorised_person_email)) {
        showMsg('Enter a valid authorised person email address.', 'error');
        return false;
      }

      // Mobile check (10 digits)
      if (!/^[0-9]{10}$/.test(mobile)) {
        showMsg('Enter a valid 10-digit mobile number.', 'error');
        return false;
      }

      if (!emailPattern.test(industry_email)) {
        showMsg('Enter a valid industry email address.', 'error');
        return false;
      }

      var password = $('input[name="password"]').val();

      // At least 8 characters, at least one letter, one digit, and one special character
      var passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/;

      if (!passwordRegex.test(password)) {
        showMsg('Password must be at least 8 characters and include letters, numbers, and special characters.', 'error');
        return false;
      }

      // Check for 4 consecutive letters (case-insensitive)
      if (/(?:abcd|bcde|cdef|defg|efgh|fghi|ghij|hijk|ijkl|jklm|klmn|lmno|mnop|nopq|opqr|pqrs|qrst|rstu|stuv|tuvw|uvwx|vwxy|wxyz)/i.test(password)) {
        showMsg('Password cannot contain 4 consecutive letters (e.g. abcd).', 'error');
        return false;
      }

      // Check for 4 consecutive digits
      if (/(?:0123|1234|2345|3456|4567|5678|6789|7890)/.test(password)) {
        showMsg('Password cannot contain 4 consecutive digits (e.g. 1234).', 'error');
        return false;
      }


      // Password match
      if (pass !== confirmPass) {
        showMsg('Passwords do not match.', 'error');
        return false;
      }
     
      return true;
    }
    // to show password
    $('#togglePassword').on('click', function() {
        var $password = $('#password');
        var type = $password.attr('type') === 'password' ? 'text' : 'password';
        $password.attr('type', type);

        // Optionally change the button text
        $(this).text(type === 'password' ? 'Show' : 'Hide');
    });

    // SEND OTP
    function sendOtp() {
        var mobile = $('input[name="mobile_no"]').val().trim();
        var email = $('input[name="email"]').val().trim();

        showMsg('Sending OTP...');
        $sendBtn.prop('disabled', true);

        $.ajax({
          url: sendOtpUrl,
          method: 'POST',
          data: { mobile, email, _token: csrfToken },
          dataType: 'json'
        }).done(function (data) {
          if (data && data.success) {
            showMsg(data.message || 'OTP sent. Check your phone/email.', 'success');
            $otpInput.focus();
            $verifyBtn.prop('disabled', false);
          } else {
            showMsg((data && data.message) ? data.message : 'Failed to send OTP. Try again.', 'error');
          }
        }).fail(function (jqXHR, textStatus, errorThrown) {
          showMsg('Network error while sending OTP.', 'error');
          console.error('Send OTP error:', textStatus, errorThrown);
        }).always(function () {
          $sendBtn.prop('disabled', false);
        });
      }

      // Filter chemicals on search input
    $('#chemical_search').on('input', function () {
      var filter = $(this).val().toLowerCase();
      $('.chemical-item').each(function () {
        var label = $(this).find('label').text().toLowerCase();
        $(this).toggle(label.indexOf(filter) > -1);
      });
    });

    // Function to update selected tags above
    function updateSelectedChemicalTags() {
      var $container = $('#selected_chemicals');
      $container.empty();

      $('.chemical-checkbox:checked').each(function () {
        var id = $(this).val();
        var label = $(this).next('label').text();

        var $tag = $('<span>')
          .addClass('badge bg-success me-2 mb-2')
          .css('cursor', 'pointer')
          .text(label + ' ');

        var $cross = $('<span>')
          .html('&times;')
          .css({ 'margin-left': '6px', 'font-weight': 'bold', 'cursor': 'pointer' })
          .on('click', function () {
            // Uncheck the checkbox and update tags & select all state
            $('#chemical_' + id).prop('checked', false);
            updateSelectedChemicalTags();
            updateSelectAllChemicals();
          });

        $tag.append($cross);
        $container.append($tag);
      });
    }

    // Update the "Select All" checkbox state
    function updateSelectAllChemicals() {
      var total = $('.chemical-checkbox').length;
      var checked = $('.chemical-checkbox:checked').length;

      $('#select_all_chemicals')
        .prop('checked', total === checked && total > 0)
        .prop('indeterminate', checked > 0 && checked < total);
    }

    // When any chemical checkbox changes, update tags and select all checkbox
    $('.chemical-checkbox').on('change', function () {
      updateSelectedChemicalTags();
      updateSelectAllChemicals();
    });

    // When Select All is toggled, check/uncheck all checkboxes and update tags
    $('#select_all_chemicals').on('change', function () {
      $('.chemical-checkbox').prop('checked', $(this).is(':checked'));
      updateSelectedChemicalTags();
    });

    // On page load, update selected tags and select all state (useful if old data restored)
    updateSelectedChemicalTags();
    updateSelectAllChemicals();



    $sendBtn.on('click', function () {
      if (!validateFields('send')) return;

      var captcha = $('#captcha_input').val().trim();
      if (!captcha) {
        showMsg('Please enter CAPTCHA before sending OTP.', 'error');
        return;
      }

      // Verify captcha first
      $.ajax({
        url: "{{ route('verify.captcha') }}", // 👈 you’ll create this route
        method: 'POST',
        data: {
          captcha: captcha,
          _token: csrfToken
        },
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            sendOtp(); // 👈 call actual OTP send logic
          } else {
            showMsg(response.message || 'Invalid CAPTCHA entered.', 'error');
            $('#captcha_input').val('').focus();
            $('#reload-captcha').click(); // refresh on fail
          }
        },
        error: function () {
          showMsg('Error verifying CAPTCHA.', 'error');
        }
      });
    });


    // VERIFY OTP
    $verifyBtn.on('click', function () {
      if (!validateFields('verify')) return;

      var otp = $otpInput.val().trim();
      if (!otp) {
        showMsg('Enter OTP to verify.', 'error');
        return;
      }

      var mobile = $('input[name="mobile_no"]').val() || '';
      var email = $('input[name="email"]').val() || '';
      // var policy = $('input[name="policy"]').val() || '';

      showMsg('Verifying OTP...');
      $verifyBtn.prop('disabled', true);

      $.ajax({
        url: verifyOtpAjaxUrl,
        method: 'POST',
        data: { otp, mobile, email, _token: csrfToken },
        dataType: 'json'
      }).done(function (data) {
        if (data && data.success) {
          showMsg(data.message || 'OTP verified.', 'success');
          $otpVerifiedField.val('1');
          $createBtn.show().prop('disabled', false);
          $sendBtn.prop('disabled', true);
          $verifyBtn.prop('disabled', true);
          $otpInput.prop('readonly', true);
        } else {
          showMsg((data && data.message) ? data.message : 'OTP verification failed.', 'error');
        }
      }).fail(function (jqXHR, textStatus, errorThrown) {
        showMsg('Network error while verifying OTP.', 'error');
        console.error('Verify OTP error:', textStatus, errorThrown);
      }).always(function () {
        // $verifyBtn.prop('disabled', false);
      });
    });

    // Prevent submit unless OTP verified
    // $('form').on('submit', function (e) {
    //   if ($otpVerifiedField.val() !== '1') {
    //     e.preventDefault();
    //     showMsg('Please verify OTP before creating account.', 'error');
    //     $otpInput.focus();
    //     return false;
    //   }
    // });

    $('#select_all_chemicals').on('change', function () {
    var isChecked = $(this).is(':checked');
    $('.chemical-checkbox').prop('checked', isChecked);
  });

  // Optional: if any chemical is manually unchecked, uncheck "Select All"
  $('.chemical-checkbox').on('change', function () {
    if ($('.chemical-checkbox:checked').length !== $('.chemical-checkbox').length) {
      $('#select_all_chemicals').prop('checked', false);
    } else {
      $('#select_all_chemicals').prop('checked', true);
    }
  });

  // On page load: auto-check "Select All" if all checkboxes were restored as checked
  if ($('.chemical-checkbox:checked').length === $('.chemical-checkbox').length) {
    $('#select_all_chemicals').prop('checked', true);
  }

  $('#reload-captcha').click(function () {
    var refreshCapcthaUrl = "{{ route('refresh.capctha') }}";
        $.ajax({
            type: 'GET',
            url: refreshCapcthaUrl,
            success: function (data) {
                $('#captcha-img').attr('src', data.captcha + '?' + Date.now()); // Force no-cache
            },
            error: function (xhr, status, error) {
                console.error('Captcha reload failed:', error);
            }
        });
    });
  });

  $('#stateDropdown').on('change', function () {
    var stateCode = $(this).val();
    //  console.log("Element count:", $('#stateDropdown').length);
    // console.log($(this).val(),1);
    $('#districtDropdown').html('<option value="">Loading...</option>');
    if (stateCode) {
      // console.log(stateCode,1);
      $.ajax({
        url: '{{ route("get.districts.by.state") }}',
        type: 'GET',
        data: { state_code: stateCode },
        success: function (response) {
          var options = '<option value="">-- Select District --</option>';
          $.each(response, function (key, district) {
            options += '<option value="' + district.id + '">' + district.district_name + '</option>';
          });
          $('#districtDropdown').html(options);
        },
        error: function () {
          $('#districtDropdown').html('<option value="">Error loading districts</option>');
        }
      });
    } else {
      $('#districtDropdown').html('<option value="">-- Select District --</option>');
    }
  });


  // if ($("#registrationForm").length > 0) {
  //       $("#registrationForm").validate({
  //           rules: {
  //               bank_user_name: { required: true, maxlength: 100 },
  //               bank_name: { required: true, maxlength: 200 },
  //               branch_address: { required: true, maxlength: 150 },
  //               bank_account_no: { required: true, maxlength: 20 },
  //               ifsc_code: { required: true, maxlength: 20 }
  //           },
  //           messages: {
  //               bank_user_name: { required: "Please enter account holder name" },
  //               bank_name: { required: "Please enter bank name" },
  //               branch_address: { required: "Please enter branch address" },
  //               bank_account_no: { required: "Please enter account number" },
  //               ifsc_code: { required: "Please enter IFSC code" }
  //           },
  //           submitHandler: function (form) {
  //               var accountField = $('#bank_account_no');
  //               var originalAccountNumber = accountField.val();

  //               // Prevent masked value from being submitted
  //               if (!/^[0-9]{9,20}$/.test(originalAccountNumber)) {
  //                   alert("Please enter a valid bank account number.");
  //                   return false;
  //               }
                
  //               // console.log(session);
  //               // alert(session);
  //               // Session-based salt (Blade syntax)
  //               var salted = {{ Session::get('random_session_id2') }} + originalAccountNumber + {{ Session::get('random_session_id1') }};

  //               // console.log(Session::get('random_session_id2'));
  //               // console.log(salted);
  //               // alert(salted);
  //               // AES encryption
  //               var key = CryptoJS.enc.Hex.parse("0123456789abcdef0123456789abcdef");
  //               var iv = CryptoJS.enc.Hex.parse("abcdef9876543210abcdef9876543210");
  //               // alert(key);
  //               var encrypted = CryptoJS.AES.encrypt(salted, key, {
  //                  iv,padding: CryptoJS.pad.ZeroPadding,
  //               });
  //               // console.log(salted);
  //               // alert(encrypted);
  //               accountField.val(encrypted.toString());

  //               form.submit();
  //           }
  //       });
  //   }


 
  // validation

  $('#password').bind("cut copy paste",function(e) {
      e.preventDefault();
  });
    const maxLengths = {
        authorised_person_email: 100,
        industry_email: 100,
        industry_name: 400,
        mobile_no: 15,
        username: 30,
        locality: 200,
        pan_no: 10,
        company_gst: 15,
        industry_pincode: 6,
    };

    const patterns = {
        authorised_person_email: /^[a-zA-Z0-9._@-]+$/,
        industry_email: /^[a-zA-Z0-9._@-]+$/,
        industry_name: /^[a-zA-Z\s'-]*$/,
        mobile_no: /^[0-9+]*$/,
        username: /^[a-zA-Z0-9_-]*$/,
        website: /^[a-zA-Z0-9.:/?&=_-]*$/,
        locality: /^[a-zA-Z0-9\s.,#:/()-]*$/,
        pan_no: /^[A-Z0-9]*$/,
        company_gst: /^[A-Z0-9]$/,
        industry_pincode: /^[0-9]*$/,
    };

    const fields = Object.keys(maxLengths);

    fields.forEach(function (field) {
        const $input = $('#' + field);
        const $errorEl = $('#' + field + '_error');

        // Keypress restriction
        $input.on('keypress', function (e) {
            const char = String.fromCharCode(e.which);
            if (!patterns[field].test(char)) {
                e.preventDefault();
            }
        });

        // Paste restriction
        $input.on('paste', function (e) {
            const pasteData = e.originalEvent.clipboardData.getData('text');
            if (!patterns[field].test(pasteData) || pasteData.length > maxLengths[field]) {
                e.preventDefault();
                if ($errorEl.length) {
                    $errorEl.text('Pasted content contains invalid characters or is too long.');
                }
            }
        });

        // Blur/change validation
        $input.on('blur change', function () {
            const val = $input.val().trim();
            if ($errorEl.length) $errorEl.text('');

            if (val.length > maxLengths[field]) {
                $errorEl.text('Input is too long.');
            } else if (!patterns[field].test(val)) {
                $errorEl.text('Invalid characters used.');
            }

            // Extra email-specific validation
            if (field === 'industry_email') {
                const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!emailPattern.test(val)) {
                    $errorEl.text('Please enter a valid email address.');
                } else if (val.includes('..') || val.split('@').length !== 2) {
                    $errorEl.text('Invalid email format.');
                }
            }
            if (field === 'authorised_person_email') {
                const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!emailPattern.test(val)) {
                    $errorEl.text('Please enter a valid email address.');
                } else if (val.includes('..') || val.split('@').length !== 2) {
                    $errorEl.text('Invalid email format.');
                }
            }
        });
    });


  
// });
  //  $('#stateDropdown').on('change', function () {
  //   var stateCode = $(this).val();
  //   console.log(stateCode);
  //   $('#districtDropdown').html('<option value="">Loading...</option>');

  //   if (stateCode) {
  //     $.ajax({
  //       url: '{{ route("get.districts.by.state") }}', // You'll define this route in web.php
  //       type: 'GET',
  //       data: { state_code: stateCode },
  //       success: function (response) {
  //         var options = '<option value="">-- Select District --</option>';
  //         $.each(response, function (key, district) {
  //           options += '<option value="' + district.id + '">' + district.district_name + '</option>';
  //         });
  //         $('#districtDropdown').html(options);
  //       },
  //       error: function () {
  //         $('#districtDropdown').html('<option value="">Error loading districts</option>');
  //       }
  //     });
  //   } else {
  //     $('#districtDropdown').html('<option value="">-- Select District --</option>');
  //   }
  // });

  $(document).ready(function () {
     // Encryption code
  if ($("#registrationForm").length > 0) {
    console.log(144);

    $("#registrationForm").validate({
    // console.log(55);
      rules: {
            password: "required",
            pan_no: {
                required: true,
            }
        },
        messages: {
            password: "Please enter your password",
            // confirm_password: "Passwords do not match",
            pan_no: "Please enter a valid PAN"
        },
        submitHandler: function (form) { // for demo           

          console.log(558);
            var passwordField = $('#password');
            var passwordConfirmField = $('#password_confirmation');
            var panField = $('#pan_no');
            var originalPassword = passwordField.val();
            var originalConfirmPassword = passwordConfirmField.val();
            var originalPan = panField.val();

                // Prevent masked value from being submitted for account number and PAN
                // if (!/^[0-9]{9,20}$/.test(originalPassword)) {
                //     alert("Please enter a valid bank account number.");
                //     return false;
                // }
                // if (!/^[A-Z0-9]{10}$/.test(originalPan)) { // Assuming PAN is alphanumeric and 10 characters
                //     alert("Please enter a valid PAN number.");
                //     return false;
                // }

                // Session-based salt (Blade syntax)
                var saltedPassword = "{{ Session::get('random_session_id2') }}' + originalPassword + '{{ Session::get('random_session_id1') }}";
                var saltedConfirmPassword = "{{ Session::get('random_session_id2') }}' + originalConfirmPassword + '{{ Session::get('random_session_id1') }}";
                var saltedPan = "{{ Session::get('random_session_id2') }}' + originalPan + '{{ Session::get('random_session_id1') }}";

                // AES encryption
                var key = CryptoJS.enc.Hex.parse("0123456789abcdef0123456789abcdef");
                var iv = CryptoJS.enc.Hex.parse("abcdef9876543210abcdef9876543210");

                var encryptedPassword = CryptoJS.AES.encrypt(saltedPassword, key, { iv, padding: CryptoJS.pad.ZeroPadding });
                var encryptedConfirmPassword = CryptoJS.AES.encrypt(saltedConfirmPassword, key, { iv, padding: CryptoJS.pad.ZeroPadding });
                var encryptedPan = CryptoJS.AES.encrypt(saltedPan, key, { iv, padding: CryptoJS.pad.ZeroPadding });

                // Set encrypted values back to the fields before submitting
                passwordField.val(encryptedPassword.toString());
                passwordConfirmField.val(encryptedConfirmPassword.toString());
                panField.val(encryptedPan.toString());
                console.log(000);
                // Submit the form with encrypted values
                form.submit();
            // return true; // for demo

        }
    });
  }
});

</script>
{{-- @include('home.footer') --}}