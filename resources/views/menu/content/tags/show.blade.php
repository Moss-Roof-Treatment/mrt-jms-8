@extends('layouts.jquery')

@section('title', 'Content - Tags - View Selected Content Tag')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">TAGS</h3>
    <h5>View Selected Content Tag</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('content-tags.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Tags Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('content-tags.edit', $tag->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-6">

        <h5 class="text-primary my-3"><b>Category Image</b></h5>
        <div class="text-center">
          @if (!$tag->image_path == null)
            <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset($tag->image_path) }}" alt="">
          @else
            <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset('storage/images/placeholders/category-folder-256x256.jpg') }}" alt="">
          @endif
        </div>

      </div> {{-- col-sm-6 --}}
      <div class="col-sm-6">

        <h5 class="text-primary my-3"><b>Category Details</b></h5>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>ID</th>
                <td>{{ $tag->id }}</td>
              </tr>
              <tr>
                <th>Title</th>
                <td>{{ $tag->title }}</td>
              </tr>
              <tr>
                <th>URL</th>
                <td>{{ $tag->slug }}</td>
              </tr>
              <tr>
                <th>Post Count</th>
                <td>
                  @if (!$tag->articles->count())
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>There are no posts with this category
                    </span>
                  @else
                    {{ $tag->articles->count() }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Image Storage Path</th>
                <td>
                  @if ($tag->image_path == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>There is no image for this category
                    </span>
                  @else
                    {{ $tag->image_path }}
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}

      </div> {{-- col-sm-6 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}

<section class="bg-light">
  <div class="container py-5">

    <h5 class="text-primary my-3"><b>Category Posts</b></h5>

    {{-- category posts table --}}
    @if (!$tag->articles->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>Threre are no articles to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table id="datatable" class="table table-striped table-bordered table-fullwidth bg-white" style="width:100%">
          <thead class="table-secondary">
            <tr>
              <th>Article ID</th>
              <th>Title</th>
              <th>Text</th>
              <th>Creation Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tag->articles as $article)
              <tr>
                <td class="text-center">
                  @if ($article->type == 1) {{-- Article --}}
                    <a href="{{ route('articles.show', $article->id) }}">{{ $article->id }}</a>
                  @else {{-- Blog --}}
                    <a href="{{ route('blogs.show', $article->id) }}">{{ $article->id }}</a>
                  @endif
                </td>
                <td>
                  {{ substr($article->title, 0, 50) }}{{ strlen($article->title) > 50 ? "..." : "" }}
                </td>
                <td>
                  {{ substr($article->text, 0, 50) }}{{ strlen($article->text) > 50 ? "..." : "" }}
                </td>
                <td>
                  {{ date('d/m/y', strtotime($article->created_at)) }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- category posts table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- jquery datatables js --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function() {
    $('#datatable').DataTable({
      "info": true, {{-- Show the page info --}}
      "lengthChange": true, {{-- Show results length --}}
      "ordering": true, {{-- Allow ordering of all columns --}}
      "paging": true, {{-- Show pagination --}}
      "processing": true, {{-- Show processing message on long load time --}}
      "searching": true, {{-- Search for results --}}
    });
  });
</script>
{{-- jquery datatables js --}}
@endpush