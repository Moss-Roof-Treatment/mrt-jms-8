@extends('layouts.app')

@section('title', '- Tasks - View All Task')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">TASKS</h3>
    <h5>View Selected Task</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('task-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Tasks Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('task-settings.edit', $selected_task->id) }}">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        @if ($selected_task->is_delible == 0)
          <a href="#" class="btn btn-danger btn-block disabled" tabindex="-1" role="button" aria-disabled="true">
            <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
          </a>
        @else
          <form method="POST" action="{{ route('task-settings.destroy', $selected_task->id) }}">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-danger btn-block">
              <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
            </button>
          </form>
        @endif
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-6">

        <p class="text-primary my-3"><b>Task Image</b></p>
        @if ($selected_task->image_path == null)
          <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset('storage/images/placeholders/task-256x256.jpg') }}">
        @else
          ​<picture>
            <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset($selected_task->image_path) }}">
          ​</picture>
        @endif

      </div> {{-- col-sm-6 --}}
      <div class="col-sm-6">

        <p class="text-primary my-3"><b>Task Details</b></p>
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <tbody>
            <tr>
              <th>ID</th>
              <td>{{ $selected_task->id }}</td>
            </tr>
            <tr>
              <th>Title</th>
              <td>{{ $selected_task->title }}</td>
            </tr>
            <tr>
              <th>Task Type</th>
              <td>{{ $selected_task->task_type->title }}</td>
            </tr>
            <tr>
              <th>Price</th>
              <td>${{ number_format(($selected_task->price / 100), 2, '.', ',') }}</td>
            </tr>
            <tr>
              <th>Editing Status</th>
              <td>
                @if ($selected_task->is_editable == 0)
                  <span class="badge badge-danger py-2 px-2">
                    <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Editable
                  </span>
                @else
                  <span class="badge badge-success py-2 px-2">
                    <i class="fas fa-check mr-2" aria-hidden="true"></i>Is Editable
                  </span>
                @endif
              </td>
            </tr>
            <tr>
              <th>Deleting Status</th>
              <td>
                @if ($selected_task->is_delible == 0)
                  <span class="badge badge-danger py-2 px-2">
                    <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Deletable
                  </span>
                @else
                  <span class="badge badge-success py-2 px-2">
                    <i class="fas fa-check mr-2" aria-hidden="true"></i>Is Deletable
                  </span>
                @endif
              </td>
            </tr>
            <tr>
              <th>Quote Visibility Status</th>
              <td>
                @if ($selected_task->is_quote_visible == 0)
                  <span class="badge badge-danger py-2 px-2">
                    <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Quote Visible
                  </span>
                @else
                  <span class="badge badge-success py-2 px-2">
                    <i class="fas fa-check mr-2" aria-hidden="true"></i>Is Quote Visible
                  </span>
                @endif
              </td>
            </tr>
            <tr>
              <th>Selectable Status</th>
              <td>
                @if ($selected_task->is_selectable == 0)
                  <span class="badge badge-danger py-2 px-2">
                    <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Selectable
                  </span>
                @else
                  <span class="badge badge-success py-2 px-2">
                    <i class="fas fa-check mr-2" aria-hidden="true"></i>Is Selectable
                  </span>
                @endif
              </td>
            </tr>
            <tr>
              <th>Product Usage Status</th>
              <td>
                @if ($selected_task->uses_product == 0)
                  <span class="badge badge-danger py-2 px-2">
                    <i class="fas fa-times mr-2" aria-hidden="true"></i>Does Not Use Product
                  </span>
                @else
                  <span class="badge badge-success py-2 px-2">
                    <i class="fas fa-check mr-2" aria-hidden="true"></i>Does Use Product
                  </span>
                @endif
              </td>
            </tr>
          </tbody>
        </table>

      </div> {{-- col-sm-6 --}}
    </div> {{-- row --}}

    {{-- task description --}}
    <p class="text-primary my-3"><b>Task Description</b></p>
    <div class="card">
      <div class="card-body">
        {{ $selected_task->description }}
      </div> {{-- card-body --}}
    </div> {{-- card --}}
    {{-- task description --}}

    {{-- task procedure --}}
    <p class="text-primary my-3"><b>Task Procedure</b></p>
    <div class="card">
      <div class="card-body">
        {{ $selected_task->procedure }}
      </div> {{-- card-body --}}
    </div> {{-- card --}}
    {{-- task procedure --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection