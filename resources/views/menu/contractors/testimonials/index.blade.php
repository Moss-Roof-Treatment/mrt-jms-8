@extends('layouts.app')

@section('title', '- Tradesperson Testimonials - View All Selected Contractor Testimonials')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">CONTRACTOR TESTIMONIALS</h3>
    <h5>View All Selected Contractor Testimonials</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route($selected_contractor->account_role->route_title, $selected_contractor->id) }}" class="btn btn-primary btn-block">
            <i class="fas fa-user mr-2" aria-hidden="true"></i>View {{ $selected_contractor->account_role->title }}
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="card">
      <div class="card-body text-center">
        <h5>There are no contractor testimonials to display</h5>
      </div> {{-- card-body --}}
    </div> {{-- card --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection