@extends('layouts.jquery')

@section('title', '- Service Areas - View All Service Areas')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SERVICE AREAS</h3>
    <h5>View All Service Areas</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a href="{{ route('service-area-settings.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>New Service Area
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <p class="text-primary my-3"><b>All Service Areas</b></p>

    @if (!$all_service_areas->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no service areas to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table id="datatable" class="table table-bordered table-fullwidth table-striped bg-white" style="width:100%">
          <thead class="table-secondary">
            <tr>
              <th>Title</th>
              <th>Subtitle</th>
              <th>Text</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_service_areas as $service_area)
              <tr>
                <td>{{ $service_area->title }}</td>
                <td>
                  @if ($service_area->subtitle == null)
                    <span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>The subtitle has not been set</span>
                  @else
                    {{ substr($service_area->subtitle, 0, 40) }}{{ strlen($service_area->subtitle) > 40 ? "..." : "" }}
                  @endif
                </td>
                <td>
                  @if ($service_area->text == null)
                    <span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>The text has not been set</span>
                  @else
                    {{ substr($service_area->text, 0, 40) }}{{ strlen($service_area->text) > 40 ? "..." : "" }}
                  @endif
                </td>
                <td class="text-center text-nowrap">
                  <a href="{{ route('service-area-settings.show', $service_area->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                  <a href="{{ route('service-area-settings.edit', $service_area->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                  </a>
                  {{-- delete modal --}}
                  {{-- modal button --}}
                  <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModalCenter-{{ $service_area->id }}-">
                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                  </button>
                  {{-- modal button --}}
                  {{-- modal --}}
                  <div class="modal fade" id="deleteModalCenter-{{ $service_area->id }}-" tabindex="-1" role="dialog" aria-labelledby="deleteModalCenter-{{ $service_area->id }}-Title" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteModalCenter-{{ $service_area->id }}-Title">Delete</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div> {{-- modal-header --}}
                        <div class="modal-body">
                          <p class="subtitle text-center">Are you sure you would like to delete the selected item...?</p>
                          <form action="{{ route('service-area-settings.destroy', $service_area->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-block">
                              <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                            </button>
                          </form>
                        </div> {{-- modal-body --}}
                      </div> {{-- modal-content --}}
                    </div> {{-- modal-dialog --}}
                  </div> {{-- modal fade --}}
                  {{-- modal --}}
                  {{-- delete modal --}}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif

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
      order: [[ 0, "asc" ]],
      columnDefs: [
        {targets: 3, orderable: false, className: "text-center text-nowrap"},
      ],
    });
  });
</script>
{{-- jquery datatables js --}}
@endpush