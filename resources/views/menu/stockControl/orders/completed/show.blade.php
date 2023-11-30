@extends('layouts.app')

@section('title', 'Stock Controll - Orders - View Selected Completed Order')

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
        <a href="{{ route('main-menu.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Main Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      @if ($selected_completed_order->user_id != null)
        <div class="col-sm-3 pb-3">
          <a href="{{ route('main-menu.index') }}" class="btn btn-dark btn-block">
            <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Main Menu
          </a>
        </div> {{-- col-sm-3 pb-3 --}}
      @endif
    </div> {{-- row pt-3 --}}
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
                  <td>{{ date('d/m/y - h:iA', strtotime($selected_completed_order->created_at)) }}</td>
                </tr>
                <tr>
                  <th>Receipt Identifier</th>
                  <td>
                    @if ($selected_completed_order->receipt_identifier == null)
                      <span class="badge badge-light py-2 px-2">
                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                      </span>
                    @else
                      {{ $selected_completed_order->receipt_identifier }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Staff Member</th>
                  <td>
                    @if ($selected_completed_order->staff_id == null)
                      <span class="badge badge-light py-2 px-2">
                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                      </span>
                    @else
                      {{ $selected_completed_order->staff->getFullNameAttribute() }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Confirmation Date</th>
                  <td>
                    @if ($selected_completed_order->confirmation_date == null)
                      <span class="badge badge-light py-2 px-2">
                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                      </span>
                    @else
                      {{ date('d/m/y - h:iA', strtotime($selected_completed_order->confirmation_date)) }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Postage Date</th>
                  <td>
                    @if ($selected_completed_order->postage_date == null)
                      <span class="badge badge-light py-2 px-2">
                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                      </span>
                    @else
                      {{ date('d/m/y - h:iA', strtotime($selected_completed_order->postage_date)) }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Courier Company Name</th>
                  <td>
                    @if ($selected_completed_order->courier_company_name == null)
                      <span class="badge badge-light py-2 px-2">
                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                      </span>
                    @else
                      {{ $selected_completed_order->courier_company_name }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Postage Confirmation Number</th>
                  <td>
                    @if ($selected_completed_order->postage_confirmation_number == null)
                      <span class="badge badge-light py-2 px-2">
                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                      </span>
                    @else
                      {{ $selected_completed_order->postage_confirmation_number }}
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
                <td>{{ $selected_completed_order->order_name }}</td>
              </tr>
              <tr>
                <th>Email</th>
                <td>{{ $selected_completed_order->order_email }}</td>
              </tr>
              <tr>
                <th>Street Address</th>
                <td>{{ $selected_completed_order->order_address }}</td>
              </tr>
              <tr>
                <th>Suburb</th>
                <td>{{ $selected_completed_order->order_suburb . ', ' . $selected_completed_order->order_postcode }}</td>
              </tr>
              <tr>
                <th>Phone</th>
                <td>{{ substr($selected_completed_order->order_phone, 0, 4) . ' ' . substr($selected_completed_order->order_phone, 4, 3) . ' ' . substr($selected_completed_order->order_phone, 7, 3) }}</td>
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
                  @if ($selected_completed_order->payment_gateway == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ $selected_completed_order->payment_gateway }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Name on Card</th>
                <td>
                  @if ($selected_completed_order->order_name_on_card == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ $selected_completed_order->order_name_on_card }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Discount</th>
                <td>
                  @if ($selected_completed_order->order_discount == 0)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    ${{ number_format(($selected_completed_order->order_discount / 100), 2, '.', ',') }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Subtotal</th>
                <td>${{ number_format(($selected_completed_order->order_subtotal / 100), 2, '.', ',') }}</td>
              </tr>
              <tr>
                <th>Tax</th>
                <td>${{ number_format(($selected_completed_order->order_tax / 100), 2, '.', ',') }}</td>
              </tr>
              <tr>
                <th>Total</th>
                <td>${{ number_format(($selected_completed_order->order_total / 100), 2, '.', ',') }}</td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}

      </div> {{-- col-sm-4 --}}
    </div> {{-- row --}}
    {{-- order info --}}

    {{-- order products --}}
    <p class="text-primary my-3"><b>Order Products</b></p>
    @if (!$selected_completed_order->products->count())
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
            @foreach ($selected_completed_order->products as $product)
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