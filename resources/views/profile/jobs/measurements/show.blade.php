@extends('layouts.profile')

@section('title', '- User Jobs - View Selected Measurement Report')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">JOB MEASUREMENTS</h3>
    <h5>View Selected Job Measurements</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('profile-jobs.show', $selected_quote->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Selected Job
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('profile-job-measurements.create', ['selected_quote_id' => $selected_quote->id]) }}" class="btn btn-dark btn-block">
          <i class="fas fa-download mr-2" aria-hidden="true"></i>Download PDF
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

  </div> {{-- container --}}
</section> {{-- section --}}

<section class="bg-dark">
  <div class="container py-5">

    {{-- PAGE ONE --}}

    <div class="card">
      <div class="card-body">

        <img class="img-fluid" src="{{ asset('storage/images/letterheads/mrt-letterhead.jpg') }}" alt="">

        <div class="row">
          <div class="col-sm-6">
            <h4 class="text-primary text-center py-2"><b>Customer No: <span class="text-danger">{{ $selected_quote->customer_id }}</span></b></h4>
          </div> {{-- col-sm-6 --}}
          <div class="col-sm-6">
            <h4 class="text-primary text-center py-2"><b>Quote No: <span class="text-danger">{{ $selected_quote->quote_identifier }}</span></b></h4>
          </div> {{-- col-sm-6 --}}
        </div> {{-- row --}}

        {{-- CONTACT INFORMATION --}}

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
                  <th></th>
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
                  <th></th>
                  <td>{{ $selected_quote->job->tenant_suburb . ', ' . $selected_quote->job->tenant_postcode }}</td>
                </tr>
              </tbody>
            </table>
          </div> {{-- col-sm-4 --}}
          <div class="col-sm-4">
            <table class="table table-bordered table-fullwidth table-striped bg-white">
              <tbody>
                <tr>
                  <th>Phone</th>
                  <td>{{ $selected_quote->customer->home_phone }}</td>
                </tr>
                <tr>
                  <th>Mobile</th>
                  <td>{{ $selected_quote->customer->mobile_phone }}</td>
                </tr>
                <tr>
                  <th>Business</th>
                  <td>{{ $selected_quote->customer->business_contact_phone }}</td>
                </tr>
              </tbody>
            </table>
          </div> {{-- col-sm-4 --}}
        </div>

        {{-- CONTACT INFORMATION --}}

        <hr>

        {{-- INSPECTION INFORMATION --}}

        <div class="row text-center">
          <div class="col-sm-3">
            @if ($selected_quote->job->inspection_type->title == null)
              <b>Inspection Type:</b> 
              <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
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

        {{-- INSPECTION INFORMATION --}}

        <hr>

        {{-- BODY --}}

        <div class="row">
          <div class="col-sm-6">

            {{-- TASKS --}}

            <h5 class="text-secondary py-2"><b>WORK LIST / JOB SPECIFICATIONS</b></h5>

            @if (!$selected_quote->quote_tasks->count())
              <p class="text-center">There are no tasks to display</p>
            @else
              @foreach ($selected_quote->quote_tasks as $quote_task)
                <div class="row">
                  <div class="col-sm-2">

                    @if ($quote_task->task->image_path == null)
                      <img class="img-fluid mx-auto d-block py-3" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                    @else
                      <img class="img-fluid mx-auto d-block py-3" src="{{ asset($quote_task->task->image_path) }}" alt="job_image">
                    @endif

                  </div> {{-- col-sm --}}
                  <div class="col-sm-10">

                    <p class="mb-0"><b>{{ $quote_task->task->title  }}</b></p>
                    <p>{{ $quote_task->task->procedure }}</p>

                  </div> {{-- col-sm --}}
                </div> {{-- row --}}
              @endforeach
            @endif

            {{-- TASKS --}}

          </div> {{-- col-sm-6 --}}
          <div class="col-sm-6">

            {{-- IMAGES --}}
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
            {{-- IMAGES --}}

            {{-- ADDITIONAL COMMENTS --}}

            <h5 class="text-secondary py-2"><b>ADDITIONAL COMMENTS</b></h5>
            @if ($selected_quote->additional_comments == null)
              <p class="text-center">There are no additional comments</p>
            @else
              <p>{{ $selected_quote->additional_comments }}</p>
            @endif

            {{-- ADDITIONAL COMMENTS --}}

          </div> {{-- col-sm-6 --}}
        </div> {{-- row --}}

        {{-- BODY --}}

        {{-- footer --}}
        <img class="img-fluid" src="{{ asset('storage/images/letterheads/mrt-letter-footer.jpg') }}" alt="">
        {{-- footer --}}

      </div> {{-- card-body --}}
    </div> {{-- card --}}

    {{-- PAGE ONE --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection