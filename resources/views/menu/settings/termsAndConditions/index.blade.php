@extends('layouts.app')

@section('title', '- Terms and Conditions - View Terms and Conditions')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">TERMS AND CONDITIONS</h3>
    <h5>View Terms and Conditions</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu 
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- card menu --}}
    <div class="row row-cols-1 row-cols-md-5 text-center pt-3">
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('terms-and-conditions-headings.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/book-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Headings</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h2 class="card-title text-dark"><b>Headings</b></h2>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('terms-and-conditions-subheadings.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/book-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Sub Headings</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h2 class="card-title text-dark"><b>Sub Headings</b></h2>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('terms-and-conditions-items.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/book-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Items</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h2 class="card-title text-dark"><b>Items</b></h2>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('terms-and-conditions-subitems.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/book-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Sub Items</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h2 class="card-title text-dark"><b>Sub Items</b></h2>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('terms-and-conditions-template.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/quote-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Template</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h2 class="card-title text-dark"><b>Template</b></h2>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
    </div> {{-- row row-cols-1 row-cols-md-3 --}}
    {{-- card menu --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection