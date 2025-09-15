<tbody>
  @forelse($industryPolicies as $index => $policy)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $policy->batch_reference }}</td>
      <td>{{ $policy->insured_company_id }}</td>
      <td>{{ $policy->policy_number }}</td>
     
      <td>{{ \Carbon\Carbon::parse($policy->created_at)->format('d-m-Y') }}</td>
      <td>
        @forelse($policy->uploadedDocuments as $document)
          <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank">
            {{ basename($document->file_path) }}
          </a><br>
        @empty
          <span>No documents Uploaded</span>
        @endforelse
      </td>
      <td>
        <button class="btn btn-sm btn-info view-policy-btn"
                data-policy="{{ $policy->policy_number }}">
          View Details
        </button>
      </td>
    </tr>
  @empty
    <tr>
      <td colspan="7" class="text-center">No records found.</td>
    </tr>
  @endforelse
</tbody>
