@extends('layouts.app')

@section('title', 'Stock Controll - Stock Controll Menu')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">STOCK CONTROL</h3>
    <h5>Stock Controll Menu</h5>
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

    {{-- card menu --}}
    <div class="row row-cols-1 row-cols-md-4 text-center pt-3">
      <div class="col mb-4 offset-sm-3">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('inventory.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/crate-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Inventory</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h3 class="card-title text-dark"><b>Inventory</b></h3>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('pending-orders.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/invoice-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Orders ({{ $pending_order_count }})</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h3 class="card-title text-dark"><b>Orders ({{ $pending_order_count }})</b></h3>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
    </div> {{-- row row-cols-1 row-cols-md-3 --}}
    {{-- card menu --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection