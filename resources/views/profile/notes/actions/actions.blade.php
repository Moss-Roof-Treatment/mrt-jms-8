<div class="btn-group" role="group" aria-label="Basic example">
  <a href="{{ route('profile-notes.show', $id) }}" class="btn btn-primary btn-sm mr-1">
    <i class="fas fa-eye" aria-hidden="true"></i>
  </a>
  @if ($recipient_id != auth()->id())
    <button type="button" class="btn btn-sm btn-primary ml-1" disabled><i class="fas fa-marker" aria-hidden="true"></i></button>
  @elseif ($recipient_id == auth()->id() && $sender_id == auth()->id())
    <button type="button" class="btn btn-sm btn-primary ml-1" disabled><i class="fas fa-marker" aria-hidden="true"></i></button>
  @else
  <form action="{{ route('profile-note-mark-as-read.update', $id) }}" method="POST">
    @method('PATCH')
    @csrf
    <button type="submit" class="btn btn-primary btn-sm ml-1">
      <i class="fas fa-marker" aria-hidden="true"></i>   
    </button>
  </form>
  @endif
</div> {{-- btn-toolbar --}}