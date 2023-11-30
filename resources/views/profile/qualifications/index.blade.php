@extends('layouts.profile')

@section('title', '- Profile - View My Qualifications')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">MY PROFILE</h3>
    <h5>View My Qualifications</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('profile.index') }}" class="btn btn-primary btn-block">
          <i class="fas fa-user mr-2" aria-hidden="true"></i>Personal Details
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('profile-financial-details.index') }}" class="btn btn-primary btn-block">
          <i class="fas fa-dollar-sign mr-2" aria-hidden="true"></i>Financial Details
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('profile-qualifications.index') }}" class="btn btn-primary btn-block">
          <i class="fas fa-id-card-alt mr-2" aria-hidden="true"></i>Qualifications
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('profile-testimonials.index') }}" class="btn btn-primary btn-block">
          <i class="fas fa-star mr-2" aria-hidden="true"></i>Testimonials
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- body --}}
    <h5 class="text-primary my-3"><b>All My Qualifications</b></h5>
    @if (!$selected_qualifications->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no qualifications to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="row row-cols-1 row-cols-md-4">
        @foreach ($selected_qualifications as $selected_qualification)
          <div class="col mb-4">
            <div class="card h-100">
              <a href="{{ route('profile-qualifications.show', $selected_qualification->id) }}">
                @if ($selected_qualification->image_path == null)
                  <img class="card-img-top" src="{{ asset('storage/images/placeholders/document-256x256.jpg') }}" alt="">
                @else
                  <img class="card-img-top" src="{{ asset($selected_qualification->image_path) }}" alt="">
                @endif
              </a>
              <div class="card-body text-center">
                <h5 class="card-title">{{ $selected_qualification->title }}</h5>
                <a href="{{ route('profile-qualifications.show', $selected_qualification->id) }}" class="btn btn-primary">
                  <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                </a>
              </div> {{-- card-body --}}
            </div> {{-- card h-100 --}}
          </div> {{-- col mb-4 --}}
        @endforeach
      </div> {{-- row --}}
    @endif
    {{-- body --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection