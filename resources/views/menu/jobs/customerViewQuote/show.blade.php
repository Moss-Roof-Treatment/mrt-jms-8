@extends('layouts.app')

@section('title', '- View Selected Customer Quote View')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">CUSTOMER QUOTE VIEW</h3>
    <h5>View Selected Customer Quote View</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('jobs.show', $selected_quote->job_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Job
        </a>
      </div> {{-- col pb-3 --}}
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
        <form action="{{ route('job-view-customer-quote.create') }}" method="GET">
          <input type="hidden" name="quote_id" value="{{ $selected_quote->id }}">
          <button type="submit" class="btn btn-dark btn-block">
            <i class="fas fa-download mr-2" aria-hidden="true"></i>Download PDF
          </button>
        </form>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

  </div> {{-- container --}}
</section> {{-- section --}}

<section class="bg-dark">
  <div class="container py-5">

    {{-- page 1 --}}

    <div class="card">
      <div class="card-body py-5">

        {{-- letterhead --}}
        <img class="img-fluid" src="{{ asset('storage/images/letterheads/mrt-quotation-letterhead.jpg') }}" alt="Letterhead image">
        {{-- letterhead --}}

        <div class="row">
          <div class="col-sm-6">
            <h4 class="text-primary text-center py-2"><b>Customer No: <span class="text-danger">{{ $selected_quote->customer_id }}</span></b></h4>
          </div> {{-- col-sm-6 --}}
          <div class="col-sm-6">
            <h4 class="text-primary text-center py-2"><b>Quote No: <span class="text-danger">{{ $selected_quote->quote_identifier }}</span></b></h4>
          </div> {{-- col-sm-6 --}}
        </div> {{-- row --}}

        <div class="row">
          <div class="col-sm">

            <table class="table table-bordered table-fullwidth table-striped bg-white">
              <tbody>
                <tr>
                  <th>Business</th>
                  <td>
                    @if ($selected_quote->customer->business_name == null)
                      <span class="badge badge-light py-2 px-2">
                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                      </span>
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

          </div> {{-- col-sm --}}
          <div class="col-sm">

            <table class="table table-bordered table-fullwidth table-striped bg-white">
              <tbody>
                <tr>
                  <th>Email</th>
                  <td>{{ $selected_quote->customer->email }}</td>
                </tr>
                <tr>
                  <th>Phone</th>
                  <td>
                    @if ($selected_quote->customer->home_phone == null)
                      <span class="badge badge-light py-2 px-2">
                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                      </span>
                    @else
                      {{ $selected_quote->customer->home_phone }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Mobile</th>
                  <td>
                    @if ($selected_quote->customer->mobile_phone == null)
                      <span class="badge badge-light py-2 px-2">
                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                      </span>
                    @else
                      {{ $selected_quote->customer->mobile_phone }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Business</th>
                  <td>
                    @if ($selected_quote->customer->business_phone == null)
                      <span class="badge badge-light py-2 px-2">
                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                      </span>
                    @else
                      {{ $selected_quote->customer->business_phone }}
                    @endif
                  </td>
                </tr>
              </tbody>
            </table>

          </div> {{-- col-sm --}}
          <div class="col-sm">

            <table class="table table-bordered table-fullwidth table-striped bg-white">
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
                      <span class="badge badge-light py-2 px-2">
                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                      </span>
                    @else
                      {{ $selected_quote->customer->home_phone }}
                    @endif
                  </td>
                </tr>
              </tbody>
            </table>

          </div> {{-- col-sm --}}
        </div> {{-- row --}}

        <hr>

        <div class="row text-center">
          <div class="col-sm-3">
            @if ($selected_quote->job->inspection_type->title == null)
              <b>Inspection Type:</b> 
              <span class="badge badge-light py-2 px-2">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
              </span>
            @else
              <b>Inspection Type:</b> {{ $selected_quote->job->inspection_type->title }}
            @endif
          </div> {{-- col-sm-3 --}}
          <div class="col-sm-3">
            <b>Date Inspected:</b> {{ date('d/m/y', strtotime($selected_quote->created_at)) }}
          </div> {{-- col-sm-3 --}}
          <div class="col-sm-3">
            <b>Inspected By:</b> {{ $selected_quote->job->salesperson->first_name }}
          </div> {{-- col-sm-3 --}}
          <div class="col-sm-3">
            @if ($selected_quote->job->building_style_id == null)
              <b>Building Style:</b> <span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>To Be Confirmed</span>
            @else
              <b>Building Style:</b> {{ $selected_quote->job->building_style->title }}
            @endif
          </div> {{-- col-sm-3 --}}
        </div> {{-- row --}}

        <hr>

        <div class="row">
          <div class="col-sm-6">

            <h5 class="text-secondary py-2"><b>WORK LIST / JOB SPECIFICATIONS</b></h5>
            @if (!$all_quote_tasks->count())
              <p class="text-center">There are no tasks to display</p>
            @else
              @foreach ($all_quote_tasks as $quote_task)
                <div class="row">
                  <div class="col-sm-2">
                    @if ($quote_task->task->image_path == null)
                      <img class="img-fluid mx-auto d-block py-3" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                    @else
                      <img class="img-fluid mx-auto d-block py-3" src="{{ asset($quote_task->task->image_path) }}" alt="job_image">
                    @endif
                  </div> {{-- col-sm-2 --}}
                  <div class="col-sm-10">
                    <p class="mb-0"><b>{{ $quote_task->task->title  }}</b></p>
                    <p>{{ $quote_task->task->description }}</p>
                  </div> {{-- col-sm-10 --}}
                </div> {{-- row --}}
              @endforeach
            @endif

          </div> {{-- col-sm-6 --}}
          <div class="col-sm-6">

            <h5 class="text-secondary py-2"><b>JOB IMAGES</b></h5>
            @if (!$all_pdf_images->count())
              <p class="text-center">There are no images to display</p>
            @else
              @if ($all_pdf_images->count() == 1)
                <img class="img-fluid my-3" src="{{ asset($all_pdf_images->first()->image_path) }}" alt="job_image">
              @else
                <div class="row row-cols-2">
                  @foreach ($all_pdf_images as $image)
                    <div class="col my-3">
                      @if ($image->image_path == null)
                        <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                      @else
                        <img class="img-fluid" src="{{ asset($image->image_path) }}" alt="job_image">
                      @endif
                    </div> {{-- col --}}
                  @endforeach
                </div> {{-- row row-cols-2 --}}
              @endif
            @endif

            <h5 class="text-secondary py-2"><b>ADDITIONAL COMMENTS</b></h5>
            @if ($selected_quote->additional_comments == null)
              <p class="text-center">There are no additional comments</p>
            @else
              <p>{{ $selected_quote->additional_comments }}</p>
            @endif

            <h5 class="text-secondary py-2"><b>PROPERTIES TO VIEW</b></h5>
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

          </div> {{-- col-sm-6 --}}
        </div> {{-- row --}}

        <hr>

        <div class="row text-center">
          <div class="col-sm">
            @if ($selected_quote->job_type_id != null)
              <p><b>Quote For: </b>{{ $selected_quote->job_type->title }}</p>
            @else
              <p><b>Quote For: </b>To Be Confirmed</p>
            @endif
          </div> {{-- col-sm --}}
          <div class="col-sm">
            <p><b>Estimated Price: </b>{{ $selected_quote->getFormattedSubtotalWithoutGst() }}</p>
          </div> {{-- col-sm --}}
          <div class="col-sm">
            <p><b>GST: </b>{{ $selected_quote->getFormattedSubtotalGst() }}</p>
          </div> {{-- col-sm --}}
          <div class="col-sm">
            <p><b>Total: </b>{{ $selected_quote->getFormattedQuoteTotal() }}<br>
              @if ($selected_quote->discount > 0)
                (Discounted)
              @endif
            </p>
          </div> {{-- col-sm --}}
        </div> {{-- row --}}

        <hr>

        {{-- footer --}}
        <img class="img-fluid" src="{{ asset('storage/images/letterheads/mrt-letter-footer.jpg') }}" alt="">
        {{-- footer --}}

      </div> {{-- card-body --}}
    </div> {{-- card --}}

    {{-- page 1 --}}

    {{-- page 2 --}}

    <div class="card mt-5 py-5">
      <div class="card-body">

        {{-- quote detail tables --}}

        <div class="row">
          <div class="col-sm-6">

            <table class="table table-bordered table-fullwidth table-striped bg-white">
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
                      <span class="badge badge-light py-2 px-2">
                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                      </span>
                    @else
                      {{ $selected_quote->customer->home_phone }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Mobile</th>
                  <td>
                    @if ($selected_quote->customer->mobile_phone == null)
                      <span class="badge badge-light py-2 px-2">
                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                      </span>
                    @else
                      {{ $selected_quote->customer->mobile_phone }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Start Date</th>
                  <td>
                    @if ($selected_quote->job->start_date == null)
                      <span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>To Be Confirmed</span>
                    @else
                      {{ date('d/m/y - h:iA', strtotime($selected_quote->job->start_date)) }}
                    @endif
                  </td>
                </tr>
              </tbody>
            </table>

          </div> {{-- col-sm-6 --}}
          <div class="col-sm-6">

            <p class="text-primary"><b>Upon acceptance, the following is required:</b></p>
            <table class="table table-bordered table-fullwidth table-striped bg-white">
              <tbody>
                <tr>
                  <th width="45%">25% Deposit Required</th>
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
          </div> {{-- col-sm-6 --}}
        </div> {{-- row --}}

        {{-- quote detail tables --}}

        <hr>

        {{-- legal terms list --}}
        <h4 class="text-center"><b>GUARANTEE</b></h4>
        <p>MOSS ROOF TREATMENT HEREBY GUARANTEES THAT THE WORK COMPLETED SHALL PERFORM THE FUNCTIONS HEREIN FOR A PERIOD OF 3 YEARS.</p>
        <p>THAT NO NEW MOSS SHALL GROW WITHIN THE STATED PERIOD OF TIME TO THE TREATED AREAS.</p>
        <p>IN THE EVENT OF FAILURE OF THE ABOVE MENTIONED ASPECTS OF THE PRODUCT THE COMPANY SHALL: - RESPRAY THE AFFECTED AREA TOTALLY FREE OF CHARGE</p>
        <br>
        <h4 class="text-center"><b>TERMS AND CONDITIONS</b></h4>
        <p>NOTE: THE BENEFITS CONFERRED BY THIS WARRANTY AND GUARANTEE ARE IN ADDITION TO ALL OTHER RIGHTS WHICH THE CLIENT IS ENTITLED TO UNDER THE TRADE PRACTICE ACT AND ANY OTHER LAW OF THE RELEVANT STATE OR TERRITORY.</p>
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
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <tbody>
            <tr>
              <th width="30%">APPENDIX - NOTICE OF TERMINATION TO</th>
              <td class="bg-white"></td>
            </tr>
          </tbody>
        </table>
        <p>TAKE NOTICE THAT I WISH TO TERMINATE THE AGREEMENT OR OFFER MADE BY ME WITH RESPECT TO THE ABOVEMENTIONED GOODS OR SERVICES AND REQUIRE YOU TO REPAY ALL MONIES PAID BY ME UNDER OR WITH RESPECT TO SUCH AGREEMENT AND TO DELIVER ALL GOODS OR OTHER PROPERTY GIVEN TO YOU BY ME PURSUANT TO SUCH AGREEMENT FORTHWITH.</p>
        <p>THIS WORK ORDER BECOMES A BINDING CONTRACT CANCELLATION OF CONTRACT BY MUTUAL AGREEMENT WILL INCUR UP TO 25% ADMINISTRATION AND RESTOCKING FEE.</p>
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <tbody>
            <tr>
              <th width="10%">DATE THIS</th>
              <td class="bg-white"></td>
              <th width="10%">DAY OF</th>
              <td class="bg-white"></td>
              <th width="10%">MONTH 20</th>
              <td class="bg-white"></td>
            </tr>
          </tbody>
        </table>
        {{-- legal terms list --}}

        {{-- footer --}}
        <img class="img-fluid" src="{{ asset('storage/images/letterheads/mrt-letter-footer.jpg') }}" alt="">
        {{-- footer --}}

      </div> {{-- card-body --}}
    </div> {{-- card --}}

    {{-- page 2 --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection