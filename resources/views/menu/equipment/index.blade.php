@extends('layouts.jquery')

@section('title', '- Equipment - View All Equipment')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">EQUIPMENT</h3>
    <h5>View All Equipment</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('main-menu.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Main Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('equipment.create') }}" class="btn btn-dark btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Equipment
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- equipment table --}}
    <h5 class="text-primary my-3"><b>All Equipment</b></h5>
    @if (!$all_equipment->count())
      <div class="card shadow-sm mt-3">
          <div class="card-body text-center">
              <h5>Threre is currently no equipment to display</h5>
          </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive mt-3">
        <table id="datatable" class="table table-bordered table-fullwidth table-striped bg-white" style="width:100%">
          <thead class="table-secondary">
            <tr>
              <th>Image</th>
              <th>Title</th>
              <th>Category</th>
              <th>Owner</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_equipment as $equipment)
              <tr>
                <td class="text-center">
                  <a href="{{ route('equipment.show', $equipment->id) }}">
                    @if ($equipment->image_path == null)  
                      <img class="img-fluid shadow-sm" style="max-width:64px;" src="{{ asset('storage/images/placeholders/tools-256x256.jpg') }}">
                    @else
                      <img class="img-fluid" style="max-width:64px;" src="{{ asset($equipment->image_path) }}" alt="">
                    @endif
                  </a>
                </td>
                <td>{{ $equipment->title }}</td>
                <td>
                  @if ($equipment->equipment_category_id == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>The equipment category has not been set
                    </span>
                  @else
                    {{ $equipment->equipment_category->title }}
                  @endif
                </td>
                <td>
                  @if ($equipment->owner_id == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>The equipment owner has not been set
                    </span>
                  @else
                    {{ $equipment->owner->getFullNameAttribute() }}
                  @endif
                </td>
                <td class="text-center text-nowrap">
                  <a class="btn btn-primary btn-sm" href="{{ route('equipment.show', $equipment->id) }}">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                  <a class="btn btn-primary btn-sm" href="{{ route('equipment.edit', $equipment->id) }}">
                    <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                  </a>
                  {{-- delete modal --}}
                  {{-- modal button --}}
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-modal-{{$equipment->id}}">
                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                  </button>
                  {{-- modal button --}}
                  {{-- modal --}}
                  <div class="modal fade" id="delete-modal-{{$equipment->id}}" tabindex="-1" role="dialog" aria-labelledby="delete-modal-{{$equipment->id}}Title" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="delete-modal-{{$equipment->id}}Title">Delete</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p class="text-center">Are you sure that you would like to delete this item?</p>
                          <form method="POST" action="{{ route('equipment.destroy', $equipment->id) }}">
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
    {{-- equipment table --}}

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
      "paging": true, {{-- Show pagination --}}
      "lengthChange": true, {{-- Show results length --}}
      "searching": true, {{-- Search for results --}}
      "ordering": true, {{-- Allow ordering of all columns --}}
      "info": true, {{-- Show the page info --}}
      "processing": true, {{-- Show processing message on long load time --}}
      order: [[ 1, "asc" ]],
      columnDefs: [
        {targets: 4, orderable: false, className: "text-center text-nowrap"},
      ],
    });
  });
</script>
{{-- jquery datatables js --}}
@endpush