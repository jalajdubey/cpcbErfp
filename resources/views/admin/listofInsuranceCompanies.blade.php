{{-- resources/views/insurancecompanylist.blade.php --}}
@extends('layouts.dashboard-layout')

@section('title', 'Insurance Company List')

@section('dashboard-content')
  <div class="card shadow-sm border-0 rounded-3 overflow-hidden mb-4">
    <div class="card-header text-white d-flex justify-content-between align-items-center"
         style="background: linear-gradient(270deg, #084095 0%, #108e16 100%);">
      <h5 class="fw-bold mb-0">
        <i class="bi bi-building me-2"></i> Insurance Company List
      </h5>
      <a href="{{ url()->previous() }}" class="btn btn-sm btn-light fw-semibold">
        <i class="bi bi-arrow-left me-1"></i> Back
      </a>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table custom-admin-table align-middle mb-0">
          <thead>
            <tr>
              <th>#</th>
              <th>Name of General Insurance Company</th>
              <th>Name of CEO</th>
              <th>Name of Actuary</th>
              <th>Contact No</th>
              <th>Web Address</th>
            </tr>
          </thead>
          <tbody>
            @forelse($getDetails as $row)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="fw-semibold">{{ $row->name_of_general_insurance_company }}</td>
                <td>{{ $row->name_of_ceo }}</td>
                <td>{{ $row->name_of_actuary }}</td>
                <td>{{ $row->contact_no ?: '—' }}</td>
                <td>
                  @if($row->web_address)
                    <a href="{{ $row->web_address }}" target="_blank"
                       class="text-decoration-none text-primary fw-semibold">
                       {{ $row->web_address }}
                    </a>
                  @else
                    <span class="text-muted">N/A</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center py-4 text-muted">
                  <i class="bi bi-info-circle me-1"></i> No records found.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
