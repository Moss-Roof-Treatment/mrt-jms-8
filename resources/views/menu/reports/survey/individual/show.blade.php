@extends('layouts.app')

@section('title', '- Reports - View Survey Overall Results')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">REPORTS</h3>
    <h5>View Individual Survey Results</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('reports.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Reports Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('reports.index') }}">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Job
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-3">
        @include('partials.reportMenu')
      </div> {{-- col-sm-3 --}}
      <div class="col-sm-9">

        <h5 class="text-primary my-3"><b>Job Search</b></h5>
        <form action="{{ route('survey-individual-report.show') }}" method="POST">
          @csrf

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group row">
                <div class="col">
                  <select name="job" class="custom-select @error('job') is-invalid @enderror mb-2">
                    <option selected disabled>Please select a job</option>
                      @if ($selected_survey == null)
                        <option selected disabled>Please select a job</option>
                      @else
                        <option selected value="{{ $selected_survey->id }}">{{ $selected_survey->quote->quote_identifier . ' - ' . $selected_survey->user->getFullNameAttribute()  . ' - ' . $selected_survey->quote->job->tenant_street_address . ', ' . $selected_survey->quote->job->tenant_suburb }}</option>
                        <option disabled>Please select a job</option>
                      @endif
                      @foreach ($all_surveys as $survey)
                        <option value="{{ $survey->id }}" @if ($survey->id == $selected_survey->id) hidden @endif>
                          {{ $survey->quote->quote_identifier . ' - ' . $survey->user->getFullNameAttribute() . ' - ' . $survey->quote->job->tenant_street_address . ', ' . $survey->quote->job->tenant_suburb }}
                        </option>
                      @endforeach
                  </select>
                  @error('job')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> {{-- col --}}
              </div> {{-- form-group row --}} 
            </div> {{-- col-sm-6 --}}
            <div class="col-sm-3">
              <div class="form-group row">
                <div class="col">
                  <button class="btn btn-primary btn-block">
                    <i class="fas fa-bullseye mr-2" aria-hidden="true"></i>Select
                  </button>
                </div> {{-- col --}}
              </div> {{-- form-group row --}}
            </div> {{-- col-sm-3 --}}
            <div class="col-sm-3">
              <div class="form-group row">
                <div class="col">
                  <a href="{{ route('survey-individual-report.index') }}" class="btn btn-dark btn-block">
                    <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                  </a>
                </div> {{-- col --}}
              </div> {{-- form-group row --}}
            </div> {{-- col-sm-3 --}}
          </div> {{-- row --}}

        </form>

        <h5 class="text-primary my-3"><b>Survey Results</b></h5>
        <div class="card">
          <div class="card-body">
            @if (!$survey_answers->count())
              <p>There is currently no survey results to display for this job.</p>
            @else
              @foreach ($survey_answers as $survey_answer)
                <div class="row">
                  <div class="col-sm-6">
                    <p><b>Q{{ $survey_answer->survey_question->id }}: {{ $survey_answer->survey_question->question }}</p></b>
                  </div> {{-- col-sm-6 --}}
                  <div class="col-sm-6">
                    <div class="progress my-1">
                      <div class="progress-bar" role="progressbar" style="width: {{ $survey_answer->answer * 20 . '%' }}" aria-valuenow="{{ $survey_answer->answer * 20 }}" aria-valuemin="0" aria-valuemax="100">{{ $survey_answer->answer * 20 . '%' }}</div>
                    </div>
                  </div> {{-- col-sm-6 --}}
                </div> {{-- row --}}
              @endforeach
            @endif
          </div> {{-- card-body --}}
        </div> {{-- card --}}

        <h5 class="text-primary my-3"><b>Survey Testimonial</b></h5>
        <div class="card">
          <div class="card-body">
            @if ($selected_survey->survey_testimonial == null )
              <p class="text-center">The testimonial has not been entered</p>
            @else
              {{ $selected_survey->survey_testimonial->text }}
            @endif
          </div> {{-- card-body --}}
        </div> {{-- card --}}

      </div> {{-- col-sm-9 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection