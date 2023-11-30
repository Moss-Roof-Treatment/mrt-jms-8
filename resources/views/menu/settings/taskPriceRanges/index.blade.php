@extends('layouts.jquery')

@section('title', '- Task Price Ranges - View All Task Price Ranges')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">TASK PRICE RANGE</h3>
    <h5>View All Task Price Ranges</h5>
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

    {{-- double storey surcharge --}}
    <h5 class="text-primary my-3"><b>Double Storey Surcharge</b></h5>
    <div class="row pb-3">
      <div class="col-sm-4">
        <form action="{{ route('double-storey-surcharge-settings.update', 1) }}" method="POST">
          @method('PATCH')
          @csrf
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">$</span>
            </div> {{-- input-group-prepend --}}
            <input type="text" class="form-control" name="surcharge" value="{{ old('surcharge', number_format(($double_storey_surcharge->price / 100), 2, '.', ',')) }}">
            <div class="input-group-append">
              <button class="btn btn-primary btn-sm" type="submit">
                <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
              </button>
            </div> {{-- input-group-append --}}
          </div> {{-- input-group --}}
        </form>
      </div>
    </div>
    {{-- double storey surcharge --}}

    {{-- task price range table --}}
    <h5 class="text-primary my-3"><b>All Task Price Ranges</b></h5>
    @if (!$all_task_price_range->count())
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
              <th>Price</th>
              <th width="20%">Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_task_price_range as $task_price_range)
              <tr>
                <td>{{ $task_price_range->min }}</td>
                <td>{{ $task_price_range->max }}</td>
                <td>${{ number_format(($task_price_range->price / 100), 2, '.', ',') }}</td>
                <td>
                  <form action="{{ route('task-price-range-settings.update', $task_price_range->id) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                      </div> {{-- input-group-prepend --}}
                      <input type="text" class="form-control" name="price">
                      <div class="input-group-append">
                        <button class="btn btn-primary btn-sm" type="submit">
                          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                        </button>
                      </div> {{-- input-group-append --}}
                    </div> {{-- input-group --}}
                  </form>
                </td>
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