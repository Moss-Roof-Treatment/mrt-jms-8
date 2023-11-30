<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    @auth
      @if (auth()->user()->account_role_id >= 3)
        <a class="navbar-brand" href="{{ route('profile.index') }}">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i><b>Moss Roof Treatment</b>
        </a>
      @else
        <a class="navbar-brand" href="{{ route('main-menu.index') }}">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i><b>Moss Roof Treatment</b>
        </a>
      @endif
    @endauth
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        @guest
            <li class="nav-item {{ Request::is('login') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
        @else
          @if (auth()->user()->account_role_id == 1 || auth()->user()->account_role_id == 2)
            @if (!Request::is('/'))
              <li class="nav-item">
                <form class="form-inline my-2 my-lg-0" action="{{ route('menu.job.search') }}" method="POST">
                  @csrf
                  <div class="input-group">
                    <input type="text" class="form-control" name="job_id" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-secondary mr-sm-2" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </form>
              </li>
            @endif
          @endif
          @if (!$notification_count == 0)
            <a href="{{ route('profile.index') }}" class="nav-item">
              <span class="badge badge-danger px-2 py-2 mt-1 mr-2">
                <i class="fa fa-bell mr-1"></i>{{ $notification_count }}
              </span>
            </a>
          @endif
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-cog mr-2" aria-hidden="true"></i>{{ auth()->user()->getFullNameAttribute() }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="{{ route('profile.index') }}">
                <i class="fas fa-id-card-alt mr-2" aria-hidden="true"></i>Profile
              </a>
              <a class="dropdown-item" href="{{ route('profile-jobs.index') }}">
                <i class="fas fa-tools mr-2" aria-hidden="true"></i>Jobs
              </a>
              <a class="dropdown-item" href="{{ route('profile-calendar.index') }}">
                <i class="fas fa-calendar mr-2" aria-hidden="true"></i>Calendar
              </a>
              <a class="dropdown-item" href="{{ route('profile-notes.index') }}">
                <i class="fas fa-sticky-note mr-2" aria-hidden="true"></i>Notes
              </a>
              <a class="dropdown-item" href="{{ route('profile-invoices.index') }}">
                <i class="fas fa-file-alt mr-2" aria-hidden="true"></i>Invoices
              </a>
              <a class="dropdown-item" href="{{ route('profile-messages.index') }}">
                <i class="fas fa-envelope mr-2" aria-hidden="true"></i>Messages
              </a>
              <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt mr-2" aria-hidden="true"></i>Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </li>
        @endguest
      </ul>
    </div> {{-- collapse navbar-collapse --}}
  </div> {{-- container --}}
</nav>