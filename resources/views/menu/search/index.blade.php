@extends('layouts.jquery')

@section('title', '- Search - Global Search Menu')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SEARCH</h3>
    <h5>Global Search Menu</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('main-menu.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Main Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- card menu --}}
    <div class="row row-cols-1 row-cols-md-4 text-center pt-3">
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('search-follow-up-process.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/phone-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Follow Up Call Search</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h2 class="card-title text-dark"><b>Follow Up Call Search</b></h2>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('search-properties.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/home-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Property Search</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h2 class="card-title text-dark"><b>Property Search</b></h2>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('search-users.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/user-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>User Search</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h2 class="card-title text-dark"><b>User Search</b></h2>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
    </div> {{-- row row-cols-1 row-cols-md-3 --}}
    {{-- card menu --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection