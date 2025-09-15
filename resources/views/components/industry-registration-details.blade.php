
<div class="modal fade" id="industryregisterModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
<div class="content content-loader" style="text-align:center;">
			<div class="container">
				<span class="loader"></span>
			</div>
</div>    
<div class="modal-dialog" style="max-width:70%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">User Registration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="POST" action="" autocomplete="off">
                    @csrf

                    <h5 class="section-title">Entity Details</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="gst_no" class="form-label required">GST Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                <input type="text" class="form-control" id="gst_no" name="gst_no" placeholder="Enter GST Number" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="company_name" class="form-label">Name of the Company</label>
                            <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Auto Fetched from GST No" readonly>
                        </div>
                        <div class="col-md-4 field-legal-name">
                            <label for="legal_name" class="form-label">Legal Name</label>
                            <input type="text" class="form-control" id="legal_name" name="legal_name" placeholder="Auto Fetched from GST No" readonly>
                        </div>

                        <div class="row g-3 mb-3" id="email-otp-section">
                                    <div class="col-md-6">
                                        <label for="company_email" class="form-label required">Company Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" class="form-control" id="company_email" name="company_email" placeholder="Enter company email" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2 align-self-end">
                                        <button type="button" id="sendEmailOtpBtn" class="btn btn-primary">Send OTP</button>
                                    </div>

                                    <div class="col-md-4" id="otp-verify-wrapper" style="display:none;">
                                        <label for="otp">Enter OTP</label>
                                        <div class="input-group">
                                            <input type="text" id="email_otp_input" class="form-control" placeholder="Enter OTP">
                                            <button type="button" id="verifyEmailOtpBtn" class="btn btn-success">Verify</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="otp-section"  style="display: none;"><!---disable end-->

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="incorporation_date" class="form-label required">Date of Incorporation</label>
                            <input type="date" class="form-control" id="incorporation_date" name="incorporation_date" required disable>
                        </div>
                        <div class="col-md-4">
                            <label for="business_category" class="form-label required">Business Category</label>
                            <select class="form-select" id="business_category" name="business_category" disable required>
                                <option selected disabled>Select your category</option>
                                <option>Government Agency</option>
                                <option>Government-Owned Enterprise (Govt. / PSU)</option>
                                <option>Private Limited Company (Ltd.)</option>
                                <option>Proprietorship/Partnership Firm</option>
                                <option>Limited Liability Partnership (LLP)</option>
                                <option>Cooperative Society/Trust</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-12">
                            <label for="registered_address" class="form-label required">Registered Address</label>
                            <textarea class="form-control" id="registered_address" name="registered_address" rows="2" disable required></textarea>
                        </div>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="state" class="form-label required">State/UT</label>
                        <select id="state-dropdown" class="form-select" >
                            <option value="">Select State</option>
                        </select>
                                                </div>
                        <div class="col-md-4">
                            <label for="district" class="form-label required">District</label>
                            <select id="district-dropdown" class="form-select" >
                                <option value="">Select District</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="pin_code"  class="form-label required">Pin Code</label>
                            <input type="text" disable class="form-control" id="pin_code" name="pin_code" required>
                        </div>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="website" class="form-label">Website Address</label>
                            <input disable type="url" class="form-control" id="website" name="website" placeholder="https://">
                        </div>
                        <div class="col-md-4">
                            <label for="pan_no" class="form-label required">Company PAN Number</label>
                            <input type="text" class="form-control" id="pan_no" name="pan_no" required>
                        </div>
                        <div class="col-md-4">
                            <label for="tin" class="form-label required">TIN No (Tax Identification Number)</label>
                            <input type="text" class="form-control" id="tin" name="tin" required>
                        </div>
                        <div class="col-md-4">
                            <label for="cin" class="form-label required">CIN (Corporate Identification Number)</label>
                            <input type="text" class="form-control" id="cin" name="cin" required>
                        </div>
                        <div class="col-md-4 field-iec">
                            <label for="iec" class="form-label required">IEC</label>
                            <input type="text" class="form-control" id="iec" name="iec" class="hidden-field">
                        </div>
                    </div>

                    <h5 class="section-title">Authorized Person Details</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="authorized_person_name" class="form-label required">Name of Authorized Person</label>
                            <input type="text" class="form-control" id="authorized_person_name" name="authorized_person_name" required>
                        </div>

                        <div class="col-md-4">
                            <label for="authorized_person_email" class="form-label required">Authorized Person Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="authorized_person_email" name="authorized_person_email" required>
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label for=""></label>
                            <div class="form-group sendEmailOTPDiv">
                                <span class="mtop-11 btn quick-btn second-btn btn-primary" data-toggle="modal"
                                    data-target="#myModal2" id="send_auth_email_otp">Get OTP</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="authorized_person_mobile" class="form-label required">Authorized Person Mobile Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="text" class="form-control" id="authorized_person_mobile" name="authorized_person_mobile" required>
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label for=""></label>
                            <div class="form-group sendEmailOTPDiv">
                                <span class="mtop-11 btn quick-btn second-btn btn-primary" data-toggle="modal"
                                    data-target="#myModal2" id="send_auth_mob_otp">Get OTP</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mt-1">
                            <label for="authorized_person_pan" class="form-label required">PAN No/ Authority Letter</label>
                            <input type="text" class="form-control" id="authorized_pan" name="authorized_pan" required>
                        </div>
                    </div>
        
                    <div class="text-center mt-4 mb-2">
                        <button type="submit" class="submit-btn" id="butsave">Register Now</button>
                    </div>
                </div>
                </div><!---end disable-->
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
$(document).ready(function() {
    // GST Handling remains unchanged
    // Removed the alert(10) as it seems unnecessary for production code.

    $('#gst_no').blur(function() {
        var gstno = $('#gst_no').val();
        $(".content-loader").show(); // Display the loader when the AJAX call starts

        $.ajax({
            url: "{{ route('validategst') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                gst_no: gstno,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            cache: false,
            success: function(dataResult) {
               console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                // console.log(dataResult.data.tradeNam);
               // var error = dataResult.data.error;
                var tradename = dataResult.data.tradeNam;
                var legalname = dataResult.data.lgnm;
                // var errordata = dataResult.data.error;
               
                $(".content-loader").hide(); // Hide the loader when the AJAX call is complete
                 
                    // Check if error is null
                    if (dataResult.data.error === null) {
                        alert("Invalid GST Number or no data found.");
                        return false; // Prevent further execution
                    }

                // if (errordata == 'Invalid GSTIN / UID') {
                //     alert(errordata);
                //     $("#butsave").prop("disabled", true);
                // } else {
                //     $("#butsave").prop("disabled", false);
                // }
                // // Fill the company and legal names
                $('#company_name').val(legalname);
                $('#legal_name').val(tradename);

            },
            error: function(dataResult) {
                console.log(dataResult);
                $(".content-loader").hide(); // Ensure the loader is hidden even if AJAX fails
            }
        });
    });
});
//otp send and verify-otp-pag


