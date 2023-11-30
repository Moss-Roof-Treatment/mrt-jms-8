@extends('layouts.app')

@section('title', '- Tradesperson Testimonials - View All Selected Tradespersons Testimonials')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">TRADESPERSON TESTIMONIALS</h3>
    <h5>View All Selected Tradespersons Testimonials</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route($selected_user->account_role->route_title, $selected_user->id) }}" class="btn btn-dark btn-block">
            <i class="fas fa-user mr-2" aria-hidden="true"></i>View {{ $selected_user->account_role->title }}
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- testimonials --}}
    <h5 class="text-primary my-3"><b>All Testimonials</b></h5>
    @if (!$selected_survey_testimonials->count() && !$selected_testimonials->count())
      <div class="card shadow-sm my-3">
        <div class="card-body text-center">
          <h5>There are no testimonials to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      @foreach ($selected_survey_testimonials as $testimonial)
        <div class="card mb-3">
          <div class="row no-gutters">
            <div class="col-md-3">
              @if ($testimonial->survey->quote->job->job_images->where('job_image_type_id', 7)->first() == null)
                <img class="card-img" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="image">
              @else
                <img class="card-img" src="{{ asset($testimonial->survey->quote->job->job_images->where('job_image_type_id', 7)->first()->image_path) }}" alt="image">
              @endif
            </div>
            <div class="col-md-9">
              <div class="card-body">
                <p class="card-text">"{{ $testimonial->text }}"</p>
                <h5 class="card-title">- {{ $testimonial->survey->user->first_name }}</h5>
                <p class="card-text"><small class="text-muted">{{ date('d/m/y', strtotime($testimonial->created_at)) }}</small></p>
              </div>
            </div>
          </div>
        </div>
      @endforeach
      @foreach ($selected_testimonials as $testimonial)
        <div class="card mb-3">
          <div class="row no-gutters">
            <div class="col-md-3">
              @if ($testimonial->image_path == null)
                <img class="card-img" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="image">
              @else
                <img class="card-img" src="{{ asset($testimonial->image_path) }}" alt="image">
              @endif
            </div>
            <div class="col-md-9">
              <div class="card-body">
                <p class="card-text">"{{ $testimonial->text }}"</p>
                <h5 class="card-title">- {{ $testimonial->name }}</h5>
                <p class="card-text"><small class="text-muted">{{ date('d/m/y', strtotime($testimonial->created_at)) }}</small></p>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    @endif
    {{-- testimonials --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection