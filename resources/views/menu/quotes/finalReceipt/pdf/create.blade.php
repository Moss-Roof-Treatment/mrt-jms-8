<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <title>{{ $selected_system->short_title }} - Final Receipt</title>
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <style>
    .text-primary
    {
      color:#0712a6;
    }
    .text-secondary
    {
      color:#db5800;
    }
    table, th, td {
      border: 2px solid #0712a6;
    }
    body {
      font-size: 16px;
    }
    div.page
    {
      page-break-after: always;
      page-break-inside: avoid;
    }
    html{height: 0;}
  </style>
</head>
<body>

  <div> {{-- container --}}

    <div class="page">

      {{-- letterhead --}}
      <img class="img-responsive" src="{{ public_path('storage/images/letterheads/mrt-final-receipt-letterhead.jpg') }}" alt="Letterhead image">
      {{-- letterhead --}}

      {{-- first table --}}
      <table class="table table-fullwidth text-primary" style="margin-top: 40px;">
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
              @if ($selected_quote->final_receipt_date == null)
                Pending
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
            <td>On Completion</td>
            <td>{{ $selected_quote->customer_id }}</td>
          </tr>
        </tbody>
      </table>
      {{-- first table --}}

      {{-- paid marker --}}
      @if ($selected_quote->getRemainingBalance() == 0)
        <h1 class="text-danger text-center"><b>PAID</b></h1>
      @else
        <h1 class="text-success text-center"><b>PENDING</b></h1>
      @endif
      {{-- paid marker --}}

      {{-- second table --}}
      <table class="table table-fullwidth text-primary" style="margin-top: 40px;">
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
      {{-- second table --}}

      {{-- price data --}}
      <div class="row">
        <div class="col-xs-4 col-xs-offset-8">
          <table class="table table-fullwidth bg-white text-primary" style="margin-top: 40px;">
            <tbody>
              <tr>
                <td><b>Subtotal:</b> {{ $selected_quote->getFormattedQuoteTotal() }}</td>
              </tr>
              @if($selected_quote->getQuotePaymentsSurcharge() != 0)
                <tr>
                  <td><b>Total Processing Fees:</b> {{ $selected_quote->getQuotePaymentsSurcharge() }}</td>
                </tr>
              @endif
              <tr>
                <td><b>Payments / Credits:</b> {{ $selected_quote->getFormattedPaymentsCreditsFinalReceipt() }}</td>
              </tr>
              <tr>
                <td><b><h4>Total: {{ $selected_quote->getFormattedRemainingBalance() }}</h4></b></td>
              </tr>
              <tr>
                <td><b>GST component:</b> {{ $selected_quote->getFormattedSubtotalGst() }}</td>
              </tr>
            </tbody>
          </table>
        </div> {{-- col-xs-4 col-xs-offset-8 --}}
      </div> {{-- row --}}
      {{-- price data --}}

      {{-- footer --}}
      <h4 class="text-primary text-center">Thank you for your business</h4>
      <h4 class="text-secondary text-center">A.B.N {{ $selected_system->abn }}</h4>
      {{-- footer --}}

    </div> {{-- page --}}

  </div> {{-- container --}}

</body>
</html>