@extends('layouts.app')

@section('title', '- Emails - Create New Email Group')

@livewireStyles

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">EMAIL USER GROUPS</h3>
    <h5>Create New Email User Group</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('email-recipient-groups.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Email User Group Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    @livewire('email-property-search')

@endsection

@livewireScripts