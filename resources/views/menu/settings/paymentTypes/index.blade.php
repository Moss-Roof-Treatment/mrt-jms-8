@extends('layouts.app')

@section('title', '- Settings - Payment Types - View All Payment Types')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">PAYMENT TYPES</h3>
    <h5>View All Payment Types</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('settings.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    {{-- payment types table --}}
    <p class="text-primary my-3"><b>All Payment Types</b></p>
    @if (!$all_payment_types->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no payment types to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Descrition</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_payment_types as $payment_type)
              <tr>
                <td>{{ $payment_type->id }}</td>
                <td>{{ $payment_type->title }}</td>
                <td>{{ $payment_type->description }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- payment types table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection