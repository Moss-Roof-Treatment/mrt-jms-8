{{-- view button --}}
<a href="{{ route('account-classes.show', $id) }}" class="btn btn-primary btn-sm">
  <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
</a>
{{-- view button --}}

{{-- edit button --}}
@if ($is_editable == 0)
  <a href="#" class="btn btn-primary btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">
    <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
  </a>
@else
  <a href="{{ route('account-classes.edit', $id) }}" class="btn btn-primary btn-sm">
    <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
  </a>
@endif
{{-- edit button --}}

{{-- delete button --}}
@if ($is_delible == 0)
  <a href="#" class="btn btn-danger btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">
    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
  </a>
@else
  {{-- delete modal --}}
  {{-- modal button --}}
  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#newTrashModal{{$id}}">
    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
  </button>
  {{-- modal button --}}
  {{-- modal --}}
  <div class="modal fade" id="newTrashModal{{$id}}" tabindex="-1" role="dialog" aria-labelledby="newTrashModal{{$id}}Title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newTrashModal{{$id}}Title">Delete</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p class="text-center">Are you sure that you would like to delete this item?</p>
          <form action="{{ route('account-classes.destroy', $id) }}" method="POST">
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
  {{-- delete button --}}
@endif
{{-- delete button --}}