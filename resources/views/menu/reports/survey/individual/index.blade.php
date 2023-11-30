@extends('layouts.app')

@section('title', '- Reports - View Individual Survey Results')

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
                    @foreach ($all_surveys as $survey)
                      <option value="{{ $survey->id }}">
                        {{ $survey->quote->quote_identifier . ' - ' . $survey->user->getFullNameAttribute()  . ' - ' . $survey->quote->job->tenant_street_address . ', ' . $survey->quote->job->tenant_suburb }}
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
          <div class="card-body text-center">
            Please fill out the search form to have the results displayed here
          </div> {{-- card-body --}}
        </div> {{-- card --}}

      </div> {{-- col-sm-9 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection