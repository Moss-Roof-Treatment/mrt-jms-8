@extends('layouts.jquery')

@section('title', '- Settings - All User Logins')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">USER LOGINS</h3>
    <h5>View All User Logins</h5>
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

    <p class="text-primary my-3"><b>All User Logins</b></p>

    @if (!$all_user_logins->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no User Logins to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table id="datatable" class="table table-bordered table-fullwidth table-striped bg-white" style="width:100%">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Account Role</th>
              <th>Date</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_user_logins as $user_login)  
              <tr>
                <td>
                  <a href="{{ route('user-login-settings.show', $user_login->id) }}">
                    {{ $user_login->id }}
                  </a>
                </td>
                <td>{{ $user_login->user->getFullNameAttribute() }}</td>
                <td>{{ $user_login->user->account_role->title }}</td>
                <td>{{ date('d/m/y - h:iA', strtotime($user_login->created_at)) }}</td>
                <td class="text-center">
                  <a href="{{ route('user-login-settings.show', $user_login->id) }}" class="btn btn-primary btn-sm">
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

@push('js')
{{-- jquery datatables js --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function() {
    $('#datatable').DataTable({
      "info": true, {{-- Show the page info --}}
      "lengthChange": true, {{-- Show results length --}}
      "ordering": true, {{-- Allow ordering of all columns --}}
      "paging": true, {{-- Show pagination --}}
      "processing": true, {{-- Show processing message on long load time --}}
      "searching": true, {{-- Search for results --}}
      order: [[ 0, "desc" ]],
      pageLength: 50,
      columnDefs: [
        {targets: 4, orderable: false, className: "text-center text-nowrap"},
      ],
    });
  });
</script>
{{-- jquery datatables js --}}
@endpush