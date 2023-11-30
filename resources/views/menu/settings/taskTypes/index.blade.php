@extends('layouts.app')

@section('title', '- Task Types - View All Task Types')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">TASK TYPES</h3>
    <h5>View All Task Types</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('task-type-settings.create') }}">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Task Type
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <p class="text-primary my-3"><b>All Task Types</b></p>

    @if (!$all_task_types->count())
      <div class="card">
        <div class="card-body">
          <p class="text-center">There are tasks to display for this system.</p>
        </div>
      </div>
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Description</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_task_types as $task_type)
              <tr>
                <td>
                  <a href="{{ route('task-type-settings.show', $task_type->id) }}">
                    {{ $task_type->id }}
                  </a>
                </td>
                <td>{{ $task_type->title }}</td>
                <td>
                  {{ substr($task_type->description, 0, 80) }}{{ strlen($task_type->description) > 80 ? "..." : "" }}
                </td>
                <td class="text-center">
                  <a href="{{ route('task-type-settings.show', $task_type->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                  @if ($task_type->is_editable == 0)
                    <a href="#" class="btn btn-primary btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">
                      <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                    </a>
                  @else
                    <a href="{{ route('task-type-settings.edit', $task_type->id) }}" class="btn btn-primary btn-sm">
                      <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                    </a>
                  @endif
                  @if ($task_type->is_delible == 0)
                    <a href="#" class="btn btn-danger btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                    </a>
                  @else
                    {{-- delete modal --}}
                    {{-- modal button --}}
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete-button-{{ $task_type->id }}">
                        <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                    </button>
                    {{-- modal button --}}
                    {{-- modal --}}
                    <div class="modal fade" id="confirm-delete-button-{{ $task_type->id }}" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-button-{{ $task_type->id }}Title" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="confirm-delete-button-{{ $task_type->id }}Title">Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p class="subtitle text-center">Are you sure you would like to delete the selected item...?</p>
                            <form method="POST" action="{{ route('task-type-settings.destroy', $task_type->id) }}">
                              @method('DELETE')
                              @csrf
                              <button type="submit" class="btn btn-danger btn-block">
                                <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                              </button>
                            </form>
                          </div>{{-- modal-header --}}
                        </div>{{-- modal-content --}}
                      </div>{{-- modal-dialog --}}
                    </div>{{-- modal fade --}}
                    {{-- modal --}}
                    {{-- delete modal --}}
                  @endif
                </td>
              </tr> 
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif

    {{ $all_task_types->links() }}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection