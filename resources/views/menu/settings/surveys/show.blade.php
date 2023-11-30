@extends('layouts.app')

@section('title', '- Survey Testimonials - View All Survey')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SURVEY TESTIMONIALS</h3>
    <h5>View Selected Survey</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('survey-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Surveys Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('survey-settings.edit', $selected_survey->id) }}">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-6">

        <p class="text-primary my-3"><b>Survey Image</b></p>

        @if ($selected_survey->quote->job->job_images->where('job_image_type_id', 7)->first() == null)
          <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="">
        @else
          <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset($selected_survey->quote->job->job_images->where('job_image_type_id', 7)->first()->image_path) }}" alt="">
        @endif

      </div> {{-- col-sm-6 --}}
      <div class="col-sm-6">

        <p class="text-primary my-3"><b>Survey Details</b></p>

        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <tbody>
            <tr>
              <th>Survey ID</th>
              <td>{{ $selected_survey->id }}</td>
            </tr>
            <tr>
              <th>Job ID</th>
              <td>
                <a href="{{ route('jobs.show', $selected_survey->quote->job_id) }}">{{ $selected_survey->quote->job_id }}</a>
              </td>
            </tr>
            <tr>
              <th>Quote ID</th>
              <td>
                <a href="{{ route('quotes.show', $selected_survey->quote->id) }}">{{ $selected_survey->quote->id }}</a>
              </td>
            </tr>
            <tr>
              <th>Customer</th>
              <td>{{ $selected_survey->quote->customer->getFullNameAttribute() }}</td>
            </tr>
            <tr>
              <th>Job Address</th>
              <td>{{ $selected_survey->quote->job->tenant_street_address . ', ' . $selected_survey->quote->job->tenant_suburb . ' ' . $selected_survey->quote->job->tenant_postcode }}</td>
            </tr>
            <tr>
              <th>Visibility</th>
              <td>
                @if ($selected_survey->survey_testimonial->is_visible == 0)
                  <span class="badge badge-danger py-2 px-2">
                    <i class="fas fa-times mr-2" aria-hidden="true"></i>Not visible
                  </span>
                @else
                <spna class="tag is-success">
                  <i class="fas fa-check mr-2" aria-hidden="true"></i>Is Visible
                </spna>
                @endif
              </td>
            </tr>
          </tbody>
        </table>

      </div> {{-- col-sm-6 --}}
    </div>

    {{-- Testimonial --}}
    <p class="text-primary my-3"><b>Survey Testimonial</b></p>
    <div class="card">
      <div class="card-body">
        {{ $selected_survey->survey_testimonial->text }}
      </div> {{-- card-body --}}
    </div> {{-- card --}}
    {{-- Testimonial --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection