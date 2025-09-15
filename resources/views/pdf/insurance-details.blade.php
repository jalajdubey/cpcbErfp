<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Policy Details - {{ $insurance->policy_number }}</title>
    <style>
        body { font-family: sans-serif; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 6px; border: 1px solid #ccc; text-align: left; }
        h3 { margin-top: 0; }
    </style>
</head>
<body>
    <h3>Insurance Policy Details</h3>
    
    <table>
    <tr><th>Policy Number</th><td>{{ $insurance->policy_number }}</td></tr>
    <tr><th>Insured Company ID</th><td>{{ $insurance->insured_company_id }}</td></tr>
    <tr><th>Name of Insured Owner</th><td>{{ $insurance->name_of_insured_owner }}</td></tr>
    <tr><th>Business Type</th><td>{{ $insurance->business_type }}</td></tr>
    <tr><th>Address></th><td>{{ $insurance->address }}</td></tr>
    <tr><th>Territorial Limits District</th><td>{{ $insurance->territorial_limits_district }}</td></tr>
    
    <tr><th>Territorial Limits State</th><td>{{ $insurance->territorial_limits_state }}</td></tr>
    <tr><th>Annual Turnover Cr</th><td>{{ $insurance->annual_turnover_cr }}</td></tr>
    <tr><th>Paid Up Capital Cr</th><td>{{ $insurance->paid_up_capital_cr }}</td></tr>
    <tr><th>Paid Up Capital Cr</th><td>{{ $insurance->paid_up_capital_cr }}</td></tr>
    <tr><th>Policy Period Year</th><td>{{ $insurance->policy_period_year }}</td></tr>
    <tr><th>Policy Period Month></th><td>{{ $insurance->policy_period_month }}</td></tr>
    <tr><th>Indemnity Limit Rs</th><td>{{ $insurance->indemnity_limit_rs }}</td></tr>
    <tr><th>Premium without Tax Rs</th><td>{{ $insurance->premium_without_tax_rs }}</td></tr>
    <tr><th>Contribution To Erf Rs</th><td>{{ $insurance->contribution_to_erf_rs }}</td></tr>
    <tr><th>Date of Proposal</th><td>{{ $insurance->date_of_proposal }}</td></tr>
    <tr><th>Payment Particulars></th><td>{{ $insurance->erf_deposit_utr_no }}</td></tr>
    <tr><th>Pan Of Company</th><td>{{ $insurance->pan_of_company }}</td></tr>
    <tr><th>Gst Of Company</th><td>{{ $insurance->gst_of_company }}</td></tr>
    <tr><th>Email Of Company</th><td>{{ $insurance->email_of_company }}</td></tr>
    <tr><th>Mobile Of Company</th><td>{{ $insurance->mobile_of_company }}</td></tr>
    <tr><th>Mobile Of Policy Number</th><td>{{ $insurance->policy_number }}</td></tr>
    </table>
</body>
</html>
