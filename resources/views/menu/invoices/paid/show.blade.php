@extends('layouts.app')

@section('title', '- Profile - View Selected Paid Invoice')

@section('content')
<section>
  <div class="container-fluid py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">PAID INVOICES</h3>
    <h5>View Selected Paid Invoice</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-6 pt-3">
      <div class="col mb-3">
        <a class="btn btn-dark btn-block" href="{{ route('invoices-paid.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Invoice Menu
        </a>
      </div> {{-- col mb-3 --}}
      <div class="col pb-3">
        <a href="{{ route($selected_paid_invoice->user->account_role->route_title, $selected_paid_invoice->user_id) }}" class="btn btn-primary btn-block">
            <i class="fas fa-user mr-2" aria-hidden="true"></i>View {{ $selected_paid_invoice->user->account_role->title }}
        </a>
      </div> {{-- col pb-3 --}}
      @if ($selected_paid_invoice->quote_id != null)
        <div class="col mb-3">
          <a class="btn btn-primary btn-block" href="{{ route('jobs.show', $selected_paid_invoice->quote->job_id) }}">
            <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Job
          </a>
        </div> {{-- col mb-3 --}}
      @endif
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

    {{-- body --}}
    <div class="row">
      <div class="col-sm-4">

        {{-- invoice details table --}}
        <h5 class="text-primary my-3"><b>Invoice Details</b></h5>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>Name</th>
                <td>{{ $selected_paid_invoice->user->getFullNameAttribute() }}</td>
              </tr>
              <tr>
                <th>Invoice ID</th>
                <td>{{ $selected_paid_invoice->id }}</td>
              </tr>
              <tr>
                <th>Invoice Identifier</th>
                <td>
                  @if ($selected_paid_invoice->identifier == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ $selected_paid_invoice->identifier }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Paid Date</th>
                <td>
                  @if ($selected_paid_invoice->paid_date == null)
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                    </span>
                  @else
                    {{ date('d/m/y', strtotime($selected_paid_invoice->paid_date)) }}
                  @endif
              </tr>
              <tr>
                <th>Confirmation Number</th>
                <td>
                  @if ($selected_paid_invoice->confirmation_number == null)
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                    </span>
                  @else
                    {{ $selected_paid_invoice->confirmation_number }}
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}
        {{-- invoice details table --}}

      </div> {{-- col-sm-4 --}}
      <div class="col-sm-4">

        {{-- job details table --}}
        <h5 class="text-primary my-3"><b>Job Details</b></h5>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>Quote ID</th>
                <td>
                  @if ($selected_paid_invoice->quote_id == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ $selected_paid_invoice->quote_id }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Job ID</th>
                <td>
                  @if ($selected_paid_invoice->quote_id == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ $selected_paid_invoice->quote->job_id }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Customer Name</th>
                <td>
                  @if ($selected_paid_invoice->quote_id == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ $selected_paid_invoice->quote->job->customer->getFullNameAttribute() }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Job Address</th>
                <td>
                  @if ($selected_paid_invoice->quote_id == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ $selected_paid_invoice->quote->job->tenant_street_address . ', ' . $selected_paid_invoice->quote->job->tenant_suburb . ' ' . $selected_paid_invoice->quote->job->tenant_postcode  }}
                  @endif                
                </td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}
        {{-- job details table --}}

      </div> {{-- col-sm-4 --}}
      <div class="col-sm-4">

        {{-- invoice cost totals table --}}
        <h5 class="text-primary my-3"><b>Invoice Totals</b></h5>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>Subtotal</th>
                <td>{{ $selected_paid_invoice->getFormattedInvoiceSubtotal() }}</td>
              </tr>
              @if($selected_paid_invoice->user->has_gst)
                <tr>
                  <th>GST</th>
                  <td>{{ $selected_paid_invoice->getFormattedInvoiceTax() }}</td>
                </tr>
              @endif
              @if($selected_paid_invoice->user->has_payg)
                <tr>
                  <th>PAYG</th>
                  <td>
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>View on Group Invoice
                    </span>
                  </td>
                </tr>
              @endif
              <tr>
                <th>Net Total</th>
                <th>{{ $selected_paid_invoice->getFormattedInvoiceTotal() }}</th>
              </tr>
              @if($selected_paid_invoice->user->super_fund_name != null)
                <tr>
                  <th>Superannuation</th>
                  <td>{{ $selected_paid_invoice->getFormattedInvoiceSuperannuation() }}</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div> {{-- table-responsive --}}
        {{-- invoice cost totals table --}}

      </div> {{-- col-sm-4 --}}
    </div> {{-- row --}}

    {{-- body --}}

    {{-- INVOICE ITEMS --}}

    <h5 class="text-primary my-3"><b>Invoice Items</b></h5>

    @if (!$selected_paid_invoice->invoice_items->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no invoice items to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      @if ($selected_paid_invoice->finalised_date == null)

        {{-- EDITABLE ITEMS --}}

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
              @foreach ($selected_paid_invoice->invoice_items as $item)
                <form action="{{ route('profile-job-invoice-item.update', $item->id) }}" method="POST">
                @method('PATCH')
                @csrf

                <tr>
                  <td><input class="input" type="text" name="job_id" value="{{ $item->job_id != null ? '$item->job_id' : '' }}" placeholder="Job ID"></td>
                  <td>
                    @if ($item->completed_date == null)
                      <input class="input" type="date" name="completed_date" value="">
                    @else
                      <input class="input" type="date" name="completed_date" value="{{ date('Y-m-d', strtotime($item->completed_date)) }}">
                    @endif
                  <td>
                    @if ($item->start_time == null)
                      <input class="input" type="time" name="start_time" value="">
                    @else
                      <input class="input" type="time" name="start_time" value="{{ date('H:i', strtotime($item->start_time)) }}">
                    @endif
                  </td>
                  <td>
                    @if ($item->end_time == null)
                      <input class="input" type="time" name="end_time" value="">
                    @else
                      <input class="input" type="time" name="end_time" value="{{ date('H:i', strtotime($item->end_time)) }}">
                    @endif
                  </td>
                  <td><input class="input" type="text" name="total_hours" value="{{ $item->total_hours }}" placeholder="Hours On Job"></td>
                  <td><input class="input" type="text" name="billable_hours" value="{{ $item->billable_hours }}" placeholder="Paid Hours"></td>
                  <td><input class="input" type="text" name="cost" value="{{ number_format(($item->cost / 100), 2, '.', ',') }}" placeholder="Pay Rate"></td>
                  <td><input class="input" type="text" name="description" value="{{ $item->description }}" placeholder="Description"></td>
                  <td>
                    <button type="submit" class="btn btn-primary">
                      <i class="fas fa-edit"></i>
                    </button>
                    </form>
                  </td>
                  <td>
                    {{-- DELETE MODAL --}}
                    <a class="button modal-btn btn-danger" data-target="confirm-delete-button-{{ $item->id }}">
                      <i class="fas fa-trash-alt"></i>
                    </a>
                    <div class="modal" id="confirm-delete-button-{{ $item->id }}">
                      <div class="modal-background"></div>
                      <div class="modal-content">
                        <div class="box">
                          <p class="title text-center text-danger">Confirm Delete</p>
                          <p class="subtitle text-center">Are you sure you would like to delete the selected invoice item...?</p>
                          
                          <form action="{{ route('profile-job-invoice-item.destroy', $item->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-block">
                              <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i> Confirm Delete
                            </button>
                          </form>

                        </div> {{-- box --}}
                      </div> {{-- modal-content --}}
                      <button class="modal-close is-large" aria-label="close"></button>
                    </div> {{-- modal --}}
                    {{-- DELETE MODAL --}}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table> {{-- table --}}
        </div> {{-- table-responsive --}}

        <form action="{{ route('profile-job-invoice-item.store') }}" method="POST">
          @csrf

          <input type="hidden" name="invoice_id" value="{{ $selected_paid_invoice->id }}">

          <button type="submit" class="btn btn-primary">
            <i class="fas fa-plus mr-2" aria-hidden="true"></i>Add Item
          </button>
        </form>

        {{-- EDITABLE ITEMS --}}

      @else

        {{-- FINALISED ITEMS --}}

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
              @foreach ($selected_paid_invoice->invoice_items as $item)
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

        {{-- FINALISED ITEMS --}}

      @endif

    @endif

    {{-- INVOICE ITEMS --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection