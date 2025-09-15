@include('home.header')
<style>
  body {
    background-color: #f1f2f3ff;
    font-family: 'Segoe UI', Roboto, sans-serif;
  }

  .card {
    border: 0.5px solid #08921bff;
    border-radius: 15px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
  }

  .card-body {
    padding: 2rem;
  }

  .form-label.required::after {
    content: " *";
    color: #dc3545;
  }

  input.form-control:focus,
  .input-group input:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.25);
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

  .policy-header {
    background: linear-gradient(90deg, #0d6efd11, #0dcaf011);
    border-bottom: 1px solid #dee2e6;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    padding: 1rem 1.5rem;
  }

  .policy-header h5 {
    margin-bottom: 0;
    font-weight: 600;
  }

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
</style>



<div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-lg-9 col-xl-8">
        <h3 class="mb-4 text-center fw-semibold text-primary">Registration</h3>

        <form method="POST" action="{{ route('register.process', $policyData->policy_number) }}" id="registrationForm" autocomplete="off" novalidate>
          @csrf
          <input type="hidden" name="policy" value="{{ $policyData->policy_number }}">
          <input type="hidden" name="role_type" value="3">
          <input type="hidden" name="industry_id" value="{{ $policyData->id }}">
          <input type="hidden" name="policy_number" value="{{ $policyData->policy_number }}">
          <input type="hidden" name="otp_verified" id="otp_verified" value="0">

          <!-- Policy details card -->
          <div class="card mb-4">
            <div class="card-body policy-header p-3">
              <div class="d-flex align-items-center gap-3">
                <div>
                  <h5 class="mb-0">Policy details</h5>
                  <small class="small-muted">Auto-filled from policy</small>
                </div>
              </div>
            </div>

            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Policy Number</label>
                  <input class="form-control" value="{{ $policyData->policy_number }}" readonly>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Industry Name</label>
                  <input class="form-control" value="{{ $policyData->name_of_insured_owner }}" readonly>
                </div>

                <div class="col-md-4">
                  <label class="form-label">Insured Company ID</label>
                  <input class="form-control" value="{{ $policyData->insured_company_id }}" readonly>
                </div>

                <div class="col-md-8">
                  <label class="form-label">Address</label>
                  <input class="form-control" value="{{ trim(($policyData->address ?? '').' '.($policyData->address_line2 ?? '')) }}" readonly>
                </div>

                <div class="col-md-6">
                  <label class="form-label">City</label>
                  <input class="form-control" value="{{ $policyData->territorial_limits_district }}" readonly>
                </div>

                <div class="col-md-6">
                  <label class="form-label">State</label>
                  <input class="form-control" value="{{ $policyData->territorial_limits_state }}" readonly>
                </div>
              </div>
            </div>
          </div>

          <!-- User inputs -->
          <div class="card mb-4">
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label required">First Name</label>
                  <input type="text" name="firstname" class="form-control" required value="{{ old('firstname') }}">
                  @error('firstname') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label required">Last Name</label>
                  <input type="text" name="lastname" class="form-control" required value="{{ old('lastname') }}">
                  @error('lastname') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label required">Email Address</label>
                  <input type="email" name="email" class="form-control" required value="{{ old('email') }}" autocomplete="off">
                  @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label required">Mobile</label>
                  <input type="number" name="mobile_no" class="form-control" required value="{{ old('mobile_no') }}" inputmode="numeric" pattern="[0-9]{10}" maxlength="10">
                  <div class="form-text small-muted">10-digit mobile number</div>
                  @error('mobile_no') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label required">Company PAN</label>
                  <input type="text" name="pan_no" class="form-control" required value="{{ old('pan_no') }}">
                  @error('pan_no') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label required">Company GST No.</label>
                  <input type="text" name="company_gst" class="form-control" required value="{{ old('company_gst') }}">
                  @error('company_gst') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label required">Address Pincode</label>
                  <input type="number" name="industry_pincode" class="form-control" required value="{{ old('industry_pincode') }}">
                  @error('industry_pincode') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label required">Password</label>
                  <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" autocomplete="new-password" required>
                    <span class="input-group-text toggle-password" id="togglePassword">Show</span>
                  </div>
                  <div class="form-text small-muted">Min 8 characters recommended</div>
                  @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label required">Confirm Password</label>
                  <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>

                <!-- OTP block -->
                <div class="col-12 col-md-6">
                  <label class="form-label required">OTP</label>
                  <div class="d-flex flex-wrap gap-2 otp-controls">
                    <input type="text" id="otp_input" class="form-control" placeholder="Enter OTP" autocomplete="one-time-code" inputmode="numeric">
                    <button type="button" id="send_otp_btn" class="btn btn-outline-primary">Send OTP</button>
                    <button type="button" id="verify_otp_btn" class="btn btn-primary" disabled>Verify OTP</button>
                  </div>
                  <small id="otp_msg" class="form-text mt-2"></small>
                </div>

              </div>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="small-muted">Already have an account? <a href="{{ route('login') }}" class="text-decoration-none">Sign in</a></div>
            <button id="create_account_btn" class="btn btn-success px-4" type="submit" disabled>Create Account</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(function() {
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

    // 🟢 Helper: validate required fields
    function validateFields(beforeAction = 'send') {
        var firstname = $('input[name="firstname"]').val().trim();
        var lastname = $('input[name="lastname"]').val().trim();
        var email = $('input[name="email"]').val().trim();
        var mobile = $('input[name="mobile_no"]').val().trim();
        var pan = $('input[name="pan_no"]').val().trim();
        var gst = $('input[name="company_gst"]').val().trim();
        var pincode = $('input[name="industry_pincode"]').val().trim();
        var pass = $('input[name="password"]').val();
        var confirmPass = $('input[name="password_confirmation"]').val();

        // Generic required check
        if (!firstname || !lastname || !email || !mobile || !pan || !gst || !pincode || !pass || !confirmPass) {
            showMsg('Please fill in all required fields before ' + (beforeAction === 'send' ? 'sending OTP.' : 'verifying OTP.'), 'error');
            return false;
        }

        // Email format
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            showMsg('Enter a valid email address.', 'error');
            return false;
        }

        // Mobile check (10 digits)
        if (!/^[0-9]{10}$/.test(mobile)) {
            showMsg('Enter a valid 10-digit mobile number.', 'error');
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
        if (!gstRegex.test(gst)) {
            showMsg('Enter a valid 15-character GST number (e.g. 22ABCDE1234F1Z5).', 'error');
            return false;
        }
        // Pincode check (6 digits)
        if (!/^[0-9]{6}$/.test(pincode)) {
            showMsg('Enter a valid 6-digit pincode.', 'error');
            return false;
        }

        // Password match
        if (pass !== confirmPass) {
            showMsg('Passwords do not match.', 'error');
            return false;
        }

        return true;
    }

    // SEND OTP
    $sendBtn.on('click', function () {
        if (!validateFields('send')) return;

        var mobile = $('input[name="mobile_no"]').val().trim();
        var email  = $('input[name="email"]').val().trim();
        var policy = $.trim($('input[name="policy"]').val() || '');

        showMsg('Sending OTP...');
        $sendBtn.prop('disabled', true);

        $.ajax({
            url: sendOtpUrl,
            method: 'POST',
            data: { mobile, email, policy, _token: csrfToken },
            dataType: 'json'
        }).done(function(data) {
            if (data && data.success) {
                showMsg(data.message || 'OTP sent. Check your phone/email.', 'success');
                $otpInput.focus();
                $verifyBtn.prop('disabled', false);
            } else {
                showMsg((data && data.message) ? data.message : 'Failed to send OTP. Try again.', 'error');
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            showMsg('Network error while sending OTP.', 'error');
            console.error('Send OTP error:', textStatus, errorThrown);
        }).always(function() {
            $sendBtn.prop('disabled', false);
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
        var policy = $('input[name="policy"]').val() || '';

        showMsg('Verifying OTP...');
        $verifyBtn.prop('disabled', true);

        $.ajax({
            url: verifyOtpAjaxUrl,
            method: 'POST',
            data: { otp, mobile, email, policy, _token: csrfToken },
            dataType: 'json'
        }).done(function(data) {
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
        }).fail(function(jqXHR, textStatus, errorThrown) {
            showMsg('Network error while verifying OTP.', 'error');
            console.error('Verify OTP error:', textStatus, errorThrown);
        }).always(function() {
            // $verifyBtn.prop('disabled', false);
        });
    });

    // Prevent submit unless OTP verified
    $('form').on('submit', function (e) {
        if ($otpVerifiedField.val() !== '1') {
            e.preventDefault();
            showMsg('Please verify OTP before creating account.', 'error');
            $otpInput.focus();
            return false;
        }
    });
});
</script>
<!-- @include('home.footer') -->


