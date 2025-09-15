<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Policy PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td {
            padding: 8px;
            border: 1px solid #ccc;
            vertical-align: top;
        }
        .table th {
            background-color: #f0f4f8;
            font-weight: bold;
            color: #2c3e50;
            width: 30%;
        }
        h3 {
            color: #084095;
            margin-bottom: 20px;
        }
        a { color: #0d6efd; text-decoration: none; }
    </style>
</head>
<body>

    <h3>Policy Details: {{ $policy->policy_number }}</h3>

    <table class="table">
        <tbody>
            <tr><th>Policy Number</th><td>{{ $policy->policy_number }}</td></tr>
            <tr><th>Insured Owner</th><td>{{ $policy->name_of_insured_owner }}</td></tr>
            <tr><th>Business Type</th><td>{{ $policy->business_type }}</td></tr>
            <tr><th>Annual Turnover</th><td>₹{{ number_format($policy->annual_turnover_cr, 2) }} Cr</td></tr>
            <tr><th>Paid Up Capital</th><td>₹{{ number_format($policy->paid_up_capital_cr, 2) }} Cr</td></tr>
            <tr><th>Indemnity Limit</th><td>₹{{ number_format($policy->indemnity_limit_rs, 2) }} </td></tr>
            <tr><th>Premium (No Tax)</th><td>₹{{ number_format($policy->premium_without_tax_rs, 2) }} </td></tr>
            <tr><th>Contribution to ERF</th><td>₹{{ number_format($policy->premium_without_tax_rs, 2) }}</td></tr>
            <tr><th>Policy Period Duration</th><td>{{ $policy->policy_duration_year  }}</td></tr>
           
            <tr><th>Date of Proposal</th><td>{{ $policy->policy_valid_upto }}</td></tr>
            <tr><th>Any One Year Limit Rs</th><td>{{ $policy->any_one_year_limit_rs }}</td></tr>
             <tr><th>Any One Accident Limit Rs</th><td>{{ $policy->any_one_accident_limit_rs }}</td></tr>
            <tr><th>Payment Particulars</th><td>{{ $policy->erf_deposit_utr_no }}</td></tr>
            <tr><th>PAN</th><td>{{ $policy->pan_of_company }}</td></tr>
            <tr><th>GST</th><td>{{ $policy->gst_of_company }}</td></tr>
            <tr><th>Email</th><td>{{ $policy->email_of_company }}</td></tr>
            <tr><th>Mobile</th><td>{{ $policy->mobile_of_company }}</td></tr>
            <tr>
                <th>Documents</th>
                <td>
                    @if ($policy->uploadedDocuments->count())
                        <ul style="margin: 0; padding-left: 16px;">
                            @foreach($policy->uploadedDocuments as $doc)
                                <li>{{ basename($doc->file_path) }}</li>
                            @endforeach
                        </ul>
                    @else
                        <em>No documents uploaded.</em>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

</body>
</html>
