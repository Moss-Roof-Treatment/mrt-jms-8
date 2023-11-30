@extends('layouts.app')

@section('title', 'Content - Content Menu')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">CONTENT</h3>
    <h5>Content Menu</h5>
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
    <div class="row row-cols-1 row-cols-md-5 text-center pt-3">
      <div class="col mb-4 offset-sm-1">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('articles.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/book-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Articles</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h2 class="card-title text-dark"><b>Articles</b></h2>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('blogs.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/book-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Blog</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h2 class="card-title text-dark"><b>Blog</b></h2>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('content-categories.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/category-folder-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Categories</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h2 class="card-title text-dark"><b>Categories</b></h2>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('content-tags.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/tag-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Tags</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h2 class="card-title text-dark"><b>Tags</b></h2>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
    </div> {{-- row row-cols-1 row-cols-md-3 --}}
    {{-- card menu --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection