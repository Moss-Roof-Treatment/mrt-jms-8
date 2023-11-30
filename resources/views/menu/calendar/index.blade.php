@extends('layouts.jquery')

@section('title', 'Calendar - System Calendar')

@push('css')
{{-- fullcalendar css --}}
<link rel="stylesheet" href="https://unpkg.com/@fullcalendar/core@4.3.1/main.min.css">
<link rel="stylesheet" href="https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.css">
<style>
  .fc-view-container {
    background-color: white;
  }
</style>
{{-- fullcalendar css --}}
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container-fluid py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">CALENDAR</h3>
    <h5>System Calendar</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-6 pt-3">
      <div class="col pb-3">
        <a href="{{ route('main-menu.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Main Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col mb-3">
        <a href="{{ route('calendar.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Event
        </a>
      </div> {{-- col mb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

    {{-- calendar search --}}
    <h5 class="text-primary my-3"><b>User Search</b></h5>
    <form action="{{ route('event-search.index') }}" method="GET">

      <div class="row row-cols-1 row-cols-sm-6 pt-3">
        <div class="col pb-3">
          <select name="staff_id" id="staff_id" class="custom-select @error('staff_id') is-invalid @enderror mb-2">
            <option selected disabled>Please select a user</option>
            @foreach ($staff_members as $staff)
              <option value="{{ $staff->id }}">{{ $staff->getFullNameTitleAttribute() }}</option>
            @endforeach
          </select>
          @error('staff_id')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div> {{-- col pb-3 --}}
        <div class="col pb-3">
          <button class="btn btn-primary btn-block" type="submit">
            <i class="fas fa-search mr-2" aria-hidden="true"></i>Search
          </button>
        </div> {{-- col pb-3 --}}
        <div class="col pb-3">
          <a href="{{ route('calendar.index') }}" class="btn btn-dark btn-block">
            <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
          </a>
        </div> {{-- col pb-3 --}}
      </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}

    </form>
    {{-- calendar search --}}

    {{-- calendar object --}}
    <div class="mt-4 mb-4" id="calendar"></div>
    {{-- calendar object --}}

    {{-- calendar job status colour key --}}
    <h5 class="text-primary my-3"><b>Job Colour Key Chart</b></h5>
    <div class="card">
      <div class="card-body">
        @if ($all_job_statuses == null)
          <h5 class="text-center">There are no system colour keys to display</h5>
        @else
          <div class="row row-cols-sm-6">
            @foreach ($all_job_statuses as $job_status)
              <div class="col-sm">
                <span class="icon" style="color:{{ $job_status->color }};">
                  <i class="fas fa-square-full mr-2 border border-dark"></i>
                </span>{{ $job_status->calendar_title }}
              </div> {{-- col --}}
            @endforeach
          </div> {{-- row row-cols-3 --}}
        @endif
      </div> {{-- card-body --}}
    </div> {{-- card --}}
    {{-- calendar job status colour key --}}

    {{-- calendar staff user colour key --}}
    <h5 class="text-primary my-3"><b>User Colour Key Chart</b></h5>
    <div class="card">
      <div class="card-body">
        @if ($staff_members == null)
          <h5 class="text-center">There are no system colour keys to display</h5>
        @else
          <div class="row row-cols-sm-6">
            @foreach ($staff_members as $staff_member)
              <div class="col-sm">
                <span class="icon" style="color:{{ $staff_member->user_color }};">
                  <i class="fas fa-square-full mr-2 border border-dark"></i>
                </span>{{ $staff_member->getFullNameTitleAttribute() }}
              </div> {{-- col --}}
            @endforeach
          </div> {{-- row row-cols-3 --}}
        @endif
      </div> {{-- card-body --}}
    </div> {{-- card --}}
    {{-- calendar staff user colour key --}}

    {{-- sold jobs table --}}
    <h5 class="text-primary my-3"><b>Sold Jobs</b></h5>
    <div class="table-responsive py-2 px-2">
      <table class="table table-bordered table-fullwidth table-striped bg-white" id="datatable" style="width:100%">
        <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Postcode</th>
              <th>Customer</th>
              <th>Job Status</th>
              <th>Sold Date</th>
              <th>Expected Payment Method</th>
              <th>Options</th>
            </tr>
        </thead>
      </table>
    </div> {{-- table-responsive --}}
    {{-- sold jobs table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- fullcalendar js --}}
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: ['dayGrid'],
      header: {
        left: 'title',
        center: '',
        right: 'today, prev,next'
      },
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
        var url = '{{ route("calendar.show", "id") }}';
        // Replace the id in the url variable with the event id.
        url = url.replace('id', eventObj.id);
        // Visit the url.
        window.location.href = url;
      },
      events: "{{ route('events.create') }}",
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
<script type="text/javascript" src="https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.js"></script>
{{-- fullcalendar js --}}

{{-- jquery datatables js --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
  $('#datatable').DataTable({
    processing: true,
    serverSide: true,
    order: [[ 0, "desc" ]],
    pageLength: 25,
    columnDefs: [
      {"targets": 3, "className": "text-nowrap"},
    ],
    ajax: '{{ route('calendar-dt.create') }}',
    columns: [
      { data: 'title', name: 'title' },
      { data: 'postcode', name: 'postcode' },
      { data: 'customer_id', name: 'customer_id' },
      { data: 'job_status_id', name: 'job_status_id' },
      { data: 'sold_date', name: 'sold_date' },
      { data: 'expected_payment_method_id', name: 'expected_payment_method_id', orderable: false, searchable: false },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
  });
});
</script>
{{-- jquery datatables js --}}
@endpush