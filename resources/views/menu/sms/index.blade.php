@extends('layouts.app')

@section('title', '- SMS - SMS Menu')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SMS</h3>
    <h5>SMS Menu</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('main-menu.index') }}">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Main Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- card menu --}}
    <div class="row row-cols-1 row-cols-md-4 text-center pt-3">
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('generic-sms.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/envelope-white-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Generic SMS</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h3 class="card-title text-dark"><b>Generic SMS</b></h3>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('group-sms.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/envelopes-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Group SMS</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h3 class="card-title text-dark"><b>Group SMS</b></h3>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('sms-templates.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/envelope-design-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>SMS Templates</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h3 class="card-title text-dark"><b>SMS Templates</b></h3>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('sms-recipient-groups.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/customer-group-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>SMS Groups</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h3 class="card-title text-dark"><b>SMS Groups</b></h3>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
    </div> {{-- row row-cols-1 row-cols-md-3 --}}
    {{-- card menu --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection