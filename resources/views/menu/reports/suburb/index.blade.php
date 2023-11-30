@extends('layouts.app')

@section('title', '- Reports - View Most Popular Suburbs')

@livewireStyles

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">REPORTS</h3>
    <h5>View Most Popular Suburbs</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('reports.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Reports Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- report content --}}
    <div class="row">
      <div class="col-sm-3 pb-3">
        @include('partials.reportMenu')
      </div> {{-- col-sm-3 --}}
      <div class="col-sm-9">

        <h5 class="text-primary my-3"><b>Suburb Filter</b></h5>
        @livewire('most-popular-suburb')

      </div> {{-- col-sm-9 --}}
    </div> {{-- row --}}
    {{-- report content --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@livewireScripts
