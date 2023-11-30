@extends('layouts.app')

@section('title', '- Dimensions - View All Dimensions')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">DIMENSIONS</h3>
    <h5>View All Dimensions</h5>
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

    <p class="text-primary my-3"><b>All Dimensions</b></p>

    @if (!$dimensions->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no dimensions to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Unit</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($dimensions as $dimension)
              <tr>
                <td>{{ $dimension->id }}</td>
                <td>{{ $dimension->title }}</td>
                <td>{{ $dimension->unit }}</td>
                <td>
                  @if ($dimension->description == null)
                    <span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>The description has not been set</span>
                  @else
                    {{ substr($dimension->description, 0, 40) }}{{ strlen($dimension->description) > 40 ? "..." : "" }}
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif

    {{ $dimensions->links() }}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection