@extends('layouts.app')

@section('title', '- Equipment - Notes - View Selected Equipment Note')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">EQUIPMENT</h3>
    <h5>View Selected Equipment Note</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('equipment.show', $note->equipment_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Equipment
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('equipment-notes.edit', $note->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit Note
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
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- note details table --}}
    <h5 class="text-primary my-3"><b>Note Details</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <thead class="table-secondary">
          <tr>
            <th>Name</th>
            <th>Priority</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $note->sender->getFullNameAttribute() }}</td>
            <td class="text-center">
              @if ($note->priority_id == null)
                <span class="badge badge-light py-2 px-2">
                  <i class="fas fa-times mr-2" aria-hidden="true"></i>None
                </span>
              @else
                <span class="badge badge-{{ $note->priority->colour->brand }} py-2 px-2">
                  <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>
                  {{ $note->priority->title . ' (' . $note->priority->resolution_amount . ' ' . $note->priority->resolution_period . ')' }}
                </span>
              @endif
            </td>
            <td>{{ date('d/m/y - h:iA', strtotime($note->created_at)) }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- note details table --}}

    <h5 class="text-primary my-3"><b>Note Comment</b></h5>
    <div class="card shadow-sm">
      <div class="card-body">
        {{ $note->text }}
      </div> {{-- card-body --}}
    </div> {{-- card --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection