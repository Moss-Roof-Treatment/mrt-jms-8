@extends('layouts.app')

@section('title', '- Priorities - View All Priorities')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">PRIORITIES</h3>
    <h5>View All Priorities</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a href="{{ route('priority-settings.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Priority
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <p class="text-primary my-3"><b>All Priorities</b></p>

    @if (!$all_priorities->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no priorities to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Priority Colour</th>
              <th>Resolution Amount</th>
              <th>Resolution Period</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_priorities as $priority)
              <tr>
                <td>{{ $priority->id }}</td>
                <td>{{ $priority->title }}</td>
                <td><i class="fas fa-square-full mr-2 border border-dark" style="color:{{ $priority->colour->colour }};"></i>{{ $priority->colour->colour }}</td>
                <td>{{ $priority->resolution_amount != null ? $priority->resolution_amount : 'None' }}</td>
                <td>{{ $priority->resolution_period != null ? $priority->resolution_period : 'None' }}</td>
                <td class="text-center">
                  @if ($priority->is_editable == 0)
                    <a href="#" class="btn btn-primary btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">
                      <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                    </a>
                  @else
                    <a href="{{ route('priority-settings.edit', $priority->id) }}" class="btn btn-primary btn-sm">
                      <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                    </a>
                  @endif
                  {{-- modal start --}}
                  @if ($priority->is_delible == 0)
                    <a href="#" class="btn btn-danger btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                    </a>
                  @else
                    {{-- delete modal --}}
                    {{-- modal button --}}
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete-job">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                    </button>
                    {{-- modal button --}}
                    {{-- modal --}}
                    <div class="modal fade" id="confirm-delete-job" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-job-title" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="confirm-delete-job-title">Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p class="text-center">Are you sure that you would like to delete this item?</p>
                            <form action="{{ route('priority-settings.destroy', $priority->id) }}" method="POST">
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
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif

    {{ $all_priorities->links() }}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection