@extends('layouts.app')

@section('title', 'Stock Controll - Inventory - View All Inventory')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">STOCK CONTROL</h3>
    <h5>View All Inventory</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('stock-control.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Stock Control Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <h5 class="text-primary my-3"><b>All Inventory</b></h5>
    <div class="card">
      <div class="card-body text-center">
        <h5>Threre is currently no inventory to display</h5>
      </div> {{-- card-body --}}
    </div> {{-- card --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection