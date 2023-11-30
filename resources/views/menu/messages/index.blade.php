@extends('layouts.jquery')

@section('title', 'Messages - View All New Messages')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">MESSAGES</h3>
    <h5>View All New Messages</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('main-menu.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Main Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('messages.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Message
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('messages-archive.index') }}" class="btn btn-primary btn-block">
          <i class="fas fa-envelope-open mr-2" aria-hidden="true"></i>Seen Messages
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('messages-trash.index') }}" class="btn btn-danger btn-block">
          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>View Trash
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- messages table --}}
    <h5 class="text-primary my-3"><b>New Messages</b></h5>
    @if (!$new_messages->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body">
          <h5 class="text-center mb-0">Threre are no new messages to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive mt-3">
        <table id="datatable" class="table table-bordered table-fullwidth table-striped bg-white" style="width:100%">
          <thead class="table-secondary">
            <tr>
              <th>Sender</th>
              <th>Recipient</th>
              <th>Message</th>
              <th>Date</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($new_messages as $new_message)
              <tr>
                <td>{{ $new_message->sender->getFullNameAttribute() }}</td>
                <td>{{ $new_message->recipient->getFullNameAttribute() }}</td>
                <td>
                  {{ substr($new_message->text, 0, 40) }}{{ strlen($new_message->text) > 40 ? "..." : "" }}
                </td>
                <td>{{ date('d/m/y - h:iA', strtotime($new_message->created_at)) }}</td>
                <td>
                  <a href="{{ route('messages.show', $new_message->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                  {{-- delete modal --}}
                  {{-- modal button --}}
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{$new_message->id}}">
                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                  </button>
                  {{-- modal button --}}
                  {{-- modal --}}
                  <div class="modal fade" id="deleteModal{{$new_message->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{$new_message->id}}Title" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteModal{{$new_message->id}}Title">Delete</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>{{-- modal-header --}}
                        <div class="modal-body">
                          <p class="text-center">Are you sure that you would like to delete this item?</p>
                          <form method="POST" action="{{ route('messages.destroy', $new_message->id) }}">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-block">
                              <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                            </button>
                          </form>
                        </div>{{-- modal body --}}
                      </div>{{-- modal-content --}}
                    </div>{{-- modal-dialog --}}
                  </div>{{-- modal fade --}}
                  {{-- modal --}}
                  {{-- delete modal --}}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- messages table --}}

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
      order: [[ 3, "desc" ]],
      columnDefs: [
        {targets: 4, orderable: false, className: "text-center text-nowrap"},
      ],
    });
  });
</script>
{{-- jquery datatables js --}}
@endpush