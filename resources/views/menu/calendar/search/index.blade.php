@extends('layouts.jquery')

@section('title', '- Calendar - System Calendar Results')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container-fluid py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">CALENDAR</h3>
    <h5>System Calendar Results</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-6 pt-3">
      <div class="col mb-3">
        <a href="{{ route('main-menu.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Main Menu
        </a>
      </div> {{-- col mb-3 --}}
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
            @if ($selected_staff_member != null)
              <option selected value="{{ $selected_staff_member->id }}">{{ $selected_staff_member->account_class->title . ' - ' . $selected_staff_member->getFullNameAttribute() }}</option>
              <option disabled>Please Select A Staff Member</option>
            @else
              <option selected disabled>Please Select A Staff Member</option>
            @endif
            @foreach ($all_staff_members as $staff)
              <option value="{{ $staff->id }}" @if ($staff->id == $selected_staff_member->id) hidden @endif>{{ $staff->account_class->title . ' - ' . $staff->getFullNameAttribute() }}</option>
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

    {{-- event search results --}}
    <h5 class="text-primary my-3"><b>User Search Results</b></h5>
    <div class="table-responsive mt-3">
      <table id="datatable" class="table table-bordered table-fullwidth table-striped bg-white" style="width:100%">
        <thead class="table-secondary">
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Start</th>
            <th>End</th>
            <th>Colour</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($events as $event)
            <tr>
              <td>{{ $event->id }}</td>
              <td>{{ $event->title }}</td>
              <td>{{ date('d/m/y - h:iA', strtotime($event->start)) }}</td>
              <td>{{ date('d/m/y - h:iA', strtotime($event->end)) }}</td>
              <td class="text-center">
                <span class="badge py-2 px-2" style="background-color:{{ $event->color }}; color:{{ $event->textColor }};">
                  <i class="fas fa-palette mr-2" aria-hidden="true"></i>{{ $event->color }}
                </span>
              </td>
              <td class="text-center">
                <a href="{{ route('calendar.show', $event->id) }}" class="btn btn-primary btn-sm">
                  <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    {{-- event search results --}}

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
      order: [[ 0, "desc" ]],
      columnDefs: [
        {targets: 5, orderable: false, className: "text-center text-nowrap"},
      ],
    });
  });
</script>
{{-- jquery datatables js --}}
@endpush