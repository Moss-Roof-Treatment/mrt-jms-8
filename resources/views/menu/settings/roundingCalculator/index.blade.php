@extends('layouts.jquery')

@section('title', '- Settings - Rounding Calculator')

@livewireStyles

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">ROUNDING CALCULATOR</h3>
    <h5>Calculate GST</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <h5 class="text-primary my-3"><b>Calculate GST</b></h5>
    @livewire('rounding-calculator')

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@livewireScripts
