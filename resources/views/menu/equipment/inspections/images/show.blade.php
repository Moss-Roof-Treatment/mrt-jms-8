@extends('layouts.app')

@section('title', '- Equipment - Inspection - View Selected Inspection Image')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">EQUIPMENT</h3>
    <h5>View Selected Equipment Inspection Image</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('equipment-items.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Equipment Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('equipment-items.show', $selected_inspection_image->equipment_inspection->equipment->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Equipment
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('equipment-inspections.show', $selected_inspection_image->equipment_inspection_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Inspection
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('equipment-inspection-images.edit', $selected_inspection_image->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit Details
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        {{-- modal start --}}
        <a class="btn btn-danger btn-block modal-button" data-target="confirm-delete-note-button">
          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
        </a>
        <div class="modal" id="confirm-delete-note-button">
          <div class="modal-background"></div>
          <div class="modal-content">
            <div class="box">
              <p class="title text-center text-danger">Confirm Delete</p>
              <p class="subtitle text-center">Are you sure you would like to delete the selected note image...?</p>
              <form action="{{ route('equipment-inspection-images.destroy', $selected_inspection_image->id) }}" method="POST">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger btn-block">
                  <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                </button>
              </form>
            </div> {{-- box --}}
          </div> {{-- modal-content --}}
          <button class="modal-close is-large" aria-label="close"></button>
        </div> {{-- modal --}}
        {{-- modal end --}}

      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-6">

        <h5 class="text-primary my-3"><b>Inspection Image</b></h5>

        @if ($selected_inspection_image->image_path == null)
          <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset('storage/images/placeholders/tools-256x256.jpg') }}" alt="">
        @else
          <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset($selected_inspection_image->image_path) }}" alt="">
        @endif

      </div> {{-- col-sm-6 --}}
      <div class="col-sm-6">

        <h5 class="text-primary my-3"><b>Inspection Details</b></h5>

        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <tbody>
            <tr>
              <th>Equipment ID</th>
              <td>{{ $selected_inspection_image->equipment_inspection->equipment->id }}</td>
            </tr>
            <tr>
              <th>Inspection ID</th>
              <td>{{ $selected_inspection_image->equipment_inspection_id }}</td>
            </tr>
            <tr>
              <th>Storage Location</th>
              <td>{{ $selected_inspection_image->image_path }}</td>
            </tr>
            <tr>
              <th>Upload Date</th>
              <td>{{ date('d/m/y', strtotime($selected_inspection_image->created_at)) }}</td>
            </tr>
          </tbody>
        </table>

        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <tbody>
            <tr>
              <th>Description</th>
            </tr>
            <tr>
              <td>
                @if ($selected_inspection_image->description == null)
                  <span class="badge badge-light py-2 px-2">
                    <i class="fas fa-times mr-2" aria-hidden="true"></i>No description has been entered
                  </span>
                @else
                  {{ $selected_inspection_image->description }}
                @endif
              </td>
            </tr>
          </tbody>
        </table>

      </div> {{-- col-sm-6 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection