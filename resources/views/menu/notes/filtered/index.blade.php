@extends('layouts.jquery')

@section('title', '- Jobs - View Filtered Jobs')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container-fluid py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">NOTES</h3>
    <h5>View All Filtered Notes</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-6 pt-3">
      <div class="col mb-3">
        <a href="{{ route('notes.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Notes Menu
        </a>
      </div> {{-- col mb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

    {{-- filter jobs --}}
    <h5 class="text-primary my-3"><b>Filter Notes</b></h5>
    <div class="row">
      <div class="col-sm-2">

        <form action="{{ route('notes-filter.index') }}" method="POST">
          @csrf

          <div class="input-group">
            <select name="account_role_id" class="custom-select" required>
              <option disabled value="">Please select an account role</option>
              @foreach ($all_account_roles as $account_role)
                <option value="{{ $account_role->id }}" @if ($selected_option == $account_role->id) selected @endif>{{ $account_role->title }}</option>
              @endforeach
            </select>
            <div class="input-group-append">
              <button class="btn btn-primary" type="submit">
                <i class="fas fa-search" aria-hidden="true"></i>
              </button>
            </div> {{-- input-group-append --}}
          </div> {{-- input-group --}}

        </form>

      </div> {{-- col-sm-4 --}}
    </div> {{-- row --}}
    {{-- filter jobs --}}

    {{-- notes table --}}
    <h5 class="text-primary my-3"><b>New Notes</b></h5>
    <div class="table-responsive py-2 px-2">
      <table class="table table-bordered table-fullwidth table-striped bg-white" id="datatable" style="width:100%">
        <thead class="table-secondary">
            <tr>
              <th>Job Number</th>
              <th>Sender</th>
              <th>Date</th>
              <th width="50%">Note</th>
              <th width="20%">Options</th>
            </tr>
        </thead>
      </table>
    </div> {{-- table-responsive --}}
    {{-- notes table --}}

    {{-- pending notes table --}}
    <h5 class="text-primary my-3"><b>Pending Action Notes</b></h5>
    <div class="table-responsive py-2 px-2">
      <table class="table table-bordered table-fullwidth table-striped bg-white" id="pending-notes-datatable" style="width:100%">
        <thead class="table-secondary">
          <tr>
            <th>Job Number</th>
            <th>Sender</th>
            <th>Date</th>
            <th width="50%">Note</th>
            <th width="20%">Options</th>
          </tr>
        </thead>
      </table>
    </div> {{-- table-responsive --}}
    {{-- pending notes table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- jquery datatables js --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
{{-- new notes datatable configuration --}}
<script>
$(document).ready(function() {
  $('#datatable').DataTable({
    processing: true,
    serverSide: true,
    order: [[ 0, "desc" ]],
    columnDefs: [
      {"targets": 0, "className": "text-center text-nowrap"},
      {"targets": 4, "className": "text-center text-nowrap"},
    ],
    ajax: '{{ route('notes-filter-new-dt.create') }}',
    columns: [
      { data: 'job_id', name: 'job_id' },
      { data: 'sender_id', name: 'sender_id' },
      { data: 'created_at', name: 'created_at' },
      { data: 'text', name: 'text' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
  });
});
</script>
{{-- new notes datatable configuration --}}
{{-- pending notes datatable configuration --}}
<script>
$(document).ready(function() {
  $('#pending-notes-datatable').DataTable({
    processing: true,
    serverSide: true,
    order: [[ 0, "desc" ]],
    columnDefs: [
      {"targets": 0, "className": "text-center text-nowrap"},
      {"targets": 4, "className": "text-center text-nowrap"},
    ],
    ajax: '{{ route('notes-filter-pending-dt.create') }}',
    columns: [
      { data: 'job_id', name: 'job_id' },
      { data: 'sender_id', name: 'sender_id' },
      { data: 'created_at', name: 'created_at' },
      { data: 'text', name: 'text' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
  });
});
</script>
{{-- pending notes datatable configuration --}}
{{-- jquery datatables js --}}
@endpush