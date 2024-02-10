@extends('layouts.jquery')

@section('title', 'Customers - View All Customers')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">CUSTOMERS</h3>
    <h5>View All Customers</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('main-menu.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Main Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('leads.index') }}" class="btn btn-dark btn-block">
          <i class=" fas fa-bars mr-2" aria-hidden="true"></i>Leads Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('customers.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>New Customer
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- index table --}}
    <h5 class="text-primary my-3"><b>All Customers</b></h5>
    <div class="table-responsive py-2 px-2">
      <table class="table table-bordered table-fullwidth table-striped bg-white" id="datatable" style="width:100%">
        <thead class="table-secondary">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Business Name</th>
            <th>Last Login</th>
            <th>Email</th>
            <th>Options</th>
          </tr>
        </thead>
      </table>
    </div> {{-- table-responsive --}}
    {{-- index table --}}

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
    order: [[ 3, "desc" ]],
    pageLength: 50,
    columnDefs: [
      {targets: 3, className: "text-nowrap", searchable: false},
      {targets: 5, className: "text-nowrap", orderable: false, searchable: false},
    ],
    ajax: '{{ route('customers-dt.create') }}',
    columns: [
      { data: 'id', name: 'id' },
      { data: 'first_name', name: 'first_name' },
      { data: 'business_name', name: 'business_name' },
      { data: 'last_login_date', name: 'last_login_date' },
      { data: 'email', name: 'email' },
      { data: 'action', name: 'action' }
    ],
  });
});
</script>
{{-- jquery datatables js --}}
@endpush