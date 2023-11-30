@extends('layouts.app')

@section('title', '- Account Roles - All User Account Roles')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">ACCOUNT ROLES</h3>
    <h5>All User Account Roles</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <p class="text-primary my-3"><b>All Account Roles</b></p>

    @if (!$all_account_roles->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no account roles to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white text-nowrap">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Description</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_account_roles as $account_role)
              <tr>
                <td>
                  <a href="{{ route('account-roles.show', $account_role->id) }}">
                    {{ $account_role->id }}
                  </a>
                </td>
                <td>{{ $account_role->title }}</td>
                <td>{{ $account_role->description }}</td>
                <td class="text-center">
                  <a href="{{ route('account-roles.show', $account_role->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
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