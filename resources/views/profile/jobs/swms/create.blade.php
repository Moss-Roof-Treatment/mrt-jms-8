<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex">

  <title>Moss Roof Treatment - Safe Working Methods Statement</title>

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

    {{-- details --}}
    <div class="row" style="padding-top:5px; padding-bottom:10px;">
      <div class="col-xs-6">
        <h4 class="text-primary text-center"><b>Tradesperson:</b> <span class="text-danger">{{ $selected_swms->tradesperson->getFullNameAttribute() }}</span></h4>
      </div>
      <div class="col-xs-6">
        <h4 class="text-primary text-center"><b>Quote No:</b> <span class="text-danger">{{ $selected_swms->quote->quote_identifier }}</span></h4>
      </div>
    </div>
    {{-- details --}}

    {{-- body --}}
    @foreach ($all_swms_question_categories as $swms_question_category)
      <h3 class="text-secondary">{{ $swms_question_category->title }}</h3>
      @foreach ($swms_question_category->quote_questions as $swms_question)
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="customCheckSwms{{$swms_question->id}}" name="questions[]" value="{{$swms_question->id}}" @if (in_array($swms_question->id, $answers_array)) checked @endif>
          <label class="custom-control-label" for="customCheckSwms{{$swms_question->id}}">{{ $swms_question->question }}</label>
        </div> {{-- custom-control custom-checkbox --}}
      @endforeach
    @endforeach
    {{-- body --}}

  </div> {{-- page --}}

  {{-- PAGE ONE --}}

  </div>

</body>
</html>