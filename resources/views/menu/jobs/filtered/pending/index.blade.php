@extends('layouts.jquery')

@section('title', '- Jobs - View Filtered Pending Jobs')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container-fluid py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">JOBS</h3>
    <h5>View Filtered Jobs</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-6 pt-3">
      <div class="col mb-3">
        <a href="{{ route('jobs.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Job Menu
        </a>
      </div> {{-- col mb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

    {{-- filter jobs --}}
    <div class="row">
      <div class="col-sm-2">

        <form action="{{ route('jobs-filter.index') }}" method="POST">
          @csrf

          <div class="input-group">
            <select name="job_status_id" class="custom-select" required>
              <option disabled value="">Please select a job status</option>
              @foreach ($all_job_statuses as $status)
                <option value="{{ $status->id }}" @if ($selected_option == $status->id) selected @endif>{{ $status->title }}</option>
              @endforeach
            </select>
            <div class="input-group-append">
              <button class="btn btn-primary" type="submit">
                <i class="fas fa-search" aria-hidden="true"></i>
              </button>
            </div> {{-- input-group-append --}}
          </div> {{-- input-group --}}

        </form>

      </div> {{-- col-sm-2 --}}
    </div> {{-- row --}}
    {{-- filter jobs --}}

    {{-- jobs table --}}
    <h5 class="text-primary my-3"><b>Filtered Jobs</b></h5>
    <div class="table-responsive py-2 px-2">
      <table class="table table-bordered table-fullwidth table-striped bg-white" id="datatable" style="width:100%">
        <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Job Types</th>
              <th>Customer</th>
              <th>Email</th>
              <th>Suburb</th>
              <th>Postcode</th>
              <th>Inspection Date</th>
              <th>Last Login</th>
              <th>Login Count</th>
              <th>Options</th>
            </tr>
        </thead>
      </table>
    </div> {{-- table-responsive --}}
    {{-- jobs table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- jquery datatables js --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
  $('#datatable').DataTable({
    processing: true,
    serverSide: true,
    order: [[ 0, "desc" ]],
    pageLength: 100,
    columnDefs: [
      {"targets": 1, "className": "text-nowrap"},
      {"targets": 9, "className": "text-nowrap"},
    ],
    ajax: '{{ route('jobs-pending-dt.create') }}',
    columns: [
      { data: 'id', name: 'id' },
      { data: 'job_type_id', name: 'job_type_id' },
      { data: 'customer_id', name: 'customer_id' },
      { data: 'email', name: 'email' },
      { data: 'tenant_suburb', name: 'tenant_suburb' },
      { data: 'tenant_postcode', name: 'tenant_postcode' },
      { data: 'inspection_date', name: 'inspection_date' },
      { data: 'last_login_date', name: 'last_login_date' },
      { data: 'login_count', name: 'login_count' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
  });
});
</script>
{{-- jquery datatables js --}}
@endpush