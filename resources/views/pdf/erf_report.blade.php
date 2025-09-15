<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ERF Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .logo { width: 100px; }
        .footer { position: fixed; bottom: 0; text-align: center; font-size: 10px; }
    </style>
</head>
<body>

    <div style="text-align: center;">
         <img src="{{ asset('images/golden_jubilee_logo.png') }}" class="logo"> 
        <h2>Environmental Relief Fund Report</h2>
        <p>Generated on {{ now()->format('d-m-Y H:i A') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>S. No.</th>
                <th>Policy Number</th>
                <th>Owner Name</th>
                <th>UTR Number</th>
                <th>Contribution (₹)</th>
                <th>Date of Payment</th>
                <th>Insurance Company</th>
            </tr>
        </thead>
        <tbody>
            @php $serial = 1; $total = 0; @endphp
            @foreach($data as $row)
                <tr>
                    <td>{{ $serial++ }}</td>
                    <td>{{ $row->policy_number }}</td>
                    <td>{{ $row->name_of_insured_owner }}</td>
                    <td>{{ $row->erf_deposit_utr_no }}</td>
                    <td style="text-align: right;">{{ number_format($row->contribution_to_erf_rs, 2) }}</td>
                    <td>{{ $row->date_of_erf_payment }}</td>
                    <td>{{ $row->insurance_company }}</td>
                </tr>
                @php $total += $row->contribution_to_erf_rs; @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4"><strong>Total Contribution</strong></td>
                <td style="text-align: right;"><strong>₹ {{ number_format($total, 2) }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Page Footer - © {{ now()->year }} | Page Number: <span class="pageNumber"></span>
    </div>
</body>
</html>
