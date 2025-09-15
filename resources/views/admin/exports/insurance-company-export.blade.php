<table>
    <thead>
        <tr>
            <th>Policy Number</th>
            <th>Insured Owner</th>
            <th>Business Type</th>
            <th>Turnover (CR)</th>
           
            <th>Name of Insured Owner</th>
            <th>Address</th>
            <th>Territorial Limits District</th>
            <th>Territorial Limits State</th>

          
            <th>Paid Up Capital Cr</th>
            <th>Policy Period Duration</th>
            <th>Policy Valid UPTO</th>

            <th>Indemnity Limit Rs</th>
            <th>Any One Year Limit Rs</th>
            <th>Any One Accident Limit Rs</th>
            <th>Premium without Tax Rs</th>
            <th>Contribution To Erf Rs</th>
            <th>Date of Proposal</th>

            <th>Payment Particulars</th>
            <th>Pan Of Company</th>
            <th>Gst Of Company</th>
            <th>Email Of Company</th>

            <th>Mobile Of Company</th>
            <th>Mobile Of Policy Number</th>
        </tr>
    </thead>
    <tbody>
  
        @foreach($insuranceData as $row)
     
        <tr>
            <td>{{ $row->policy_number }}</td>
            <td>{{ $row->name_of_insured_owner }}</td>
            <td>{{ $row->business_type }}</td>
            <td>{{ $row->annual_turnover_cr }}</td>

            <td>{{ $row->insured_company_id }}</td>
            <td>{{ $row->address }}</td>
            <td>{{ $row->territorial_limits_district }}</td>
            <td>{{ $row->territorial_limits_state }}</td>

            <td>{{ $row->paid_up_capital_cr }}</td>
            <td>{{ $row->policy_duration_year }}</td>
            <td>{{ $row->policy_valid_upto }}</td>
            <td>{{ $row->indemnity_limit_rs }}</td>
            <td>{{ $row->any_one_year_limit_rs }}</td>
            <td>{{ $row->any_one_accident_limit_rs }}</td>
            <td>{{ $row->premium_without_tax_rs }}</td>

            <td>{{ $row->contribution_to_erf_rs }}</td>
            <td>{{ $row->date_of_proposal }}</td>
            <td>{{ $row->erf_deposit_utr_no }}</td>
            <td>{{ $row->pan_of_company }}</td>
            <td>{{ $row->gst_of_company }}</td>

            <td>{{ $row->email_of_company }}</td>
            <td>{{ $row->mobile_of_company }}</td>
            <td>{{ $row->policy_number }}</td>


        </tr>
        @endforeach
    </tbody>
</table>
