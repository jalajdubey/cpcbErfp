<table class="table table-bordered">
<a href="{{ route('insurance.export.pdf', $insurance->policy_number) }}" class="btn btn-outline-danger btn-sm float-end" target="_blank">
    <i class="bi bi-file-earmark-pdf"></i> Download PDF
</a>
    <tr><th>Policy Number</th><td>{{ $insurance->policy_number }}</td></tr>
    <tr><th>Insured Company ID</th><td>{{ $insurance->insured_company_id }}</td></tr>
    <tr><th>Name of Insured Owner</th><td>{{ $insurance->name_of_insured_owner }}</td></tr>
    <tr><th>Business Type</th><td>{{ $insurance->business_type }}</td></tr>
    <tr><th>Address</th><td>{{ $insurance->address }}</td></tr>
    <tr><th>Territorial Limits District</th><td>{{ $insurance->territorial_limits_district }}</td></tr>
    
    <tr><th>Territorial Limits State</th><td>{{ $insurance->territorial_limits_state }}</td></tr>
    <tr><th>Annual Turnover Cr</th><td>{{ $insurance->annual_turnover_cr }}</td></tr>
    <tr><th>Paid Up Capital Cr</th><td>{{ $insurance->paid_up_capital_cr }}</td></tr>
    <tr><th>Policy Duration Year </th><td>{{ $insurance->policy_duration_year  }}</td></tr>
    <tr><th>Policy Valid Upto</th><td>{{ $insurance->policy_valid_upto }}</td></tr>
    
    <tr><th>Indemnity Limit Rs</th><td>{{ $insurance->indemnity_limit_rs }}</td></tr>
    <tr><th>Date of erf payment</th><td>{{ $insurance->date_of_erf_payment }}</td></tr>
    <tr><th>Any One year limit rs </th><td>{{ $insurance->any_one_year_limit_rs  }}</td></tr>
    <tr><th>Any One Accident limit Rs </th><td>{{ $insurance->any_one_accident_limit_rs  }}</td></tr>
    <tr><th>Premium without Tax Rs</th><td>{{ $insurance->premium_without_tax_rs }}</td></tr>
    <tr><th>Contribution To Erf Rs</th><td>{{ $insurance->contribution_to_erf_rs }}</td></tr>
    <tr><th>Date of Proposal</th><td>{{ $insurance->date_of_proposal }}</td></tr>
    <tr><th>Payment Particulars></th><td>{{ $insurance->erf_deposit_utr_no }}</td></tr>
    <tr><th>Pan Of Company</th><td>{{ $insurance->pan_of_company }}</td></tr>
    <tr><th>Gst Of Company</th><td>{{ $insurance->gst_of_company }}</td></tr>
    <tr><th>Email Of Company</th><td>{{ $insurance->email_of_company }}</td></tr>
    <tr><th>Mobile Of Company</th><td>{{ $insurance->mobile_of_company }}</td></tr>
    <tr><th>Mobile Of Policy Number</th><td>{{ $insurance->policy_number }}</td></tr>
    <!-- Add more fields as needed -->
</table>