<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <title>{{ $selected_system->short_title }} - Tax Invoice</title>
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
      <img class="img-responsive" src="{{ public_path('storage/images/letterheads/mrt-tax-invoice-letterhead.jpg') }}" alt="Letterhead image">
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
              @if ($selected_quote->tax_invoice_date == null)
                Pending
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
            <td style="background-color:#ffed4a;">On Completion</td>
            <td>{{ $selected_quote->customer_id }}</td>
          </tr>
        </tbody>
      </table>
      {{-- first table --}}

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
      {{-- second table --}}

      {{-- third table --}}
      @if ($selected_quote->tax_invoice_note != null)
        <table class="table table-fullwidth text-primary" style="margin-top: 40px;">
          <tbody>
            <tr>
              <td><b>Notes</b></td>
            </tr>
            <tr>
              <td>{{ $selected_quote->tax_invoice_note }}</td>
            </tr>
          </tbody>
        </table>
      @endif
      {{-- third table --}}

      {{-- fourth table --}}
      <table class="table table-fullwidth bg-white text-primary" style="margin-top: 40px;">
        <tbody>
          <tr>
            <th colspan="3" width="70%">Payment Options</th>
            <td><b>Payments / Credits:</b> {{ $selected_quote->getFormattedPaymentsTotal() }}</td>
          </tr>
          <tr>
            <td colspan="3" rowspan="3">
              <b>Bank Details:</b> {{ $selected_system->bank_name }} - {{ $selected_system->bank_account_name }}, BSB: {{ $selected_system->bank_bsb_number }}, ACC: {{ $selected_system->bank_account_number }}<br>
              <b>Payment Card:</b> Mastercard or Visa<br>
              <b>Reference Number:</b> {{ $selected_quote->quote_identifier }}<br>
              <b>Payment Reference:</b> Please use the above reference number when making a payment.<br>
              <b>Payment Card:</b> Mastercard or Visa<br>
              <b>Other:</b> Cash / Cheque<br>
              <b>OR pay through our online payment system.</b>
            </td>
          </tr>
          <tr>
            <td><b><h3>Balance Due: {{ $selected_quote->getFormattedRemainingBalanceTaxInvoice() }}</h3></b></td>
          </tr>
          <tr>
            <td><b>GST component:</b> {{ $selected_quote->getFormattedRemainingBalanceTaxInvoiceGst() }}</td>
          </tr>
        </tbody>
      </table>
      {{-- fourth table --}}

      {{-- footer --}}
      <h4 class="text-primary text-center">Thank you for your business</h4>
      <h4 class="text-secondary text-center">A.B.N {{ $selected_system->abn }}</h4>
      {{-- footer --}}

    </div> {{-- page --}}

  </div> {{-- container --}}

</body>
</html>