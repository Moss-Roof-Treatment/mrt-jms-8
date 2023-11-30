@extends('layouts.jquery')

@section('title', 'Quotes - View All Quotes')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">QUOTES</h3>
    <h5>View All Quotes</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('main-menu.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Main Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('quote-requests.index') }}">
          <i class="fas fa-file-invoice mr-2" aria-hidden="true"></i>Quote Requests ({{ $pending_quote_requests_count }})
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- filter jobs --}}
    <div class="row">
      <div class="col-sm-3">

        <form action="{{ route('quotes-filter.index') }}" method="POST">
          @csrf

          <div class="input-group">
            <select name="quote_type_id" class="custom-select" required>
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

      </div> {{-- col-sm-4 --}}
    </div> {{-- row --}}
    {{-- filter jobs --}}

    {{-- quotes table --}}
    <h5 class="text-primary my-3"><b>All Quotes</b></h5>
    <div class="table-responsive py-2 px-2">
      <table class="table table-bordered table-fullwidth table-striped bg-white" id="datatable" style="width:100%">
        <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Job ID</th>
              <th>Customer</th>
              <th>Suburb</th>
              <th>Quote Status</th>
              <th>Options</th>
            </tr>
        </thead>
      </table>
    </div> {{-- table-responsive --}}
    {{-- quotes table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- jquery datatables js --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
  $('#datatable').DataTable({
    processing: true,
    serverSide: true,
    order: [[ 0, "desc" ]],
    pageLength: 50,
    columnDefs: [
      {targets: 5, orderable: false, className: "text-center text-nowrap"},
    ],
    ajax: '{{ route('quotes-dt.create') }}',
    columns: [
      { data: 'id', name: 'id' },
      { data: 'job_id', name: 'job_id' },
      { data: 'customer_id', name: 'customer_id' },
      { data: 'suburb', name: 'suburb' },
      { data: 'quote_status_id', name: 'quote_status_id' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
  });
});
</script>
{{-- jquery datatables js --}}
@endpush