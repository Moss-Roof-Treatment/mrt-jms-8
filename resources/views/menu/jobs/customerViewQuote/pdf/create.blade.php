<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <title>{{ $selected_system->short_title }} - Quote</title>
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
      <img style="width:100%;" src="{{ public_path('storage/images/letterheads/mrt-quotation-letterhead.jpg') }}" alt="">
      {{-- letterhead --}}

      {{-- quote and customer id --}}
      <div class="row" style="padding-top:5px; padding-bottom:10px;">
        <div class="col-xs-6">
          <h4 class="text-primary text-center"><b>Customer No:</b> <span class="text-danger">{{ $selected_quote->customer_id }}</span></h4>
        </div>
        <div class="col-xs-6">
          <h4 class="text-primary text-center"><b>Quote No:</b> <span class="text-danger">{{ $selected_quote->quote_identifier }}</span></h4>
        </div>
      </div>
      {{-- quote and customer id --}}

      {{-- detail tables --}}
      <div class="row">
        <div class="col-xs-4">
          <table class="table table-striped">
            <tbody>
              <tr>
                <th>Business</th>
                <td>
                  @if ($selected_quote->customer->business_name == null)
                    Not Applicable
                  @else
                    {{ $selected_quote->customer->business_name }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Name</th>
                <td>{{ $selected_quote->customer->getFullNameAttribute() }}</td>
              </tr>
              <tr>
                <th>Address</th>
                <td>{{ $selected_quote->customer->street_address }}</td>
              </tr>
              <tr>
                <th>Suburb</th>
                <td>{{ $selected_quote->customer->suburb . ' ' . $selected_quote->customer->postcode }}</td>
              </tr>
            </tbody>
          </table>
        </div> {{-- col-xs-4 --}}
        <div class="col-xs-4">
          <table class="table table-striped">
            <tbody>
              <tr>
                <th>Email</th>
                <td>{{ $selected_quote->customer->email }}</td>
              </tr>
              <tr>
                <th>Phone</th>
                <td>
                  @if ($selected_quote->customer->home_phone == null)
                    Not Applicable
                  @else
                    {{ $selected_quote->customer->home_phone }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Mobile</th>
                <td>
                  @if ($selected_quote->customer->mobile_phone == null)
                    Not Applicable
                  @else
                    {{ $selected_quote->customer->mobile_phone }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Business</th>
                <td>
                  @if ($selected_quote->customer->business_phone == null)
                    Not Applicable
                  @else
                    {{ $selected_quote->customer->business_phone }}
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div> {{-- col-xs-4 --}}
        <div class="col-xs-4">
          <table class="table table-striped">
            <tbody>
              <tr>
                <th>Tenant</th>
                <td>{{ $selected_quote->job->tenant_name }}</td>
              </tr>
              <tr>
                <th>Job Address</th>
                <td>{{ $selected_quote->job->tenant_street_address }}</td>
              </tr>
              <tr>
                <th>Suburb</th>
                <td>{{ $selected_quote->job->tenant_suburb . ' ' . $selected_quote->job->tenant_postcode }}</td>
              </tr>
              <tr>
                <th>Phone</th>
                <td>
                  @if ($selected_quote->customer->home_phone == null)
                    Not Applicable
                  @else
                    {{ $selected_quote->customer->home_phone }}
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div> {{-- col-xs-4 --}}
      </div> {{-- row --}}
      {{-- detail tables --}}

      <hr>

      {{-- level --}}
      <div class="row">
        <div class="col-xs-3 text-center">
          @if ($selected_quote->job->building_style_id == null)
            <small><b>Building Style:</b> Not Applicable</small>
          @else
            <small><b>Building Style:</b> {{ $selected_quote->job->building_style->title }}</small>
          @endif
        </div>
        <div class="col-xs-3 text-center">
          <small><b>Inspection Type:</b> {{ $selected_quote->job->inspection_type->title }}</small>
        </div>
        <div class="col-xs-3 text-center">
          @if ($selected_quote->job->inspection_date == null)
            <small><b>Date Inspected:</b> Not Applicable</small>
          @else
            <small><b>Date Inspected:</b> {{ date('d/m/y', strtotime($selected_quote->created_at)) }}
          @endif
        </div>
        <div class="col-xs-3 text-center"><small><b>Inspected By:</b> {{ $selected_quote->job->salesperson->first_name }}</small></div>
      </div>
      {{-- level --}}

      <hr>

      {{-- body --}}
      <div class="row">
        <div class="col-xs-6">
          <h5 class="text-secondary"><b>WORK LIST / JOB SPECIFICATIONS</b></h5>
          @if (!$all_quote_tasks->count())
            <p class="text-center">There are no tasks to display</p>
          @else
            @foreach ($all_quote_tasks as $quote_task)
              <div class="row">
                <div class="col-xs-2" style="padding-bottom: 5px;">
                  @if ($quote_task->task->image_path == null)
                    <img class="img-responsive" src="{{ public_path('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                  @else
                    <img class="img-responsive" src="{{ public_path($quote_task->task->image_path) }}" alt="job_image">
                  @endif
                </div> {{-- col-xs-2 --}}
                <div class="col-xs-10">
                  <p>
                    <b>{{ $quote_task->task->title  }}</b>
                    <br>
                    @if ($quote_task->description == null)
                      {{ $quote_task->task->description }}
                    @else
                      {{ $quote_task->description }}
                    @endif
                  </p>
                </div> {{-- col-xs-10 --}}
              </div> {{-- row --}}
            @endforeach
          @endif
        </div> {{-- col-xs-6 --}}
        <div class="col-xs-6">
          <h5 class="text-secondary"><b>JOB IMAGES</b></h5>
          @if (!$all_pdf_images->count())
            <p class="text-center">There are no images to display</p>
          @else
            @if ($all_pdf_images->count() == 1)
              <img class="img-responsive" style="padding-bottom:30px;" src="{{ public_path($all_pdf_images->first()->image_path) }}" alt="job_image">
            @else
              <div class="row" style="padding-bottom:30px;">
                @foreach ($all_pdf_images as $image)
                  <div class="col-xs-6">
                    @if ($image->image_path == null)
                      <img class="img-responsive" src="{{ public_path('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                    @else
                      <img class="img-responsive" src="{{ public_path($image->image_path) }}" alt="job_image">
                    @endif
                  </div> {{-- col-xs-6 --}}
                @endforeach
              </div> {{-- row --}}
            @endif
          @endif
          <h5 class="text-secondary"><b>ADDITIONAL COMMENTS</b></h5>
          @if ($selected_quote->additional_comments == null)
            <p class="text-center">There are no additional comments</p>
          @else
            <p>{{ $selected_quote->additional_comments }}</p>
          @endif
          <h5 class="text-secondary"><b>PROPERTIES TO VIEW</b></h5>
          @if ($selected_quote->job->default_properties_to_view_id == null)
            <p class="text-center">There are no properties to view</p>
          @else
            <p>
              {{ $selected_quote->job->default_properties_to_view->property_1 }}<br>
              {{ $selected_quote->job->default_properties_to_view->property_2 }}<br>
              {{ $selected_quote->job->default_properties_to_view->property_3 }}<br>
              {{ $selected_quote->job->default_properties_to_view->property_4 }}
            </p>
          @endif
        </div> {{-- col-xs-6 --}}
      </div> {{-- row --}}
      {{-- body --}}

      <hr>

      {{-- level --}}
      <div class="row">
        <div class="col-xs-3">
          @if ($selected_quote->job_type_id != null)
            <p class="text-center"><b>Quote For: </b>{{ $selected_quote->job_type->title }}</p>
          @else
            <p class="text-center"><b>Quote For: </b>{{ $selected_system->short_title }}</p>
          @endif
        </div> {{-- col-xs-3 --}}
        <div class="col-xs-3">
          <p class="text-center"><b>Estimated Price: </b>{{ $selected_quote->getFormattedSubtotalWithoutGst() }}</p>
        </div> {{-- col-xs-3 --}}
        <div class="col-xs-3">
          <p class="text-center"><b>GST: </b>{{ $selected_quote->getFormattedSubtotalGst() }}</p>
        </div> {{-- col-xs-3 --}}
        <div class="col-xs-3">
          <p class="text-center"><b>Total: </b>{{ $selected_quote->getFormattedQuoteTotal() }}<br>
            @if ($selected_quote->discount > 0)
              (Discounted)
            @endif
          </p>
        </div> {{-- col-xs-3 --}}
      </div> {{-- row --}}
      {{-- level --}}

      <hr>

    </div> {{-- page --}}

    <div class="page">

      {{-- footer --}}

      <div class="row">
        <div class="col-xs-6">

          <table class="table table-striped">
            <tbody>
              <tr>
                <th>Owner</th>
                <td>{{ $selected_quote->customer->getFullNameAttribute() }}</td>
              </tr>
              <tr>
                <th>Address</th>
                <td>{{ $selected_quote->job->tenant_street_address }}</td>
              </tr>
              <tr>
                <th>Suburb</th>
                <td>{{ $selected_quote->job->tenant_suburb . ', ' . $selected_quote->job->tenant_postcode }}</td>
              </tr>
              <tr>
                <th>Email</th>
                <td>{{ $selected_quote->customer->email }}</td>
              </tr>
              <tr>
                <th>Phone</th>
                <td>
                  @if ($selected_quote->customer->home_phone == null)
                    Not Applicable
                  @else
                    {{ $selected_quote->customer->home_phone }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Mobile</th>
                <td>
                  @if ($selected_quote->customer->mobile_phone == null)
                    Not Applicable
                  @else
                    {{ $selected_quote->customer->mobile_phone }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Start Date</th>
                <td>
                  @if ($selected_quote->job->start_date == null)
                    To Be Confirmed
                  @else
                    {{ date('d/m/y - h:iA', strtotime($selected_quote->job->start_date)) }}
                  @endif
                </td>
              </tr>
            </tbody>
          </table>

        </div> {{-- col-xs-6 --}}
        <div class="col-xs-6">

          <p class="text-primary"><b>Upon acceptance, the following is required:</b></p>

          <table class="table table-striped">
            <tbody>
              <tr>
                <th width="40%">25% Deposit Required</th>
                <td>{{ $selected_quote->getFormattedDepositTotal() }}</td>
              </tr>
              <tr>
                <th>Balance Due On Completion</th>
                <td>{{ $selected_quote->getFormattedDepositBalanceOnCompletion() }}</td>
              </tr>
              <tr>
                <th>Signature</th>
                <td></td>
              </tr>
              <tr>
                <th>Date</th>
                <td></td>
              </tr>
              <tr>
                <td colspan="2">
                  <b>Bank Details:</b><br> {{ $selected_system->bank_name }} - {{ $selected_system->bank_account_name }}, BSB: {{ $selected_system->bank_bsb_number }}, ACC: {{ $selected_system->bank_account_number }}<br>
                  <b>Reference Number:</b> {{ $selected_quote->quote_identifier }}<br>
                  <b>Payment Reference:</b> Please use the above reference number when making a payment.<br>
                  <b>Payment Card:</b> Mastercard or Visa<br>
                  <b>Other:</b> Cash / Cheque<br>
                  <b>OR pay through our online payment system.</b>
                </td>
              </tr>
            </tbody>
          </table>

        </div> {{-- col-xs-6 --}}
      </div> {{-- row --}}

      {{-- footer --}}

      <hr>

      <h4 class="text-center"><b>GUARANTEE</b></h4>
      <p>MOSS ROOF TREATMENT HEREBY GUARANTEES THAT THE WORK COMPLETED SHALL PERFORM THE FUNCTIONS HEREIN FOR A PERIOD OF 3 YEARS.</p>
      <p>THAT NO NEW MOSS SHALL GROW WITHIN THE STATED PERIOD OF TIME TO THE TREATED AREAS.</p>
      <p>IN THE EVENT OF FAILURE OF THE ABOVE MENTIONED ASPECTS OF THE PRODUCT THE COMPANY SHALL: - RESPRAY THE AFFECTED AREA TOTALLY FREE OF CHARGE</p>

      <h4 class="text-center"><b>TERMS AND CONDITIONS</b></h4>
      <p>NOTE: THE BENEFITS CONFERRED BY THIS WARRANTY AND GUARANTEE ARE IN ADDITION TO ALL OTHER RIGHTS WHICH THE CLIENT IS ENTITLED TO UNDER THE TRADE PRACTICE ACT AND ANY OTHER LAW OF THE RELEVANT STATE OR TERRITORY.</p>
      <small>
      <ol>
        <li>THE CLIENT AGREES TO SUPPLY ALL POWER AND WATER AS REQUIRED.</li>
        <li>THE CLIENT AGREES TO KEEP CHILDREN/PETS AWAY FROM WORKMEN WHILE WORK IS IN PROGRESS. THE CLIENT AGREES NOT TO LET ANYBODY WALK ON ROOF WHILE WORK IS IN PROGRESS.</li>
        <li>THE COMPANY WILL ENDEAVOUR TO FINISH THE WORK AS NEAR TO THE DESIRED DATE OF COMPLETION AS POSSIBLE BUT WITHOUT A FIRM DATE FOR COMPLETION.</li>
        <li>THE DETAILS OF ALL WORK ARE DESIGNATED OVERLEAF.</li>
        <li>NO RESPONSIBILITY CAN BE TAKEN UNDER ANY CIRCUMSTANCES FOR DAMAGE TO ANY VEHICLES PARKED ON OR NEAR THE PREMISES (PLEASE REMOVE THEM PRIOR TO COMMENCEMENT). FURTHER TO THIS NO RESPONSIBILITY CAN BE TAKEN UNDER ANY CIRCUMSTANCES FOR DAMAGES TO FURNITURE/PLANTS ETC NEAR THE PREMISES - (PLEASE REMOVE OR COVER PRIOR TO COMMENCEMENT).</li>
        <li>NO RESPONSIBILITY CAN BE TAKEN UNDER ANY CIRCUMSTANCES FOR DAMAGE TO GUTTERS THAT ARE SOFT OR IN A RUSTED CONDITION.</li>
        <li>WHEN MOSS ROOF TREATMENT IS APPLIED MOSS ROOF TREATMENT WILL GUARANTEE THAT THERE WILL BE NO NEW MOSS GROWTH UP TO A PERIOD OF 3 YEARS. IF SO THE AFFECTED AREA WILL BE TREATED AGAIN FREE OF CHARGE.</li>
        <li>ALL WATER TANKS MUST BE DISCONNECTED PRIOR TO COMMENCEMENT OF WORK BY THE CUSTOMER OR BY PRIOR ARRANGEMENT WITH THE TRADESPERSON.</li>
        <li>THE COMPANY RESERVES THE RIGHT TO CANCEL THIS CONTRACT DUE TO UNFORESEEN CIRCUMSTANCES.</li>
        <li>THE CONTRACT PRICE IS FIRM AND FULL PAYMENT IS DUE IMMEDIATELY ON COMPLETION. ALL PRODUCTS REMAIN THE PROPERTY OF MOSS ROOF TREATMENT UNTIL SUCH TIME AS THE PAYMENT IS MADE IN FULL AND FUNDS CLEARED.</li>
        <li>MOSS ROOF TREATMENT OR ITS REPRESENTATIVES RESERVES THE RIGHT TO ACTIVELY PURSUE COLLECTION OF OUTSTANDING AMOUNTS AND COSTS, IF ANY, AND WILL BE PASSED ONTO THE CUSTOMER.</li>
        <li>PART PAYMENTS MUST BE MET ON THE INVOICE DUE DATE(S) IN FULL OR LATE PAYMENT FEE WILL BE CHARGED.</li>
        <li>FOLLOWING COMPLETION OF WORK THE COMPANY DOES NOT ACCEPT RESPONSIBILITY FOR STORM DAMAGE.</li>
        <li>LIABILITY EXTENDS ONLY TO THE AREA OF THE ROOF TREATED BY THE COMPANY.</li>
        <li>THIS GUARANTEE DOES NOT EXTEND TO DAMAGE OR LOSS CAUSED OR SUFFERED AS A RESULT OF EXCEPTIONAL WEATHER CONDITIONS, FLOODS OR FIRE, EXTREME SUBSIDENCE OR MOVEMENT OR OTHER ACTS OF GOD.</li>
      </ol>
      </small>
      <table class="table">
        <tbody>
          <tr>
            <th width="40%">APPENDIX - NOTICE OF TERMINATION TO</th>
            <td></td>
          </tr>
        </tbody>
      </table>

      <p>TAKE NOTICE THAT I WISH TO TERMINATE THE AGREEMENT OR OFFER MADE BY ME WITH RESPECT TO THE ABOVEMENTIONED GOODS OR SERVICES AND REQUIRE YOU TO REPAY ALL MONIES PAID BY ME UNDER OR WITH RESPECT TO SUCH AGREEMENT AND TO DELIVER ALL GOODS OR OTHER PROPERTY GIVEN TO YOU BY ME PURSUANT TO SUCH AGREEMENT FORTHWITH.</p>
      <p>THIS WORK ORDER BECOMES A BINDING CONTRACT CANCELLATION OF CONTRACT BY MUTUAL AGREEMENT WILL INCUR UP TO 25% ADMINISTRATION AND RESTOCKING FEE.</p>

      <table class="table">
        <tbody>
          <tr>
            <th width="10%">DATE THIS</th>
            <td></td>
            <th width="10%">DAY OF</th>
            <td></td>
            <th width="10%">MONTH 20</th>
            <td></td>
          </tr>
        </tbody>
      </table>

    </div> {{-- page --}}

  </div>

</body>
</html>