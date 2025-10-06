@include('layouts.header')

@include('layouts.sidebar')
@include('layouts.top-navbar')

<style>
  h5 {
    color: linear-gradient(269.87deg, #084095 2.99%, #108e16 96.59%);
  }

  h3 {
    color: linear-gradient(269.87deg, #084095 2.99%, #108e16 96.59%);
  }

  .form-section {
    border: 2px solid #c2cfc4;
    /* Grey border */
    border-radius: 15px;
    /* border-top: 1px solid #e2e8f0; */
    /* padding-top: 2rem; */
    /* margin-top: 1.5rem; */
  }

  .form-section-number {
    background-color: #08921b color: #0a58ca;
    font-weight: bold;
    margin-right: 0.5rem;
  }

  @media (min-width: 768px) {
    .form-section {
      margin-left: 1rem;
      margin-right: 1rem;
    }

    .card-header {
      /* background-image: linear-gradient(#023b0e, #086f1e); */
      background: linear-gradient(to bottom right, #f36c1d, #8c8e92);
      padding: 1rem 1.25rem;
      border-top-left-radius: 12px;
      border-top-right-radius: 12px;
      border-bottom: 1px solid #dbeafe;
    }

    .card-header h5 {
      margin-bottom: 0;
      font-weight: 600;
      color: #f7f8fa;
    }

    .card {
      border: 1px solid #dee2e6;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
      background-color: #fff;
      margin-bottom: 1.5rem;
      padding: 0;
      overflow: hidden;
      /* Ensure curves are not hidden */
    }
  }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">



<div class="container mb-5" style="max-width:560px;">
  <h3 class="mb-3">Verify Policy Number</h3>

  <div id="alert" class="alert d-none"></div>

  <form id="policyForm" method="POST" action="{{ route('policy.check.verify') }}">
    @csrf

    <div class="mb-3">
      <label class="form-label">Policy Number</label>
      <input type="text" name="policy_number" id="policy_number" class="form-control" required>
      @error('policy_number')
        <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>

    <div class="d-flex gap-2">

      <button type="submit" id="ajaxVerifyBtn" class="btn btn-primary">Verify & Continue</button>
    </div>
  </form>

  <hr class="my-4">

  <div id="preview" class="border rounded p-3 d-none">
    <h6 class="mb-2">Policy Details</h6>
    <div><strong>Policy:</strong> <span id="pv_policy"></span></div>
    <div><strong>Insurance Company Name:</strong> <span id="pv_insurance_name"></span></div>
    <div><strong>Start Date:</strong> <span id="pv_start_date"></span></div>
    <div><strong>End Date:</strong> <span id="pv_end_date"></span></div>
    <div><strong>ERFO Amount:</strong> <span id="pv_erpo_amount"></span></div>
    <button id="goRegisterBtn" class="btn btn-success mt-3 d-none">Go to Registration</button>
  </div>

  <form method="POST" action="{{ route('register.process') }}" id="registrationForm" autocomplete="off" novalidate>
    @csrf




    <div class="card form-section">
      <div class="card-header">
        <h5 class="mb-0"><span class="form-section-number">Policy Number</h5>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="mb-3">
            <label class="form-label">Policy Number</label>
            <input type="text" name="policy_number" id="policy_number" class="form-control" required>
            @error('policy_number')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="d-flex gap-2">

            <button type="submit" id="ajaxVerifyBtn" class="btn btn-primary">Verify & Continue</button>
          </div>
        </div>
      </div>

      <div id="preview" class="border rounded p-3 d-none">
        <h6 class="mb-2">Policy Details</h6>
        <div><strong>Policy:</strong> <span id="pv_policy"></span></div>
        <div><strong>Insurance Company Name:</strong> <span id="pv_insurance_name"></span></div>
        <div><strong>Start Date:</strong> <span id="pv_start_date"></span></div>
        <div><strong>End Date:</strong> <span id="pv_end_date"></span></div>
        <div><strong>ERFO Amount:</strong> <span id="pv_erpo_amount"></span></div>
        <button id="goRegisterBtn" class="btn btn-success mt-3 d-none">Go to Registration</button>
      </div>

      <div class="card-header">
        <h5 class="mb-0"><span class="form-section-number">Policy Document</h5>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-mb-3">
            <label for="pdfFile" class="form-label">Upload PDF Document</label>
            <input type="file" name="pdf" id="pdfFile" class="form-control underline-only" accept=".pdf" required>
            @error('dc_address') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
          </div>
        </div>
      </div>
    </div>
    <div class="card form-section">
      <div class="card-header">
        <h5 class="mb-0"><span class="form-section-number">District Collector’s office address</h5>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-mb-3">
            <label class="form-label required">Address</label>
            <input type="text" name="dc_address" class="form-control underline-only" required
              value="{{ old('dc_address') }}" maxlength="400" autocomplete="off">
            @error('dc_address') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
          </div>
        </div>
      </div>
    </div>
    {{-- <div class="card form-section">
      <div class="card-header">
        <h5 class="mb-0"><span class="form-section-number">Authorised Person Info</h5>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-8">
            <label class="form-label required">Email Address</label>
            <input type="email" name="authorised_person_email" class="form-control underline-only" required
              value="{{ old('authorised_person_email') }}" maxlength="100" autocomplete="off">
            @error('authorised_person_email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
          </div>

          <div class="col-md-4">
            <label class="form-label required">Mobile</label>
            <input type="number" name="mobile_no" class="form-control underline-only" required
              value="{{ old('mobile_no') }}" inputmode="numeric" pattern="[0-9]{10}" maxlength="15" autocomplete="off">
            <div class="form-text small-muted">10-digit mobile number</div>
            @error('mobile_no') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-4">
            <label class="form-label">Remarks</label>
            <input type="text" name="comment" class="form-control underline-only" required value="{{ old('comment') }}"
              inputmode="numeric" maxlength="900" autocomplete="off">
            <div class="form-text small-muted"></div>
            @error('comment') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
          </div>

        </div>
      </div>
    </div> --}}
    <div class="">
      <div class="form-check">
        <input type="checkbox" name="declare" id="declare" class="form-check-input">
        I hereby confirm all the data is correct
      </div>

    </div>
    <!-- Submit -->
    <div class="d-flex justify-content-between align-items-center mt-4">
      <button id="create_account_btn" class="btn btn-success px-4" type="submit">Submit</button>
    </div>
  </form>


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
</div>


{{-- @push('scripts') --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script>
  $(document).ready(function () {
    $('#ajaxVerifyBtn').on('click', function (e) {
      e.preventDefault(); // stop form submit
      // console.log(55555);
      const policy = $('#policy_number').val().trim();
      const alertBox = $('#alert');
      const preview = $('#preview');

      alertBox.removeClass().addClass('alert d-none');
      preview.addClass('d-none');

      if (!policy) {
        alertBox.removeClass().addClass('alert alert-danger').text('Please enter a policy number.');
        return;
      }

      $.ajax({
        url: "{{ route('policy.check.ajax') }}",

        type: "POST",
        data: JSON.stringify({ policy_number: policy }),
        contentType: "application/json",
        dataType: "json",
        headers: {
          "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        success: function (data, textStatus, jqXHR) {
          // console.log("Ajax Success Data:", data);
          // alert('hello');
          // Clear previous alert messages
          alertBox.removeClass().addClass('alert d-none');

          if (!data.ok) {
            alertBox.removeClass().addClass('alert alert-danger').text(data.message || 'Policy not found.');
            return;
          }

          // success - show preview
          $('#pv_policy').text(data.data.policy_number);
          $('#pv_insurance_name').text(data.data.insurance_company_name ?? '-');
          $('#pv_start_date').text(data.data.policy_start_date ?? '-');
          $('#pv_end_date').text(data.data.policy_end_date ?? '-');
          $('#pv_erpo_amount').text(data.data.erfo_amount ?? '-');
          const addr = [
            data.data.address_line1,
            data.data.address_line2,
            data.data.city,
            data.data.state,
            data.data.pincode
          ].filter(Boolean).join(', ');
          $('#pv_addr').text(addr || '-');
          preview.removeClass('d-none');

          // redirect after short delay
          // const target = `{{ route('register.form') }}?policy=${encodeURIComponent(data.data.policy_number)}`;
          // setTimeout(() => { window.location.href = target; }, 800);
        },
        error: function (jqXHR, textStatus, errorThrown) {
          let msg = 'Something went wrong. Please try again.';
          if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
            msg = jqXHR.responseJSON.message;
          }
          alertBox.removeClass().addClass('alert alert-danger').text(msg);
        }
      });
    });
  });
</script>
<!-- <script>
document.getElementById('ajaxVerifyBtn').addEventListener('click', async function(e){
    e.preventDefault(); // stop form submit
    const policy = document.getElementById('policy_number').value.trim();
    const alertBox = document.getElementById('alert');
    const preview  = document.getElementById('preview');

    alertBox.className = 'alert d-none';
    preview.classList.add('d-none');

    if(!policy){
        alertBox.className = 'alert alert-danger';
        alertBox.textContent = 'Please enter a policy number.';
        return;
    }

    try{
        const resp = await fetch('{{ route('policy.check.ajax') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ policy_number: policy })
        });

        const data = await resp.json();

        if(!resp.ok || !data.ok){
            alertBox.className = 'alert alert-danger';
            alertBox.textContent = (data && data.message) ? data.message : 'Policy not found.';
            return;
        }

        // optional: show preview briefly
        document.getElementById('pv_policy').textContent   = data.data.policy_number;
        document.getElementById('pv_industry').textContent = data.data.industry_name ?? '-';
        const addr = [data.data.address_line1, data.data.address_line2, data.data.city, data.data.state, data.data.pincode]
                        .filter(Boolean).join(', ');
        document.getElementById('pv_addr').textContent = addr || '-';
        preview.classList.remove('d-none');

        // redirect using query string (slashes safe)
        const target = `{{ route('register.form') }}?policy=${encodeURIComponent(data.data.policy_number)}`;
        setTimeout(() => { window.location.href = target; }, 800);

    }catch(e){
        alertBox.className = 'alert alert-danger';
        alertBox.textContent = 'Something went wrong. Please try again.';
    }
});
</script> -->
{{-- @endpush --}}