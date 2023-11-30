@extends('layouts.profile')

@section('title', '- Profile - View Selected Qualifications')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">MY PROFILE</h3>
    <h5>View Selected Qualification</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('profile.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Profile Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- body --}}
    <h5 class="text-primary my-3"><b>Qualification Image</b></h5>
    @if ($selected_qualification->image_path == null)
      <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset('storage/images/placeholders/document-256x256.jpg') }}" alt="">
    @else
      <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset($selected_qualification->image_path) }}" alt="">
    @endif

    <h5 class="text-primary my-3"><b>Qualification Details</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <tbody>
          <tr>
            <th>Name</th>
            <td>{{ $selected_qualification->staff->getFullNameAttribute() }}</td>
          </tr>
          <tr>
            <th>Title</th>
            <td>{{ $selected_qualification->title }}</td>
          </tr>
          <tr>
            <th>Description</th>
            <td width="80%">{{ $selected_qualification->description }}</td>
          </tr>
          <tr>
            <th>Creation Date</th>
            <td>{{ date('d/m/y - h:iA', strtotime($selected_qualification->created_at)) }}</td>
          </tr>
          <tr>
            <th>Issue Date</th>
            <td>{{ date('d/m/y', strtotime($selected_qualification->issue_date)) }}</td>
          </tr>
          <tr>
            <th>Expiry Date</th>
            <td>{{ date('d/m/y', strtotime($selected_qualification->expiry_date)) }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- body --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection