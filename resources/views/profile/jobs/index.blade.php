@extends('layouts.profileJquery')

@section('title', 'Profile - Staff - Jobs')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">MY JOBS</h3>
    <h5>View All My Jobs</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('profile.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Profile Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- new jobs table --}}
    <h5 class="text-primary my-3"><b>All My Jobs</b></h5>
    <div class="table-responsive mt-3">
      <table class="table table-bordered table-fullwidth table-striped bg-white" id="new-datatable" style="width:100%">
        <thead class="table-secondary">
          <tr>
            <th>Job No</th>
            <th>Suburb</th>
            <th>Customer</th>
            <th>Sold Date</th>
            <th>Job Status</th>
            <th>Options</th>
          </tr>
        </thead>
      </table>
    </div> {{-- table-responsive --}}
    {{-- new jobs table --}}

    {{-- completed jobs table --}}
    <div class="custom-control custom-checkbox my-3">
      <input type="checkbox" class="custom-control-input" id="completed-visibility-checkbox" onclick="toggle_visibility('completed-jobs-visibility-div');">
      <label class="custom-control-label text-primary" for="completed-visibility-checkbox">
      <h5><b>All My Completed Jobs</b></h5>
      </label>
    </div>
    <div id="completed-jobs-visibility-div" style="display:none;">

      <div class="table-responsive mt-3">
        <table class="table table-bordered table-fullwidth table-striped bg-white" id="old-datatable" style="width:100%">
          <thead class="table-secondary">
            <tr>
              <th>Job ID</th>
              <th>Suburb</th>
              <th>Customer</th>
              <th>Job Type</th>
              <th>Job Status</th>
              <th>Invoice</th>
              <th>Paid Date</th>
              <th>Options</th>
            </tr>
          </thead>
        </table>
      </div> {{-- table-responsive --}}

    </div> {{-- completed-jobs-visibility-div --}}
    {{-- completed jobs table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- jquery datatables js --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
  $('#new-datatable').DataTable({
    processing: true,
    serverSide: true,
    order: [[ 0, "desc" ]],
    columnDefs: [
      {targets: 4, className: "text-nowrap"},
      {targets: 5, orderable: false, className: "text-center text-nowrap"},
    ],
    ajax: '{{ route('profile-jobs.create') }}',
    columns: [
      { data: 'id', name: 'id' },
      { data: 'suburb', name: 'suburb' },
      { data: 'customer_id', name: 'customer_id' },
      { data: 'sold_date', name: 'sold_date' },
      { data: 'quote_status_id', name: 'quote_status_id' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
  });
});
</script>
<script>
$(document).ready(function() {
  $('#old-datatable').DataTable({
    processing: true,
    serverSide: true,
    order: [[ 0, "desc" ]],
    columnDefs: [
      {targets: 3, orderable: false, className: "text-center text-nowrap"},
      {targets: 4, orderable: false, className: "text-nowrap"},
      {targets: 5, orderable: false, className: "text-nowrap"},
      {targets: 6, orderable: false, className: "text-nowrap"},
      {targets: 7, orderable: false, className: "text-center text-nowrap"},
    ],
    ajax: '{{ route('profile-old-jobs.create') }}',
    columns: [
      { data: 'id', name: 'id' },
      { data: 'suburb', name: 'suburb' },
      { data: 'customer_id', name: 'customer_id' },
      { data: 'job_type_id', name: 'job_type_id' },
      { data: 'quote_status_id', name: 'quote_status_id' },
      { data: 'invoice_identifier', name: 'invoice_identifier' },
      { data: 'invoice_paid_date', name: 'invoice_paid_date' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
  });
});
</script>
{{-- jquery datatables js --}}

{{-- Toggle Visibility By Id Generic --}}
<script type="text/javascript">
  function toggle_visibility(id) {
    var e = document.getElementById(id);
    if (e.style.display == 'none')
      e.style.display = 'block';
    else
      e.style.display = 'none';
  }
</script>
{{-- Toggle Visibility By Id Generic --}}
@endpush