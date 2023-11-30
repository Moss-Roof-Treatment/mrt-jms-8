@extends('layouts.app')

@section('title', '- Emails - View All Email User Groups')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">EMAIL USER GROUPS</h3>
    <h5>View All Email User Groups</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('email-recipient-groups.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Email User Group Menu
        </a>
      </div> {{-- col --}}
      <div class="col">
        {{-- delete modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModal">
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
                <form action="{{ route('email-recipient-groups.destroy', $selected_group->id) }}" method="POST">
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
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <h5 class="text-primary my-3"><b>User Group Details</b></h5>

    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <thead class="table-secondary">
          <tr>
            <th>Title</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $selected_group->title }}</td>
            <td>{{ $selected_group->description }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}

    {{-- user group recipients table --}}
    <h5 class="text-primary my-3"><b>User Recipients</b></h5>
    @if ($users == null)
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no users to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>Customer ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($users as $user)
              <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->getFullNameAttribute() }}</td>
                <td>{{ $user->email }}</td>
                <td class="text-center">
                  {{-- remove modal --}}
                  {{-- modal button --}}
                  <button type="button" class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#removeModal{{$user->id}}">
                    <i class="fas fa-user-slash mr-2" aria-hidden="true"></i>Remove
                  </button>
                  {{-- modal button --}}
                  {{-- modal --}}
                  <div class="modal fade" id="removeModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="removeModal{{$user->id}}Title" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="removeModal{{$user->id}}Title">Delete</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p class="text-center">Are you sure that you would like to delete this item?</p>
                          <form action="{{ route('email-recipient-groups.update', $selected_group->id) }}" method="POST">
                            @method('PATCH')
                            @csrf
                            <input type="hidden" name="selected_user" value="{{ $user->id }}">
                            <button type="submit" class="btn btn-danger btn-block">
                              <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                            </button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  {{-- modal --}}
                  {{-- remove modal --}}
                </td>
              </tr>
            @empty
              <tr>
                <td class="text-center" colspan="4">There are no items to display</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- user group recipients table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection