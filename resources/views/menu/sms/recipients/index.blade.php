@extends('layouts.app')

@section('title', '- SMS - SMS Recipient Group - View All SMS Recipient Groups')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SMS RECIPIENT GROUPS</h3>
    <h5>View All SMS Recipient Groups</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('sms.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>SMS Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('sms-recipient-groups.create') }}">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Group
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- sms recipient groups table --}}
    <h5 class="text-primary my-3"><b>All Recipient User Groups</b></h5>
    @if (!$user_groups->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no sms recipient groups to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
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
            @foreach ($user_groups as $user_group)
              <tr>
                <td>{{ $user_group->id }}</td>
                <td>
                  {{ substr($user_group->title, 0, 50) }}{{ strlen($user_group->title) > 50 ? "..." : "" }}
                </td>
                <td>
                  {{ substr($user_group->description, 0, 80) }}{{ strlen($user_group->description) > 80 ? "..." : "" }}
                </td>
                <td class="text-center">
                  <a href="{{ route('sms-recipient-groups.show', $user_group->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>

                  {{-- delete modal --}}
                  {{-- modal button --}}
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">
                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                  </button>
                  {{-- modal button --}}
                  {{-- modal --}}
                  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteModalTitle">Delete</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p class="text-center">Are you sure that you would like to delete this item?</p>
                          <form action="{{ route('sms-recipient-groups.destroy', $user_group->id) }}" method="POST">
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

                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- sms recipient groups table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection