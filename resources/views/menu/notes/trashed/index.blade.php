@extends('layouts.app')

@section('title', '- View All Trashed Notes')

@section('content')
<section>
  <div class="container-fluid py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">NOTES</h3>
    <h5>View All Trashed Notes</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-6 pt-3">
      <div class="col mb-3">
        <a class="btn btn-dark btn-block" href="{{ route('notes.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>View Notes Menu
        </a>
      </div> {{-- col mb-3 --}}
      <div class="col mb-3">

        {{-- permenent delete modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#permenentDeleteModal">
          <i class="fas fa-dumpster mr-2" aria-hidden="true"></i>Permanently Delete
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="permenentDeleteModal" tabindex="-1" role="dialog" aria-labelledby="permenentDeleteModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="permenentDeleteModalTitle">Permanently Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center">Are you sure you would like to permanently delete all item...?</p>
                <a class="btn btn-danger btn-block" href="{{ route('notes-empty-trash.index') }}">
                  <i class="fas fa-dumpster mr-2" aria-hidden="true"></i>Permanent Delete
                </a>
              </div>
            </div>
          </div>
        </div>
        {{-- modal --}}
        {{-- permenent delete modal --}}

      </div> {{-- col mb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

    <h5 class="text-primary my-3"><b>All Trashed Notes</b></h5>
    @if (!$deleted_notes->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no trashed notes to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}    
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white text-nowrap">
          <thead class="table-secondary">
            <tr>
              <th>Sender</th>
              <th>Recipient</th>
              <th>Creation Date</th>
              <th>Trashed Date</th>
              <th>Note</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($deleted_notes as $deleted_note)
              <tr>
                <td>
                  @if ($deleted_note->sender_id == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ $deleted_note->sender->getFullNameAttribute() }}
                  @endif
                </td>
                <td>
                  @if ($deleted_note->recipient_id == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ $deleted_note->recipient->getFullNameAttribute() }}
                  @endif
                </td>
                <td>{{ date('d/m/y h:iA', strtotime($deleted_note->created_at)) }}</td>
                <td>{{ date('d/m/y h:iA', strtotime($deleted_note->deleted_at)) }}</td>
                <td>
                  {{ substr($deleted_note->text, 0, 40) }}{{ strlen($deleted_note->text) > 40 ? "..." : "" }}
                </td>
                <td>
                  <div class="btn-toolbar text-nowrap" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group btn-group-sm mr-2 mb-1" role="group" aria-label="First group">

                      {{-- JOB NOTE BUTTONS --}}
                      <a href="{{ route('notes-trashed.show', $deleted_note->id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                      </a>

                    </div>
                    <div class="btn-group btn-group-sm mr-2 mb-1" role="group" aria-label="Second group">

                      <form action="{{ route('notes-trashed.update', $deleted_note->id) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm" name="note_type" value="job">
                          <i class="fas fa-trash-restore mr-2" aria-hidden="true"></i>Restore
                        </button>
                      </form>

                    </div>
                    <div class="btn-group btn-group-sm mr-2 mb-1" role="group" aria-label="Third group">

                      {{-- permanent delete modal --}}
                      {{-- modal button --}}
                      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#selected-trashed-note-{{$deleted_note->id}}">
                        <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                      </button>
                      {{-- modal button --}}
                      {{-- modal --}}
                      <div class="modal fade" id="selected-trashed-note-{{$deleted_note->id}}" tabindex="-1" role="dialog" aria-labelledby="selected-trashed-note-{{$deleted_note->id}}Title" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="selected-trashed-note-{{$deleted_note->id}}Title">Delete</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p class="text-center">Are you sure that you would like to permanently delete this item?</p>
                              <form action="{{ route('notes-trashed.destroy', $deleted_note->id) }}" method="POST">
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

                    </div> {{-- btn-group btn-group-sm mr-2 mb-1 --}}
                  </div> {{-- btn-toolbar text-nowrap --}}
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