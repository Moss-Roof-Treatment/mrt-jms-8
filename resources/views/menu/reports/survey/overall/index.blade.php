@extends('layouts.app')

@section('title', '- Reports - View Overall Survey Results')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">REPORTS</h3>
    <h5>View Overall Survey Results</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('reports.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Reports Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-3">
        @include('partials.reportMenu')
      </div> {{-- col-sm-3 --}}
      <div class="col-sm-9">

        <h5 class="text-primary my-3"><b>Tradesperson Search</b></h5>

        <form action="{{ route('survey-overall-report.show') }}" method="POST">
          @csrf

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group row">
                <div class="col">
                  <select name="tradesperson" class="custom-select @error('tradesperson') is-invalid @enderror mb-2">
                    <option selected disabled>Please select a tradesperson</option>
                    @foreach ($all_tradespersons as $tradesperson)
                      <option value="{{ $tradesperson->id }}">
                        {{ $tradesperson->getFullNameAttribute() }}
                      </option>
                    @endforeach
                  </select>
                  @error('tradesperson')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> {{-- col --}}
              </div> {{-- form-group row --}}
            </div> {{-- col-sm-6 --}}
            <div class="col-sm-3">
              <button class="btn btn-primary btn-block">
                <i class="fas fa-bullseye mr-2" aria-hidden="true"></i>Select
              </button>
            </div> {{-- col-sm-3 --}}
            <div class="col-sm-3">
              <a href="{{ route('survey-overall-report.index') }}" class="btn btn-dark btn-block">
                <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
              </a>
            </div> {{-- col-sm-3 --}}
          </div> {{-- row --}}

        </form>

        <h5 class="text-primary my-3"><b>All Tradesperson Results</b></h5>
        <div class="card">
          <div class="card-body">
            @if ($all_surveys_count == 0)
              <p class="text-center">Please fill out the search form to have the results displayed here</p>
            @else
              <h4 class="text-primary text-center mb-4">Total Surveys: {{ $all_surveys_count }}</h4>
              @foreach ($all_questions as $question)
                <div class="row">
                  <div class="col-sm-6">
                    <p><b>Q{{ $question->id }}: {{ $question->question }}</p></b>
                  </div> {{-- col-sm-6 --}}
                  <div class="col-sm-6">
                    <div class="progress my-1">
                      <div class="progress-bar" role="progressbar" style="width: {{ round($question->answers->avg('answer') * 20) . '%' }}" aria-valuenow="{{ round($question->answers->avg('answer'), 2) * 20 }}" aria-valuemin="0" aria-valuemax="100">{{ round($question->answers->avg('answer') * 20) . '%' }}</div>
                    </div> {{-- row --}}
                  </div> {{-- col-sm-6 --}}
                </div> {{-- row --}}
              @endforeach
            @endif
          </div> {{-- card-body --}}
        </div> {{-- card --}}
      </div> {{-- col-sm-9 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection