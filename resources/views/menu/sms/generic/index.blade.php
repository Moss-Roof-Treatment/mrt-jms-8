@extends('layouts.jquery')

@section('title', 'SMS - Generic SMS - View All Generic SMS')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">Generic SMS</h3>
    <h5>View All Sent Generic SMS</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col mb-3">
        <a href="{{ route('sms.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>SMS Menu
        </a>
      </div> {{-- col mb-3 --}}
      <div class="col pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('generic-sms.create') }}">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New SMS
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

    {{-- sent sms table --}}
    <h5 class="text-primary my-3"><b>All Sent Generic SMS</b></h5>
    <div class="table-responsive text-nowrap py-2 px-2">
      <table class="table table-bordered table-fullwidth table-striped bg-white" id="datatable" style="width:100%">
        <thead class="table-secondary">
            <tr>
              <th>Job ID</th>
              <th>Recipient Name</th>
              <th>Phone Number</th>
              <th>Sent Date</th>
              <th>Options</th>
            </tr>
        </thead>
      </table>
    </div> {{-- table-responsive --}}
    {{-- sent sms table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- jquery datatables --}}
{{-- datatables js --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
{{-- datatables js --}}
{{-- datatables bootstrap js --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
{{-- datatables bootstrap js --}}
{{-- generic sms datatable configuration --}}
<script>
$(document).ready(function() {
  $('#datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route('generic-sms-dt.create') }}',
    columns: [
      {data: 'job_id', name: 'job_id'},
      {data: 'recipient_name', name: 'recipient_name'},
      {data: 'mobile_phone', name: 'mobile_phone'},
      {data: 'created_at', name: 'created_at'},
      {data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false}
    ],
  });
});
</script>
{{-- generic sms datatable configuration --}}
{{-- jquery datatables --}}
@endpush