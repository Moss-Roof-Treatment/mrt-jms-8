@extends('layouts.app')

@section('title', '- Settings - Payment Methods - View All Payment Methods')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">PAYMENT METHODS</h3>
    <h5>View All Payment Methods</h5>
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

    {{-- payment methods table --}}
    <p class="text-primary my-3"><b>All Payment Methods</b></p>
    @if (!$all_payment_methods->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no payment methods to display</h5>
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
            @foreach ($all_payment_methods as $payment_method)
              <tr>
                <td>{{ $payment_method->id }}</td>
                <td>{{ $payment_method->title }}</td>
                <td>{{ $payment_method->description }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- payment methods table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection