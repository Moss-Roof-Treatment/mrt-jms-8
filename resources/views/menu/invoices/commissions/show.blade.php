@extends('layouts.app')

@section('title', '- Invoices - View Selected Commission')

@section('content')
<section>
    <div class="container py-5">

        {{-- title --}}
        <h3 class="text-secondary mb-0">COMMISSIONS</h3>
        <h5>View Selected Commission</h5>
        {{-- title --}}

        {{-- navigation --}}
        <div class="row row-cols-1 row-cols-sm-4 pt-3">
            <div class="col pb-3">
                <a href="{{ route('invoice-commissions.index') }}" class="btn btn-dark btn-block">
                    <i class="fas fa-bars mr-2" aria-hidden="true"></i>Commissions Menu
                </a>
            </div> {{-- col pb-3 --}}
            @if($selected_commission->quote_id != null)
                <div class="col pb-3">
                    <a href="{{ route('jobs.show', $selected_commission->quote->job_id) }}" class="btn btn-primary btn-block">
                        <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Job
                    </a>
                </div> {{-- col pb-3 --}}
            @endif
            @if($selected_commission->quote_id != null)
                <div class="col pb-3">
                    <a href="{{ route('quotes.show', $selected_commission->quote_id) }}" class="btn btn-primary btn-block">
                        <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Quote
                    </a>
                </div> {{-- col pb-3 --}}
            @endif
            <div class="col pb-3">
                <a href="{{ route($selected_commission->salesperson->account_role->route_title, $selected_commission->salesperson_id) }}" class="btn btn-primary btn-block">
                    <i class="fas fa-user mr-2" aria-hidden="true"></i>View {{ $selected_commission->salesperson->account_role->title }}
                </a>
            </div> {{-- col pb-3 --}}
            @if ($selected_commission->approval_date == null)
                <div class="col pb-3">
                    <a href="{{ route('invoice-commissions.edit', $selected_commission->id) }}" class="btn btn-primary btn-block">
                        <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                    </a>
                </div> {{-- col pb-3 --}}
            @endif
            @if ($selected_commission->approval_date == null)
                <div class="col pb-3">
                {{-- delete modal --}}
                {{-- modal button --}}
                <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModal">
                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                </button>
                {{-- modal button --}}
                {{-- modal --}}
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalTitle">Delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center">Are you sure that you would like to delete this item?</p>
                                <form action="{{ route('invoice-commissions.destroy', $selected_commission->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-block">
                                        <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- modal --}}
                {{-- delete modal --}}
                </div> {{-- col pb-3 --}}
            @endif
            @if ($selected_commission->approval_date == null)
                <div class="col pb-3">
                    <form action="{{ route('invoice-commissions-convert.update', $selected_commission->id) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-edit mr-2" aria-hidden="true"></i>Convert To Invoice
                        </button>
                    </form>
                </div> {{-- col pb-3 --}}
            @endif
            @if ($selected_commission->invoice_id != null)
                @if ($selected_commission->invoice->paid_date == null)
                    <div class="col pb-3">
                        <a href="{{ route('invoices-outstanding.show', $selected_commission->invoice_id) }}" class="btn btn-primary btn-block">
                            <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Invoice
                        </a>
                    </div> {{-- col pb-3 --}}
                @else
                    <div class="col pb-3">
                        <a href="{{ route('invoices-paid.show', $selected_commission->invoice_id) }}" class="btn btn-primary btn-block">
                            <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Invoice
                        </a>
                    </div> {{-- col pb-3 --}}
                @endif
            @endif
        </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
        {{-- navigation --}}

        <div class="row">
            <div class="col-sm-6">

                {{-- sold jobs table --}}
                <h5 class="text-primary my-3"><b>Job Details</b></h5>
                <div class="table-responsive py-2 px-2">
                    <table class="table table-bordered table-fullwidth table-striped bg-white" id="datatable" style="width:100%">
                        <tbody>
                            <tr>
                                <th>Quote Identifier</th>
                                <td>
                                    @if($selected_commission->quote_id == null)
                                        <span class="badge badge-light py-2 px-2">
                                            <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                                        </span>
                                    @else
                                        {{ $selected_commission->quote->quote_identifier }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Job ID</th>
                                <td>
                                    @if($selected_commission->quote_id == null)
                                        <span class="badge badge-light py-2 px-2">
                                            <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                                        </span>
                                    @else
                                        {{ $selected_commission->quote->job_id }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Customer</th>
                                <td>
                                    @if($selected_commission->quote_id == null)
                                        <span class="badge badge-light py-2 px-2">
                                            <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                                        </span>
                                    @else
                                        {{ $selected_commission->quote->customer->getFullNameAttribute() }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Job Status</th>
                                <td>
                                    @if($selected_commission->quote_id == null)
                                        <span class="badge badge-light py-2 px-2">
                                            <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                                        </span>
                                    @else
                                        {{ $selected_commission->quote->job->job_status->title }}
                                    @endif`
                                </td>
                            </tr>
                            <tr>
                                <th>Quote Status</th>
                                <td>
                                    @if($selected_commission->quote_id == null)
                                        <span class="badge badge-light py-2 px-2">
                                            <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                                        </span>
                                    @else
                                        {{ $selected_commission->quote->quote_status->title }}
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> {{-- table-responsive --}}
                {{-- sold jobs table --}}

            </div> {{-- col-sm-6 --}}
            <div class="col-sm-6">

                {{-- sold jobs table --}}
                <h5 class="text-primary my-3"><b>Commission Details</b></h5>
                <div class="table-responsive py-2 px-2">
                    <table class="table table-bordered table-fullwidth table-striped bg-white" id="datatable" style="width:100%">
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{ $selected_commission->salesperson->getFullNameTitleAttribute() }}</td>
                            </tr>
                            <tr>
                                <th>Quote Total</th>
                                <td>${{ number_format(($selected_commission->quote_total / 100), 2, '.', ',') }}</td>
                            </tr>
                            <tr>
                                <th>Default Total Commission</th>
                                <td>{{ $selected_commission->total_percent * 100 }}%</td>
                            </tr>
                            <tr>
                                <th>Total Quote Commissions</th>
                                <td>
                                    @if($selected_commission->quote_id == null)
                                        <span class="badge badge-light py-2 px-2">
                                            <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                                        </span>
                                    @else
                                        {{ $selected_commission->quote->commissions->count() }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Individual Commission</th>
                                <td>{{ $selected_commission->individual_percent_value * 100 }}%</td>
                            </tr>
                            <tr>
                                <th>Commission Total</th>
                                <td>${{ number_format(($selected_commission->quote_total * $selected_commission->individual_percent_value / 100), 2, '.', ',') }}</td>
                            </tr>
                            @if ($selected_commission->edited_total != null)
                                <tr>
                                    <th>Edited Total</th>
                                    <td>${{ number_format(($selected_commission->edited_total / 100), 2, '.', ',') }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($selected_commission->approval_date == null)
                                        <span class="badge badge-warning p-2">
                                            <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                                        </span>
                                    @else
                                        <span class="badge badge-success p-2">
                                            <i class="fas fa-check mr-2" aria-hidden="true"></i>Completed
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @if ($selected_commission->approval_date != null)
                                <tr>
                                    <th>Invoice Date</th>
                                    <td>{{ date('d/m/Y', strtotime($selected_commission->approval_date)) }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div> {{-- table-responsive --}}
                {{-- sold jobs table --}}

            </div> {{-- col-sm-6 --}}
        </div> {{-- row --}}

    </div> {{-- container --}}
</section> {{-- section --}}
@endsection