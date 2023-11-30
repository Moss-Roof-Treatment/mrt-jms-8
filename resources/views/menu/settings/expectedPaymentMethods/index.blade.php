@extends('layouts.app')

@section('title', '- Expected Payment Methods - View All Expected Payment Methods')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">EXPECTED PAYMENT METHODS</h3>
    <h5>View All Expected Payment Methods</h5>
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

    <p class="text-primary my-3"><b>All Expected Payment Methods</b></p>
    @if (!$all_expected_payment_methods->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no expected payment methods to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Payment Type</th>
              <th>Payment Method</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_expected_payment_methods as $expected_payment_method)
              <tr>
                <td>{{ $expected_payment_method->id }}</td>
                <td>{{ $expected_payment_method->title }}</td>
                <td>
                  @if ($expected_payment_method->payment_type_id == null)
                    <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
                  @else
                    {{ $expected_payment_method->payment_type->title }}
                  @endif
                </td>
                <td>
                  @if ($expected_payment_method->payment_method_id == null)
                    <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
                  @else
                    {{ $expected_payment_method->payment_method->title }}
                  @endif
                </td>
                <td><span class="text-truncate">{{ $expected_payment_method->description }}</span></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection