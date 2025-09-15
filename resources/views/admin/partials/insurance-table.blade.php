<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Policy Number</th>
            <th>Insured Owner</th>
            <th>Business Type</th>
            <th>Turnover</th>
            <th>Company</th>
            <th>Uploaded Document</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($insuranceData as $row)
        <tr>
            <td>{{ $row->policy_number }}</td>
            <td>{{ $row->name_of_insured_owner }}</td>
            <td>{{ $row->business_type }}</td>
            <td>{{ $row->annual_turnover_cr }}</td>
            <td>{{ $row->company_name }}</td>
            <td>
            @if ($row->file_path)
                <a href="{{ asset('storage/app/public/' .$row->file_path) }}" target="_blank">
                    {{ basename($row->file_path) }}
                </a>
            @else
                No document uploaded
            @endif
        </td>
            <td>
                <button class="btn btn-sm btn-primary view-policy-btn"
                data-policy="{{ $row->policy_number }}">
                    View Details
                </button>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center">No records found.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $insuranceData->withQueryString()->links() }}

