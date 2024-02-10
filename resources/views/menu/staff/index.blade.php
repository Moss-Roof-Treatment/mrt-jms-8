@extends('layouts.jquery')

@section('title', 'Staff - View All Staff Members')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">STAFF</h3>
    <h5>View All Staff Members</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('main-menu.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Main Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('staff.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Staff Member
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- staff table --}}
    <h5 class="text-primary my-3"><b>All Staff</b></h5>
    @if (!$all_staff_members->count())
      <div class="card">
        <div class="card-body">
          <h5 class="text-center mb-0">Threre are no staff to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive mt-3">
        <table id="datatable" class="table table-bordered table-fullwidth table-striped bg-white" style="width:100%">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Business Name</th>
              <th>Last Login</th>
              <th>Login Status</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_staff_members as $user)
              <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->getFullNameAttribute() }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->business_name }}</td>
                <td>{!! $user->getLastLoginAttribute() !!}</td>
                <td>
                  <span class="badge badge-{{ $user->login_status->colour->brand }} py-2 px-2">
                    @if ($user->login_status_id == 1 )
                      <i class="fas fa-check mr-2" aria-hidden="true"></i>
                    @else
                      <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>
                    @endif
                    {{ $user->login_status->title }}
                  </span>
                </td>
                <td>
                  <a class="btn btn-primary btn-sm" href="{{ route('staff.show', $user->id) }}">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- staff table --}}

  </div> {{-- container py-5 --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- jquery datatables js --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function() {
    $('#datatable').DataTable({
      columnDefs: [
        {targets: 6, className: "text-nowrap", orderable: false, searchable: false},
      ],
      "info": true, {{-- Show the page info --}}
      "lengthChange": true, {{-- Show results length --}}
      "ordering": true, {{-- Allow ordering of all columns --}}
      "paging": true, {{-- Show pagination --}}
      "processing": true, {{-- Show processing message on long load time --}}
      "searching": true, {{-- Search for results --}}
    });
  });
</script>
{{-- jquery datatables js --}}
@endpush