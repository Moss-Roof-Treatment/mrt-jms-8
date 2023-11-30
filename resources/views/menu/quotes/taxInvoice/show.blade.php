@extends('layouts.app')

@section('title', '- Quote - View Selected Tax Invoice')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">TAX INVOICE</h3>
    <h5>View Selected Tax Invoice</h5>
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
        <form action="{{ route('quote-tax-invoices.create') }}" method="GET">
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

    <div class="card">
      <div class="card-body">

        {{-- letterhead --}}
        <img class="img-fluid py-3" src="{{ asset('storage/images/letterheads/mrt-tax-invoice-letterhead.jpg') }}" alt="Letterhead image">
        {{-- letterhead --}}

        {{-- receipt data --}}
        <div class="table-responsive mt-3">
          <table class="table table-bordered table-fullwidth bg-white table-primary text-primary">
            <tbody>
              <tr>
                <th colspan="3" width="70%">Receipt Name</th>
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
                  @if ($selected_quote->tax_invoice_date == null)
                    <span class="badge badge-warning py-2 px-2"><i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending</span>
                  @else
                    {{ date('d/m/y', strtotime($selected_quote->tax_invoice_date)) }}
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

        {{-- quantity data --}}
        <div class="table-responsive mt-3">
          <table class="table table-bordered table-fullwidth bg-white table-primary text-primary text-nowrap">
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
                <td>Remaining Balance</td>
                <td>1</td>
                <td></td>
                <td>{{ $selected_quote->getFormattedRemainingBalanceDeposit() }}</td>
              </tr>
              @foreach ($selected_quote->quote_tax_invoice_items as $tax_invoice_item)
                <tr>
                  <td>{{ $tax_invoice_item->title }}</td>
                  <td></td>
                  <td>{{ $tax_invoice_item->quantity }}</td>
                  <td>{{ $tax_invoice_item->getIndividualPriceAttribute() }}</td>
                  <td>{{ $tax_invoice_item->getTotalPriceAttribute() }}</td>
                </tr>
              @endforeach
              @if ($selected_quote->tax_invoice_discount != 0)
                <tr>
                  <td>Discount</td>
                  <td>Discount</td>
                  <td>1</td>
                  <td></td>
                  <td>- ${{ $selected_quote->getTaxInvoiceDiscount() }}</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div> {{-- table-responsive --}}
        {{-- quantity data --}}

        {{-- notes --}}
        @if ($selected_quote->tax_invoice_note != null)
          <div class="table-responsive mt-3">
            <table class="table table-bordered table-fullwidth bg-white table-primary text-primary">
              <tbody>
                <tr>
                  <td><b>Notes</b></td>
                </tr>
                <tr>
                  <td>{{ $selected_quote->tax_invoice_note }}</td>
                </tr>
              </tbody>
            </table>
          </div> {{-- table-responsive --}}
        @endif
        {{-- notes --}}

        {{-- price data --}}
        <div class="table-responsive mt-3">
          <table class="table table-bordered table-fullwidth bg-white table-primary text-primary">
            <tbody>
              <tr>
                <th colspan="3" width="70%">Payment Options</th>
                <td><h6><b>Payments / Credits:</b> {{ $selected_quote->getFormattedDepositPaidTotal() }}</h6></td>
              </tr>
              <tr>
                <td colspan="3" rowspan="3">
                  <b>Bank Details:</b> {{ $selected_system->bank_name }} - {{ $selected_system->bank_account_name }}, BSB: {{ $selected_system->bank_bsb_number }}, ACC: {{ $selected_system->bank_account_number }}<br>
                  <b>Reference Number:</b> {{ $selected_quote->quote_identifier }}<br>
                  <b>Payment Reference:</b> Please use the above reference number when making a payment.<br>
                  <b>Payment Card:</b> Mastercard or Visa<br>
                  <b>Other:</b> Cash / Cheque<br>
                  <b>OR pay through our online payment system.</b>
                </td> 
              </tr>
              <tr>
                <td><h4><b>Balance Due:</b> {{ $selected_quote->getFormattedRemainingBalanceTaxInvoice() }}</h4></td>
              </tr>
              <tr>
                <td>GST component: {{ $selected_quote->getFormattedRemainingBalanceTaxInvoiceGst() }}</td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}
        {{-- price data --}}

        <h4 class="text-primary text-center">Thank you for your business</h4>
        <h4 class="text-secondary text-center">A.B.N {{ $selected_system->abn }}</h4>

        {{-- footer --}}
        <img class="img-fluid py-3" src="{{ asset('storage/images/letterheads/mrt-letter-footer.jpg') }}" alt="Footer image">
        {{-- footer --}}

      </div> {{-- card-body --}}
    </div> {{-- card --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection