<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex">

  <title>Moss Roof Treatment - Job Measurements</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <style>

    .text-primary
    {
      color:#0712a6;
    }

    .text-secondary
    {
      color:#db5800;
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

    <img style="width:100%;" src="{{ public_path('storage/images/letterheads/mrt-letterhead.jpg') }}" alt="">

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

        <table class="table table-bordered table-striped">
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

      </div> {{-- col-xs-4 --}}
      <div class="col-xs-4">

        <table class="table table-bordered table-striped">
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

      </div> {{-- col-xs-4 --}}
      <div class="col-xs-4">

        <table class="table table-bordered table-striped">
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

      </div> {{-- col-xs-4 --}}
    </div> {{-- row --}}

    {{-- detail tables --}}

    {{-- level --}}

    <div class="row text-center">
      <div class="col-xs-3">
        @if ($selected_quote->job->inspection_type->title == null)
          <small><b>Inspection Type:</b> Not Applicable</small>
        @else
          <small><b>Inspection Type:</b> {{ $selected_quote->job->inspection_type->title }}</small>
        @endif
      </div> {{-- col-xs-3 --}}
      <div class="col-xs-3">
        <small><b>Date Inspected:</b> {{ date('d M Y', strtotime($selected_quote->created_at)) }}</small>
      </div> {{-- col-xs-3 --}}
      <div class="col-xs-3">
        <b>Inspected By:</b> {{ $selected_quote->job->salesperson->first_name }}
      </div> {{-- col-xs-3 --}}
      <div class="col-xs-3">
        @if ($selected_quote->job->building_style_id == null)
          <small><b>Building Style:</b> To Be Confirmed</small>
        @else
          <small><b>Building Style:</b> {{ $selected_quote->job->building_style->title }}</small>
        @endif
      </div> {{-- col-xs-3 --}}
    </div> {{-- row --}}

    {{-- level --}}

    <hr>

    {{-- body --}}

    <div class="row">
      <div class="col-xs-6">

        <h5 class="text-secondary"><b>WORK LIST / JOB SPECIFICATIONS</b></h5>

        @if (!$selected_quote->quote_tasks->count())
          <p>There are no tasks to display</p>
        @else
          @foreach ($selected_quote->quote_tasks as $quote_task)
            <div class="row" style="margin-bottom:20px">
              <div class="col-xs-2">

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
                  {{ $quote_task->task->procedure }}
                </p>

              </div> {{-- col-xs-10 --}}
            </div> {{-- row --}}
          @endforeach
        @endif

      </div> {{-- col-xs-6 --}}
      <div class="col-xs-6">

        <h5 class="text-secondary"><b>JOB IMAGES</b></h5>

        @if (!$all_pdf_images->count())
          <p>There are no images to display</p>
        @else
          @foreach ($all_pdf_images->chunk(2) as $pdf_images_chunk)
            <div class="row" style="padding-bottom:10px;">
              @foreach ($pdf_images_chunk as $image)
                <div class="col-xs-6">
                  @if ($image->image_path == null)
                    <img class="img-responsive" src="{{ public_path('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                  @else
                    <img class="img-responsive" src="{{ public_path($image->image_path) }}" alt="job_image">
                  @endif
                </div>
              @endforeach
            </div>
          @endforeach
        @endif

        <h5 class="text-secondary"><b>ADDITIONAL COMMENTS</b></h5>
        <p>
          @if ($selected_quote->additional_comments == null)
            There are no additional comments
          @else
            {{ $selected_quote->additional_comments }}
          @endif
        </p>

      </div> {{-- col-xs-6 --}}
    </div> {{-- row --}}

    {{-- body --}}

  </div> {{-- page --}}

  {{-- PAGE ONE --}}

  </div>

</body>
</html>