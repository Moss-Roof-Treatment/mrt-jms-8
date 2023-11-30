@extends('layouts.jquery')

@section('title', '- Emails - View All Trashed Generic Emails')

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
    <h5>View All Trashed Generic Emails</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('generic-emails.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Generic Emails Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        {{-- permenent delete modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#permenentDeleteModal">
          <i class="fas fa-dumpster mr-2" aria-hidden="true"></i>Permanently Delete All
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="permenentDeleteModal" tabindex="-1" role="dialog" aria-labelledby="permenentDeleteModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="permenentDeleteModalTitle">Permanently Delete All</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center">Are you sure you would like to permanently delete all items?</p>
                <a class="btn btn-danger btn-block" href="{{ route('generic-emails-empty-trash.index') }}" >
                  <i class="fas fa-dumpster mr-2" aria-hidden="true"></i>Permanently Delete
                </a>
              </div>
            </div>
          </div>
        </div>
        {{-- modal --}}
        {{-- permenent delete modal --}}
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- trashed email table --}}
    <h5 class="text-primary my-3"><b>All Trashed Emails</b></h5>
    <div class="table-responsive text-nowrap py-2 px-2">
      <table class="table table-bordered table-fullwidth table-striped bg-white" id="datatable" style="width:100%">
        <thead class="table-secondary">
            <tr>
              <th>Recipient Name</th>
              <th>Email</th>
              <th>Sent Date</th>
              <th>Trashed Date</th>
              <th>Options</th>
            </tr>
        </thead>
      </table>
    </div> {{-- table-responsive --}}
    {{-- trashed email table --}}

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
    order: [[ 3, "desc" ]],
    columnDefs: [
      {"targets": 4, "className": "text-center text-nowrap"},
    ],
    ajax: '{{ route('generic-emails-trash-dt.create') }}',
    columns: [
      { data: 'recipient', name: 'recipient' },
      { data: 'recipient_email', name: 'recipient_email' },
      { data: 'created_at', name: 'created_at' },
      { data: 'deleted_at', name: 'deleted_at' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
  });
});
</script>
{{-- jquery datatables js --}}
@endpush