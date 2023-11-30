{{-- view button --}}
<a href="{{ route('generic-emails.show', $id) }}" class="btn btn-primary btn-sm">
  <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
</a>
{{-- view button --}}

{{-- delete modal --}}
{{-- modal button --}}
<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#trashModal{{$id}}">
    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Trash
</button>
{{-- modal button --}}
{{-- modal --}}
<div class="modal fade" id="trashModal{{$id}}" tabindex="-1" role="dialog" aria-labelledby="trashModal{{$id}}Title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="trashModal{{$id}}Title">Trash</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-center">Are you sure that you would like to trash this item?</p>
        <form method="POST" action="{{ route('generic-emails.destroy', $id) }}">
          @method('DELETE')
          @csrf
          <button type="submit" class="btn btn-danger btn-block">
            <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Trash
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
{{-- modal --}}
{{-- delete modal --}}