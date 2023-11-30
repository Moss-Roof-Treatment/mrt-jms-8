<div class="btn-toolbar text-nowrap" role="toolbar" aria-label="Toolbar with button groups">
  <div class="btn-group btn-group-sm mr-2 mb-1" role="group" aria-label="First group">

    {{-- view button --}}
    <a href="{{ route('notes.show', $id) }}" class="btn btn-primary btn-sm">
      <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
    </a>
    {{-- view button --}}

  </div>
  @if ($jms_acknowledged_at == null)
    <div class="btn-group btn-group-sm mr-2 mb-1" role="group" aria-label="Second group">
      {{-- acknowledge button --}}
      <form action="{{ route('notes.update', $id) }}" method="POST">
        @method('PATCH')
        @csrf
        <button type="submit" class="btn btn-primary btn-sm">
          <i class="fas fa-check-circle mr-2" aria-hidden="true"></i>Ack
        </button>
      </form>
      {{-- acknowledge button --}}
    </div>
  @endif
  <div class="btn-group btn-group-sm mr-2 mb-1" role="group" aria-label="Third group">

    <form action="{{ route('notes-mark-as-recipient-read.update', $id) }}" method="POST">
      @method('PATCH')
      @csrf
      <button type="submit" class="btn btn-primary btn-sm">
        <i class="fas fa-marker mr-2" aria-hidden="true"></i>Mark as Read
      </button>
    </form>

  </div>
  <div class="btn-group btn-group-sm mr-2 mb-1" role="group" aria-label="Fourth group">

    {{-- reply button --}}
    <a href="{{ route('notes.show', $id) }}" class="btn btn-primary btn-sm">
      <i class="fas fa-reply mr-2" aria-hidden="true"></i>Reply
    </a>
    {{-- reply button --}}

  </div>
  <div class="btn-group btn-group-sm mr-2 mb-1" role="group" aria-label="Fifth group">

    {{-- trash button --}}
    {{-- trash modal --}}
    {{-- modal button --}}
    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#newTrashModal{{$id}}">
        <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Trash
    </button>
    {{-- modal button --}}
    {{-- modal --}}
    <div class="modal fade" id="newTrashModal{{$id}}" tabindex="-1" role="dialog" aria-labelledby="newTrashModal{{$id}}Title" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="newTrashModal{{$id}}Title">Confirm Trash</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p class="text-center">Are you sure that you would like to trash this note?</p>
            <form action="{{ route('notes.destroy', $id) }}" method="POST">
              @method('DELETE')
              @csrf
              <button type="submit" class="btn btn-danger btn-block">
                <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Confirm Trash
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
    {{-- modal --}}
    {{-- trash modal --}}
    {{-- trash button --}}

  </div>
</div>