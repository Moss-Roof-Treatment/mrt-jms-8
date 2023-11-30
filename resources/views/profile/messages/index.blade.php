@extends('layouts.profileJquery')

@section('title', '- Profile')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">MY MESSAGES</h3>
    <h5>View My Messages</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('profile.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Profile Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('profile-messages.create') }}">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Message
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        {{-- permenent delete modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-dark btn-block" data-toggle="modal" data-target="#permenentDeleteModal">
          <i class="fas fa-marker mr-2" aria-hidden="true"></i>Mark All As Read
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="permenentDeleteModal" tabindex="-1" role="dialog" aria-labelledby="permenentDeleteModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="permenentDeleteModalTitle">Mark All As Read</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center">Are you sure you would like to mark all items as read?</p>
                <form action="{{ route('profile-messages-read-all.update', auth()->id()) }}" method="POST">
                  @method('PATCH')
                  @csrf
                  <button type="submit" class="btn btn-dark btn-block">
                    <i class="fas fa-marker mr-2" aria-hidden="true"></i>Mark All As Read
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
        {{-- modal --}}
        {{-- permenent delete modal --}}
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- new message table --}}
    <h5 class="text-primary my-3"><b>All My New Messages</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white" id="new-datatable" style="width:100%">
        <thead class="table-secondary">
          <tr>
            <th>Sender</th>
            <th>Message</th>
            <th>Created At</th>
            <th>Options</th>
          </tr>
        </thead>
      </table>
    </div> {{-- table-responsive --}}
    {{-- new message table --}}

    {{-- seen message table --}}
    <div class="custom-control custom-checkbox my-3">
      <input type="checkbox" class="custom-control-input" id="completed-visibility-checkbox" onclick="toggle_visibility('seen-messages-visibility-div');">
      <label class="custom-control-label text-primary" for="completed-visibility-checkbox">
      <h5><b>All My Seen Messages</b></h5>
      </label>
    </div>
    <div id="seen-messages-visibility-div" style="display:none;">

      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white text-nowrap" id="seen-datatable" style="width:100%">
          <thead class="table-secondary">
            <tr>
              <th>Sender</th>
              <th>Message</th>
              <th>Created At</th>
              <th>Options</th>
            </tr>
          </thead>
        </table>
      </div> {{-- table-responsive --}}

    </div> {{-- seen-messages-visibility-div --}}
    {{-- seen message table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- jquery datatables js --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
  $('#new-datatable').DataTable({
    processing: true,
    serverSide: true,
    order: [[ 0, "desc" ]],
    columnDefs: [
      {targets: 3, orderable: false, className: "text-center text-nowrap"},
    ],
    ajax: '{{ route('profile-messages-dt.create') }}',
    columns: [
      { data: 'sender_id', name: 'sender_id' },
      { data: 'text', name: 'text' },
      { data: 'created_at', name: 'created_at' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
  });
});
</script>
<script>
$(document).ready(function() {
  $('#seen-datatable').DataTable({
    processing: true,
    serverSide: true,
    order: [[ 0, "desc" ]],
    columnDefs: [
      {targets: 3, orderable: false, className: "text-center text-nowrap"},
    ],
    ajax: '{{ route('profile-messages-sent-dt.create') }}',
    columns: [
      { data: 'sender_id', name: 'sender_id' },
      { data: 'text', name: 'text' },
      { data: 'created_at', name: 'created_at' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
  });
});
</script>
{{-- jquery datatables js --}}

{{-- Toggle Visibility By Id Generic --}}
<script type="text/javascript">
  function toggle_visibility(id) {
    var e = document.getElementById(id);
    if (e.style.display == 'none')
      e.style.display = 'block';
    else
      e.style.display = 'none';
  }
</script>
{{-- Toggle Visibility By Id Generic --}}
@endpush