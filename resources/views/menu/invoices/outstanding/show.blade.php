@extends('layouts.app')

@section('title', '- Invoices - View Selected Outstanding Invoice')

@section('content')
<section>
  <div class="container-fluid py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">OUTSTANDING INVOICES</h3>
    <h5>View Selected Outstanding Invoice</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-6 pt-3">
      <div class="col mb-3">
        <a class="btn btn-dark btn-block" href="{{ route('invoices-outstanding.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Invoice Menu
        </a>
      </div> {{-- col mb-3 --}}
      @if ($selected_invoice->paid_date == null)
        <div class="col mb-3">
          <form action="{{ route('invoices-outstanding.update', $selected_invoice->id) }}" method="POST">
            @method('PATCH')
            @csrf
            @if ($selected_invoice->finalised_date == null)
              <button type="submit" class="btn btn-success btn-block">
                <i class="fas fa-check mr-2" aria-hidden="true"></i>Finalise Invoice Items
              </button>
            @else
              <button type="submit" class="btn btn-warning btn-block">
                <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit Invoice Items
              </button>
            @endif
          </form>
        </div> {{-- col mb-3 --}}
        <div class="col mb-3">
          <form action="{{ route('invoices-staff-confirmation.update', $selected_invoice->id) }}" method="POST">
            @method('PATCH')
            @csrf
            @if ($selected_invoice->confirmed_date == null)
              <button type="submit" class="btn btn-success btn-block">
                <i class="fas fa-check mr-2" aria-hidden="true"></i>Confirm Invoice
              </button>
            @else
              <button type="submit" class="btn btn-warning btn-block">
                <i class="fas fa-edit mr-2" aria-hidden="true"></i>Unconfirm Invoice
              </button>
            @endif
          </form>
        </div> {{-- col mb-3 --}}
        <div class="col mb-3">
          {{-- confirm modal --}}
          {{-- modal button --}}
          <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#confirmMarkAsPaidModal">
              <i class="fas fa-check mr-2" aria-hidden="true"></i>Mark As Paid
          </button>
          {{-- modal button --}}
          {{-- modal --}}
          <div class="modal fade" id="confirmMarkAsPaidModal" tabindex="-1" role="dialog" aria-labelledby="confirmMarkAsPaidModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="confirmMarkAsPaidModalTitle">Mark As Paid</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p class="text-center">Please enter the payment confirmation number and date</p>
                  <form action="{{ route('invoices-mark-as-paid.update', $selected_invoice->id) }}" method="POST">
                    @method('PATCH')
                    @csrf

                    <input type="text" class="form-control my-3" name="confirmation_number" placeholder="Please enter the payment confirmation number">

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
                <form action="{{ route('invoices-outstanding.destroy', $selected_invoice->id) }}" method="POST">
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
      </div> {{-- col mb-3 --}}
      <div class="col mb-3 ">
        <form action="{{ route('invoices-download-pdf.create') }}" method="GET">
          <input type="hidden" name="selected_invoice_id" value="{{ $selected_invoice->id }}">
          <button type="submit" class="btn btn-dark btn-block">
            <i class="fas fa-download mr-2" aria-hidden="true"></i>Download as PDF
          </button>
        </form>
      </div> {{-- col mb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

    {{-- body --}}
    <div class="row">

      {{-- left side column --}}

      <div class="col-sm-2">

        {{-- outstanding invoice list --}}
        <h5 class="text-primary my-3"><b>Outstanding Invoices</b></h5>
        @if (!$selected_invoice->user->invoices->count())
          <div class="card">
            <div class="card-body text-center">
              There are currently no outstanding invoives to display
            </div>
          </div>
        @else
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <thead class="table-secondary">
              <tr>
                <th>Invoice</th>
                <th>Date Submitted</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($selected_invoice->user->getOutstandingInvoiceModels() as $invoice)
                <tr @if ($invoice->id == $selected_invoice->id) class="table-warning" @endif>
                  <td>
                    <a href="{{ route('invoices-outstanding.show', $invoice->id) }}">
                      {{ $invoice->identifier }}
                    </a>
                  </td>
                  <td>
                    @if($invoice->submission_date == null)
                      <span class="badge badge-warning py-2 px-2">
                        <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>Is Not Submitted
                      </span>
                    @else
                      {{ date('d/m/y - h:iA', strtotime($invoice->submission_date)) }}
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
        {{-- outstanding invoice list --}}

        {{-- invoice group button --}}
        @if ($selected_invoice->user->getOutstandingConfirmedInvoiceModels()->count())
          <a href="{{ route('invoices-group.show', $selected_invoice->user_id) }}" class="btn btn-primary btn-block">
            <i class="fas fa-layer-group mr-2" aria-hidden="true"></i>Invoice Group
          </a>
        @else
          <button type="button" class="btn btn-primary btn-block" disabled>
            <i class="fas fa-layer-group mr-2" aria-hidden="true"></i>Invoice Group
          </button>
        @endif
        {{-- invoice group button --}}

      </div> {{-- col-sm-2 --}}

      {{-- left side column --}}

      {{-- right side column --}}

      <div class="col-sm-10">

        <div class="row">

          {{-- left half --}}

          <div class="col-sm-6">

            {{-- invoice details table --}}

            <h5 class="text-primary my-3"><b>Invoice Details</b></h5>
            <div class="table-responsive">
              <table class="table table-bordered table-fullwidth table-striped bg-white">
                <tbody>
                  <tr>
                    <th>Name</th>
                    <td>
                      @foreach ($all_account_roles as $account_role)
                        @if ($selected_invoice->user->account_role_id == $account_role->id)
                          <a href="{{ route($selected_invoice->user->account_role->route_title, $selected_invoice->user_id) }}">
                            {{ $selected_invoice->user->getFullNameTitleAttribute() }}
                          </a>
                        @endif
                      @endforeach
                    </td>
                  </tr>
                  <tr>
                    <th>Invoice ID</th>
                    <td>{{ $selected_invoice->id }}</td>
                  </tr>
                  <tr>
                    <th>Invoice Identifier</th>
                    <td>
                      @if ($selected_invoice->identifier == null)
                        <span class="badge badge-light py-2 px-2">
                          <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                        </span>
                      @else
                        {{ $selected_invoice->identifier }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Editing Status</th>
                    <td>
                      @if ($selected_invoice->finalised_date == null)
                        <span class="badge badge-warning py-2 px-2">
                          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Is Editable
                        </span>
                      @else
                        <span class="badge badge-success py-2 px-2">
                          <i class="fas fa-check mr-2" aria-hidden="true"></i>Is Finalised
                        </span>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Submission Status</th>
                    <td>
                      @if ($selected_invoice->submission_date == null)
                        <span class="badge badge-warning py-2 px-2">
                          <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                        </span>
                      @else
                        <span class="badge badge-success py-2 px-2">
                          <i class="fas fa-check mr-2" aria-hidden="true"></i>Is Submitted
                        </span>
                      @endif
                    </td>
                  </tr>
                  <tr>
                  <th>Paid Date</th>
                    <td>
                      @if ($selected_invoice->paid_date == null)
                        <span class="badge badge-warning py-2 px-2">
                          <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                        </span>
                      @else
                        {{ date('d/m/y', strtotime($selected_invoice->paid_date)) }}
                      @endif
                  </tr>
                  <tr>
                    <th>Confirmation Number</th>
                    <td>
                      @if ($selected_invoice->confirmation_number == null)
                        <span class="badge badge-warning py-2 px-2">
                          <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                        </span>
                      @else
                        {{ $selected_invoice->confirmation_number }}
                      @endif
                  </tr>
                </tbody>
              </table>
            </div> {{-- table-responsive --}}

            {{-- invoice details table --}}

          </div> {{-- col-sm-6 --}}

          {{-- left half --}}

          {{-- right half --}}

          <div class="col-sm-6">

            {{-- job details table --}}

            <h5 class="text-primary my-3"><b>Job Details</b></h5>

            <div class="table-responsive">
              <table class="table table-bordered table-fullwidth table-striped bg-white">
                <tbody>
                  <tr>
                    <th>Quote ID</th>
                    <td>
                      @if ($selected_invoice->quote_id == null)
                        <span class="badge badge-light py-2 px-2">
                          <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                        </span>
                      @else
                        <a href="{{ route('jobs.show', $selected_invoice->quote_id) }}">{{ $selected_invoice->quote_id }}</a>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Job ID</th>
                    <td>
                      @if ($selected_invoice->quote_id == null)
                        <span class="badge badge-light py-2 px-2">
                          <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                        </span>
                      @else
                        <a href="{{ route('jobs.show', $selected_invoice->quote->job_id) }}">{{ $selected_invoice->quote->job_id }}</a>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Customer Name</th>
                    <td>
                      @if ($selected_invoice->quote_id == null)
                        <span class="badge badge-light py-2 px-2">
                          <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                        </span>
                      @else
                        {{ $selected_invoice->quote->job->customer->getFullNameAttribute() }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Job Address</th>
                    <td>
                      @if ($selected_invoice->quote_id == null)
                        <span class="badge badge-light py-2 px-2">
                          <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                        </span>
                      @else
                        {{ $selected_invoice->quote->job->tenant_street_address . ', ' . $selected_invoice->quote->job->tenant_suburb . ' ' . $selected_invoice->quote->job->tenant_postcode  }}
                      @endif                
                    </td>
                  </tr>
                </tbody>
              </table>
            </div> {{-- table-responsive --}}

            <h5 class="text-primary my-3"><b>Quote Rates</b></h5>
            @if ($selected_invoice->getInvoiceQuoteRates() == null)
              <div class="card">
                <div class="card-body">
                  <h5 class="text-center">There are no rates to display</h5>
                </div> {{-- card-body --}}
              </div> {{-- card --}}
            @else
              <div class="table-responsive">
                <table class="table table-bordered table-fullwidth table-striped bg-white">
                  <thead class="table-secondary">
                    <tr>
                      <th>Rate</th>
                      <th>Quantity</th>
                      <th>Pay Rate</th>
                      <th>Total</th>
                      <th>Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($selected_invoice->getInvoiceQuoteRates() as $quote_rate)
                      <tr>
                        <td><a href="{{ route('rate-settings.show', $quote_rate->rate_id) }}" target="_blank">{{ $quote_rate->rate->title }}</a></td>
                        <td>{{ $quote_rate->quantity }}</td>
                        <td>${{ number_format(($quote_rate->individual_price / 100), 2, '.', ',') }}</td>
                        <td>${{ number_format(($quote_rate->total_price / 100), 2, '.', ',') }}</td>
                        <td>{{ $quote_rate->rate->description }}</td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="5" class="text-center">There are no quote rates to display</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div> {{-- table-responsive --}}
            @endif

          </div> {{-- col-sm-6 --}}

          {{-- right half --}}

        </div> {{-- row --}}

        {{-- invoice items --}}

        <h5 class="text-primary my-3"><b>Invoice Items</b></h5>
        @if (!$selected_invoice->invoice_items->count())
          <div class="card shadow-sm mt-3">
            <div class="card-body text-center">
              <h5>There are no invoice items to display</h5>
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @else
          @if ($selected_invoice->finalised_date == null)

            {{-- editable items --}}

            <div class="table-responsive">
              <table class="table table-bordered table-fullwidth table-striped bg-white">
                <thead class="table-secondary">
                  <tr>
                    <th>Job ID</th>
                    <th>Completed Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Hours on Job</th>
                    <th>Paid Hours</th>
                    <th>Pay Rate</th>
                    <th width="25%">Description</th>
                    <th colspan="2">Options</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($selected_invoice->invoice_items as $item)
                    <form action="{{ route('profile-job-invoice-item.update', $item->id) }}" method="POST">
                    @method('PATCH')
                    @csrf

                    <tr>
                      <td><input class="form-control" type="text" name="job_id" value="{{ $item->job_id != null ? $item->job_id : '' }}" placeholder="Job ID"></td>
                      <td>
                        @if ($item->completed_date == null)
                          <input class="form-control" type="date" name="completed_date" value="">
                        @else
                          <input class="form-control" type="date" name="completed_date" value="{{ date('Y-m-d', strtotime($item->completed_date)) }}">
                        @endif
                      <td>
                        @if ($item->start_time == null)
                          <input class="form-control" type="time" name="start_time" value="">
                        @else
                          <input class="form-control" type="time" name="start_time" value="{{ date('H:i', strtotime($item->start_time)) }}">
                        @endif
                      </td>
                      <td>
                        @if ($item->end_time == null)
                          <input class="form-control" type="time" name="end_time" value="">
                        @else
                          <input class="form-control" type="time" name="end_time" value="{{ date('H:i', strtotime($item->end_time)) }}">
                        @endif
                      </td>
                      <td><input class="form-control" type="text" name="total_hours" value="{{ $item->total_hours }}" placeholder="Hours On Job"></td>
                      <td><input class="form-control" type="text" name="billable_hours" value="{{ $item->billable_hours }}" placeholder="Paid Hours"></td>
                      <td><input class="form-control" type="text" name="cost" value="{{ number_format(($item->cost / 100), 2, '.', ',') }}" placeholder="Pay Rate"></td>
                      <td><input class="form-control" type="text" name="description" value="{{ $item->description }}" placeholder="Description"></td>
                      <td>
                        <button type="submit" class="btn btn-primary">
                          <i class="fas fa-edit"></i>
                        </button>
                        </form>
                      </td>
                      <td>
                        {{-- delete modal --}}
                        {{-- modal button --}}
                        <button type="button" class="btn btn-danger mb-1" data-toggle="modal" data-target="#confirm-delete-button-{{ $item->id }}">
                          <i class="fas fa-trash-alt" aria-hidden="true"></i>
                        </button>
                        {{-- modal button --}}
                        {{-- modal --}}
                        <div class="modal fade" id="confirm-delete-button-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-button-{{ $item->id }}-title" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="confirm-delete-button-{{ $item->id }}-title">Delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <p class="text-center">Are you sure that you would like to delete this item?</p>
                                <form action="{{ route('profile-job-invoice-item.destroy', $item->id) }}" method="POST">
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
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table> {{-- table --}}
            </div> {{-- table-responsive --}}

            <form action="{{ route('profile-job-invoice-item.store') }}" method="POST">
              @csrf

              <input type="hidden" name="invoice_id" value="{{ $selected_invoice->id }}">

              <button type="submit" class="btn btn-primary">
                <i class="fas fa-plus mr-2" aria-hidden="true"></i>Add Item
              </button>
            </form>

            {{-- editable items --}}

          @else

            {{-- finalised items --}}

            <div class="table-responsive">
              <table class="table table-bordered table-fullwidth table-striped bg-white">
                <thead class="table-secondary">
                  <tr>
                    <th>Job ID</th>
                    <th>Completed Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Hours on Job</th>
                    <th>Paid Hours</th>
                    <th>Pay Rate</th>
                    <th width="25%">Description</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($selected_invoice->invoice_items as $item)
                    <tr>
                      <td>
                        @if ($item->job_id == null)
                          <span class="badge badge-light py-2 px-2">
                            <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                          </span>
                        @else
                          {{ $item->job_id }}
                        @endif
                      </td>
                      <td>
                        @if ($item->completed_date == null)
                          <span class="badge badge-light py-2 px-2">
                            <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                          </span>
                        @else
                          {{ date('d/m/y', strtotime($item->completed_date)) }}
                        @endif
                      <td>
                        @if ($item->start_time == null)
                          <span class="badge badge-light py-2 px-2">
                            <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                          </span>
                        @else
                          {{ date('h:iA', strtotime($item->start_time)) }}
                        @endif
                      </td>
                      <td>
                        @if ($item->end_time == null)
                          <span class="badge badge-light py-2 px-2">
                            <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                          </span>
                        @else
                          {{ date('h:iA', strtotime($item->end_time)) }}
                        @endif
                      </td>
                      <td>
                        @if ($item->total_hours == null)
                          <span class="badge badge-light py-2 px-2">
                            <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                          </span>
                        @else
                          {{ $item->total_hours }}
                        @endif
                      </td>
                      <td>
                        @if ($item->billable_hours == null)
                          <span class="badge badge-light py-2 px-2">
                            <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                          </span>
                        @else
                          {{ $item->billable_hours }}
                        @endif
                      </td>
                      <td>${{ number_format(($item->cost / 100), 2, '.', ',') }}</td>
                      <td>{{ $item->description }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table> {{-- table --}}
            </div> {{-- table-responsive --}}

            {{-- finalised items --}}

          @endif

        @endif

        {{-- invoice items --}}

        {{-- invoice cost totals table --}}
        <div class="row">
          <div class="col-sm-4 offset-sm-8">

            <h5 class="text-primary my-3"><b>Invoice Totals</b></h5>
            <div class="table-responsive">
              <table class="table table-bordered table-fullwidth table-striped bg-white">
                <tbody>
                  <tr>
                    <th>Subtotal</th>
                    <td>{{ $selected_invoice->getFormattedInvoiceSubtotal() }}</td>
                  </tr>
                  @if($selected_invoice->user->has_gst == 1)
                    <tr>
                      <th>GST</th>
                      <td>{{ $selected_invoice->getFormattedInvoiceTax() }}</td>
                    </tr>
                  @endif
                  @if($selected_invoice->user->has_payg == 1)
                    <tr>
                      <th>PAYG</th>
                      <td>
                        <span class="badge badge-warning py-2 px-2">
                          <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                        </span>
                      </td>
                    </tr>
                  @endif
                  <tr>
                    <th>Net Total</th>
                    <th>{{ $selected_invoice->getFormattedInvoiceTotal() }}</th>
                  </tr>
                  @if($selected_invoice->user->super_fund_name != null)
                    <tr>
                      <th>Superannuation</th>
                      <td>{{ $selected_invoice->getFormattedInvoiceSuperannuation() }}</td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div> {{-- table-responsive --}}

          </div> {{-- col-sm-4 offset-sm-8 --}}
        </div> {{-- row --}}
        {{-- invoice cost totals table --}}

      </div> {{-- col-sm-10 --}}

      {{-- right side column --}}

    </div> {{-- row --}}
    {{-- body --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection