@extends('layouts.jquery')

@section('title', '- View Selected Contractor Job Report')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">CONTRACTOR JOB REPORT</h3>
    <h5>View Selected Contractor Job Report</h5>
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
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

  </div> {{-- container --}}
</section> {{-- section --}}

<section class="bg-dark">
  <div class="container py-5">

    {{-- START OF QUOTE VIEW --}}

    <div class="card">
      <div class="card-body py-5">

        <div class="row">
          <div class="col-sm-6 offset-sm-6">
            <h4 class="title is-size-3 text-primary text-center">
              @if ($selected_quote->job->start_date == null)
                <b>Approx Start:</b> <span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>To Be Confirmed</span>
              @else
                <b>Approx Start: {{ date('d/m/y - h:iA', strtotime($selected_quote->job->start_date)) }}</b>
              @endif
            </h4>
          </div> {{-- col-sm-6 offset-sm-6 --}}
        </div> {{-- row --}}

        {{-- letterhead --}}
        <img class="img-fluid" src="{{ asset('storage/images/letterheads/mrt-contractor-job-report-letterhead.jpg') }}" alt="">
        {{-- letterhead --}}

        <div class="row">
          <div class="col-sm-6">
            <h4 class="text-primary text-center py-2"><b>Customer No: <span class="text-danger">{{ $selected_quote->customer_id }}</span></b></h4>
          </div> {{-- col-sm-6 --}}
          <div class="col-sm-6">
            <h4 class="text-primary text-center py-2"><b>Quote No: <span class="text-danger">{{ $selected_quote->quote_identifier }}</span></b></h4>
          </div> {{-- col-sm-6 --}}
        </div> {{-- row --}}

        {{-- INFORMATION TABLES --}}

        <div class="row">
          <div class="col-sm-4">

            <table class="table table-bordered table-fullwidth table-striped bg-white">
              <tbody>
                <tr>
                  <th>Owner</th>
                  <td>{{ $selected_quote->customer->getFullNameAttribute() }}</td>
                </tr>
                <tr>
                  <th>Address</th>
                  <td>{{ $selected_quote->customer->street_address }}</td>
                </tr>
                <tr>
                  <th>Suburb</th>
                  <td>{{ $selected_quote->customer->suburb . ', ' . $selected_quote->customer->postcode }}</td>
                </tr>
                <tr>
                  <th>Email</th>
                  <td>{{ $selected_quote->customer->email }}</td>
                </tr>
              </tbody>
            </table>

          </div> {{-- col-sm-4 --}}
          <div class="col-sm-4">

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
              </tbody>
            </table>

          </div> {{-- col-sm-4 --}}
          <div class="col-sm-4">

            <table class="table table-bordered table-fullwidth table-striped bg-white">
              <tbody>
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

          </div> {{-- col-sm-4 --}}
        </div> {{-- row --}}

        {{-- INFORMATION TABLES --}}

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
            <b>Date Inspected:</b> {{ date('d M Y', strtotime($selected_quote->created_at)) }}
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

                    <p class="mb-0"><b>{{ $quote_task->task->title . ' - ' . $quote_task->task->task_type->title  }}</b></p>
                    <p class="subtitle is-size-5">{{ $quote_task->task->procedure }}</p>

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
              @foreach ($all_pdf_images->chunk(2) as $pdf_images_chunk)
                <div class="row">
                  @foreach ($pdf_images_chunk as $image)
                    <div class="col-sm-6 my-3">
                      @if ($image->image_path == null)
                        <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                      @else
                        <img class="img-fluid" src="{{ asset($image->image_path) }}" alt="job_image">
                      @endif
                    </div>
                  @endforeach
                </div>
              @endforeach
            @endif

            <h5 class="text-secondary py-2"><b>ADDITIONAL COMMENTS</b></h5>
            @if ($selected_quote->additional_comments == null)
              <p class="text-center">There are no additional comments</p>
            @else
              <p>{{ $selected_quote->additional_comments }}</p>
            @endif

          </div> {{-- col-sm-6 --}}
        </div> {{-- row --}}

        {{-- footer --}}
        <img class="img-fluid" src="{{ asset('storage/images/letterheads/mrt-letter-footer.jpg') }}" alt="">
        {{-- footer --}}

      </div> {{-- card-body --}}
    </div> {{-- card --}}

    {{-- PAGE TWO --}}

    <div class="card mt-5 py-5">
      <div class="card-body">

        {{-- SECTION ONE --}}

        <div class="row">
          <div class="col-sm-6">

            <h5 class="text-secondary py-2"><b>SAFE WORK METHOD STATEMENT:</b></h5>

            <p class="subtitle is-size-4">The SWMS is a site-specific statement that must be prepared before any high-risk work is commenced.</p>

          </div> {{-- col-sm-6 --}}
          <div class="col-sm-6">

            <table class="table table-bordered table-fullwidth table-striped bg-white">
              <tbody>
                <tr>
                  <th>Business Name:</th>
                </tr>
                <tr>
                  <th>ABN:</th>
                </tr>
                <tr>
                  <th>Tradesperson:</th>
                </tr>
              </tbody>
            </table>

          </div> {{-- col-sm-6 --}}
        </div> {{-- row --}}

        {{-- SECTION ONE --}}

        {{-- SECTION TWO --}}

        <h5 class="text-secondary py-2"><b>TOOL BOX CHECK LIST: PLEASE INDICATE ALL ON PHOTO</b></h5>

        <div class="row">
          <div class="col-sm-6">

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Location of anchor points if required 
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Location of ladder
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                No go zones identified
              </label>
            </div>

          </div> {{-- col-sm-6 --}}
          <div class="col-sm-6">

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Ladder secured top & bottom
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Working above 2m, fall protection must be used
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Secure work area with sign indicating roofer on-site
              </label>
            </div>

          </div> {{-- col-sm-6 --}}
        </div> {{-- row --}}

        {{-- SECTION TWO --}}

        {{-- SECTION THREE --}}

        <div class="row">
          <div class="col-sm-6">

            <h5 class="text-secondary py-2"><b>WHAT ARE THE HAZARDS AND RISKS</b></h5>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Working above 2m in height
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Working from ladders
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Loose hoses
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Pets in the backyard
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Spray coming off the roof
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Contact with product
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                UV Rays
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Electrical hazards
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Moving spray unit
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Filling motorized machine with petrol when hot
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Working in adverse weather
              </label>
            </div>

            <h5 class="text-secondary py-2"><b>ACTIVITIES TO BE CARRIED OUT</b></h5>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Application of Moss Roof Treatment
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Disconnection of water tanks
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Securing work site
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Measuring product from one container to spray unit
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Measuring product from one container to spray unit
              </label>
            </div>

          </div> {{-- col-sm-6 --}}
          <div class="col-sm-6">

            <h5 class="text-secondary py-2"><b>RISK CONTROL MEASURES</b></h5>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Applying & using correct fall protection, including fall-arrest devices
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Three point ladder contact
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Secure hoses with ties
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Pets to be separated from tradesmen when on site
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                No go zones for foot traffic
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Goggles & long sleeves to be worn, correct spraying distance
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Safety switch on electrical equipment. Set up away from wires
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Locate trailer in position so spray unit can easily be loaded
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Fill machine once it has cooled
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Check weather conditions regularly
              </label>
            </div>

            <div class="field">
              <label class="checkbox">
                <input type="checkbox">
                Call 000 in an emergency
              </label>
            </div>

            <h5 class="text-secondary py-2"><b>Sign & date as the person responsible for implementing on-site risk control methods:</b></h5>

            <table class="table table-bordered table-fullwidth table-striped bg-white">
              <tbody>
                <tr>
                  <th>Print Name:</th>
                </tr>
                <tr>
                  <th>Signature:</th>
                </tr>
                <tr>
                  <th>Date:</th>
                </tr>
              </tbody>
            </table>

          </div> {{-- col-sm-6 --}}
        </div> {{-- row --}}

        {{-- SECTION THREE --}}

        {{-- footer --}}
        <img class="img-fluid" src="{{ asset('storage/images/letterheads/mrt-letter-footer.jpg') }}" alt="">
        {{-- footer --}}

      </div> {{-- card-body --}}
    </div> {{-- card --}}

    {{-- PAGE TWO --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection