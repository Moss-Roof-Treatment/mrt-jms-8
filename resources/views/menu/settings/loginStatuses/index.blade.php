@extends('layouts.app')

@section('title', '- Login Statuses - View All Login Statuses')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">LOGIN STATUSES</h3>
    <h5>View All Login Statuses</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a href="{{ route('login-statuses-settings.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Login Status
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <p class="text-primary my-3"><b>All Login Statuses</b></p>

    @if (!$all_login_statuses->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no job types to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white text-nowrap">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Count</th>
              <th>Description</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_login_statuses as $login_status)
              <tr>
                <td>
                  <a href="{{ route('login-statuses-settings.show', $login_status->id) }}">
                    {{ $login_status->id }}
                  </a>
                </td>
                <td>{{ $login_status->title }}</td>
                <td>{{ $login_status->users_count }}</td>
                <td>
                  @if ($login_status->description == null)
                    <span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>The description has not been set</span>
                  @else
                    {{ substr($login_status->description, 0, 80) }}{{ strlen($login_status->description) > 80 ? "..." : "" }}
                  @endif
                </td>
                <td class="text-center">
                  <a href="{{ route('login-statuses-settings.show', $login_status->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif

    {{ $all_login_statuses->links() }}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection