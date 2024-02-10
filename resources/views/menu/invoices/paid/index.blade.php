@extends('layouts.jquery')

@section('title', '- Invoices - View All Paid Invoices')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">PAID INVOICES</h3>
    <h5>View All Paid Invoices</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
        <div class="col pb-3">
          <a href="{{ route('invoices.index') }}" class="btn btn-dark btn-block">
            <i class="fas fa-file-alt mr-2" aria-hidden="true"></i>Invoices Menu
          </a>
        </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- paid invoices table --}}
    <h5 class="text-primary my-3"><b>All Paid Invoices</b></h5>
    @if (!$all_paid_invoices->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>Threre are no paid invoices to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive mt-3">
        <table id="datatable" class="table table-bordered table-fullwidth table-striped" style="width:100%">
          <thead class="table-secondary">
            <tr>
              <th>Identifier</th>
              <th>Submission Date</th>
              <th>Job ID</th>
              <th>Customer Name</th>
              <th>Tradesperson Name</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_paid_invoices as $invoice)
              <tr>
                <td>
                  @if ($invoice->identifier == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ $invoice->identifier }}
                  @endif
                </td>
                <td>
                  @if ($invoice->submission_date == null)
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>Is Not Submitted
                    </span>
                  @else
                    {{ date('d/m/y - h:iA', strtotime($invoice->submission_date)) }}
                  @endif
                </td>
                <td>
                  @if ($invoice->quote_id == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ $invoice->quote->job_id }}
                  @endif
                </td>
                <td>
                  @if ($invoice->quote_id == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ $invoice->quote->customer->getFullNameAttribute() }}
                  @endif
                </td>
                <td>{{ $invoice->user->getFullNameAttribute() }}</td>
                <td>
                  <a href="{{ route('invoices-paid.show', $invoice->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- paid invoices table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- jquery datatables js --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function() {
    $('#datatable').DataTable({
      "info": true, {{-- Show the page info --}}
      "lengthChange": true, {{-- Show results length --}}
      "ordering": true, {{-- Allow ordering of all columns --}}
      "paging": true, {{-- Show pagination --}}
      "processing": true, {{-- Show processing message on long load time --}}
      "searching": true, {{-- Search for results --}}
    });
  });
</script>
{{-- jquery datatables js --}}
@endpush