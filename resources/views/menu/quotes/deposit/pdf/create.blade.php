<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <title>{{ $selected_system->short_title }} - Deposit Receipt</title>
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

    {{-- page 1 --}}

    <div class="page">

      {{-- letterhead --}}
      <img class="img-responsive" src="{{ public_path('storage/images/letterheads/mrt-deposit-receipt-letterhead.jpg') }}" alt="Letterhead image">
      {{-- letterhead --}}

      {{-- receipt data --}}
      <table class="table table-fullwidth text-primary" style="margin-top: 40px;">
        <tbody>
          <tr>
            <th colspan="3" width="70%">Deposit Receipt Name</th>
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
              @if (!$selected_quote->payments->count())
                <span class="badge badge-warning py-2 px-2"><i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending</span>
              @else
                {{ date('d/m/y', strtotime($selected_quote->payments->first->latest()->created_at)) }}
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
      {{-- receipt data --}}

        {{-- void marker --}}
        @if ($selected_quote->payments->first->latest()->void_date != null)
          <h1 class="text-danger text-center"><b>VOID</b></h1>      
        @endif
        {{-- void marker --}}

      {{-- quantity data --}}
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
            <td>{{ $selected_quote->getFormattedDepositPaidTotal() }}</td>
          </tr>
        </tbody>
      </table>
      {{-- quantity data --}}

      {{-- price data --}}
      <div class="row">
        <div class="col-xs-4 col-xs-offset-8">
          <table class="table table-fullwidth bg-white text-primary" style="margin-top: 40px;">
            <tbody>
              <tr>
                <td><b>Total:</b> {{ $selected_quote->getFormattedDepositPaidTotal() }}</td>
              </tr>
              @if($selected_quote->getQuoteDepositPaymentsSurcharge() != 0)
                <tr>
                  <td><b>Processing Fee:</b> {{ $selected_quote->getQuotePaymentsSurcharge() }}</td>
                </tr>
              @endif
              <tr>
                <td><h4><b>Remaining Balance:</b> {{ $selected_quote->getFormattedRemainingBalanceDeposit() }}</h4></td>
              </tr>
              <tr>
                <td>GST component {{ $selected_quote->getFormattedDepositPaidGst() }}</td>
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

    {{-- page 1 --}}

  </div> {{-- container --}}

</body>
</html>