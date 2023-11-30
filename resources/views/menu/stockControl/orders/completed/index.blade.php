@extends('layouts.app')

@section('title', 'Stock Controll - Orders - View Selected Completed Order')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">STOCK CONTROL</h3>
    <h5>View Selected Completed Order</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('pending-orders.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Pending Orders Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    {{-- completed orders table --}}
    <h5 class="text-primary my-3"><b>All Completed Orders</b></h5>
    @if (!$all_previous_orders->count())
      <div class="card">
        <div class="card-body text-center">
          <h5>There are no completed orders to display</h5>
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
            @foreach ($all_previous_orders as $previous_order)
              <tr>
                <td>{{ $previous_order->id }}</td>
                <td>{{ $previous_order->receipt_identifier }}</td>
                <td>{{ $previous_order->order_name }}</td>
                <td>{{ $previous_order->order_address . ', ' . $previous_order->order_suburb . ', ' . $previous_order->order_postcode }}</td>
                <td>
                  @if ($previous_order->confirmation_date == null)
                    <span class="badge badge-warning py-2 px-2">
                    <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>Previous
                    </span>
                  @else
                    {{ date('d/m/y - h:iA', strtotime($previous_order->confirmation_date)) }}
                  @endif
                </td>
                <td>
                  @if ($previous_order->postage_date == null)
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>Previous
                    </span>
                  @else
                    {{ date('d/m/y - h:iA', strtotime($previous_order->postage_date)) }}
                  @endif
                </td>
                <td>
                  <a href="{{ route('previous-orders.show', $previous_order->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- completed orders table --}}

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