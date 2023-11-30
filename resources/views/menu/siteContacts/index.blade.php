@extends('layouts.jquery')

@section('title', 'Site Contacts - View All Site Contacts')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SITE CONTACTS</h3>
    <h5>View All Site Contacts</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('main-menu.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Main Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('site-contacts-trashed.index') }}" class="btn btn-danger btn-block">
          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>View Trash
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- new site contacts table --}}
    <h5 class="text-primary my-3"><b>New Site Contacts</b></h5>
    <div class="table-responsive mt-3">
      <table id="new-datatable" class="table table-bordered table-fullwidth table-striped bg-white text-nowrap" style="width:100%">
        <thead class="table-secondary">
          <tr>
            <th>Sender Name</th>
            <th>Sender Email</th>
            <th>Date</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($new_site_contacts as $site_contact)
            <tr>
              <td>{{ $site_contact->name }}</td>
              <td>
                {{ substr($site_contact->text, 0, 40) }}{{ strlen($site_contact->text) > 40 ? "..." : "" }}
              </td>
              <td>{{ date('d/m/y - h:iA', strtotime($site_contact->created_at)) }}</td>
              <td class="text-center">
                <a href="{{ route('site-contacts.show', $site_contact->id) }}" class="btn btn-primary btn-sm">
                  <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                </a>
                {{-- delete modal --}}
                {{-- modal button --}}
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{$site_contact->id}}">
                  <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                </button>
                {{-- modal button --}}
                {{-- modal --}}
                <div class="modal fade" id="deleteModal{{$site_contact->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{$site_contact->id}}Title" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteModal{{$site_contact->id}}Title">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p class="text-center">Are you sure that you would like to delete this item?</p>
                        <form method="POST" action="{{ route('site-contacts.destroy', $site_contact->id) }}">
                          @method('DELETE')
                          @csrf
                          <button type="submit" class="btn btn-danger btn-block">
                            <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                {{-- modal --}}
                {{-- delete modal --}}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- new site contacts table --}}

    {{-- pending site contacts table --}}
    <h5 class="text-primary my-3"><b>Pending Site Contacts</b></h5>
    <div class="table-responsive mt-3">
      <table id="pending-datatable" class="table table-bordered table-fullwidth table-striped bg-white text-nowrap" style="width:100%">
        <thead class="table-secondary">
          <tr>
            <th>Sender Name</th>
            <th>Sender Email</th>
            <th>Message</th>
            <th>Date</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($seen_site_contacts as $site_contact)
            <tr>
              <td>{{ $site_contact->name }}</td>
              <td>{{ $site_contact->email }}</td>
              <td>
                {{ substr($site_contact->text, 0, 40) }}{{ strlen($site_contact->text) > 40 ? "..." : "" }}
              </td>
              <td>{{ date('d/m/y - h:iA', strtotime($site_contact->created_at)) }}</td>
              <td class="text-center">
                <a href="{{ route('site-contacts.show', $site_contact->id) }}" class="btn btn-primary btn-sm">
                  <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                </a>
                {{-- delete modal --}}
                {{-- modal button --}}
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{$site_contact->id}}">
                  <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                </button>
                {{-- modal button --}}
                {{-- modal --}}
                <div class="modal fade" id="deleteModal{{$site_contact->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{$site_contact->id}}Title" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteModal{{$site_contact->id}}Title">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p class="text-center">Are you sure that you would like to delete this item?</p>
                        <form method="POST" action="{{ route('site-contacts.destroy', $site_contact->id) }}">
                          @method('DELETE')
                          @csrf
                          <button type="submit" class="btn btn-danger btn-block">
                            <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                {{-- modal --}}
                {{-- delete modal --}}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- pending site contacts table --}}

    {{-- site contacts table --}}
    <h5 class="text-primary my-3"><b>Acknowledged Site Contacts</b></h5>
    <div class="table-responsive mt-3">
      <table id="old-datatable" class="table table-bordered table-fullwidth table-striped bg-white text-nowrap" style="width:100%">
        <thead class="table-secondary">
          <tr>
            <th>Sender Name</th>
            <th>Sender Email</th>
            <th>Message</th>
            <th>Date</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($acknowledged_site_contacts as $site_contact)
            <tr>
              <td>{{ $site_contact->name }}</td>
              <td>{{ $site_contact->email }}</td>
              <td>
                {{ substr($site_contact->text, 0, 40) }}{{ strlen($site_contact->text) > 40 ? "..." : "" }}
              </td>
              <td>{{ date('d/m/y - h:iA', strtotime($site_contact->created_at)) }}</td>
              <td class="text-center">
                <a href="{{ route('site-contacts.show', $site_contact->id) }}" class="btn btn-primary btn-sm">
                  <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                </a>
                {{-- delete modal --}}
                {{-- modal button --}}
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{$site_contact->id}}">
                  <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                </button>
                {{-- modal button --}}
                {{-- modal --}}
                <div class="modal fade" id="deleteModal{{$site_contact->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{$site_contact->id}}Title" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteModal{{$site_contact->id}}Title">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p class="text-center">Are you sure that you would like to delete this item?</p>
                        <form method="POST" action="{{ route('site-contacts.destroy', $site_contact->id) }}">
                          @method('DELETE')
                          @csrf
                          <button type="submit" class="btn btn-danger btn-block">
                            <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                {{-- modal --}}
                {{-- delete modal --}}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- site contacts table --}}

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
      "info": true, {{-- Show the page info --}}
      "lengthChange": true, {{-- Show results length --}}
      "ordering": true, {{-- Allow ordering of all columns --}}
      "paging": true, {{-- Show pagination --}}
      "processing": true, {{-- Show processing message on long load time --}}
      "searching": true, {{-- Search for results --}}
      order: [[ 0, "desc" ]],
      columnDefs: [
        {targets: 3, orderable: false, className: "text-center text-nowrap"},
      ],
    });
  });
</script>

<script>
  $(document).ready(function() {
    $('#pending-datatable').DataTable({
      "info": true, {{-- Show the page info --}}
      "lengthChange": true, {{-- Show results length --}}
      "ordering": true, {{-- Allow ordering of all columns --}}
      "paging": true, {{-- Show pagination --}}
      "processing": true, {{-- Show processing message on long load time --}}
      "searching": true, {{-- Search for results --}}
      order: [[ 0, "desc" ]],
      columnDefs: [
        {targets: 4, orderable: false, className: "text-center text-nowrap"},
      ],
    });
  });
</script>

<script>
  $(document).ready(function() {
    $('#old-datatable').DataTable({
      "info": true, {{-- Show the page info --}}
      "lengthChange": true, {{-- Show results length --}}
      "ordering": true, {{-- Allow ordering of all columns --}}
      "paging": true, {{-- Show pagination --}}
      "processing": true, {{-- Show processing message on long load time --}}
      "searching": true, {{-- Search for results --}}
      order: [[ 0, "desc" ]],
      columnDefs: [
        {targets: 4, orderable: false, className: "text-center text-nowrap"},
      ],
    });
  });
</script>
{{-- jquery datatables js --}}
@endpush