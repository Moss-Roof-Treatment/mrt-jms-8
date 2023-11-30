@extends('layouts.app')

@section('title', '- Account Roles - View Selected Account Role')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">ACCOUNT ROLES</h3>
    <h5>View Selected Account Role</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('account-roles.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Account Role Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <p class="text-primary my-3"><b>Users With This Account Role</b></p>
    @if (!$selected_role->users->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no users with this selected account role to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white text-nowrap">
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
              <td>{{ $user->id }}</td>
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