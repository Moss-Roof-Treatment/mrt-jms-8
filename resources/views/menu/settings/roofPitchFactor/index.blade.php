@extends('layouts.jquery')

@section('title', '- Tasks - View All Tasks')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">ROOF PITCH FACTOR</h3>
    <h5>View All Roof Pitch Factors</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    {{-- task price range table --}}
    <h5 class="text-primary my-3"><b>All Roof Pitch Multiplication Factors</b></h5>
    @if (!$all_roof_pitch_multiply_factors->count())
      <div class="card">
        <div class="card-body">
          <h5 class="text-center mb-0">Threre are no task price ranges to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive mt-3 py-2 px-2">
        <table id="datatable" class="table table-bordered table-fullwidth table-striped bg-white" style="width:100%">
          <thead class="table-secondary">
            <tr>
              <th>Min</th>
              <th>Max</th>
              <th>Value</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_roof_pitch_multiply_factors as $roof_pitch_multiply_factor)
              <tr>
                <td>{{ $roof_pitch_multiply_factor->min }}&#176;</td>
                <td>{{ $roof_pitch_multiply_factor->max }}&#176;</td>
                <td>x {{ $roof_pitch_multiply_factor->value }}%</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- task price range table --}}

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
      order: [[ 0, "asc" ]],
      columnDefs: [
        {targets: 3, orderable: false, className: "text-center text-nowrap"},
      ],
    });
  });
</script>
{{-- jquery datatables js --}}
@endpush