@extends('layouts.profileJquery')

@section('title', 'Profile - Staff - Calendar')

@push('css')
  <link rel="stylesheet" href="https://unpkg.com/@fullcalendar/core@4.3.1/main.min.css">
  <link rel="stylesheet" href="https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.css">
  <link rel="stylesheet" href="https://unpkg.com/@fullcalendar/timegrid@4.3.0/main.min.css">
  <link rel="stylesheet" href="https://unpkg.com/@fullcalendar/list@4.3.0/main.min.css">
  <style>
    .fc-view-container {
      background-color: white;
    }
  </style>
  {{-- jquery datatables css --}}
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
  {{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container-fluid py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">MY CALENDAR</h3>
    <h5>View All Events</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-6 pt-3">
      <div class="col pb-3">
        <a href="{{ route('profile.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Profile Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('profile-events.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Event
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

    {{-- calendar object --}}
    <div class="mt-4 mb-4" id="calendar">
    </div> {{-- calendar --}}
    {{-- calendar object --}}

    {{-- calendar colour key --}}
    <h5 class="text-primary my-3"><b>Colour Key Chart</b></h5>
    <div class="card">
      <div class="card-body">

        <div class="row row-cols-sm-5">
          <div class="col-sm">
            <span class="icon" style="color:{{ $selected_job_statuses[0]->color }};">
              <i class="fas fa-square-full mr-2 border border-dark"></i>
            </span>{{ $selected_job_statuses[0]->title }}
          </div>
          <div class="col-sm">
            <span class="icon" style="color:{{ $selected_job_statuses[1]->color }};">
              <i class="fas fa-square-full mr-2 border border-dark"></i>
            </span>{{ $selected_job_statuses[1]->title }}
          </div>
          <div class="col-sm">
            <span class="icon" style="color:{{ $selected_job_statuses[2]->color }};">
              <i class="fas fa-square-full mr-2 border border-dark"></i>
            </span>{{ $selected_job_statuses[2]->title }}
          </div>
          <div class="col-sm">
            <span class="icon" style="color:{{ $selected_job_statuses[3]->color }};">
              <i class="fas fa-square-full mr-2 border border-dark"></i>
            </span>{{ $selected_job_statuses[3]->title }}
          </div>
          <div class="col-sm">
            <span class="icon" style="color:{{ $selected_job_statuses[4]->color }};">
              <i class="fas fa-square-full mr-2 border border-dark"></i>
            </span>{{ $selected_job_statuses[4]->title }}
          </div>
          <div class="col-sm">
            <span class="icon" style="color:{{ auth()->user()->user_color }};">
              <i class="fas fa-square-full mr-2 border border-dark"></i>
            </span>{{ auth()->user()->getFullNameAttribute() }}
          </div>
        </div>

      </div> {{-- card-body --}}
    </div> {{-- card --}}
    {{-- calendar colour key --}}

    <h5 class="text-primary my-3"><b>Jobs To Do</b></h5>
    <div class="table-responsive py-2 px-2">
      <table class="table table-bordered table-fullwidth table-striped bg-white" id="datatable" style="width:100%">
        <thead class="table-secondary">
          <th>ID</th>
          <th>Postcode</th>
          <th>Customer</th>
          <th>Quote Status</th>
          <th>Sold Date</th>
          <th>Expected Payment Method</th>
          <th>Options</th>
        </thead>
      </table>
    </div> {{-- table-responsive --}}
    {{-- sold jobs table --}}


  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- full calendar js --}}
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
      header: {
        left: 'title',
        center: '',
        right: 'today, prev,next'
      },
      height: 800,
      locale: 'en-au', // English - Australia.
      navLinks: true, // Display navigation links.
      eventTimeFormat: { // Format of the time displayed on events.
        hour: 'numeric',
        minute: '2-digit',
        hour12: true,
        meridiem: true
      },
      eventClick: function(info){
        // Set the event object as a variable.
        var eventObj = info.event;
        // Set the route url as a variable.
        var url = '{{ route("profile-events.show", "id") }}';
        // Replace the id in the url variable with the event id.
        url = url.replace('id', eventObj.id);
        // Visit the url.
        window.location.href = url;
      },
      events: "{{ route('profile-calendar.create') }}",
      eventRender: function (info) {
        if (info.event.extendedProps.image_paths != null) {
          info.el.querySelector('.fc-title').innerHTML = info.event.title + ' ' + info.event.extendedProps.image_paths;
        }
      }
    });
    objCalendar = calendar;
    calendar.render();
  });
</script>
<script type="text/javascript" src="https://unpkg.com/@fullcalendar/core@4.3.1/main.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/@fullcalendar/interaction@4.3.0/main.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/@fullcalendar/timegrid@4.3.0/main.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/@fullcalendar/list@4.3.0/main.min.js"></script>
{{-- full calendar js --}}

{{-- jquery datatables js --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
  $('#datatable').DataTable({
    processing: true,
    serverSide: true,
    order: [[ 0, "desc" ]],
    pageLength: 10,
    columnDefs: [
      {"targets": 4, "className": "text-nowrap"},
      {"targets": 5, "className": "text-nowrap"},
      {"targets": 6, "className": "text-center text-nowrap"},
    ],
    ajax: '{{ route('profile-pending-jobs-dt.create') }}',
    columns: [
      { data: 'id', name: 'id' },
      { data: 'tenant_postcode', name: 'tenant_postcode' },
      { data: 'tenant_name', name: 'tenant_name' },
      { data: 'quote_status', name: 'quote_status' },
      { data: 'sold_date', name: 'sold_date' },
      { data: 'expected_payment_method', name: 'expected_payment_method' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
  });
});
</script>
{{-- jquery datatables js --}}
@endpush