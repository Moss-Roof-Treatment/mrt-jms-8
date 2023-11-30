<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex">

  <title>Moss Roof Treatment - Invoice</title>

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

    th, td {
      border: 2px solid #0712a6;
    }

    td 
    {
      font-size: 12px;
    }

    th
    {
      font-size: 12px;
    }

    p
    {
      font-size: 12px;
    }

    hr
    {
      border: 1px solid #0712a6;
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

  <div>

  <div class="page">

    {{-- letterhead --}}

    <p>
      <b>
        @if ($selected_invoice->user->business_name == null) 
          {{ $selected_invoice->user->getFullNameAttribute() }}<br>
        @else
          {{ $selected_invoice->user->business_name . ' - ' . $selected_invoice->user->getFullNameAttribute() }}<br>
        @endif
        @if ($selected_invoice->user->abn != null)
          ABN: {{ substr($selected_invoice->user->abn, 0, 2) . ' ' . substr($selected_invoice->user->abn, 2, 3) . ' ' . substr($selected_invoice->user->abn, 5, 3) . ' ' . substr($selected_invoice->user->abn, 8, 3) }}<br>
        @endif
        {{ $selected_invoice->user->street_address }}<br>
        {{ $selected_invoice->user->suburb . ', ' . $selected_invoice->user->postcode }}<br>
        @if ($selected_invoice->user->business_phone == null)
          {{ substr($selected_invoice->user->mobile_phone, 0, 4) . ' ' . substr($selected_invoice->user->mobile_phone, 4, 3) . ' ' . substr($selected_invoice->user->mobile_phone, 7, 3) }}
        @else
          {{ substr($selected_invoice->user->business_phone, 0, 4) . ' ' . substr($selected_invoice->user->business_phone, 4, 3) . ' ' . substr($selected_invoice->user->business_phone, 7, 3) }}
        @endif
      </b>
    </p>

    @if ($selected_invoice->user->has_gst == 1)
      <h2><b>Tax Invoice</b></h2>
    @else
      <h2><b>Pay Slip</b></h2>
    @endif

    {{-- letterhead --}}

    {{-- invoice information --}}

    <div class="row" style="padding-top:5px; padding-bottom:10px;">
      <div class="col-xs-6">

        <table class="table" style="border-top: 2px solid #0712a6;">
          <tbody>
            <tr>
              <th>Name</th>
              <td>{{ $selected_system->title }}</td>
            </tr>
            <tr>
              <th>ABN</th>
              <td>{{ $selected_system->abn }}</td>
            </tr>
            <tr>
              <th>Address</th>
              <td>{{ $selected_system->contact_address }}</td>
            </tr>
            <tr>
              <th>Phone</th>
              <td>{{ substr($selected_system->contact_phone, 0, 4) . ' ' . substr($selected_system->contact_phone, 4, 3) . ' ' . substr($selected_system->contact_phone, 7, 3) }}</td>
            </tr>
          </tbody>
        </table>

      </div> {{-- col-xs-6 --}}
      <div class="col-xs-3 col-xs-offset-3">

        <table class="table" style="border-top: 2px solid #0712a6;">
          <tbody>
            <tr>
              <th>Invoice No</th>
              <td><b><span class="text-danger">{{ $selected_invoice->identifier }}</span></b></td>
            </tr>
            <tr>
              <th>Date</th>
              <td>
                @if ($selected_invoice->paid_date == null)
                  To Be Confirmed
                @else
                  {{ date('d/m/y', strtotime($selected_invoice->paid_date)) }}
                @endif
              </td>
            </tr>
          </tbody>
        </table>

      </div> {{-- col-xs-3 col-xs-offset-3 --}}
    </div> {{-- row --}}

    {{-- invoice information --}}

    {{-- body --}}

    <table class="table" style="border-top: 2px solid #0712a6;">
      <tbody>
        <tr>
          <th width="20%">Job No</th>
          <th width="20%">Date</th>
          <th width="40%">Description</th>
          <th width="20%">Amount</th>
        </tr>
        @if ($selected_invoice->quote_id != null)
          <tr>
            <tr>
              <td></td>
              <td></td>
              <td>
                {{ $selected_invoice->quote->job->tenant_name }}<br>
                {{ $selected_invoice->quote->job->tenant_street_address . ', ' . $selected_invoice->quote->job->tenant_suburb . ' ' . $selected_invoice->quote->job->tenant_postcode }}<br>
                @if ($selected_invoice->quote->job->tenant_home_phone != null)
                  {{ 'Contact Number: ' . $selected_invoice->quote->job->tenant_home_phone }}
                @endif
                @if ($selected_invoice->quote->job->tenant_mobile_phone != null)
                  {{ 'Contact Number: ' . $selected_invoice->quote->job->tenant_mobile_phone }}
                @endif
              </td>
              <td></td>
            </tr>
          </tr>
        @endif
        @foreach ($selected_invoice->invoice_items as $item)
          <tr>
            <td>{{ $item->job_id }}</td>
            <td>
              @if ($item->completed_date == null)
                To Be Confirmed
              @else
                {{ date('d/m/y', strtotime($item->completed_date)) }}
              @endif
            </td>
            <td>{{ $item->description }}</td>
            <td>${{ number_format(($item->cost_total / 100), 2, '.', ',') }}</td>
          </tr>
        @endforeach
        <tr>
          <td style="border:none;"></td>
          <td style="border:none;"></td>
          <th>Subtotal</th>
          <td>{{ $selected_invoice->getFormattedInvoiceSubtotal() }}</td>
        </tr>
        @if($selected_invoice->user->has_gst)
          <tr>
            <td style="border:none;"></td>
            <td style="border:none;"></td>
            <th>GST</th>
            <td>{{ $selected_invoice->getFormattedInvoiceTax() }}</td>
          </tr>
        @endif
        @if($selected_invoice->user->has_payg)
          <tr>
            <td style="border:none;"></td>
            <td style="border:none;"></td>
            <th>PAYG</th>
            <td>View on Group Invoice</td>
          </tr>
        @endif
        <tr>
          <td style="border:none;"></td>
          <td style="border:none;"></td>
          <th>Net Total</th>
          <th>{{ $selected_invoice->getFormattedInvoiceTotal() }}</th>
        </tr>
        @if($selected_invoice->user->super_fund_name != null)
          <tr>
            <td style="border:none;"></td>
            <td style="border:none;"></td>
            <th>Superannuation</th>
            <td>{{ $selected_invoice->getFormattedInvoiceSuperannuation() }}</td>
          </tr>
        @endif
      </tbody>
    </table>

    <table class="table" style="border-top: 2px solid #0712a6;">
      <tbody>
        <tr>
          <th>Payment Details</th>
          <th>Reference</th>
        </tr>
        <tr>
          <td>{{ '(' . $selected_invoice->user->bank_bsb . ') ' . \Str::mask($selected_invoice->user->bank_account_number, '*', '0', 4) . ' ' . $selected_invoice->user->bank_account_name }}</td>
          <td>{{ $selected_system->acronym  }}</td>
        </tr>
      </tbody>
    </table>

    <table class="table" style="border-top: 2px solid #0712a6;">
      <tbody>
        <tr>
          <th width="20%">Lod:</th>
          <td></td>
        </tr>
        <tr>
          <th>Rec:</th>
          <td></td>
        </tr>
        <tr>
          <th>Date:</th>
          <td></td>
        </tr>
      </tbody>
    </table>

    <p>
      <b>Office Use Only</b>
      <br>
      (Contractor rates include Tax and Superannuation)
    </p>

    {{-- body --}}

  </div> {{-- page --}}

  </div>

</body>
</html>