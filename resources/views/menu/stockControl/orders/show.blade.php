@extends('layouts.jquery')

@section('title', 'Stock Controll - Orders - View Selected Pending Order')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container-fluid py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">STOCK CONTROL</h3>
    <h5>View Selected Pending Order</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-6 pt-3">
      <div class="col mb-3">
        <a href="{{ route('pending-orders.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Pending Orders Menu
        </a>
      </div> {{-- col mb-3 --}}
      <div class="col mb-3">
        @if ($selected_pending_order->confirmation_date == null)
          {{-- confirm order modal --}}
          {{-- modal button --}}
          <button type="button" class="btn btn-warning btn-block mb-1" data-toggle="modal" data-target="#confirmOrderModal">
            <i class="fas fa-edit mr-2" aria-hidden="true"></i>Confirm Order
          </button>
          {{-- modal button --}}
          {{-- modal --}}
          <div class="modal fade" id="confirmOrderModal" tabindex="-1" role="dialog" aria-labelledby="confirmOrderModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="confirmOrderModalTitle">Confirm Order</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p class="text-center">Are you sure that you would like to confirm this order?</p>
                  <form action="{{ route('pending-orders-confirm-order.update', $selected_pending_order->id) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <button type="submit" class="btn btn-dark btn-block">
                      <i class="fas fa-edit mr-2" aria-hidden="true"></i>Confirm Order
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          {{-- modal --}}
          {{-- confirm order modal --}}
        @else
          <a href="#" class="btn btn-success btn-block disabled" tabindex="-1" role="button" aria-disabled="true">
            <i class="fas fa-check mr-2" aria-hidden="true"></i>Order Confirmed
          </a>
        @endif
      </div> {{-- col mb-3 --}}
      <div class="col mb-3">
        @if ($selected_pending_order->postage_date == null)
          {{-- confirm order modal --}}
          {{-- modal button --}}
          <button type="button" class="btn btn-warning btn-block mb-1" data-toggle="modal" data-target="#confirmPostageModal">
            <i class="fas fa-edit mr-2" aria-hidden="true"></i>Confirm postage
          </button>
          {{-- modal button --}}
          {{-- modal --}}
          <div class="modal fade" id="confirmPostageModal" tabindex="-1" role="dialog" aria-labelledby="confirmPostageModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="confirmPostageModalTitle">Confirm postage</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p class="text-center">Are you sure that you would like to confirm this order?</p>
                  <form action="{{ route('pending-orders-confirm-postage.update', $selected_pending_order->id) }}" method="POST">
                    @method('PATCH')
                    @csrf

                    <div class="form-group row">
                      <label for="courier_company_name" class="col-md-3 col-form-label text-md-right">Courier Name</label>
                      <div class="col-md-8">
                        <input id="courier_company_name" type="text" class="form-control @error('courier_company_name') is-invalid @enderror mb-2" name="courier_company_name" value="{{ old('courier_company_name') }}" placeholder="Please enter the courier company name">
                        @error('courier_company_name')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div> {{-- col-md-9 --}}
                    </div> {{-- form-group row --}}

                    <div class="form-group row">
                      <label for="postage_confirmation_number" class="col-md-3 col-form-label text-md-right">Confirmation</label>
                      <div class="col-md-8">
                        <input id="postage_confirmation_number" type="text" class="form-control @error('postage_confirmation_number') is-invalid @enderror mb-2" name="postage_confirmation_number" value="{{ old('postage_confirmation_number') }}" placeholder="Please enter the postage confirmation number">
                        @error('postage_confirmation_number')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div> {{-- col-md-9 --}}
                    </div> {{-- form-group row --}}

                    <button type="submit" class="btn btn-dark btn-block">
                      <i class="fas fa-edit mr-2" aria-hidden="true"></i>Confirm postage
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          {{-- modal --}}
          {{-- confirm order modal --}}
        @else
          <a href="#" class="btn btn-success btn-block disabled" tabindex="-1" role="button" aria-disabled="true">
            <i class="fas fa-check mr-2" aria-hidden="true"></i>Order Posted
          </a>
        @endif
      </div> {{-- col mb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

    {{-- order info --}}
    <div class="row">
      <div class="col-sm-4">

          <p class="text-primary my-3"><b>Order Details</b></p>

          <div class="table-responsive">
              <table class="table table-bordered table-fullwidth table-striped bg-white">
                  <tbody>
                      <tr>
                          <th>Order Date</th>
                          <td>{{ date('d/m/y - h:iA', strtotime($selected_pending_order->created_at)) }}</td>
                      </tr>
                      <tr>
                          <th>Receipt Identifier</th>
                          <td>
                              @if ($selected_pending_order->receipt_identifier == null)
                                  <span class="badge badge-light py-2 px-2">
                                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                                  </span>
                              @else
                                  {{ $selected_pending_order->receipt_identifier }}
                              @endif
                          </td>
                      </tr>
                      <tr>
                          <th>Staff Member</th>
                          <td>
                              @if ($selected_pending_order->staff_id == null)
                                  <span class="badge badge-warning py-2 px-2">
                                      <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                                  </span>
                              @else
                                  {{ $selected_pending_order->staff->getFullNameAttribute() }}
                              @endif
                          </td>
                      </tr>
                      <tr>
                          <th>Confirmation Date</th>
                          <td>
                              @if ($selected_pending_order->confirmation_date == null)
                                  <span class="badge badge-warning py-2 px-2">
                                      <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                                  </span>
                              @else
                                  {{ date('d/m/y - h:iA', strtotime($selected_pending_order->confirmation_date)) }}
                              @endif
                          </td>
                      </tr>
                      <tr>
                          <th>Postage Date</th>
                          <td>
                              @if ($selected_pending_order->postage_date == null)
                                  <span class="badge badge-warning py-2 px-2">
                                      <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                                  </span>
                              @else
                                  {{ date('d/m/y - h:iA', strtotime($selected_pending_order->postage_date)) }}
                              @endif
                          </td>
                      </tr>
                      <tr>
                          <th>Courier Company Name</th>
                          <td>
                              @if ($selected_pending_order->courier_company_name == null)
                                  <span class="badge badge-warning py-2 px-2">
                                      <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                                  </span>
                              @else
                                  {{ $selected_pending_order->courier_company_name }}
                              @endif
                          </td>
                      </tr>
                      <tr>
                          <th>Postage Confirmation Number</th>
                          <td>
                              @if ($selected_pending_order->postage_confirmation_number == null)
                                  <span class="badge badge-warning py-2 px-2">
                                      <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                                  </span>
                              @else
                                  {{ $selected_pending_order->postage_confirmation_number }}
                              @endif
                          </td>
                      </tr>
                  </tbody>
              </table>
          </div> {{-- table-responsive --}}

      </div> {{-- col-sm-4 --}}
      <div class="col-sm-4">

          <p class="text-primary my-3"><b>Customer Details</b></p>

          <div class="table-responsive">
              <table class="table table-bordered table-fullwidth table-striped bg-white">
                  <tbody>
                      <tr>
                          <th>Name</th>
                          <td>{{ $selected_pending_order->order_name }}</td>
                      </tr>
                      <tr>
                          <th>Email</th>
                          <td>{{ $selected_pending_order->order_email }}</td>
                      </tr>
                      <tr>
                          <th>Street Address</th>
                          <td>{{ $selected_pending_order->order_address }}</td>
                      </tr>
                      <tr>
                          <th>Suburb</th>
                          <td>{{ $selected_pending_order->order_suburb . ', ' . $selected_pending_order->order_postcode }}</td>
                      </tr>
                      <tr>
                          <th>Phone</th>
                          <td>{{ substr($selected_pending_order->order_home_phone, 0, 4) . ' ' . substr($selected_pending_order->order_home_phone, 4, 3) . ' ' . substr($selected_pending_order->order_home_phone, 7, 3) }}</td>
                      </tr>
                  </tbody>
              </table>
          </div> {{-- table-responsive --}}

      </div> {{-- col-sm-4 --}}
      <div class="col-sm-4">

        <p class="text-primary my-3"><b>Payment Details</b></p>

        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
              <tbody>
                  <tr>
                      <th>Payment Gateway</th>
                      <td>
                          @if ($selected_pending_order->payment_gateway == null)
                              <span class="badge badge-light py-2 px-2">
                              <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                              </span>
                          @else
                              {{ $selected_pending_order->payment_gateway }}
                          @endif
                      </td>
                  </tr>
                  <tr>
                      <th>Name on Card</th>
                      <td>
                          @if ($selected_pending_order->order_name_on_card == null)
                              <span class="badge badge-light py-2 px-2">
                              <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                              </span>
                          @else
                              {{ $selected_pending_order->order_name_on_card }}
                          @endif
                      </td>
                  </tr>
                  <tr>
                      <th>Discount</th>
                      <td>
                      @if ($selected_pending_order->order_discount == 0)
                          <span class="badge badge-light py-2 px-2">
                              <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                          </span>
                          @else
                              ${{ number_format(($selected_pending_order->order_discount / 100), 2, '.', ',') }}
                          @endif
                      </td>
                  </tr>
                  <tr>
                      <th>Subtotal</th>
                      <td>${{ number_format(($selected_pending_order->order_subtotal / 100), 2, '.', ',') }}</td>
                  </tr>
                  <tr>
                      <th>Tax</th>
                      <td>${{ number_format(($selected_pending_order->order_tax / 100), 2, '.', ',') }}</td>
                  </tr>
                  <tr>
                      <th>Total</th>
                      <td>${{ number_format(($selected_pending_order->order_total / 100), 2, '.', ',') }}</td>
                  </tr>
              </tbody>
          </table>
        </div> {{-- table-responsive --}}

      </div> {{-- col-sm-4 --}}
    </div> {{-- row --}}
    {{-- order info --}}

    {{-- order products --}}
    <p class="text-primary my-3"><b>Order Products</b></p>
    @if (!$selected_pending_order->products->count())
      <div class="card">
        <div class="card-body text-center">
          <h5>There are no products to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive mt-3">
        <table id="datatable" class="table table-bordered table-fullwidth table-striped bg-white" style="width:100%">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Description</th>
              <th>Quantity</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($selected_pending_order->products as $product)
              <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->pivot->quantity }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- order products --}}

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