@if ($is_editable == 0)
  <a href="#" class="btn btn-primary btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">
    <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
  </a>
@else
  <a href="{{ route('postcode-settings.edit', $id) }}" class="btn btn-primary btn-sm">
    <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
  </a>
@endif
{{-- modal start --}}
@if ($is_delible == 0)
  <a href="#" class="btn btn-danger btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">
    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
  </a>
@else
  {{-- delete modal --}}
  {{-- modal button --}}
  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete-job-{{$id}}">
    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
  </button>
  {{-- modal button --}}
  {{-- modal --}}
  <div class="modal fade" id="confirm-delete-job-{{$id}}" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-job-{{$id}}-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirm-delete-job-{{$id}}-title">Delete</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p class="text-center">Are you sure that you would like to delete this item?</p>
          <form action="{{ route('postcode-settings.destroy', $id) }}" method="POST">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-danger btn-block">
              <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
            </button>
          </form>
        </div> {{-- modal-body --}}
      </div> {{-- modal-content --}}
    </div> {{-- modal-dialog --}}
  </div> {{-- modal fade --}}
  {{-- modal --}}
  {{-- delete modal --}}
@endif