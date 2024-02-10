@extends('layouts.jquery')

@section('title', '- Quotes - View Filtered Quotes')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">QUOTES</h3>
    <h5>View Filtered Quotes</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('quotes.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Quote Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    {{-- filter quotes --}}
    <div class="row">
      <div class="col-sm-3">

        <form action="{{ route('quotes-filter.index') }}" method="POST">
          @csrf

          <div class="input-group">
            <select name="quote_type_id" class="custom-select" required>
              <option disabled value="">Please select a quote status</option>
              @foreach ($all_quote_statuses as $status)
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

      </div> {{-- col-sm-4 --}}
    </div> {{-- row --}}
    {{-- filter quotes --}}

    {{-- quotes table --}}
    <p class="text-primary my-3"><b>Filtered Quotes</b></p>
    <div class="table-responsive py-2 px-2">
      <table class="table table-bordered table-fullwidth table-striped bg-white" id="datatable" style="width:100%">
        <thead class="table-secondary">
            <tr>
              <th>ID</th>
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
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
  $('#datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route('quotes-default-dt.create') }}',
    columns: [
      { data: 'id', name: 'id' },
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