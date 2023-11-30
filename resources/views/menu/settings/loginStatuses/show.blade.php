@extends('layouts.app')

@section('title', '- Login Statuses - View Selected Login Status')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">LOGIN STATUSES</h3>
    <h5>View Selected Login Status</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('login-statuses-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Login Status Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        @if ($selected_login_status->is_editable == 0)
          <a href="#" class="btn btn-primary btn-block disabled" tabindex="-1" role="button" aria-disabled="true">
            <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
          </a>
        @else
          <a href="{{ route('login-statuses-settings.edit', $selected_login_status->id) }}" class="btn btn-primary btn-block">
            <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
          </a>
        @endif
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        @if ($selected_login_status->is_delible == 0)
          <a href="#" class="btn btn-danger btn-block disabled" tabindex="-1" role="button" aria-disabled="true">
            <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
          </a>
        @else
          {{-- modal start --}}
          <a class="button modal-btn btn-danger btn-block" data-target="confirm-delete-button">
            <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
          </a>
          <div class="modal" id="confirm-delete-button">
            <div class="modal-background"></div>
            <div class="modal-content">
              <div class="box">
                <p class="title text-center text-danger">Confirm Delete</p>
                <p class="subtitle text-center">Are you sure you would like to delete this item...?</p>
                <form method="POST" action="{{ route('login-statuses-settings.destroy', $selected_login_status->id) }}">
                  @method('DELETE')
                  @csrf
                  <button type="submit" class="btn btn-danger btn-block">
                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                  </button>
                </form>
              </div> {{-- box --}}
            </div> {{-- modal-content --}}
            <button class="modal-close is-large" aria-label="close"></button>
          </div> {{-- modal --}}
          {{-- modal start --}}
        @endif
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <p class="text-primary my-3"><b>Login Status Details</b></p>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white text-nowrap">
        <thead class="table-secondary">
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Edit Status</th>
            <th>Delete Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $selected_login_status->id }}</td>
            <td>{{ $selected_login_status->title }}</td>
            <td class="text-center">
              @if ($selected_login_status->is_editable == 0)
                <span class="badge badge-danger py-2 px-2">
                  <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Editable
                </span>
              @else
                <span class="badge badge-success py-2 px-2">
                  <i class="fas fa-check mr-2" aria-hidden="true"></i>Is Editable
                </span>
              @endif
            </td>
            <td class="text-center">
              @if ($selected_login_status->is_delible == 0)
                <span class="badge badge-danger py-2 px-2">
                  <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Delible
                </span>
              @else
                <span class="badge badge-success py-2 px-2">
                  <i class="fas fa-check mr-2" aria-hidden="true"></i>Is Delible
                </span>
              @endif
            </td>
          </tr>        
        </tbody>
      </table>
    </div> {{-- table-responsive --}}

    <p class="text-primary my-3"><b>Login Status Description</b></p>
    <div class="card">
      <div class="card-body">
        {{ $selected_login_status->description }}
      </div> {{-- card-body --}}
    </div> {{-- card --}}

    <p class="text-primary my-3"><b>Login Status Message</b></p>
    <div class="card">
      <div class="card-body">
        {{ $selected_login_status->message }}
      </div> {{-- card-body --}}
    </div> {{-- card --}}

    <p class="text-primary my-3"><b>Users With This Login Statuses</b></p>
    @if (!$selected_users->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no users with this login status to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Account Role</th>
              <th>Account Class</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($selected_users as $user)
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
                <td>{{ $user->account_role->title }}</td>
                <td>{{ $user->account_class->title }}</td>
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

    {{ $selected_users->links() }}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection