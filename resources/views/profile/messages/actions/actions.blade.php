<div class="btn-group" role="group" aria-label="Basic example">
  <a href="{{ route('profile-messages.show', $id) }}" class="btn btn-primary btn-sm mr-1">
    <i class="fas fa-eye" aria-hidden="true"></i>
  </a>
  <form action="{{ route('profile-messages.update', $id) }}" method="POST">
    @method('PATCH')
    @csrf
    <button class="btn btn-primary btn-sm ml-1">
      <i class="fas fa-marker" aria-hidden="true"></i>                     
    </button>
  </form>
</div> {{-- btn-toolbar --}}