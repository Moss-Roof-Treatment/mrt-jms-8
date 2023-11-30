@extends('layouts.app')

@section('title', '- Tradesperson Rates - View Selected Tradespersons Rate')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">TRADESPERSON RATES</h3>
    <h5>View Selected Tradespersons Rate</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('tradesperson-rates.index', ['selected_user_id' => $selected_rate->user_id]) }}" class="btn btn-dark btn-block">
          <i class="fas fa-dollar-sign mr-2" aria-hidden="true"></i>View Rates
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('tradespersons.show', $selected_rate->user_id) }}" class="btn btn-dark btn-block">
          <i class="fas fa-user mr-2" aria-hidden="true"></i>View Tradesperson
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('tradesperson-rates.edit', $selected_rate->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit Rate
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <form action="{{ route('tradesperson-rates.destroy', $selected_rate->id) }}" method="POST">
          @method('DELETE')
          @csrf
          <input type="hidden" name="selected_user_id" value="{{ $selected_rate->user_id }}">
          <button type="submit" class="btn btn-danger btn-block">
          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete Rate
          </button>
        </form>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- details table --}}
    <h5 class="text-primary my-3"><b>Details</b></h5>
    <table class="table table-bordered table-fullwidth table-striped bg-white">
      <thead class="table-secondary">
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Tradesperson</th>
          <th>Default Price</th>
          <th>Tradesperson Price</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ $selected_rate->id }}</td>
          <td>{{ $selected_rate->rate->title }}</td>
          <td>{{ $selected_rate->user->getFullNameAttribute() }}</td>
          <td>${{ number_format(($selected_rate->rate->price / 100), 2, '.', ',') }}</td>
          <td>${{ number_format(($selected_rate->price / 100), 2, '.', ',') }}</td>
        </tr>
      </tbody>
    </table>
    {{-- details table --}}

    {{-- description --}}
    <h5 class="text-primary my-3"><b>Description</b></h5>
    <div class="card">
      <div class="card-body">
        {{ $selected_rate->rate->description }}
      </div> {{-- card-body --}}
    </div> {{-- card --}}
    {{-- description --}}

    {{-- procedure --}}
    <h5 class="text-primary my-3"><b>Procedure</b></h5>
    <div class="card">
      <div class="card-body">
        {{ $selected_rate->rate->procedure }}
      </div> {{-- card-body --}}
    </div> {{-- card --}}
    {{-- procedure --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection