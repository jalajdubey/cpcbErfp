@include('home.header')


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
        <div><strong>Industry:</strong> <span id="pv_industry"></span></div>
        <div><strong>Address:</strong> <span id="pv_addr"></span></div>
        <button id="goRegisterBtn" class="btn btn-success mt-3 d-none">Go to Registration</button>
    </div>
</div>


@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#ajaxVerifyBtn').on('click', function(e) {
        e.preventDefault(); // stop form submit
    // console.log(55555);
        const policy  = $('#policy_number').val().trim();
        const alertBox = $('#alert');
        const preview  = $('#preview');

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
            success: function(data, textStatus, jqXHR) {
                if (!data.ok) {
                    alertBox.removeClass().addClass('alert alert-danger').text(data.message || 'Policy not found.');
                    return;
                }

                // success - show preview
                $('#pv_policy').text(data.data.policy_number);
                $('#pv_industry').text(data.data.industry_name ?? '-');
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
            error: function(jqXHR, textStatus, errorThrown) {
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
@endpush





