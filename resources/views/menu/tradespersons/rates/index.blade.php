@extends('layouts.app')

@section('title', '- Tradesperson Rates - View All Selected Tradespersons Rates')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">TRADESPERSON RATES</h3>
    <h5>View All Selected Tradespersons Rates</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route($selected_user->account_role->route_title, $selected_user->id) }}" class="btn btn-dark btn-block">
            <i class="fas fa-user mr-2" aria-hidden="true"></i>View {{ $selected_user->account_role->title }}
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('tradesperson-rates.create', ['selected_user_id' => $selected_user->id]) }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Rate
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- set payment rates --}}
    <h5 class="text-primary my-3"><b>Set Payment Rates</b></h5>
    @if (!$selected_rates->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no set payment rates</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Procedure</th>
              <th>Price</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($selected_rates as $selected_rate)
              <tr>
                <td>
                  <a href="{{ route('tradesperson-rates.show', $selected_rate->id) }}">
                    {{ $selected_rate->id }}
                  </a>
                </td>
                <td>{{ $selected_rate->rate->title }}</td>
                <td>
                  {{ substr($selected_rate->rate->procedure, 0, 60) }}{{ strlen($selected_rate->rate->procedure) > 60 ? "..." : "" }}
                </td>
                <td>${{ number_format(($selected_rate->price / 100), 2, '.', ',') }}</td>
                <td class="text-center">
                  <a href="{{ route('tradesperson-rates.show', $selected_rate->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye" aria-hidden="true"></i>
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- set payment rates --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection