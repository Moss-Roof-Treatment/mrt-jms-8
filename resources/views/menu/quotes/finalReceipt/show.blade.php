@extends('layouts.app')

@section('title', '- Quote - View Selected Final Receipt')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">FINAL RECEIPT</h3>
    <h5>View Selected Final Receipt</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('quotes.show', $selected_quote->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-file-invoice mr-2" aria-hidden="true"></i>View Quote
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('customers.show', $selected_quote->customer_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-user mr-2" aria-hidden="true"></i>View Customer
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('jobs.show', $selected_quote->job_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Job
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <form action="{{ route('quote-final-receipts.create') }}" method="GET">
          <input type="hidden" name="quote_id" value="{{ $selected_quote->id }}">
          <button type="submit" class="btn btn-dark btn-block">
            <i class="fas fa-download mr-2" aria-hidden="true"></i>Download PDF
          </button>
        </form>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

  </div> {{-- container --}}
</section> {{-- section --}}
<section class="bg-dark">
  <div class="container py-5">

    {{-- page 1 --}}

    <div class="card">
      <div class="card-body">

        {{-- letterhead --}}
        <img class="img-fluid py-3" src="{{ asset('storage/images/letterheads/mrt-final-receipt-letterhead.jpg') }}" alt="Letterhead image">
        {{-- letterhead --}}

        {{-- receipt data --}}
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth bg-white table-primary text-primary">
            <tbody>
              <tr>
                <th colspan="3" width="70%"">Receipt Name</th>
                <th>Date</th>
                <th>Job #</th>
              </tr>
              <tr>
                <td colspan="3" rowspan="4">
                  {{ $selected_quote->customer->business_name ?? '' }}
                  <br>
                  {{ $selected_quote->customer->getFullNameAttribute() }}
                  <br>
                  {{ $selected_quote->job->tenant_street_address }}
                  <br>
                  {{ $selected_quote->job->tenant_suburb . ', ' . $selected_quote->job->tenant_postcode }}
                </td>
              </tr>
              <tr>
                <td>
                  @if ($selected_quote->final_receipt_date == null)
                    <span class="badge badge-warning py-2 px-2"><i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending</span>
                  @else
                    {{ date('d/m/y', strtotime($selected_quote->final_receipt_date)) }}
                  @endif
                </td>
                <td>{{ $selected_quote->job_id }}</td>
              </tr>
              <tr>
                <th>Terms</th>
                <th>Customer #</th>
              </tr>
              <tr>
                <td class="table-warning">On Completion</td>
                <td>{{ $selected_quote->customer_id }}</td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}
        {{-- receipt data --}}

        {{-- paid marker --}}
        @if ($selected_quote->getRemainingBalance() == 0)
          <h1 class="text-danger text-center"><b>PAID</b></h1>
        @else
          <h1 class="text-success text-center"><b>PENDING</b></h1>
        @endif
        {{-- paid marker --}}

        {{-- quantity marker --}}
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth bg-white table-primary text-primary">
            <tbody>
              <tr>
                <th>Item</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Rate</th>
                <th>Amount</th>
              </tr>
              <tr>
                <td>{{ $selected_system->short_title }}</td>
                <td>Remaining Balance as of 
                  @if ($selected_quote->tax_invoice_date == null)
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>Tax invoice date has not been set
                    </span>
                  @else
                    {{ date('d/m/y', strtotime($selected_quote->tax_invoice_date)) }}
                  @endif
                </td>
                <td>1</td>
                <td></td>
                <td>{{ $selected_quote->getFormattedRemainingBalanceTaxInvoice() }}</td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}
        {{-- quantity marker --}}

        {{-- price data --}}
        <div class="row">
          <div class="col-sm-4 offset-sm-8">
            <div class="table-responsive">
              <table class="table table-bordered table-fullwidth bg-white table-primary text-primary">
                <tbody>
                  <tr>
                    <td><h6><b>Subtotal:</b> {{ $selected_quote->getFormattedQuoteTotal() }}</h6></td>
                  </tr>
                  <tr>
                    <td><h6><b>Payments / Credits:</b> {{ $selected_quote->getFormattedPaymentsCreditsFinalReceipt() }}</h6></td>
                  </tr>
                  @if($selected_quote->getQuotePaymentsSurcharge() != 0)
                    <tr>
                      <td><h6><b>Total Processing Fees:</b> {{ $selected_quote->getQuotePaymentsSurcharge() }}</h6></td>
                    </tr>
                  @endif
                  <tr>
                    <td><h4><b>Total:</b> {{ $selected_quote->getFormattedRemainingBalance() }}</h4></td>
                  </tr>
                  <tr>
                    <td><b>GST component:</b> {{ $selected_quote->getFormattedSubtotalGst() }}</td>
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

    {{-- page 1 --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection