@extends('layouts.profileJquery')

@section('title', 'Profile - Staff - Invoices')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">MY INVOICES</h3>
    <h5>View All Outstanding Invoices</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('profile.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Profile Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('profile-group-invoice.index') }}" class="btn btn-dark btn-block">
            <i class="fas fa-bars mr-2" aria-hidden="true"></i>Group Invoice Menu
        </a>
    </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('profile-invoices.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Invoice
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- outstanding invoice table --}}
    <h5 class="text-primary my-3"><b>All My Outstanding Invoices</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white" id="outstanding-datatable" style="width:100%">
        <thead class="table-secondary">
          <tr>
            <th>Invoice</th>
            <th>Job ID</th>
            <th>Suburb</th>
            <th>Customer</th>
            <th>Submission Date</th>
            <th>Options</th>
          </tr>
        </thead>
      </table>            
    </div> {{-- table container --}}
    {{-- outstanding invoice table --}}

    {{-- paid invoice table --}}
    <div class="custom-control custom-checkbox my-3">
      <input type="checkbox" class="custom-control-input" id="completed-visibility-checkbox" onclick="toggle_visibility('paid-invoice-visibility-div');">
      <label class="custom-control-label text-primary" for="completed-visibility-checkbox">
      <h5><b>All My Paid Invoices</b></h5>
      </label>
    </div>
    <div id="paid-invoice-visibility-div" style="display:none;">

      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white" id="paid-datatable" style="width:100%">
          <thead class="table-secondary">
            <tr>
              <th>Invoice</th>
              <th>Job ID</th>
              <th>Suburb</th>
              <th>Customer</th>
              <th>Submission Date</th>
              <th>Options</th>
            </tr>
          </thead>
        </table>            
      </div> {{-- table container --}}

    </div> {{-- paid-invoice-visibility-div --}}
    {{-- paid invoice table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- jquery datatables js --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
  $('#outstanding-datatable').DataTable({
    processing: true,
    serverSide: true,
    order: [[ 0, "desc" ]],
    columnDefs: [
      {targets: 5, orderable: false, className: "text-center text-nowrap"},
    ],
    ajax: '{{ route('profile-invoices-dt.create') }}',
    columns: [
      { data: 'identifier', name: 'identifier' },
      { data: 'quote_id', name: 'quote_id' },
      { data: 'suburb', name: 'suburb' },
      { data: 'customer', name: 'customer' },
      { data: 'submission_date', name: 'submission_date' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
  });
});
</script>
<script>
$(document).ready(function() {
  $('#paid-datatable').DataTable({
    processing: true,
    serverSide: true,
    order: [[ 0, "desc" ]],
    columnDefs: [
      {targets: 5, orderable: false, className: "text-center text-nowrap"},
    ],
    ajax: '{{ route('profile-paid-invoices.create') }}',
    columns: [
      { data: 'identifier', name: 'identifier' },
      { data: 'quote_id', name: 'quote_id' },
      { data: 'suburb', name: 'suburb' },
      { data: 'customer', name: 'customer' },
      { data: 'submission_date', name: 'submission_date' },
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
