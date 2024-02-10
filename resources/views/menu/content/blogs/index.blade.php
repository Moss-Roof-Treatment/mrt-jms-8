@extends('layouts.jquery')

@section('title', 'Content - Blogs - View All Blogs')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">BLOGS</h3>
    <h5>View All Blogs</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('content.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Content Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('blogs.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Blog
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- articles table --}}
    <h5 class="text-primary my-3"><b>All Blogs</b></h5>
    @if (!$articles->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>Threre are no articles to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive mt-3">
        <table id="datatable" class="table table-bordered table-fullwidth table-striped bg-white" style="width:100%">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Text</th>
              <th>Created At</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($articles as $article)
              <tr>
                <td>
                  <a href="{{ route('blogs.show', $article->id) }}">
                    {{ $article->id }}
                  </a>
                </td>
                <td>
                  {{ substr($article->title, 0, 40) }}{{ strlen($article->title) > 40 ? "..." : "" }}
                </td>
                <td>
                  {{ substr($article->text, 0, 40) }}{{ strlen($article->text) > 40 ? "..." : "" }}
                </td>
                <td>{{ date('d/m/y', strtotime($article->created_at)) }}</td>
                <td>
                  <a href="{{ route('blogs.show', $article->id ) }}" class="btn btn-primary btn-sm mb-1">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                  <a class="btn btn-primary btn-sm mb-1" href="{{ route('blogs.edit', $article->id) }}">
                    <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                  </a>
                  {{-- delete modal --}}
                  {{-- modal button --}}
                  <button type="button" class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#deleteModal">
                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                  </button>
                  {{-- modal button --}}
                  {{-- modal --}}
                  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteModalTitle">Delete</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p class="text-center">Are you sure that you would like to delete this blog?</p>
                          <form action="{{ route('blogs.destroy', $article->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-block">
                              <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                            </button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  {{-- modal --}}
                  {{-- delete modal --}}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- articles table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- jquery datatables js --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script>
    new DataTable('#datatable', {
        "info": true, {{-- Show the page info --}}
        "lengthChange": true, {{-- Show results length --}}
        "ordering": true, {{-- Allow ordering of all columns --}}
        "paging": true, {{-- Show pagination --}}
        "processing": true, {{-- Show processing message on long load time --}}
        "searching": true, {{-- Search for results --}}
        "order": [[ 0, "asc" ]],
        "columnDefs": [
            {"targets": 4, "orderable": false, "className": "text-center text-nowrap"},
        ],
    });
</script>
{{-- jquery datatables js --}}
@endpush