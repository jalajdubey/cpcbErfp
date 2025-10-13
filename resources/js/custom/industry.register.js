
$(function () {
  console.log("✅ Industry.register.js loaded via Vite");

  const $sendBtn = $('#send_otp_btn');
  const $verifyBtn = $('#verify_otp_btn');
  const $otpInput = $('#otp_input');
  const $otpMsg = $('#otp_msg');
  const $createBtn = $('#create_account_btn');
  const $otpVerifiedField = $('#otp_verified');
  const $togglePassword = $('#togglePassword');

  const csrfToken = $('meta[name="csrf-token"]').attr('content');

  // Laravel route paths — use absolute URLs for Vite
  const sendOtpUrl = '/send-otp';
  const verifyOtpAjaxUrl = '/ajax/verify-otp';
  const verifyCaptchaUrl = '/verify-captcha';
  const refreshCaptchaUrl = '/refresh-captcha';
  const getDistrictsUrl = '/get-districts-by-state';

  // Helper: show messages
  function showMsg(text, type) {
    let cls = 'text-muted';
    if (type === 'success') cls = 'text-success';
    if (type === 'error') cls = 'text-danger';
    $otpMsg.removeClass('text-muted text-success text-danger').addClass(cls).text(text);
  }

  // === Password Toggle ===
  $togglePassword.on('click', function () {
    const $password = $('#password');
    const type = $password.attr('type') === 'password' ? 'text' : 'password';
    $password.attr('type', type);
    $(this).text(type === 'password' ? 'Show' : 'Hide');
  });

  // === Reload Captcha ===
  $('#reload-captcha').click(function () {
    $.ajax({
      type: 'GET',
      url: refreshCaptchaUrl,
      success: function (data) {
        $('#captcha-img').attr('src', data.captcha + '?' + Date.now());
      },
      error: function (xhr, status, error) {
        console.error('Captcha reload failed:', error);
      },
    });
  });

  // === State → District Dropdown ===
  $('#stateDropdown').on('change', function () {
    const stateCode = $(this).val();
    const $districtDropdown = $('#districtDropdown');

    $districtDropdown.html('<option value="">Loading...</option>');
    if (!stateCode) {
      $districtDropdown.html('<option value="">-- Select District --</option>');
      return;
    }

    $.ajax({
      url: getDistrictsUrl,
      type: 'GET',
      data: { state_code: stateCode },
      success: function (response) {
        let options = '<option value="">-- Select District --</option>';
        $.each(response, function (key, district) {
          options += `<option value="${district.id}">${district.district_name}</option>`;
        });
        $districtDropdown.html(options);
      },
      error: function () {
        $districtDropdown.html('<option value="">Error loading districts</option>');
      },
    });
  });

  // === Filter chemicals ===
  $('#chemical_search').on('input', function () {
    const filter = $(this).val().toLowerCase();
    $('.chemical-item').each(function () {
      const label = $(this).find('label').text().toLowerCase();
      $(this).toggle(label.indexOf(filter) > -1);
    });
  });

  // === Selected Chemical Badges ===
  function updateSelectedChemicalTags() {
    const $container = $('#selected_chemicals');
    $container.empty();

    $('.chemical-checkbox:checked').each(function () {
      const id = $(this).val();
      const label = $(this).next('label').text();

      const $tag = $('<span>')
        .addClass('badge bg-success me-2 mb-2')
        .css('cursor', 'pointer')
        .text(label + ' ');

      $('<span>')
        .html('&times;')
        .css({ 'margin-left': '6px', 'font-weight': 'bold', 'cursor': 'pointer' })
        .on('click', function () {
          $(`#chemical_${id}`).prop('checked', false);
          updateSelectedChemicalTags();
        })
        .appendTo($tag);

      $container.append($tag);
    });
  }

  $('.chemical-checkbox').on('change', updateSelectedChemicalTags);
  updateSelectedChemicalTags();

  // === OTP Logic ===
  function validateFields() {
    // Keep your existing validation logic exactly (shortened for brevity)
    if (!$('#industry_name').val()) {
      showMsg('Please fill required fields before sending OTP.', 'error');
      return false;
    }
    return true;
  }

  $sendBtn.on('click', function () {
    if (!validateFields()) return;

    const captcha = $('#captcha_input').val().trim();
    if (!captcha) {
      showMsg('Enter CAPTCHA before sending OTP.', 'error');
      return;
    }

    $.post(verifyCaptchaUrl, { captcha, _token: csrfToken })
      .done((response) => {
        if (response.success) {
          sendOtp();
        } else {
          showMsg(response.message || 'Invalid CAPTCHA.', 'error');
          $('#captcha_input').val('').focus();
          $('#reload-captcha').click();
        }
      })
      .fail(() => showMsg('Error verifying CAPTCHA.', 'error'));
  });

  function sendOtp() {
    const mobile = $('input[name="mobile_no"]').val().trim();
    const email = $('input[name="industry_email"]').val().trim();

    showMsg('Sending OTP...');
    $sendBtn.prop('disabled', true);

    $.post(sendOtpUrl, { mobile, email, _token: csrfToken })
      .done((data) => {
        if (data.success) {
          showMsg(data.message || 'OTP sent successfully.', 'success');
          $otpInput.focus();
          $verifyBtn.prop('disabled', false);
        } else {
          showMsg(data.message || 'Failed to send OTP.', 'error');
        }
      })
      .fail(() => showMsg('Network error while sending OTP.', 'error'))
      .always(() => $sendBtn.prop('disabled', false));
  }

  $verifyBtn.on('click', function () {
    const otp = $otpInput.val().trim();
    if (!otp) {
      showMsg('Enter OTP to verify.', 'error');
      return;
    }

    const mobile = $('input[name="mobile_no"]').val().trim();
    const email = $('input[name="industry_email"]').val().trim();

    $.post(verifyOtpAjaxUrl, { otp, mobile, email, _token: csrfToken })
      .done((data) => {
        if (data.success) {
          showMsg('OTP verified successfully.', 'success');
          $otpVerifiedField.val('1');
          $createBtn.prop('disabled', false);
        } else {
          showMsg(data.message || 'Invalid OTP.', 'error');
        }
      })
      .fail(() => showMsg('Error verifying OTP.', 'error'));
  });

  // === Password encryption before submit ===
  $("#registrationForm").validate({
    rules: { password: "required", pan_no: { required: true } },
    messages: {
      password: "Please enter your password",
      pan_no: "Please enter a valid PAN",
    },
    submitHandler: function (form) {
      const passwordField = $('#password');
      const confirmField = $('#password_confirmation');
      const panField = $('#pan_no');

      const saltedPassword = `${window.random_salt_2}${passwordField.val()}${window.random_salt_1}`;
      const saltedConfirm = `${window.random_salt_2}${confirmField.val()}${window.random_salt_1}`;
      const saltedPan = `${window.random_salt_2}${panField.val()}${window.random_salt_1}`;

      const key = CryptoJS.enc.Hex.parse("0123456789abcdef0123456789abcdef");
      const iv = CryptoJS.enc.Hex.parse("abcdef9876543210abcdef9876543210");

      passwordField.val(CryptoJS.AES.encrypt(saltedPassword, key, { iv, padding: CryptoJS.pad.ZeroPadding }).toString());
      confirmField.val(CryptoJS.AES.encrypt(saltedConfirm, key, { iv, padding: CryptoJS.pad.ZeroPadding }).toString());
      panField.val(CryptoJS.AES.encrypt(saltedPan, key, { iv, padding: CryptoJS.pad.ZeroPadding }).toString());

      form.submit();
    },
  });
});
