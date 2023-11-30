@extends('layouts.jquery')

@section('title', 'Content - Tags - View All Content Tags')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">TAGS</h3>
    <h5>View All Content Tags</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('content.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Content Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('content-tags.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Tag
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- tags table --}}
    <h5 class="text-primary my-3"><b>All Tags</b></h5>
    @if (!$all_tags->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>Threre are no tags to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive mt-3">
        <table id="datatable" class="table table-bordered table-fullwidth table-striped bg-white" style="width:100%">
          <thead class="table-secondary">
            <tr>
              <th>Title</th>
              <th>URL</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_tags as $tag)
              <tr>
                <td>
                  {{ substr($tag->title, 0, 60) }}{{ strlen($tag->title) > 60 ? "..." : "" }}
                </td>
                <td>
                  {{ substr($tag->slug, 0, 60) }}{{ strlen($tag->slug) > 60 ? "..." : "" }}
                </td>
                <td class="text-center">
                  <a href="{{ route('content-tags.show', $tag->id ) }}" class="btn btn-primary btn-sm mb-1">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                  <a class="btn btn-primary btn-sm mb-1" href="{{ route('content-tags.edit', $tag->id) }}">
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
                          <p class="text-center">Are you sure that you would like to delete this content tag?</p>
                          <form action="{{ route('content-tags.destroy', $tag->id) }}" method="POST">
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
    {{-- tags table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- jquery datatables js --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function() {
    $('#datatable').DataTable({
      "info": true, {{-- Show the page info --}}
      "lengthChange": true, {{-- Show results length --}}
      "ordering": true, {{-- Allow ordering of all columns --}}
      "paging": true, {{-- Show pagination --}}
      "processing": true, {{-- Show processing message on long load time --}}
      "searching": true, {{-- Search for results --}}
      order: [[ 0, "asc" ]],
      columnDefs: [
        {targets: 2, orderable: false, className: "text-center text-nowrap"},
      ],
    });
  });
</script>
{{-- jquery datatables js --}}
@endpush