@extends('layouts.app')

@section('title', '- User Logins - View Selected User Login')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">USER LOGINS</h3>
    <h5>View Selected User Login</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('user-login-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>User Login Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <p class="text-primary my-3"><b>User Details</b></p>

    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <thead class="table-secondary">
          <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Account Class</th>
            <th>Account Role</th>
            <th>Time</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $selected_user_login->user_id }}</td>
            <td>{{ $selected_user_login->user->getFullNameAttribute() }}</td>
            <td>{{ $selected_user_login->user->account_class->title }}</td>
            <td>{{ $selected_user_login->user->account_role->title }}</td>
            <td>{{ date('d/m/y - h:iA', strtotime($selected_user_login->created_at)) }}</td>
          </tr>        
        </tbody>
      </table>
    </div> {{-- table-responsive --}}

    <p class="text-primary my-3"><b>Device Details</b></p>

    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <thead class="table-secondary">
          <tr>
            <th>IP Address</th>
            <th>User Agent</th>
            <th>URL</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $selected_user_login->ip_address }}</td>
            <td>{{ $selected_user_login->user_agent }}</td>
            <td>{{ $selected_user_login->referrer }}</td>
          </tr>        
        </tbody>
      </table>
    </div> {{-- table-responsive --}}

    <p class="text-primary my-3"><b>Previous User Logins</b></p>

    @if ($all_selected_user_logins->count() <= 1)
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no previous user logins to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>IP Adress</th>
              <th>User Agent</th>
              <th>URL</th>
              <th>Time</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_selected_user_logins as $user_login)
              @if ($selected_user_login->id != $user_login->id)
                <tr>
                  <td>{{ $user_login->ip_address }}</td>
                  <td>{{ $user_login->user_agent }}</td>
                  <td>{{ $user_login->referrer }}</td>
                  <td>{{ date('d/m/y - h:iA', strtotime($user_login->created_at)) }}</td>
                </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection