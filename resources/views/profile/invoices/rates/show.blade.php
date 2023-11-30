@extends('layouts.profile')

@section('title', '- Job Rates - View Selected Job Rates')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">JOB RATES</h3>
    <h5>View Selected Job Rates</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('profile-jobs.show', $selected_quote_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Selected Job
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <form action="{{ route('profile-job-rates.create') }}" method="GET">
          <input type="hidden" name="selected_quote_id" value="{{ $selected_quote_id }}">
          <button type="submit" class="btn btn-dark btn-block">
            <i class="fas fa-print mr-2" aria-hidden="true"></i>Print Rates
          </button>
        </form>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- quote rate --}}
    <h5 class="text-primary my-3"><b>Job Rates</b></h5>
    @if (!$selected_rate_users->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>You do not have the rates that have been selected for you in the quote. Please contact the office to have the required quote rates added to your user account.</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>Title</th>
              <th width="30%">Procedure</th>
              <th width="30%">Description</th>
              <th>Rate</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($selected_rate_users as $user_rate)
              <tr>
                <td>{{ $user_rate->rate->title }}</td>
                <td>{{ $user_rate->rate->procedure }}</td>
                <td>{{ $user_rate->rate->description }}</td>
                <td>${{ number_format(($user_rate->price / 100), 2, '.', ',') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- quote rate --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection