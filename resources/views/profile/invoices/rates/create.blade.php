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
        <h4 class="text-primary text-center"><b>Name:</b> <span class="text-danger">{{ $selected_user->getFullNameAttribute() }}</span></h4>
      </div>
      <div class="col-xs-6">
        <h4 class="text-primary text-center"><b>Job No:</b> <span class="text-danger">{{ $selected_quote->quote_identifier }}</span></h4>
      </div>
    </div>

    {{-- quote and customer id --}}

    {{-- detail tables --}}
    <h5 class="text-primary"><b>Job Rates</b></h5>
    @if (!$selected_rate_users->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>You do not have the rates that have been selected for you in the quote. Please contact the office to have the required quote rates added to your user account.</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <table class="table table-bordered table-striped">
        <thead class="table-secondary">
          <tr>
            <th>Title</th>
            <th width="30%">Procedure</th>
            <th width="30%">Description</th>
            <th>Rate</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            @foreach ($selected_rate_users as $user_rate)
              <tr>
                <td>{{ $user_rate->rate->title }}</td>
                <td>{{ $user_rate->rate->procedure }}</td>
                <td>{{ $user_rate->rate->description }}</td>
                <td>${{ number_format(($user_rate->price / 100), 2, '.', ',') }}</td>
              </tr>
            @endforeach
          </tr>
        </tbody>
      </table>
    @endif
    {{-- detail tables --}}

  </div> {{-- page --}}

  {{-- PAGE ONE --}}
  </div>

</body>
</html>