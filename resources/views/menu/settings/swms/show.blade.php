@extends('layouts.app')

@section('title', '- Jobs - View Selected Job')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SWMS</h3>
    <h5>View Selected SWMS</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('swms-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>SWMS Menu 
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a href="{{ route('quotes.show', $selected_swms->quote_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-file-invoice mr-2" aria-hidden="true"></i>View Quote
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a href="{{ route('tradespersons.show', $selected_swms->tradesperson_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-user mr-2" aria-hidden="true"></i>View Tradesperson
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a href="{{ route('swms-settings.create') }}" class="btn btn-dark btn-block">
          <i class="fas fa-download mr-2" aria-hidden="true"></i>Download PDF
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

  </div> {{-- container --}}
</section> {{-- section --}}

<section class="bg-dark">
  <div class="container py-5">

    {{-- swms form --}}
    @if (!$all_swms_questions->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are currently no SWMS questions to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
    <div class="card">
      <div class="card-body">

        {{-- letterhead --}}
        <img class="img-fluid my-3" src="{{ asset('storage/images/letterheads/mrt-letterhead.jpg') }}" alt="">
        {{-- letterhead --}}

        {{-- details --}}
        <div class="row">
          <div class="col-6">
            <h4 class="text-primary text-center"><b>Tradesperson:</b> <span class="text-danger">{{ $selected_swms->tradesperson->getFullNameAttribute() }}</span></h4>
          </div>
          <div class="col-6">
            <h4 class="text-primary text-center"><b>Quote No:</b> <span class="text-danger">{{ $selected_swms->quote->quote_identifier }}</span></h4>
          </div>
        </div>
        {{-- details --}}

        @foreach ($all_swms_question_categories as $swms_question_category)
          <h3 class="text-secondary my-3">{{ $swms_question_category->title }}</h3>
          <div class="container">
            <div class="row row-cols-1 row-cols-sm-2">
              @foreach ($swms_question_category->quote_questions as $swms_question)
                <div class="col">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheckSwms{{$swms_question->id}}" name="questions[]" value="{{$swms_question->id}}" @if (in_array($swms_question->id, $answers_array)) checked @endif disabled>
                    <label class="custom-control-label" for="customCheckSwms{{$swms_question->id}}">{{ $swms_question->question }}</label>
                  </div> {{-- custom-control custom-checkbox --}}
                </div> {{-- col --}}
              @endforeach
            </div> {{-- row row-cols-3 --}}
          </div> {{-- container --}}
        @endforeach

        {{-- footer --}}
        <img class="img-fluid my-3" src="{{ asset('storage/images/letterheads/mrt-letter-footer.jpg') }}" alt="">
        {{-- footer --}}

      </div> {{-- card-body --}}
    </div> {{-- card --}}
    @endif
    {{-- swms form --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection