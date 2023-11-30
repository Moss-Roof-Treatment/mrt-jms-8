@extends('layouts.jquery')

@section('title', '- Emails - View All Generic Emails')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">EMAILS</h3>
    <h5>View All Generic Emails</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('emails.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Emails Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('generic-emails.create') }}">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Email
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a class="btn btn-danger btn-block" href="{{ route('generic-emails-trash.index') }}">
          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>View Trash 
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- sent email table --}}
    <h5 class="text-primary my-3"><b>All Sent Emails</b></h5>
    <div class="table-responsive text-nowrap py-2 px-2">
      <table class="table table-bordered table-fullwidth table-striped bg-white" id="datatable" style="width:100%">
        <thead class="table-secondary">
            <tr>
              <th>Recipient Name</th>
              <th>Email</th>
              <th>Sent Date</th>
              <th>Options</th>
            </tr>
        </thead>
      </table>
    </div> {{-- table-responsive --}}
    {{-- sent email table --}}

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
    order: [[ 2, "desc" ]],
    columnDefs: [
      {"targets": 3, "className": "text-center text-nowrap"},
    ],
    ajax: '{{ route('generic-emails-dt.create') }}',
    columns: [
      { data: 'recipient', name: 'recipient' },
      { data: 'recipient_email', name: 'recipient_email' },
      { data: 'created_at', name: 'created_at' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
  });
});
</script>
{{-- jquery datatables js --}}
@endpush