</script>
<script>
    $('#sendEmailOtpBtn').click(function () {
        const email = $('#company_email').val();

        $.ajax({
            url: "{{ route('email.send.otp') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                company_email: email
            },
            success: function (res) {
                alert(res.message);
                $('#otp-verify-wrapper').show();
            },
            error: function (xhr) {
                alert(xhr.responseJSON.message || 'Something went wrong');
            }
        });
    });

    $('#verifyEmailOtpBtn').click(function () {
        const email = $('#company_email').val();
        const otp = $('#email_otp_input').val();

        $.ajax({
            url: "{{ route('email.verify.otp') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                company_email: email,
                otp: otp
            },
            success: function (res) {
                alert(res.verified);
                if (res.status === 'success' && res.verified === true ) {
                    $('#verifyEmailOtpBtn').removeClass('btn-success').addClass('btn-outline-success').text('Verified');
                    $('#verifyEmailOtpBtn').prop('disabled', true);
                    $('#email_otp_input').prop('readonly', true);
                    $('#otp-section').show(); 
                }
             
            },
            error: function (xhr) {
                alert(xhr.responseJSON.message || 'OTP verification failed');
            }
        });
    });
</script>
<script>
$(function () {
    // Alert test
    alert(10);

    // Blade routes with placeholder for district URL
    const statesUrl = "{{ route('states') }}";
    const districtUrlTemplate = "{{ route('districts', ['stateId' => '__STATE_ID__']) }}";

    // Load states
    $.ajax({
        url: statesUrl,
        method: 'GET',
        success: function (data) {
            data.forEach(function (state) {
                $('#state-dropdown').append(
                    `<option value="${state.id}">${state.name}</option>`
                );
            });
        },
        error: function (xhr) {
            console.error("Error loading states:", xhr.responseText);
        }
    });

    // Load districts on state change
    $('#state-dropdown').on('change', function () {
        let stateId = $(this).val();
        $('#district-dropdown').html('<option value="">Select District</option>');

        if (stateId) {
            const districtUrl = districtUrlTemplate.replace('__STATE_ID__', stateId);
            $.ajax({
                url: districtUrl,
                method: 'GET',
                success: function (data) {
                    data.forEach(function (district) {
                        $('#district-dropdown').append(
                            `<option value="${district.id}">${district.name}</option>`
                        );
                    });
                },
                error: function (xhr) {
                    console.error("Error loading districts:", xhr.responseText);
                }
            });
        }
    });
});
</script>

