@extends('layouts.app')

@section('title', '- Task Types - View All Task Type')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">TASK TYPES</h3>
    <h5>View Selected Task Type</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('task-type-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Task Types Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('task-type-settings.edit', $selected_task_type->id) }}">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-6">

        <p class="text-primary my-3"><b>Task Type Image</b></p>

        @if ($selected_task_type->image_path == null)
          <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset('storage/images/placeholders/task-256x256.jpg') }}">
        @else
          <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset($selected_task_type->image_path) }}">
        @endif

      </div> {{-- col-sm-6 --}}
      <div class="col-sm-6">

        <p class="text-primary my-3"><b>Task Type Details</b></p>

        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>ID</th>
                <td>{{ $selected_task_type->id }}</td>
              </tr>
              <tr>
                <th>Title</th>
                <td>{{ $selected_task_type->title }}</td>
              </tr>
              <tr>
                <th>Task Count</th>
                <td>{{ $selected_task_type->tasks->count() }}</td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}

      </div> {{-- col-sm-6 --}}
    </div> {{-- row --}}

    {{-- DESCRIPTION --}}

    <p class="text-primary my-3"><b>Task Type Description</b></p>
    <div class="card shadow-sm mt-3">
      <div class="card-body">
        {{ $selected_task_type->description }}
      </div> {{-- card-body --}}
    </div> {{-- card --}}

    {{-- DESCRIPTION --}}

    {{-- TASKS --}}

    <p class="text-primary my-3"><b>Tasks</b></p>
    @if (!$all_tasks->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no tasks with this task type</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Default Price</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_tasks as $task)
              <tr>
                <td>
                  <a href="{{ route('task-settings.show', $task->id) }}">
                    {{ $task->id }}
                  </a>
                </td>
                <td>{{ $task->title }}</td>
                <td>${{ number_format(($task->price / 100), 2, '.', ',') }}</td>
                <td class="text-center">
                  <a href="{{ route('task-settings.show', $task->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif

    {{-- TASKS --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection