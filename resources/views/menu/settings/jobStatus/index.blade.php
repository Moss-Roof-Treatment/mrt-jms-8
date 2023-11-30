@extends('layouts.app')

@section('title', '- Job Status - View All Job Statuses')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">JOB STATUS</h3>
    <h5>View All Job Statuses</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a href="{{ route('job-status-settings.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Job Status
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <p class="text-primary my-3"><b>All Job Statuses</b></p>

    @if (!$job_statuses->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no job statuses to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Colour</th>
              <th>Description</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($job_statuses as $job_status)
              <tr>
                <td>{{ $job_status->id }}</td>
                <td>{{ $job_status->title }}</td>
                <td>
                  <span class="icon" style="color:{{ $job_status->color }};">
                    <i class="fas fa-square-full mr-2 border border-dark"></i>
                  </span>
                </td>
                <td>
                  @if ($job_status->description == null)
                    <span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>The description has not been set</span>
                  @else
                    {{ substr($job_status->description, 0, 50) }}{{ strlen($job_status->description) > 50 ? "..." : "" }}
                  @endif
                </td>
                <td class="text-center">
                  @if ($job_status->is_editable == 0)
                    <a href="#" class="btn btn-primary btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">
                      <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                    </a>
                  @else
                    <a href="{{ route('job-status-settings.edit', $job_status->id) }}" class="btn btn-primary btn-sm">
                      <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                    </a>
                  @endif
                  @if ($job_status->is_delible == 0)
                    <a href="#" class="btn btn-danger btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                    </a>
                  @else
                    {{-- delete modal --}}
                    {{-- modal button --}}
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{$job_status->id}}">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                    </button>
                    {{-- modal button --}}
                    {{-- modal --}}
                    <div class="modal fade" id="deleteModal{{$job_status->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{$job_status->id}}Title" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteModal{{$job_status->id}}Title">Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p class="text-center">Are you sure that you would like to delete this item?</p>
                            <form method="POST" action="{{ route('job-status-settings.destroy', $job_status->id) }}">
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
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif

    {{ $job_statuses->links() }}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection