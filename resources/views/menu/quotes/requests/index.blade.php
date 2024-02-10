@extends('layouts.jquery')

@section('title', 'Quotes - View All Quote Requests')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">QUOTE REQUESTS</h3>
    <h5>View All Quote Requests</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('main-menu.index') }}">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Main Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('quotes.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Quote Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- index table --}}
    <h5 class="text-primary my-3"><b>All Quote Requests</b></h5>
    @if (!$all_quote_requests->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no quote requests to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}   
    @else
      <table id="datatable" class="table table-bordered table-fullwidth table-strimed bg-white">
        <thead class="table-secondary">
          <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Street Address</th>
            <th>Suburb</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Source</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($all_quote_requests as $selected_quote_request)
            <tr>
              <td>
                <a href="{{ route('quote-requests.show', $selected_quote_request->id) }}">
                  {{ $selected_quote_request->id }}
                </a>
              </td>
              <td>
                @if ($selected_quote_request->first_name == null && $selected_quote_request->last_name == null)
                  <span class="badge badge-warning py-2 px-2">
                    <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                  </span>
                @else
                  {{ $selected_quote_request->first_name . ' ' . $selected_quote_request->last_name }}</td>
                @endif
              <td>
                @if ($selected_quote_request->street_address == null)
                  <span class="badge badge-warning py-2 px-2">
                    <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                  </span>
                @else
                  {{ substr($selected_quote_request->street_address, 0, 30) }}
                  {{ strlen($selected_quote_request->street_address) > 30 ? '...' : '' }}
                @endif
              </td>
              <td>
                @if ($selected_quote_request->suburb == null)
                  <span class="badge badge-warning py-2 px-2">
                    <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                  </span>
                @else
                  {{ $selected_quote_request->suburb }}
                @endif
              </td>
              <td>
                {{ $selected_quote_request->getFullPhoneNumber() }}
              </td>
              <td>
                @if ($selected_quote_request->quote_request_status_id == null)
                  <span class="badge badge-warning py-2 px-2">
                    <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>The status has not been set
                  </span>
                @else
                  {{ $selected_quote_request->quote_request_status->title }}
                @endif
              </td>
              <td class="text-center">
                @if ($selected_quote_request->is_latr == 0)
                  <span class="badge bg-secondary text-white py-2 px-2">
                    <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>MRT
                  </span>
                @else
                  <span class="badge bg-primary text-white py-2 px-2">
                    <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>LATR
                  </span>
                @endif
              </td>
              <td class="text-center">
                <a href="{{ route('quote-requests.show', $selected_quote_request->id) }}" class="btn btn-primary btn-sm">
                  <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
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
      "info": true, {{-- Show the page info --}}
      "lengthChange": true, {{-- Show results length --}}
      "ordering": true, {{-- Allow ordering of all columns --}}
      "paging": true, {{-- Show pagination --}}
      "processing": true, {{-- Show processing message on long load time --}}
      "searching": true, {{-- Search for results --}}
    });
  });
</script>
{{-- jquery datatables js --}}
@endpush