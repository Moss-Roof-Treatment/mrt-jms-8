@extends('layouts.app')

@section('title', '- Equipment Groups - View Selected Equipment Group')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">EQUIPMENT GROUPS</h3>
    <h5>View Selected Equipment Group</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('equipment-group-settings.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Equipment Group Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('equipment-group-settings.edit', $selected_equipment_group->id) }}">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('equipment-items.create') }}">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Equipment
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    {{-- equipment group details table --}}
    <div class="row">
      <div class="col-sm-7">
        <h5 class="text-primary my-4"><b>Equipment Group Details</b></h5>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>ID</th>
                <td>{{ $selected_equipment_group->id }}</td>
              </tr>
              <tr>            
                <th>Title</th>
                <td>{{ $selected_equipment_group->title }}</td>
              </tr>
              <tr>
                <th>Description</th>
                <td>
                  @if ($selected_equipment_group->description == null)
                    <span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>The description has not been set.</span>
                  @else
                    {{ $selected_equipment_group->description }}
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}
      </div>
      <div class="col-sm-5">
        <h5 class="text-primary my-4"><b>Equipment Group Image</b></h5>
        <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset('storage/images/placeholders/tools-256x256.jpg') }}">
      </div>
    </div>
    {{-- equipment group details table --}}

    {{-- group equipment table --}}
    <h5 class="text-primary my-4"><b>Equipment In This Group {{ '(' . $selected_equipment_group->equipments->count() . ')' }}</b></h5>
    @if (!$selected_equipment_group->equipments->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no equipments to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>Image</th>
              <th>Title</th>
              <th>Category</th>
              <th>Used By</th>
              <th>Last Inspection</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($selected_equipment_group->equipments as $equipment)
              <tr>
                <td>
                  <a href="{{ route('equipment-items.show', $equipment->id) }}">
                    <img style="max-width: 50px;" class="img-fluid shadow-sm mx-auto d-block" src="{{ asset('storage/images/placeholders/tools-256x256.jpg') }}">
                  </a>
                </td>
                <td>{{ $equipment->title }}</td>
                <td>{{ $equipment->equipment_category->title }}</td>
                <td>{{ $equipment->owner->getFullNameAttribute() }}</td>
                <td></td>
                <td class="text-center">
                  <a class="btn btn-primary btn-sm" href="{{ route('equipment-items.show', $equipment->id) }}">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                  <a class="btn btn-primary btn-sm" href="{{ route('equipment-items.edit', $equipment->id) }}">
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
                          <form method="POST" action="{{ route('equipment-items.destroy', $equipment->id) }}">
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
    {{-- group equipment table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection