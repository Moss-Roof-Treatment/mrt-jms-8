@extends('layouts.jquery')

@section('title', '- Tasks - View All Tasks')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">TASKS</h3>
    <h5>View All Tasks</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('task-settings.create') }}">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Task
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <p class="text-primary my-3"><b>All Tasks</b></p>
    {{-- task table --}}
    <div class="table-responsive text-nowrap py-2 px-2">
      <table class="table table-bordered table-fullwidth table-striped bg-white" id="datatable" style="width:100%">
        <thead class="table-secondary">
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Task Type</th>
            <th>Price</th>
            <th>Use Count</th>
            <th>Options</th>
          </tr>
        </thead>
      </table>
    </div> {{-- table-responsive --}}
    {{-- task table --}}

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
    processing: true,
    serverSide: true,
    order: [[ 0, "asc" ]],
    columnDefs: [
      {"targets": 5, "className": "text-center"},
    ],
    ajax: '{{ route('task-settings-dt.create') }}',
    columns: [
      { data: 'id', name: 'id' },
      { data: 'title', name: 'title' },
      { data: 'task_type', name: 'task_type' },
      { data: 'price', name: 'price' },
      { data: 'count', name: 'count' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
  });
});
</script>
{{-- jquery datatables js --}}
@endpush