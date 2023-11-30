@extends('layouts.app')

@section('title', '- Colours - View All Colours')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">COLOURS</h3>
    <h5>View All Colours</h5>
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

    <p class="text-primary my-3"><b>All Colours</b></p>

    @if (!$all_colours->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no colours to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Colour</th>
              <th>Brand</th>
              <th>Text Colour</th>
              <th>Text Brand</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_colours as $colour)
              <tr>
                <td>{{ $colour->id }}</td>
                <td>{{ $colour->title }}</td>
                <td><i class="fas fa-square-full mr-2 border border-dark" style="color:{{ $colour->colour }};"></i>{{ $colour->colour }}</td>
                <td>{{ $colour->brand }}</td>
                <td><i class="fas fa-square-full mr-2 border border-dark" style="color:{{ $colour->text_colour }};"></i>{{ $colour->text_colour }}</td>
                <td>{{ $colour->text_brand }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection