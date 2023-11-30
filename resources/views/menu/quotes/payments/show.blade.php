@extends('layouts.app')

@section('title', 'Quote Payments - View Selected Quote Payment')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">QUOTE PAYMENTS</h3>
    <h5>View Selected Quote Payment</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('quotes.show', $selected_payment->quote_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Quote
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('jobs.show', $selected_payment->quote->job_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Job
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <form action="{{ route('quote-payments.update', $selected_payment->id) }}" method="POST">
          @method('PATCH')
          @csrf
          @if ($selected_payment->void_date == null)
            <button type="submit" class="btn btn-danger btn-block">
              <i class="fas fa-times mr-2" aria-hidden="true"></i>Void Payment
            </button>
          @else
            <button type="submit" class="btn btn-success btn-block">
              <i class="fas fa-check mr-2" aria-hidden="true"></i>Restore Payment
            </button>
          @endif
        </form>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- content --}}
    <div class="row">
      <div class="col-sm-6">

        {{-- payment table --}}
        <h5 class="text-primary my-3"><b>Customer Information</b></h5>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped">
            <tbody>
              <tr>
                <th>Customer ID</th>
                <td>{{ $selected_payment->quote->customer_id }}</td>
              </tr>
              <tr>
                <th>Quote ID</th>
                <td>{{ $selected_payment->quote_id }}</td>
              </tr>
              <tr>
                <th>Job ID</th>
                <td>{{ $selected_payment->quote->job_id }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        {{-- payment table --}}

      </div>
      <div class="col-sm-6">

        {{-- payment table --}}
        <h5 class="text-primary my-3"><b>Payment Information</b></h5>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped">
            <tbody>
              <tr>
                <th>ID</th>
                <td>{{ $selected_payment->id }}</td>
              </tr>
              <tr>
                <th>Payment Type</th>
                <td>{{ $selected_payment->paymentType->title }}</td>
              </tr>
              @if ($selected_payment->void_date != null)
                <tr>
                  <th>Void Date</th>
                  <td class="text-danger"><b>{{ date('d/m/y - h:iA', strtotime($selected_payment->void_date)) }}</b></td>
                </tr>
              @endif
              <tr>
                <th>Payment Method</th>
                <td>{{ $selected_payment->paymentMethod->title }}</td>
              </tr>
              <tr>
                <th>Payment Amount</th>
                <td>
                  {{ $selected_payment->getFormattedPaymentAmount() }}
                  @if ($selected_payment->void_date != null)
                    <span class="text-danger"><b>VOID</b></span>
                  @endif
                </td>
              </tr>
              <tr>
                <th>Staff Memeber</th>
                <td>{{ $selected_payment->staff->getFullNameAttribute() }}</td>
              </tr>
              <tr>
                <th>Processing Fee</th>
                <td>{{ $selected_payment->has_processing_fee == 0 ? 'No Processing Fee' : 'Has Processing Fee'  }}</td>
              </tr>
              <tr>
                <th>Payment Date</th>
                <td>{{ date('d/m/y - h:iA', strtotime($selected_payment->payment_date)) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        {{-- payment table --}}

      </div>
    </div>
    {{-- content --}}

  </div> {{-- container --}}
</section> {{-- section --}}
<section class="bg-dark">
  <div class="container py-5">

    {{-- customer view quote --}}
    <div class="card">
      <div class="card-body">

        {{-- letterhead --}}
        @if ($selected_payment->payment_type_id == 1) {{-- is desposit --}}
          <img class="img-fluid py-3" src="{{ asset('storage/images/letterheads/mrt-deposit-receipt-letterhead.jpg') }}" alt="">
        @else {{-- is payment --}}
          <img class="img-fluid py-3" src="{{ asset('storage/images/letterheads/mrt-tax-invoice-letterhead.jpg') }}" alt="">
        @endif
        {{-- letterhead --}}

        {{-- receipt data --}}
        <div class="table-responsive mt-3">
          <table class="table table-bordered table-fullwidth table-primary bg-white text-primary">
            <tbody>
              <tr>
                <th colspan="3" width="70%">{{ $selected_payment->paymentType->title }} Receipt Name</th>
                <th>Date</th>
                <th>Job #</th>
              </tr>
              <tr>
                <td colspan="3" rowspan="4">
                  {{ $selected_payment->quote->customer->business_name ?? '' }}
                  <br>
                  {{ $selected_payment->quote->customer->getFullNameAttribute() }}
                  <br>
                  {{ $selected_payment->quote->job->tenant_street_address }}
                  <br>
                  {{ $selected_payment->quote->job->tenant_suburb . ', ' . $selected_payment->quote->job->tenant_postcode }}
                </td>
              </tr>
              <tr>
                <td>{{ $selected_payment->getFormattedCreationDate() }}</td>
                <td>{{ $selected_payment->quote->job_id }}</td>
              </tr>
              <tr>
                <th>Terms</th>
                <th>Customer #</th>
              </tr>
              <tr>
                <td class="table-warning">On Completion</td>
                <td>{{ $selected_payment->quote->customer_id }}</td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}
        {{-- receipt data --}}

        {{-- void marker --}}
        @if ($selected_payment->void_date != null)
          <p class="text-danger text-center display-4 mt-3"><b>VOID</b></p>
        @endif
        {{-- void marker --}}

        {{-- quantity data --}}
        <div class="table-responsive mt-3">
          <table class="table table-bordered table-fullwidth table-primary bg-white text-primary">
            <tbody>
              <tr>
                <th>Item</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Rate</th>
                <th>Amount</th>
              </tr>
              <tr>
                <td>{{ $selected_system->title }}</td>
                <td>{{ $selected_payment->paymentType->title }}</td>
                <td>1</td>
                <td></td>
                <td>${{ number_format(($selected_payment->payment_amount / 100), 2, '.', ',') }}</td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}
        {{-- quantity data --}}

        {{-- price data --}}
        <div class="row mt-3">
          <div class="col-sm-4 offset-sm-8">
            <div class="table-responsive">
              <table class="table table-bordered table-fullwidth table-primary bg-white text-primary">
                <tbody>
                  <tr>
                    <td><h6><b>Payments / Credits:</b> {{ $selected_payment->getFormattedPaymentAmount() }}</h6></td>
                  </tr>
                  @if($selected_payment->has_processing_fee == 1)
                    <tr>
                      <td><h6><b>Processing Fee:</b> ${{ number_format(($selected_payment->payment_amount * 0.0175 / 100 + 0.30), 2, '.', ',') }}</h6></td>
                    </tr>
                  @endif
                  <tr>
                    <td><h4><b>Remaining Balance:</b> ${{ number_format(($selected_payment->remaining_amount / 100), 2, '.', ',') }}</h4></td>
                  </tr>
                  <tr>
                    <td>GST component: {{ $selected_payment->getFormattedPaymentTaxAmount() }}</td>
                  </tr>
                </tbody>
              </table>
            </div> {{-- table-responsive --}}
          </div> {{-- col-sm-4 offset-sm-8 --}}
        </div> {{-- row --}}
        {{-- price data --}}

        <h4 class="text-primary text-center">Thank you for your business</h4>
        <h4 class="text-secondary text-center">A.B.N {{ $selected_system->abn }}</h4>

        {{-- footer --}}
        <img class="img-fluid py-3" src="{{ asset('storage/images/letterheads/mrt-letter-footer.jpg') }}" alt="Footer image">
        {{-- footer --}}

      </div> {{-- card-body --}}
    </div> {{-- card --}}
    {{-- customer view quote --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection