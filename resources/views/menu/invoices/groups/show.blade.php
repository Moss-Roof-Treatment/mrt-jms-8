@extends('layouts.jquery')

@section('title', '- Invoices - View Selected Group Invoice')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
    <div class="container-fluid py-5">

        {{-- title --}}
        <h3 class="text-secondary mb-0">GROUP INVOICES</h3>
        <h5>View Selected Group Invoice</h5>
        {{-- title --}}

        {{-- navigation --}}
        <div class="row row-cols-1 row-cols-sm-6 pt-3">
            <div class="col pb-3">
                <a href="{{ route('group-invoices.index') }}" class="btn btn-dark btn-block">
                    <i class="fas fa-bars mr-2" aria-hidden="true"></i>Group Invoice Menu
                </a>
            </div> {{-- col pb-3 --}}
            <div class="col pb-3">
                <a href="{{ route($selected_invoices->first()->user->account_role->route_title, $selected_invoices->first()->user_id) }}" class="btn btn-primary btn-block">
                    <i class="fas fa-user mr-2" aria-hidden="true"></i>View {{ $selected_invoices->first()->user->account_role->title }}
                </a>
            </div> {{-- col pb-3 --}}
            <div class="col mb-3">
                <a href="{{ route('group-invoices.create', ['selected_confirmation_number' => $selected_confirmation_number]) }}" class="btn btn-dark btn-block">
                    <i class="fas fa-download mr-2" aria-hidden="true"></i>Download PDF
                </a>
            </div> {{-- col mb-3 --}}
        </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
        {{-- navigation --}}

        <h5 class="text-primary my-3"><b>All Invoices In This Group</b></h5>
        <div class="table-responsive">
            <table id="datatable" class="table table-bordered table-fullwidth table-striped bg-white" style="width:100%">
                <thead class="table-secondary">
                    <th>Identifier</th>
                    <th>Confirmation Number</th>
                    <th>Job ID</th>
                    <th>Completed Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Hours On Job</th>
                    <th>Billable Hours</th>
                    <th>Pay Rate</th>
                    <th>Total</th>
                    <th>Description</th>
                </thead>
                <tbody>
                    @foreach($selected_invoices as $invoices)
                        @foreach($invoices->invoice_items as $item)
                            <tr>
                                <td><a href="{{ route('invoices-outstanding.show', $item->invoice_id) }}" target="_blank">{{ $item->invoice->identifier }}</a></td>
                                <td>{{ $item->invoice->confirmation_number }}</td>
                                <td>
                                    @if($item->job_id == null)
                                        <span class="badge badge-light py-2 px-2">
                                            <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                                        </span>
                                    @else
                                        {{ $item->job_id }}
                                    @endif
                                </td>
                                <td>
                                    @if($item->completed_date == null)
                                        <span class="badge badge-light py-2 px-2">
                                            <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                                        </span>
                                    @else
                                        {{ date('d/m/y', strtotime($item->completed_date)) }}
                                    @endif
                                </td>
                                <td>{{ date('h:iA', strtotime($item->start_time)) }}</td>
                                <td>{{ date('h:iA', strtotime($item->end_time)) }}</td>
                                <td>
                                    @if($item->total_hours == null)
                                        <span class="badge badge-light py-2 px-2">
                                            <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                                        </span>
                                    @else
                                        {{ $item->total_hours }}
                                    @endif
                                </td>
                                <td>
                                    @if($item->billable_hours == null)
                                        <span class="badge badge-light py-2 px-2">
                                            <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                                        </span>
                                    @else
                                        {{ $item->billable_hours }}
                                    @endif
                                </td>
                                <td>{{ $item->getFormattedCost() }}</td>
                                <td>{{ $item->getFormattedCostTotal() }}</td>
                                <td>
                                    @if($item->description == null)
                                        <span class="badge badge-light py-2 px-2">
                                            <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                                        </span>
                                    @else
                                        {{ substr($item->description, 0, 60) }}
                                        {{ strlen($item->description) > 60 ? '...' : '' }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div> {{-- table-responsive --}}

        {{-- totals table --}}
        <div class="row">
            <div class="col-4 offset-8">
                <table class="table table-bordered table-fullwidth table-striped">
                    <tbody>
                        <tr>
                            <th>Subtotal</th>
                            <td>${{ number_format(($item_cost_total / 100), 2, '.', ',') }}</td>
                        </tr>
                        @if($selected_user->has_gst == 1)
                            <tr>
                                <th>GST</th>
                                <td>${{ number_format(($item_gst / 100), 2, '.', ',') }}</td>
                            </tr>
                        @endif
                        @if($selected_user->has_payg == 1)
                            <tr>
                                <th>PAYG</th>
                                <td>${{ number_format(($item_payg / 100), 2, '.', ',') }}</td>
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

    </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- jquery datatables js --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script>
    new DataTable('#datatable', {
        "info": true, {{-- Show the page info --}}
        "lengthChange": true, {{-- Show results length --}}
        "ordering": true, {{-- Allow ordering of all columns --}}
        "paging": true, {{-- Show pagination --}}
        "processing": true, {{-- Show processing message on long load time --}}
        "searching": true, {{-- Search for results --}}
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            {"targets": 10, "orderable": false, "className": "text-nowrap"},
        ],
    });
</script>
{{-- jquery datatables js --}}
@endpush