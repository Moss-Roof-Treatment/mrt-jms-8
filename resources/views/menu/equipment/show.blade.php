@extends('layouts.app')

@section('title', '- Equipment - View Selected Equipment')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">EQUIPMENT</h3>
    <h5>View Selected Equipment</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('equipment.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Equipment Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('equipment.edit', $equipment->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('equipment-inspections.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-clipboard-check mr-2" aria-hidden="true"></i>Inspections
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('equipment-notes.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-sticky-note mr-2" aria-hidden="true"></i>Notes
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('equipment-documents.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-file-alt mr-2" aria-hidden="true"></i>Documents
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        {{-- delete modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModal">
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
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-6">

        <h5 class="text-primary my-3"><b>Equipment Image</b></h5>
        @if ($equipment->image_path == null)  
          <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset('storage/images/placeholders/tools-256x256.jpg') }}">
        @else
          <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset($equipment->image_path) }}" alt="">
        @endif

        <h5 class="text-primary my-3"><b>Equipment Details</b></h5>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th width="30%">Title</th>
                <td>{{ $equipment->title }}</td>
              </tr>
              <tr>
                <th>Description</th>
                <td>
                  @if ($equipment->description == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>The equipment description has not been set
                    </span>
                  @else
                    {{ $equipment->description }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Serial Number</th>
                <td>
                  @if ($equipment->serial_number == null)
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>The serial number has not been set
                    </span>
                  @else
                    {{ $equipment->serial_number }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Category</th>
                <td>
                  @if ($equipment->equipment_category_id == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>The equipment category has not been set
                    </span>
                  @else
                    {{ $equipment->equipment_category->title }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Group</th>
                <td>
                  @if ($equipment->equipment_group_id == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>The equipment group has not been set
                    </span>
                  @else
                    {{ $equipment->equipment_group->title }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Tag & Test No</th>
                <td>
                  @if ($equipment->equipment_inspections->last() == null)
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>This equipment is untested
                    </span>
                  @else
                    {{ $equipment->equipment_inspections->last()->tag_and_test_id }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Last Inspection</th>
                <td>
                  @if ($equipment->equipment_inspections->last() == null)
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>This equipment is untested
                    </span>
                  @else
                    {{ date('d/m/y', strtotime($equipment->equipment_inspections->last()->inspection_date)) }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Next Inspection</th>
                <td>
                  @if ($equipment->equipment_inspections->last() == null)
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>This equipment is untested
                    </span>
                  @else
                    {{ date('d/m/y', strtotime($equipment->equipment_inspections->last()->next_inspection_date)) }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Inspection Count</th>
                <td>
                  @if ($equipment->equipment_inspections->last() == null)
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>This equipment is untested
                    </span>
                  @else
                    {{ $equipment->equipment_inspections->count() }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Owner</th>
                <td>
                  @if ($equipment->owner_id == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>The equipment owner has not been set
                    </span>
                  @else
                    {{ $equipment->owner->getFullNameAttribute() }}
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}

      </div> {{-- col-sm-6 --}}
      <div class="col-sm-6">

        <h5 class="text-primary my-3"><b>Safety & Training Manuals</b></h5>
        @if (!$equipment_documents->count())
          <div class="card shadow-sm mt-3">
            <div class="card-body text-center">
              <h5>No documents have been uploaded for this equipment</h5>
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @else
          <div class="table-responsive">
            <table class="table table-bordered table-fullwidth table-striped bg-white">
              <thead class="table-secondary">
                <tr>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($equipment_documents as $document)
                  <tr>
                    <td>
                      @if ($document->image_path == null)  
                        <img class="img-fluid shadow-sm" style="max-width:64px;" src="{{ asset('storage/images/placeholders/document-256x256.jpg') }}">
                      @else
                        <img class="img-fluid shadow-sm" style="max-width:64px;" src="{{ asset($document->image_path) }}">
                      @endif
                    </td>
                    <td>{{ $document->title }}</td>
                    <td class="text-center">
                      <a class="btn btn-primary btn-sm" href="{{ route('equipment-documents.show', $document->id) }}">
                        <i class="fas fa-eye" aria-hidden="true"></i>
                      </a>
                      <a class="btn btn-primary btn-sm" href="{{ route('equipment-documents.edit', $document->id) }}">
                        <i class="fas fa-edit" aria-hidden="true"></i>
                      </a>
                      <a class="btn btn-primary btn-sm" href="{{ route('equipment-documents-download.show', $document->id) }}">
                        <i class="fas fa-download" aria-hidden="true"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div> {{-- table-responsive --}}
        @endif

      </div> {{-- col-sm-6 --}}
    </div> {{-- row --}}

    {{-- notes table --}}
    <h5 class="text-primary my-3"><b>Equipment Notes</b></h5>
    @if (!$equipment_notes->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>No notes have been created for this equipment</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white text-nowrap">
          <thead class="table-secondary">
            <tr>
              <th>Created At</th>
              <th>Name</th>
              <th>Message</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($equipment_notes as $note)
              <tr>
                <td>{{ date('d/m/y', strtotime($note->created_at)) }}</td>
                <td>{{ $note->sender->getFullNameAttribute() }}</td>
                <td>
                  {{ substr($note->text, 0, 70) }}{{ strlen($note->text) > 70 ? "..." : "" }}
                </td>
                <td class="text-center">
                  <a class="btn btn-primary btn-sm" href="{{ route('equipment-notes.show', $note->id) }}">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                  <a class="btn btn-primary btn-sm" href="{{ route('equipment-notes.edit', $note->id) }}">
                    <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                  </a>
                  {{-- delete modal --}}
                  {{-- modal button --}}
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteNoteModal{{$note->id}}">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                  </button>
                  {{-- modal button --}}
                  {{-- modal --}}
                  <div class="modal fade" id="deleteNoteModal{{$note->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteNoteModal{{$note->id}}Title" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteNoteModal{{$note->id}}Title">Delete</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p class="text-center">Are you sure that you would like to delete this item?</p>
                          <form action="{{ route('equipment-notes.destroy', $note->id) }}" method="POST">
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
    {{-- notes table --}}

    {{-- inspections table --}}
    <h5 class="text-primary my-3"><b>Inspection Details</b></h5>
    @if (!$equipment_inspections->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>No inspections have been performed on this equipment</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white text-nowrap">
          <thead class="table-secondary">
            <tr>
              <th>Inspection Date</th>
              <th>Inspection Company</th>
              <th>Inspected By</th>
              <th>Tag and Test Number</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($equipment_inspections as $inspection)
              <tr>
                <td>{{ date('d/m/y', strtotime($inspection->created_at)) }}</td>
                <td>{{ $inspection->inspection_company }}</td>
                <td>{{ $inspection->inspector_name }}</td>
                <td>{{ $inspection->tag_and_test_id }}</td>
                <td class="text-center">
                  <a class="btn btn-primary btn-sm" href="{{ route('equipment-inspections.show', $inspection->id) }}">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                  <a class="btn btn-primary btn-sm" href="{{ route('equipment-inspections.edit', $inspection->id) }}">
                    <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                  </a>
                  {{-- delete modal --}}
                  {{-- modal button --}}
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteInspectionModal{{$inspection->id}}">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                  </button>
                  {{-- modal button --}}
                  {{-- modal --}}
                  <div class="modal fade" id="deleteInspectionModal{{$inspection->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteInspectionModal{{$inspection->id}}Title" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteInspectionModal{{$inspection->id}}Title">Delete</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p class="text-center">Are you sure that you would like to delete this item?</p>
                          <form action="{{ route('equipment-inspections.destroy', $inspection->id) }}" method="POST">
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
    {{-- inspections table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection