@extends('layouts.app')

@section('title', '- Reports - View All Customer Referral Report')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">REPORTS</h3>
    <h5>View All Customer Referrals</h5>
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

        <form action="{{ route('customer-referral-report.show') }}" method="POST">
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
                  <a href="{{ route('customer-referral-report.index') }}" class="btn btn-dark btn-block">
                    <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                  </a>
                </div> {{-- col --}}
              </div> {{-- form-group row --}}
            </div> {{-- col-sm-3 --}}
          </div> {{-- row --}}

        </form>

        <p class="text-primary my-3"><b>All Customer Referrals</b></p>
        <div class="card">
          <div class="card-body">
            <h4 class="text-primary text-center mb-4">Total Customer Referrals: {{ $total_customer_referrals }}</h4>
            <h4 class="text-primary text-center mb-4">Total Sold: {{ $total_sold_quotes }}</h4>
            @if (!$sold_quotes->count())
              <p class="text-center">There are no customer referrals to display</p>
            @else
              <div class="table-responsive">
                <table class="table">
                  <thead class="table-secondary">
                    <tr>
                      <th width="28%">Referral</th>
                      <th></th>
                      <th width="9%">Count</th>
                      <th width="9%">Percent</th>
                      <th width="9%">Sold</th>
                      <th width="9%">% Sold</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($sold_quotes as $quote)
                      <tr>
                        <td>{{ $quote->first()->customer->referral->title }}</td>
                        <td>
                          <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ number_format($quote->first()->customer->referral->usersCount() / $total_customer_referrals * 100) . '%' }}" aria-valuenow="{{ number_format($quote->first()->customer->referral->usersCount() / $total_customer_referrals * 100) }}" aria-valuemin="0" aria-valuemax="100">{{ number_format($quote->first()->customer->referral->usersCount() / $total_customer_referrals * 100) . '%' }}</div>
                          </div>
                        </td>
                        <td>{{ $quote->first()->customer->referral->usersCount() }}</td>
                        <td>{{ number_format($quote->first()->customer->referral->usersCount() / $total_customer_referrals * 100) . '%' }}</td>
                        <td>{{ $quote->count() }}</td>
                        <td>{{ number_format($quote->count() / $quote->first()->customer->referral->usersCount() * 100) . '%' }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @endif
          </div>{{-- card-body --}}
        </div>{{-- card --}}

      </div> {{-- col-sm-9 --}}
    </div> {{-- row --}}
    {{-- report content --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection