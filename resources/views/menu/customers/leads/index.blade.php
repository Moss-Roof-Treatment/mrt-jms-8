@extends('layouts.jquery')

@section('title', 'Customers - View All Customer Leads')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container-fluid py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">CUSTOMERS</h3>
    <h5>View All Customer Leads</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-6 pt-3">
      <div class="col pb-3">
        <a href="{{ route('customers.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Customer Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('leads.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Customer Lead
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

    {{-- customer leads table --}}
    @if (!$all_leads->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>Threre are no customer leads to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive mt-3">
        <table id="datatable" class="table table-bordered table-fullwidth table-striped bg-white" style="width:100%">
          <thead class="table-secondary">
            <tr>
              <th>Name</th>
              <th>Account Class</th>
              <th>Business Name</th>
              <th>Postcode</th>
              <th>Last Contact Date</th>
              <th>Call Back Date</th>
              <th>Status</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_leads as $lead)
              <tr>
                <td>
                  @if ($lead->first_name == null || $lead->last_name == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Name has not been set
                    </span>
                  @else
                    {{ $lead->first_name . ' ' . $lead->last_name }}
                  @endif
                </td>
                <td>
                  @if ($lead->account_class_id == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Account class has not been set
                    </span>
                  @else
                    {{ $lead->account_class->title }}
                  @endif
                </td>
                <td>
                  @if ($lead->business_name == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Business name has not been set
                    </span>
                  @else
                    {{ $lead->business_name }}
                  @endif
                </td>
                <td>
                  @if ($lead->postcode == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Postcode has not been set
                    </span>
                  @else
                    {{ $lead->postcode }}
                  @endif
                </td>
                <td>
                  @if ($lead->lead_contacts->last() == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Customer has not been contacted
                    </span>
                  @else
                    {{ $lead->lead_contacts->last()->created_at->diffForHumans() }}
                  @endif
                </td>
                <td>
                  @if ($lead->lead_contacts->last() == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Customer has not been contacted
                    </span>
                  @else
                    @if ($lead->lead_contacts->last()->call_back_date == null)
                      <span class="badge badge-light py-2 px-2">
                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Call back date has not been set
                      </span>
                    @else
                      {{ $lead->lead_contacts->last()->call_back_date->diffForHumans() }}
                    @endif
                  @endif
                </td>
                <td>
                    <i class="fas fa-square-full mr-2 border border-dark" style="color:{{ $lead->lead_status->colour->colour }};"></i>
                    {{ $lead->lead_status->title }}
                </td>
                <td class="text-center">
                  <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- customer leads table --}}

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
      "pageLength": 100,
      order: [[ 0, "asc" ]],
      columnDefs: [
        {targets: 7, orderable: false, className: "text-center text-nowrap"},
      ],
    });
  });
</script>
{{-- jquery datatables js --}}
@endpush