@extends('layouts.app')

@section('title', 'Stock Controll - Inventory - View Selected Inventory')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">STOCK CONTROL</h3>
    <h5>View Selected Inventory</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('main-menu.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Main Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection