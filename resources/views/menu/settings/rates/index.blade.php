@extends('layouts.app')

@section('title', 'Rate Settings - View All Rates')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">RATES SETTINGS</h3>
    <h5>View All Rates</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col mb-3">
        <a href="{{ route('rate-settings.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Event
        </a>
      </div> {{-- col mb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- index table --}}
    <h5 class="text-primary my-3"><b>All Rates</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <thead class="table-secondary">
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($all_rates as $rate)
            <tr>
              <td>{{ $rate->id }}</td>
              <td>{{ $rate->title }}</td>
              <td>
                {{ substr($rate->description, 0, 60) }}
                {{ strlen($rate->description) > 60 ? '...' : '' }}
              </td>
              <td class="text-center">
                <a href="{{ route('rate-settings.show', $rate->id) }}" class="btn btn-primary btn-sm">View</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    {{-- index table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection