@extends('layouts.app')

@section('title', '- SMS - SMS Reciptient Group - Create New SMS Reciptient Group')

@livewireStyles

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SMS RECIPIENT GROUPS</h3>
    <h5>Create New SMS Reciptient Group</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('sms-recipient-groups.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Reciptient Group Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    @livewire('property-search')

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@livewireScripts