@extends('layouts.jquery')

@section('title', '- Invoices - View Confirmed Outstanding Invoice Items')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container-fluid py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">INVOICES</h3>
    <h5>View Confirmed Outstanding Invoice Items</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-6 pt-3">
      <div class="col mb-3">
        <a class="btn btn-dark btn-block" href="{{ route('invoices-outstanding.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Invoice Menu
        </a>
      </div> {{-- col mb-3 --}}
      <div class="col pb-3">
        <a href="{{ route($selected_user->account_role->route_title, $selected_user->id) }}" class="btn btn-primary btn-block">
            <i class="fas fa-user mr-2" aria-hidden="true"></i>View {{ $selected_user->account_role->title }}
        </a>
      </div> {{-- col pb-3 --}}
      @if ($selected_user->getOutstandingConfirmedInvoiceModels()->isNotEmpty())
        <div class="col mb-3">
          {{-- confirm modal --}}
          {{-- modal button --}}
          <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#confirmMarkAsPaidModal">
              <i class="fas fa-check mr-2" aria-hidden="true"></i>Mark All As Paid
          </button>
          {{-- modal button --}}
          {{-- modal --}}
          <div class="modal fade" id="confirmMarkAsPaidModal" tabindex="-1" role="dialog" aria-labelledby="confirmMarkAsPaidModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="confirmMarkAsPaidModalTitle">Mark All As Paid</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p class="text-center">Please enter the payment confirmation number and date</p>
                  <form action="{{ route('invoices-group.update', $selected_user->id) }}" method="POST">
                    @method('PATCH')
                    @csrf

                    <input type="text" class="form-control my-3" name="confirmation_number" placeholder="Please enter the payment confirmation number">

                    @if($selected_user->has_payg == 1)
                      <input type="text" class="form-control my-3" name="payg" placeholder="Please enter the pay as you go tax amount">
                    @endif

                    <input type="date" class="form-control my-3" name="confirmation_date">

                    <button type="submit" class="btn btn-success btn-block">
                      <i class="fas fa-check mr-2" aria-hidden="true"></i>Mark As Paid
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          {{-- modal --}}
          {{-- confirm modal --}}
        </div> {{-- col mb-3 --}}
      @endif
      <div class="col mb-3">
        <a href="{{ route('invoices-group.create', ['selected_user_id' => $selected_user->id]) }}" class="btn btn-dark btn-block">
          <i class="fas fa-download mr-2" aria-hidden="true"></i>Download PDF
        </a>
      </div> {{-- col mb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

    {{-- content --}}

    {{-- outstanding invoices table --}}
    <h5 class="text-primary my-3"><b>All Outstanding Invoice Items</b></h5>
    <table id="datatable" class="table table-bordered table-fullwidth table-striped" style="width:100%">
      <thead class="table-secondary">
        <tr>
          <th>Identifier</th>
          <th>Job ID</th>
          <th>Completed Date</th>
          <th>Start Time</th>
          <th>End Time</th>
          <th>Hours On Job</th>
          <th>Billable Hours</th>
          <th>Pay Rate</th>
          <th>Total</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($selected_user->getOutstandingConfirmedInvoiceModels() as $invoices)
          @foreach ($invoices->invoice_items as $item)
            <tr>
              <td><a href="{{ route('invoices-outstanding.show', $item->invoice_id) }}" target="_blank">{{ $item->invoice->identifier }}</a></td>
              <td>{{ $item->job_id }}</td>
              <td>
                @if($item->completed_date == null)
                  <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
                @else
                  {{ date('d/m/y', strtotime($item->completed_date)) }}
                @endif
              </td>
              <td>
                @if($item->start_time == null)
                  <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
                @else
                  {{ date('h:iA', strtotime($item->start_time)) }}
                @endif
              </td>
              <td>
                @if($item->end_time == null)
                  <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
                @else
                  {{ date('h:iA', strtotime($item->end_time)) }}
                @endif
              </td>
              <td>
                @if($item->total_hours == null)
                  <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
                @else
                  {{ date('h:iA', strtotime($item->total_hours)) }}
                @endif
              </td>
              <td>{{ $item->billable_hours }}</td>
              <td>{{ $item->getFormattedCost() }}</td>
              <td>{{ $item->getFormattedCostTotal() }}</td>
              <td>
                {{ substr($item->description, 0, 60) }}
                {{ strlen($item->description) > 60 ? '...' : '' }}
              </td>
            </tr>
          @endforeach
        @endforeach
      </tbody>
    </table>
    {{-- outstanding invoices table --}}

    {{-- totals table --}}
    <div class="row">
      <div class="col-4 offset-8">
        <table class="table table-bordered table-fullwidth table-striped">
          <tbody>
            <tr>
              <th>Subtotal</th>
              <td>${{ number_format(($item_cost_total / 100), 2, '.', ',') }}</td>
            </tr>
            @if($selected_user->has_gst)
              <tr>
                <th>GST</th>
                <td>${{ number_format(($item_gst / 100), 2, '.', ',') }}</td>
              </tr>
            @endif
            @if($selected_user->has_payg == 1)
              <tr>
                  <th>PAYG</th>
                  <td>
                    <span class="badge badge-warning py-2 px-2"><i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending</span>
                  </td>
              </tr>
            @endif
            <tr>
              <th>Net Total</th>
              <td>${{ number_format(($invoces_total / 100), 2, '.', ',') }}</td>
            </tr>
            @if($selected_user->super_fund_name != null)
              <tr>
                <th>Superannuation</th>
                <td>${{ number_format(($item_superannuation / 100), 2, '.', ',') }}</td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
    {{-- totals table --}}

    {{-- content --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- jquery datatables js --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script>
  new DataTable('#datatable', {
    'info': false, {{-- Show the page info --}}
    'lengthChange': false, {{-- Show results length --}}
    'order': [[0, 'asc']], {{-- the default order --}}
    'paging': false, {{-- Show pagination --}}
    'searching': false, {{-- Search for results --}}
  });
</script>
{{-- jquery datatables js --}}
@endpush