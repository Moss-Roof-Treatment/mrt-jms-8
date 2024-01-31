@extends('layouts.jquery')

@section('title', '- Equipment Groups - View All Equipment Groups')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">EQUIPMENT GROUPS</h3>
    <h5>View All Equipment Groups</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('equipment.index') }}">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Equipment Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('equipment-group-settings.create') }}">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Group
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    {{-- all groups table --}}
    <p class="text-primary my-3"><b>All Equipment Groups</b></p>
    @if (!$all_equipment_groups->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no equipment groups to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <table id="datatable" class="table table-bordered table-fullwidth table-striped bg-white" style="width:100%">
        <thead class="table-secondary">
          <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Description</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($all_equipment_groups as $equipment_group)
            <tr>
              <td class="text-center">
                <a href="{{ route('equipment-group-settings.show', $equipment_group->id) }}">
                  <img style="max-width: 50px;" src="{{ asset($equipment_group->get_image()) }}" alt="">
                </a>
              </td>
              <td>{{ $equipment_group->title }}</td>
              <td>
                @if ($equipment_group->description == null)
                  <span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>The description has not been set.</span>
                @else
                  {{ substr($equipment_group->description, 0, 80) }}{{ strlen($equipment_group->description) > 80 ? "..." : "" }}
                @endif
              </td>
              <td class="text-center">
                <a class="btn btn-primary btn-sm" href="{{ route('equipment-group-settings.show', $equipment_group->id) }}">
                  <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                </a>
                <a class="btn btn-primary btn-sm" href="{{ route('equipment-group-settings.edit', $equipment_group->id) }}">
                  <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                </a>
                {{-- delete modal --}}
                {{-- modal button --}}
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-modal-{{$equipment_group->id}}">
                  <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                </button>
                {{-- modal button --}}
                {{-- modal --}}
                <div class="modal fade" id="delete-modal-{{$equipment_group->id}}" tabindex="-1" role="dialog" aria-labelledby="delete-modal-{{$equipment_group->id}}Title" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="delete-modal-{{$equipment_group->id}}Title">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p class="text-center">Are you sure that you would like to delete this item?</p>
                        <form method="POST" action="{{ route('equipment-group-settings.destroy', $equipment_group->id) }}">
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
    @endif
    {{-- all groups table --}}

    {{ $all_equipment_groups->links() }}

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
      "paging": true, {{-- Show pagination --}}
      "lengthChange": true, {{-- Show results length --}}
      "searching": true, {{-- Search for results --}}
      "ordering": true, {{-- Allow ordering of all columns --}}
      "info": true, {{-- Show the page info --}}
      "processing": true, {{-- Show processing message on long load time --}}
      order: [[ 1, "asc" ]],
      columnDefs: [
        {targets: 3, orderable: false, className: "text-center text-nowrap"},
      ],
    });
  });
</script>
{{-- jquery datatables js --}}
@endpush