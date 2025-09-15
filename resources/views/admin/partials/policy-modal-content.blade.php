<style>
  .custom-policy-table {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
  }

  .custom-policy-table th {
    background-color: #f0f4f8;
    font-weight: 600;
    color: #2c3e50;
    width: 30%;
    vertical-align: top;
    border-color: #e0e6ed;
  }

  .custom-policy-table td {
    background-color: #fcfcfc;
    color: #4a4a4a;
    border-color: #e8edf3;
  }

  .custom-policy-table tr:nth-child(even) td {
    background-color: #f8fbfc;
  }

  .custom-policy-table a {
    color: #0d6efd;
    text-decoration: none;
  }

  .custom-policy-table a:hover {
    text-decoration: underline;
    color: #084298;
  }

  .card-header h5 {
    font-weight: 600;
    color: #084095;
  }
</style>

<div class="card shadow-sm border-0 mb-4">
<div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
    <h5 class="mb-0 text-primary">Policy Details</h5>
    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

    <div class="card-body p-4">
        <table class="table table-bordered align-middle custom-policy-table">
            <tbody>
                <tr>
                    <th scope="row" style="width: 30%;">Policy Number</th>
                    <td>{{ $policy->policy_number }}</td>
                </tr>
                <tr>
                    <th>Insured Owner</th>
                    <td>{{ $policy->name_of_insured_owner }}</td>
                </tr>
                <tr>
                    <th>Business Type</th>
                    <td>{{ $policy->business_type }}</td>
                </tr>
                <tr>
                    <th>Annual Turnover</th>
                    <td>₹{{ number_format($policy->annual_turnover_cr, 2) }} Cr</td>
                </tr>
                <tr>
                    <th>Paid Up Capital Cr</th>
                    <td>₹{{ number_format($policy->paid_up_capital_cr, 2) }} Cr</td>
                </tr>
                <tr>
                    <th>Indemnity Limit  Rs</th>
                    <td>₹{{ number_format($policy->indemnity_limit_rs, 2) }} Cr</td>
                </tr>
                 <tr>
                    <th>Any One year limit rs</th>
                    <td>₹{{ number_format($policy->any_one_year_limit_rs, 2) }} Cr</td>
                </tr>
                <tr>
                    <th>Any One Accident limit Rs</th>
                    <td>₹{{ number_format($policy->any_one_accident_limit_rs , 2) }} Cr</td>
                </tr>
                <tr>
                    <th>Premium without Tax Rs</th>
                    <td>₹{{ number_format($policy->premium_without_tax_rs, 2) }} Cr</td>
                </tr>
                <tr>
                    <th>Contribution To Erf Rs</th>
                    <td>₹{{ number_format($policy->premium_without_tax_rs, 2) }} Cr</td>
                </tr>
                <tr>
                    <th>Policy Period Duration</th>
                    <td>{{  $policy->policy_duration_year}}</td>
                </tr>
                <tr>
                    <th>Policy Period </th>
                    <td>{{  $policy->policy_valid_upto}}</td>
                </tr>
                <tr>
                    <th>Date of Proposal</th>
                    <td>{{  $policy->date_of_proposal}}</td>
                </tr>
                <tr>
                    <th>ERF Deposit UTR NO.</th>
                    <td>{{  $policy->erf_deposit_utr_no}}</td>
                </tr>
                 <tr>
                    <th>Date of ERFP Payment</th>
                    <td>{{  $policy->date_of_erf_payment}}</td>
                </tr>
                <tr>
                    <th>Pan Of Company</th>
                    <td>{{  $policy->pan_of_company}}</td>
                </tr>
                <tr>
                    <th>Gst Of Company</th>
                    <td>{{  $policy->gst_of_company}}</td>
                </tr>
                <tr>
                    <th>Email Of Company</th>
                    <td>{{  $policy->email_of_company}}</td>
                </tr>
                <tr>
                    <th>Mobile Of Company</th>
                    <td>{{  $policy->mobile_of_company}}</td>
                </tr>
                <tr>
                    <th> Policy Number</th>
                    <td>{{  $policy->policy_number}}</td>
                </tr>
                <tr>
                    <th>Uploaded Documents</th>
                    <td>
                        @if ($policy->uploadedDocuments->count())
                            <ul class="mb-0 ps-3">
                                @foreach($policy->uploadedDocuments as $doc)
                                    <li>
                                        <i class="bi bi-file-earmark-text me-1 text-primary"></i>
                                        <a href="{{ asset('storage/app/public/' . $doc->file_path) }}" target="_blank">
                                            {{ basename($doc->file_path) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-muted fst-italic">No documents uploaded.</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
