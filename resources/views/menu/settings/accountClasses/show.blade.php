@extends('layouts.app')

@section('title', '- Account Classes - View Selected Account Class')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">ACCOUNT CLASSES</h3>
    <h5>View Selected Account Class</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('account-classes.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Account Class Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        @if ($selected_account_class->is_editable == 0)
          <a href="#" class="btn btn-primary btn-block disabled" tabindex="-1" role="button" aria-disabled="true">
            <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
          </a>
        @else
          <a href="{{ route('account-classes.edit', $selected_account_class->id) }}" class="btn btn-primary btn-block">
            <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
          </a>
        @endif
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        @if ($selected_account_class->is_delible == 0)
          <a href="#" class="btn btn-danger btn-block disabled" tabindex="-1" role="button" aria-disabled="true">
            <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
          </a>
        @else
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
                </div> {{-- modal-header --}}
                <div class="modal-body">
                  <p class="text-center">Are you sure that you would like to delete this item?</p>
                  <form action="{{ route('account-classes.destroy', $selected_account_class->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger btn-block">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                    </button>
                  </form>
                </div> {{-- modal-body --}}
              </div> {{-- modal-content --}}
            </div> {{-- modal-dialog modal-dialog-centered --}}
          </div> {{-- modal fade --}}
          {{-- modal --}}
          {{-- delete modal --}}
        @endif
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <p class="text-primary my-3"><b>Account Class Details</b></p>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <thead class="table-secondary">
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $selected_account_class->id }}</td>
            <td>{{ $selected_account_class->title }}</td>
            <td>{{ $selected_account_class->description }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}

    <p class="text-primary my-3"><b>Users With This Account Class</b></p>
    @if (!$selected_account_class->users->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no users with this account class to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Account Class</th>
              <th>Account Role</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($selected_account_class->users as $user)
              <tr>
                <td>
                  @if ($user->account_role->id == 1)
                    <a href="{{ route('staff.show', $user->id) }}">
                  @elseif ($user->account_role->id == 2)
                    <a href="{{ route('tradespersons.show', $user->id) }}">
                  @elseif ($user->account_role->id == 3)
                    <a href="{{ route('contractors.show', $user->id) }}">
                  @else
                    <a href="{{ route('customers.show', $user->id) }}">
                  @endif
                    {{ $user->id }}
                  </a>  
                </td>
                <td>{{ $user->getFullNameAttribute() }}</td>
                <td>{{ $user->account_class->title }}</td>
                <td>{{ $user->account_role->title }}</td>
                <td class="text-center">
                  @if ($user->account_role->id == 1 || $user->account_role->id == 2)
                    <a href="{{ route('staff.show', $user->id) }}" class="btn btn-primary btn-sm">
                      <i class="fas fa-eye mr-2" aria-hidden="true"></i>View User
                    </a>
                  @elseif ($user->account_role->id == 3)
                    <a href="{{ route('tradespersons.show', $user->id) }}" class="btn btn-primary btn-sm">
                      <i class="fas fa-eye mr-2" aria-hidden="true"></i>View User
                    </a>
                  @elseif ($user->account_role->id == 4)
                    <a href="{{ route('contractors.show', $user->id) }}" class="btn btn-primary btn-sm">
                      <i class="fas fa-eye mr-2" aria-hidden="true"></i>View User
                    </a>
                  @else
                    <a href="{{ route('customers.show', $user->id) }}" class="btn btn-primary btn-sm">
                      <i class="fas fa-eye mr-2" aria-hidden="true"></i>View User
                    </a>
                  @endif
                </td>
              </tr> 
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection