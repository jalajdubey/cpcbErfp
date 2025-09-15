<table>
  <thead>
    <tr>
      <th>Policy</th>
      <th>Owner</th>
      <th>Business</th>
      <th>Turnover</th>
      <th>Company</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody>
    @foreach($insuranceData as $row)
      <tr>
        <td>{{ $row->policy_number }}</td>
        <td>{{ $row->name_of_insured_owner }}</td>
        <td>{{ $row->business_type }}</td>
        <td>{{ $row->annual_turnover_cr }}</td>
        <td>{{ $row->company_name }}</td>
        <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d-m-Y') }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
