@extends('layouts.jquery')

@section('title', 'Stock Controll - Orders - View All Pending Orders')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">STOCK CONTROL</h3>
    <h5>View All Pending Orders</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('stock-control.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Stock Control Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a href="{{ route('previous-orders.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Completed Orders Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    {{-- pending orders table --}}
    <h5 class="text-primary my-3"><b>All Pending Orders</b></h5>
    @if (!$all_pending_orders->count())
      <div class="card">
        <div class="card-body text-center">
          <h5>There are no pending orders to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive mt-3">
        <table id="datatable" class="table table-bordered table-fullwidth table-striped bg-white" style="width:100%">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Receipt Number</th>
              <th>Order Name</th>
              <th>Order Address</th>
              <th>Confirmation Date</th>
              <th>Postage Date</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_pending_orders as $pending_order)
              <tr>
                <td>{{ $pending_order->id }}</td>
                <td>{{ $pending_order->receipt_identifier }}</td>
                <td>{{ $pending_order->order_name }}</td>
                <td>{{ $pending_order->order_address . ', ' . $pending_order->order_suburb . ', ' . $pending_order->order_postcode }}</td>
                <td>
                  @if ($pending_order->confirmation_date == null)
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                    </span>
                  @else
                    {{ date('d/m/y - h:iA', strtotime($pending_order->confirmation_date)) }}
                  @endif
                </td>
                <td>
                  @if ($pending_order->postage_date == null)
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                    </span>
                  @else
                    {{ date('d/m/y - h:iA', strtotime($pending_order->postage_date)) }}
                  @endif
                </td>
                <td>
                  <a href="{{ route('pending-orders.show', $pending_order->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- pending orders table --}}

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