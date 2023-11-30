@extends('layouts.jquery')

@section('title', '- Systems - View All Messages')

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
    <h5>View All Trashed Messages</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('messages.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Message Menu
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
                <a class="btn btn-danger btn-block" href="{{ route('messages-empty-trash.index') }}">
                  <i class="fas fa-dumpster mr-2" aria-hidden="true"></i>Permanent Delete
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

    {{-- messages table --}}
    <h5 class="text-primary my-3"><b>Trashed Messages</b></h5>
    @if (!$trashed_messages->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no trashed message to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <table id="datatable" class="table table-bordered table-fullwidth table-striped bg-white" style="width:100%">
        <thead class="table-secondary">
          <tr>
            <th>Sender</th>
            <th>Message</th>
            <th>Date</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($trashed_messages as $trashed_message)
            <tr>
              <td>{{ $trashed_message->sender->getFullNameAttribute() }}</td>
              <td>
                {{ substr($trashed_message->text, 0, 40) }}{{ strlen($trashed_message->text) > 40 ? "..." : "" }}
              </td>
              <td>{{ date('d/m/y h:iA', strtotime($trashed_message->created_at)) }}</td>
              <td>
                <a href="{{ route('messages-trash.show', $trashed_message->id) }}" class="btn btn-primary btn-sm">
                  <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                </a>
                {{-- permenent delete modal --}}
                {{-- modal button --}}
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#permenentDeleteModal{{$trashed_message->id}}">
                  <i class="fas fa-dumpster mr-2" aria-hidden="true"></i>Permanently Delete
                </button>
                {{-- modal button --}}
                {{-- modal --}}
                <div class="modal fade" id="permenentDeleteModal{{$trashed_message->id}}" tabindex="-1" role="dialog" aria-labelledby="permenentDeleteModal{{$trashed_message->id}}Title" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="permenentDeleteModal{{$trashed_message->id}}Title">Permanently Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p class="text-center">Are you sure you would like to permanently delete this items?</p>
                        <form method="POST" action="{{ route('messages-trash.destroy', $trashed_message->id) }}">
                          @method('DELETE')
                          @csrf
                          <button type="submit" class="btn btn-danger btn-block">
                            <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Permenent Delete
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                {{-- modal --}}
                {{-- permenent delete modal --}}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
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
      order: [[ 2, "desc" ]],
      columnDefs: [
        {targets: 3, orderable: false, className: "text-center text-nowrap"},
      ],
    });
  });
</script>
{{-- jquery datatables js --}}
@endpush