@extends('layouts.app')

@section('title', '- Reports - View Customer Account Classes')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">REPORTS</h3>
    <h5>View Customer Account Classes</h5>
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

        <h5 class="text-primary my-3"><b>Date Search</b></h5>

        <form action="{{ route('account-class-report.show') }}" method="POST">
          @csrf

          <div class="row">
            <div class="col-sm-3">
              <div class="form-group row">
                <div class="col">
                  <input class="form-control" type="date" name="start_date">
                </div> {{-- col --}}
              </div> {{-- form-group row --}}
            </div> {{-- col-sm-3 --}}
            <div class="col-sm-3">
              <div class="form-group row">
                <div class="col">
                  <input class="form-control" type="date" name="end_date">
                </div> {{-- col --}}
              </div> {{-- form-group row --}}
            </div> {{-- col-sm-3 --}}
            <div class="col-sm-3">
              <div class="form-group row">
                <div class="col">
                  <button class="btn btn-primary btn-block" type="submit">
                    <i class="fas fa-search mr-2" aria-hidden="true"></i>Search
                  </button>
                </div> {{-- col --}}
              </div> {{-- form-group row --}}
            </div> {{-- col-sm-3 --}}
            <div class="col-sm-3">
              <div class="form-group row">
                <div class="col">
                  <a href="{{ route('account-classes-report.index') }}" class="btn btn-dark btn-block">
                    <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                  </a>
                </div> {{-- col --}}
              </div> {{-- form-group row --}}
            </div> {{-- col-sm-3 --}}
          </div> {{-- row --}}

        </form>

        <h5 class="text-primary my-3"><b>All Customer Account Classes</b></h5>
        <div class="card">
          <div class="card-body">
            <h4 class="text-primary text-center mb-4">Total Customer Account Classes: {{ $selected_account_classes->count() }}</h4>
            @if (!$selected_account_classes->count())
              <p class="text-center">There are no customer account classes to display</p>
            @else
              @foreach ($selected_account_classes as $account_class)
                <div class="row">
                  <div class="col-sm-4">
                    <p><b>{{ $account_class->title }}</b> - {{ $account_class->users_count }}</p>
                  </div> {{-- col-sm-4 --}}
                  <div class="col-sm-8">
                    <div class="progress my-1">
                      <div class="progress-bar" role="progressbar" style="width: {{ number_format($account_class->users_count / $total_user_count * 100) . '%' }}" aria-valuenow="{{ number_format($account_class->users_count / $total_user_count * 100) }}" aria-valuemin="0" aria-valuemax="100">{{ number_format($account_class->users_count / $total_user_count * 100) . '%' }}</div>
                    </div>
                  </div> {{-- --}}
                </div> {{-- row --}}
              @endforeach
            @endif
          </div>{{-- card-body --}}
        </div>{{-- card --}}

      </div> {{-- col-sm-9 --}}
    </div> {{-- row --}}
    {{-- report content --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection