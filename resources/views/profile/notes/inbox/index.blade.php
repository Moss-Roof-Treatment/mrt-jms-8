@extends('layouts.profileJquery')

@section('title', 'Profile - Staff - Notes')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">MY NOTES</h3>
    <h5>View My Inbox</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('profile.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Profile Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- new notes table --}}
    <h5 class="text-primary my-3"><b>All My New Notes</b></h5>
    <div class="table-responsive mt-3">
      <table class="table table-bordered table-fullwidth table-striped bg-white" id="datatable" style="width:100%">
        <thead class="table-secondary">
          <tr>
            <th>Job No</th>
            <th>Suburb</th>
            <th>Sender</th>
            <th>Created At</th>
            <th>Note</th>
            <th>Options</th>
          </tr>
        </thead>
      </table>
    </div> {{-- table-responsive --}}
    {{-- new notes table --}}

    {{-- acknowledged notes --}}
    <h5 class="text-primary my-3"><b>All Acknowledged Notes</b></h5>
    <div class="table-responsive mt-3">
      <table class="table table-bordered table-fullwidth table-striped bg-white" id="acknowledged-datatable" style="width:100%">
        <thead class="table-secondary">
          <tr>
            <th>Job No</th>
            <th>Suburb</th>
            <th>Sender</th>
            <th>Created At</th>
            <th>Note</th>
            <th>Options</th>
          </tr>
        </thead>
      </table>
    </div> {{-- table-responsive --}}
    {{-- acknowledged notes --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- jquery datatables js --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
  $('#datatable').DataTable({
    processing: true,
    serverSide: true,
    order: [[ 0, "desc" ]],
    columnDefs: [
      {targets: 0, className: "text-nowrap"},
      {targets: 1, className: "text-nowrap"},
      {targets: 2, className: "text-nowrap"},
      {targets: 3, className: "text-nowrap"},
      {targets: 5, orderable: false, className: "text-center text-nowrap"},
    ],
    ajax: '{{ route('profile-notes.create') }}',
    columns: [
      { data: 'id', name: 'id' },
      { data: 'suburb', name: 'suburb' },
      { data: 'sender_id', name: 'sender_id' },
      { data: 'created_at', name: 'created_at' },
      { data: 'text', name: 'text' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
  });
});
</script>
<script>
$(document).ready(function() {
  $('#acknowledged-datatable').DataTable({
    processing: true,
    serverSide: true,
    order: [[ 0, "desc" ]],
    columnDefs: [
      {targets: 0, className: "text-nowrap"},
      {targets: 1, className: "text-nowrap"},
      {targets: 2, className: "text-nowrap"},
      {targets: 3, className: "text-nowrap"},
      {targets: 5, orderable: false, className: "text-center text-nowrap"},
    ],
    ajax: '{{ route('profile-notes-acknowledged-dt.create') }}',
    columns: [
      { data: 'id', name: 'id' },
      { data: 'suburb', name: 'suburb' },
      { data: 'sender_id', name: 'sender_id' },
      { data: 'created_at', name: 'created_at' },
      { data: 'text', name: 'text' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
  });
});
</script>
{{-- jquery datatables js --}}
@endpush