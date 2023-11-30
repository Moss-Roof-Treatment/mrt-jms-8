@extends('layouts.app')

@section('title', '- Systems - View Selected Job Note')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">NOTES</h3>
    <h5>View All Trashed Notes</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('notes-trashed.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Trashed Notes Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        @if ($selected_trashed_note->job_id != null)
          <a class="btn btn-primary btn-block" href="{{ route('jobs.show', $selected_trashed_note->job_id) }}">
            <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Job
          </a>
        @endif
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        {{-- permanent delete modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#selected-trashed-note-{{$selected_trashed_note->id}}">
          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="selected-trashed-note-{{$selected_trashed_note->id}}" tabindex="-1" role="dialog" aria-labelledby="selected-trashed-note-{{$selected_trashed_note->id}}Title" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="selected-trashed-note-{{$selected_trashed_note->id}}Title">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center">Are you sure that you would like to permanently delete this item?</p>
                <form action="{{ route('notes-trashed.destroy', $selected_trashed_note->id) }}" method="POST">
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
        {{-- permanent delete modal --}}
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- note details table --}}
    <h5 class="text-primary my-3"><b>Note Details</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <thead class="table-secondary">
          <th>Sender</th>
          <th>Recipient</th>
          <th>Priority</th>
          <th>Creation Date</th>
          <th>Deleted Date</th>
          <th>Type</th>
        </thead>
        <tbody>
          <td>
            @if ($selected_trashed_note->sender_id == null)
              <span class="badge badge-light py-2 px-2">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
              </span>
            @else
              {{ $selected_trashed_note->sender->getFullNameAttribute() }}
            @endif
          </td>
          <td>
            @if ($selected_trashed_note->recipient_id == null)
              <span class="badge badge-light py-2 px-2">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
              </span>
            @else
              {{ $selected_trashed_note->recipient->getFullNameAttribute() }}
              @if ($selected_trashed_note->recipient_seen_at == null)
                <div class="badge badge-danger py-2 px-2 ml-2">
                  <i class="fas fa-eye-slash" aria-hidden="true"></i>
                </div>
              @else
                <div class="badge badge-success py-2 px-2 ml-2">
                  <i class="fas fa-eye" aria-hidden="true"></i>
                </div>
              @endif
            @endif
          </td>
          <td>
            @if ($selected_trashed_note->priority_id == null)
              <span class="badge badge-light py-2 px-2">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
              </span>
            @else
              <span class="badge badge-{{ $selected_trashed_note->priority->colour->brand }} py-2 px-2">
                <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>
                {{ $selected_trashed_note->priority->title . ' (' . $selected_trashed_note->priority->resolution_amount . ' ' . $selected_trashed_note->priority->resolution_period . ')' }}
              </span>
            @endif
          </td>
          <td>{{ date('d/m/y h:iA', strtotime($selected_trashed_note->created_at)) }}</td>
          <td>{{ date('d/m/y h:iA', strtotime($selected_trashed_note->deleted_at)) }}</td>
          <td class="text-center">
            @if ($selected_trashed_note->is_internal == 0)
              <span class="badge badge-success py-2 px-2"><i class="fas fa-check mr-2" aria-hidden="true"></i>Customer</span>
            @else
              <span class="badge badge-danger py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>Internal</span>
            @endif
          </td>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- note details table --}}

    {{-- note message --}}
    <h5 class="text-primary my-3"><b>Message</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-fullwidth bg-white">
        <tbody>
          <tr>
            <td>{{ $selected_trashed_note->text }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- note message --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection