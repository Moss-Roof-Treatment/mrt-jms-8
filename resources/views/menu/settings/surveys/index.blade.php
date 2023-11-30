@extends('layouts.app')

@section('title', '- Survey Testimonials - View All Surveys Testimonials')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SURVEY TESTIMONIALS</h3>
    <h5>View All Survey Testimonials</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <p class="text-primary my-3"><b>All Surveys Testimonials</b></p>

    @if (!$all_surveys->count())
      <div class="card">
        <div class="card-body text-center">
          <h5>There are surveys to display for this system.</h5>
        </div>
      </div>
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Customer</th>
              <th>Job Address</th>
              <th width="40%">Testimonial</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_surveys as $selected_survey)
              <tr>
                <td>
                  <a href="{{ route('survey-settings.show', $selected_survey->id) }}">
                    {{ $selected_survey->id }}
                  </a>
                </td>
                <td>{{ $selected_survey->quote->customer->getFullNameAttribute() }}</td>
                <td>{{ $selected_survey->quote->job->tenant_street_address . ', ' . $selected_survey->quote->job->tenant_suburb . ' ' . $selected_survey->quote->job->tenant_postcode }}</td>
                <td>
                  {{ substr($selected_survey->survey_testimonial->text, 0, 80) }}
                  {{ strlen($selected_survey->survey_testimonial->text) > 80 ? "..." : "" }}
                </td>
                <td class="text-center">
                  <a href="{{ route('survey-settings.show', $selected_survey->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                </td>
              </tr> 
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif

    {{ $all_surveys->links() }}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection