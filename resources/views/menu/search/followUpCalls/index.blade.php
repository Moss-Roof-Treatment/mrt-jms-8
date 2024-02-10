@extends('layouts.jquery')

@section('title', '- Search - Follow Up Call Search')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container-fluid py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SEARCH</h3>
    <h5>Follow Up Call Search</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-6 pt-3">
      <div class="col mb-3">
        <a href="{{ route('search.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Search Menu
        </a>
      </div> {{-- col mb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

    {{-- filter quotes --}}
    <div class="row">
      <div class="col-sm-2">

        <form action="{{ route('search-follow-up-process-results.show') }}" method="POST">
          @csrf

          <div class="input-group">
            <select name="quote_status_id" class="custom-select" required>
              <option selected disabled>Please select a quote status</option>
              @foreach ($all_quote_statuses as $status)
                <option value="{{ $status->id }}">{{ $status->title }}</option>
              @endforeach
            </select>
            <div class="input-group-append">
              <button class="btn btn-primary" type="submit">
                <i class="fas fa-search" aria-hidden="true"></i>
              </button>
            </div> {{-- input-group-append --}}
          </div> {{-- input-group --}}

        </form>

      </div> {{-- col-sm-3 --}}
    </div> {{-- row --}}
    {{-- filter quotes --}}

    {{-- jobs table --}}
    <h5 class="text-primary my-3"><b>All Follow Up Calls</b></h5>
    <div class="table-responsive py-2 px-2">
      <table class="table table-bordered table-fullwidth table-striped bg-white" id="datatable" style="width:100%">
        <thead class="table-secondary">
          <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Address</th>
            <th>Suburb</th>
            <th>Postcode</th>
            <th>Referral</th>
            <th>Last Login</th>
            <th>Login Count</th>
            <th>Quote Status</th>
            <th>Follow Up Call Status</th>
            <th>Job Type</th>
            <th>Image</th>
            <th></th>
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
    order: [6, 'desc'],
    pageLength: 100,
    columnDefs: [
      {targets: 0, className: 'text-nowrap'},
      {targets: 6, className: 'text-nowrap', searchable: false},
      {targets: 11, className: 'text-center', orderable: false, searchable: false},
      {targets: 12, className: 'text-center text-nowrap', orderable: false, searchable: false },
    ],
    ajax: '{{ route('search-follow-up-process-dt.create') }}',
    columns: [
      {data: 'quote_identifier', name: 'quote_identifier'},
      {data: 'customer_id', name: 'customer_id'},
      {data: 'street_address', name: 'street_address'},
      {data: 'suburb', name: 'suburb'},
      {data: 'postcode', name: 'postcode'},
      {data: 'referral', name: 'referral'},
      {data: 'last_login_date', name: 'last_login_date'},
      {data: 'login_count', name: 'login_count'},
      {data: 'quote_status_id', name: 'quote_status_id'},
      {data: 'follow_up_call_status', name: 'follow_up_call_status'},
      {data: 'job_type_id', name: 'job_type_id'},
      {data: 'image', name: 'image'},
      {data: 'action', name: 'action'}
    ],
  });
});
</script>
{{-- jquery datatables js --}}
@endpush