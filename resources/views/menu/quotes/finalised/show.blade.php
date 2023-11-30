@extends('layouts.jquery')

@section('title', 'Quotes - View Selected Finalised Quote')

@push('css')
{{-- Datepicker CSS --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-PMjWzHVtwxdq7m7GIxBot5vdxUY+5aKP9wpKtvnNBZrVv1srI8tU6xvFMzG8crLNcMj/8Xl/WWmo/oAP/40p1g==" crossorigin="anonymous" />
{{-- Datepicker CSS --}}
@endpush

@section('content')
<section>
  <div class="container-fluid py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">QUOTES</h3>
    <h5>View Selected Finalised Quote</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-6 pt-3">
      <div class="col mb-3">
        <a href="{{ route('quotes.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Quote Menu
        </a>
      </div> {{-- col mb-3 --}}
      <div class="col mb-3">
        <a href="{{ route('jobs.show', $selected_quote->job_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Job
        </a>
      </div> {{-- col mb-3 --}}
      <div class="col mb-3">
        <a href="{{ route('customers.show', $selected_quote->customer_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Customer
        </a>
      </div> {{-- col mb-3 --}}
      <div class="col mb-3">
        <a href="{{ route('quick-quote.show', $selected_quote->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Quick Quote
        </a>
        <a href="{{ route('job-view-customer-quote.show', $selected_quote->id) }}" class="btn btn-primary btn-block mr-2 mt-2">
          <i class="fas fa-file-invoice mr-2" aria-hidden="true"></i>View Quote
        </a>
      </div> {{-- col mb-3 --}}
      <div class="col mb-3">
        <form action="{{ route('quotes-finalise.update', $selected_quote->id) }}" method="POST">
          @method('PATCH')
          @csrf
          <button type="submit" class="btn btn-warning btn-block mb-2">
            <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit Quote
          </button>
        </form>
      </div> {{-- col mb-3 --}}
      <div class="col mb-3">
        {{-- online quote access email modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-dark btn-block" data-toggle="modal" data-target="#confirm-send-data-entered-email">
          <i class="fas fa-envelope mr-2" aria-hidden="true"></i>Send "Online Quote Access" Email
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="confirm-send-data-entered-email" tabindex="-1" role="dialog" aria-labelledby="confirm-send-data-entered-email-title" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="confirm-send-data-entered-email-title">Confirm Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center">Please confirm the text for the new online quote access email.</p>

                <form action="{{ route('send-customer-credentials-email.store') }}" method="POST">
                  @csrf

                  <input type="hidden" name="quote_id" value="{{ $selected_quote->id }}">

                  <div class="form-group row">
                    <label for="subject" class="col-md-2 col-form-label text-md-right">Subject</label>
                    <div class="col-md-9">
                      <input type="text" class="form-control @error('subject') is-invalid @enderror mb-2" name="subject" id="subject" value="{{ old('subject', $selected_email_template->subject) }}" placeholder="Please enter the subject">
                      @error('subject')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div> {{-- col-md-9 --}}
                  </div> {{-- form-group row --}}

                  <div class="form-group row">
                    <label for="message" class="col-md-2 col-form-label text-md-right">Message</label>
                    <div class="col-md-9">
                      <textarea class="form-control @error('message') is-invalid @enderror mb-2" type="text" name="message" rows="10" placeholder="Please enter the message" style="resize:none">{{ old('message', $selected_email_template->text) }}</textarea>
                      @error('message')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div> {{-- col-md-9 --}}
                  </div> {{-- form-group row --}}

                  <button type="submit" class="btn btn-dark btn-block">
                    <i class="fas fa-envelope mr-2" aria-hidden="true"></i>Send "Online Quote Access" Email
                  </button>
                </form>
              </div> {{-- modal-body --}}
            </div> {{-- modal-content --}}
          </div> {{-- modal-dialog --}}
        </div> {{-- modal fade --}}
        {{-- modal --}}
        {{-- online quote access email modal --}}
      </div>
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

    {{-- status dropdowns --}}
    <div class="row row-cols-1 row-cols-sm-6 pt-3">
      <div class="col mb-3">
        <p class="text-primary text-center"><b>Quote Status</b></p>
        <form action="{{ route('update-quote-status.update', $selected_quote->id) }}" method="POST">
          @method('PATCH')
          @csrf
          <div class="input-group mb-3">
            <select name="quote_status_id" class="custom-select @error('quote_status_id') is-invalid @enderror">
              @if ($selected_quote->quote_status_id != null)
                <option value="{{ $selected_quote->quote_status_id }}">{{ $selected_quote->quote_status->title }}</option>
              @endif
              <option disabled>Please select a job status</option>
              @foreach ($all_quote_statuses as $quote_status)
                <option value="{{ $quote_status->id }}" @if ($quote_status->id == $selected_quote->quote_status_id) hidden @endif>{{ $quote_status->title }}</option>
              @endforeach
            </select>
            <div class="input-group-append">
              <button class="btn btn-dark" type="submit"><i class="fas fa-edit"></i></button>
            </div> {{-- form-control --}}
          </div> {{-- input-group mb-3 --}}
        </form>
      </div> {{-- col mb-3 --}}

      <div class="col mb-3">
        <p class="text-primary text-center"><b>Expected Payment Method</b></p>
        <form action="{{ route('update-quote-expected-payment.update', $selected_quote->id) }}" method="POST">
          @method('PATCH')
          @csrf
          <div class="input-group mb-3">
            <select name="expected_payment_method_id" class="custom-select @error('expected_payment_method_id') is-invalid @enderror">
              <option selected disabled>Please select a job status</option>
              @if ($selected_quote->expected_payment_method_id != null)
                <option selected value="{{ $selected_quote->expected_payment_method_id }}">{{ $selected_quote->expected_payment_method->title }}</option>
              @endif
              @foreach ($all_expected_payment_methods as $expected_payment_method)
                <option value="{{ $expected_payment_method->id }}" @if ($expected_payment_method->id == $selected_quote->expected_payment_method_id) hidden @endif>
                  {{ $expected_payment_method->title }}
                </option>
              @endforeach
            </select>
            <div class="input-group-append">
              <button class="btn btn-dark" type="submit"><i class="fas fa-edit"></i></button>
            </div> {{-- form-control --}}
          </div> {{-- input-group mb-3 --}}
        </form>
      </div> {{-- col mb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- status dropdowns --}}

    {{-- content --}}
    <div class="row">
      <div class="col-sm-4">

        {{-- pricing table --}}
        <h5 class="text-primary my-3"><b>Quote Details</b></h5>
        <div class="table-responsive my-3">
          <table class="table table-bordered table-fullwidth table-striped">
            <tbody>
              <tr>
                <th>Quote Identifier</th>
                <td>{{ $selected_quote->quote_identifier }}</td>
              </tr>
              <tr>
                <th>Job</th>
                <td>{{ $selected_quote->job_id }}</td>
              </tr>
              <tr>
                <th>Customer</th>
                <td>{{ $selected_quote->customer->getFullNameAttribute() }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        {{-- pricing table --}}

        {{-- tasks cards --}}
        <h5 class="text-primary my-3"><b>Quote Tasks</b></h5>
        @if (!$selected_quote->quote_tasks->count())
          <div class="card">
            <div class="card-body">
              <h5 class="text-center">There are no quote tasks to display</h5>
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @else
          @foreach ($selected_quote->quote_tasks as $quote_task)
          <div class="card my-3">
              <div class="card-body pb-0">
                <div class="row">
                  <div class="col-sm-2 text-center">
                    @if ($quote_task->task->image_path == null)
                      <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/task-256x256.jpg') }}" alt="">
                    @else
                      <img class="img-fluid mb-3" src="{{ asset($quote_task->task->image_path) }}" alt="">
                    @endif
                  </div> {{-- col-sm-2 --}}
                  <div class="col-sm-10">
                    <p>
                      <b>{{ $quote_task->task->title }}</b>
                      - {{ $quote_task->task->task_type->title }}
                      @if ($quote_task->task->is_quote_visible == 0)
                        <span class="badge badge-danger py-2 px-2 ml-2">
                          <i class="fas fa-eye-slash mr-2" aria-hidden="true"></i>Not Visible On Quote
                        </span>
                      @else
                        <span class="badge badge-success py-2 px-2 ml-2">
                          <i class="fas fa-eye mr-2" aria-hidden="true"></i>Visible On Quote
                        </span>
                      @endif
                    </p>
                    <p>{{ $quote_task->total_quantity . ' x ' . '$' . number_format(($quote_task->individual_price / 100), 2, '.', ',') . ' = ' . '$' . number_format(($quote_task->total_price / 100), 2, '.', ',') }}</p>
                    <p>
                    @if ($quote_task->description == null)
                      <span class="badge badge-light py-2 px-2">
                        <i class="fas fa-times mr-2" aria-hidden="true"></i> There are no additional comments for this task
                      </span>
                    @else
                      {{ $quote_task->description }}
                    @endif
                    </p>
                  </div> {{-- col-sm-10 --}}
                </div> {{-- row --}}
              </div> {{-- card-body --}}
            </div> {{-- card --}}
          @endforeach
        @endif
        {{-- tasks cards --}}

        {{-- products table --}}
        <h5 class="text-primary my-3"><b>Quote Products</b></h5>
        @if (!$selected_quote->quote_products->count())
          <div class="card">
            <div class="card-body">
              <h5 class="text-center">There are no quote products to display</h5>
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @else
          @foreach ($selected_quote->quote_products as $quote_product)
            <div class="card my-3">
              <div class="card-body pb-0">
                <div class="row">
                  <div class="col-sm-2">
                    @if ($quote_product->product?->getFeaturedImage() == null)
                      <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/stock-256x256.jpg') }}" alt="">
                    @else
                      <img class="img-fluid shadow-sm" src="{{ asset($quote_product->product->getFeaturedImage()->image_path) }}" alt="">
                    @endif
                  </div> {{-- col-sm-2 --}}
                  <div class="col-sm-10">
                    <p><b>
                      {{ $quote_product->product->name }}
                    </b></h5>
                    <p>{{ $quote_product->quantity . ' x ' . '$' . number_format(($quote_product->individual_price / 100), 2, '.', ',') . ' = ' . '$' . number_format(($quote_product->total_price / 100), 2, '.', ',') }}</p>
                    <p>
                      @if ($quote_product->description == null)
                        <span class="badge badge-light py-2 px-2">
                          <i class="fas fa-times mr-2" aria-hidden="true"></i> There are no additional comments for this product
                        </span>
                      @else
                        {{ $quote_product->description }}
                      @endif
                    </p>
                  </div> {{-- col-sm-10 --}}
                </div> {{-- row --}}
              </div> {{-- card-body --}}
            </div> {{-- card --}}
          @endforeach
        @endif
        {{-- products table --}}

        {{-- rates table --}}
        <h5 class="text-primary my-3"><b>Quote Rates</b></h5>
        @if (!$selected_quote->quote_rates->count()) 
          <div class="card">
            <div class="card-body">
              <h5 class="text-center">There are no quote rates to display</h5>
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @else
          @foreach ($selected_quote->quote_rates as $quote_rate)
            <div class="card my-3">
              <div class="card-body pb-0">
                <div class="row">
                  <div class="col-sm-2">
                    @if ($quote_rate->rate->image_path == null)
                      <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/tools-256x256.jpg') }}" alt="">
                    @else
                      <img class="img-fluid" src="{{ asset($quote_rate->rate->image_path) }}" alt="">
                    @endif
                  </div> {{-- col-sm-2 --}}
                  <div class="col-sm-10">
                    <p>
                      <b>
                        {{ $quote_rate->rate->title }} -
                      </b>
                      @if ($quote_rate->staff_id == null)
                        <span class="badge badge-warning py-2 px-2">
                          <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i> Pending
                        </span>
                      @else
                        {{ $quote_rate->staff->getFullNameTitleAttribute() }}
                      @endif
                    </p>
                    <p>{{ $quote_rate->quantity . ' x ' . '$' . number_format(($quote_rate->individual_price / 100), 2, '.', ',') . ' = ' . '$' . number_format(($quote_rate->total_price / 100), 2, '.', ',') }}</p>
                    <p>
                      @if ($quote_rate->description == null)
                        <span class="badge badge-light py-2 px-2">
                          <i class="fas fa-times mr-2" aria-hidden="true"></i> There are no additional comments for this rate
                        </span>
                      @else
                        {{ $quote_rate->description }}
                      @endif
                    </p>
                  </div> {{-- col-sm-10 --}}
                </div> {{-- row --}}
              </div> {{-- card-body --}}
            </div> {{-- card --}}
          @endforeach
        @endif
        {{-- rates table --}}

      </div> {{-- col --}}
      <div class="col-sm-3">

        {{-- pricing table --}}
        <h5 class="text-primary my-3"><b>Quote Totals</b></h5>
        <div class="table-responsive my-3">
          <table class="table table-bordered table-fullwidth table-striped">
            <tbody>
              <tr>
                <th>Task Cost Total</th>
                <td>{{ $selected_quote->getFormattedTotalTasksCost() }}</td>
              </tr>
              <tr>
                <th>Tradesperson Rate Cost Total</th>
                <td>{{ $selected_quote->getFormattedTotalRatesCost() }}</td>
              </tr>
              <tr>
                <th>Product Cost Total</th>
                <td>{{ $selected_quote->getFormattedTotalProductsCost() }}</td>
              </tr>
              <tr>
                <th>Profit Margin</th>
                <td>{{ $selected_quote->getFormattedProfitMargin() }}</td>
              </tr>
              <tr>
                <th>Discount</th>
                <td>{{ $selected_quote->getFormattedDiscount() }}</td>
              </tr>
              <tr>
                <th>Subtotal</th>
                <td>{{ $selected_quote->getFormattedSubtotalWithoutGst() }}</td>
              </tr>
              <tr>
                <th>GST</th>
                <td>{{ $selected_quote->getFormattedSubtotalGst() }}</td>
              </tr>
              <tr>
                <th>Quote Total</th>
                <td><b>{{ $selected_quote->getFormattedQuoteTotal() }}</b></td>
              </tr>
            </tbody>
          </table>
        </div>
        {{-- pricing table --}}

      </div> {{-- col --}}
      <div class="col-sm-5">

        {{-- pricing table --}}
        <h5 class="text-primary my-3"><b>Contracted Totals</b></h5>
        <div class="table-responsive my-3">
          <table class="table table-bordered table-fullwidth table-striped">
            <tbody>
              <tr>
                <th>Opening Balance</th>
                <td>{{ $selected_quote->getFormattedOpeningBalance() }}</td>
              </tr>
              <tr>
                <th>Deposit Total</th>
                <td>{{ $selected_quote->getFormattedDepositTotal() }}</td>
              </tr>
              <tr>
                <th>Payments Total</th>
                <td>{{ $selected_quote->getFormattedPaymentsTotal() }}</td>
              </tr>
              <tr>
                <th>Remaining Balance</th>
                <td>{{ $selected_quote->getFormattedRemainingBalance() }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        {{-- pricing table --}}

        {{-- deposits section --}}
        <h5 class="text-primary my-3"><b>Deposit</b></h5>
        {{-- create deposit payment form --}}
        <div class="card">
          <div class="card-body">

            <form action="{{ route('quote-payments.store') }}" method="POST">
              @csrf

              <input type="hidden" name="selected_quote_id" value="{{ $selected_quote->id }}">

              <div class="form-row">
                <div class="form-group col-md-4">
                  <input class="form-control @error('deposit_date') is-invalid @enderror" type="date" name="deposit_date" value="{{ @old('deposit_date') }}">
                  @error('deposit_date')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> {{-- form-group col-md-4 --}}
                <div class="form-group col-md-4">
                  <select name="deposit_method" class="custom-select @error('deposit_method') is-invalid @enderror">
                    <option selected disabled>Payment method</option>
                    @foreach ($all_payment_methods as $payment_method)
                      <option value="{{ $payment_method->id }}" @if (old('deposit_method') == $payment_method->id) selected @endif>{{ $payment_method->title }}</option>
                    @endforeach
                  </select>
                  @error('deposit_method')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> {{-- form-group col-md-4 --}}
                <div class="form-group col-md-4">
                  <input type="text" class="form-control @error('deposit_amount') is-invalid @enderror" name="deposit_amount" id="deposit-amount" placeholder="Payment amount" value="{{ old('deposit_amount') }}" onchange="depositConfirmModal()">
                  @error('deposit_amount')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> {{-- form-group col-md-4 --}}
              </div> {{-- form-row --}}

              <div class="row">
                <div class="col">
                  {{-- modal button --}}
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirm-deposit">
                  <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create
                  </button>
                  {{-- modal button --}}
                </div>
              </div> {{-- form-row --}}

              {{-- modal --}}
              <div class="modal fade" id="confirm-deposit" tabindex="-1" role="dialog" aria-labelledby="confirm-depositTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="confirm-depositTitle">Confirm Deposit</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">

                      <h3 class="text-center" id="confirm-deposit-amount">@if (old('deposit_amount')) ${{ old('deposit_amount') }} @else $0.00 @endif</h3>
                      <p class="text-center">Are you sure that you would like to create this deposit?</p>

                      {{-- send email to customer input --}}
                      <div class="row text-center mb-3">
                        <div class="col-sm">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="notify_customer_via_email" id="notify_customer_via_email_deposit">
                            <label class="custom-control-label" for="notify_customer_via_email_deposit">Notify customer via email</label>
                          </div>
                        </div>
                      </div>

                      <button type="submit" class="btn btn-primary btn-block" name="action" value="deposit">
                        <i class="fas fa-check mr-2" aria-hidden="true"></i>Confirm
                      </button>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}

            </form>
          </div> {{-- card-body --}}
        </div> {{-- card --}}
        {{-- create deposit payment form --}}

        @if ($selected_quote->getQuoteDepositPaymentsModels()->count())
          {{-- deposit payments --}}
          <div class="table-responsive my-3">
            <table class="table table-bordered table-fullwidth table-striped">
              <thead class="table-secondary">
                <tr>
                  <th>ID</th>
                  <th>Type</th>
                  <th>Amount</th>
                  <th>Method</th>
                  <th>Date</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($selected_quote->getQuoteDepositPaymentsModels() as $payment)
                  <tr>
                    <td>
                      <a href="{{ route('quote-payments.show', $payment->id) }}">
                        @if ($payment->void_date == null)
                          <span class="badge badge-success py-2 px-2">
                            {{ $payment->id }}
                          </span>
                        @else
                          <span class="badge badge-danger py-2 px-2">
                            {{ $payment->id }}
                          </span>
                        @endif
                      </a>
                    </td>
                    <td>{{ $payment->paymentType->title }}</td>
                    <td>
                      {{ $payment->getFormattedPaymentAmount() }}
                      @if ($payment->void_date != null)
                        <span class="text-danger"><b>VOID</b></span>
                      @endif
                    </td>
                    <td>{{ $payment->paymentMethod->title }}</td>
                    <td>{{ $payment->getFormattedCreationDate() }}</td>
                    <td class="text-center">
                      <a class="btn btn-primary btn-sm" href="{{ route('quote-payments.show', $payment->id) }}">
                        <i class="fas fa-eye" aria-hidden="true"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          {{-- deposit payments --}}
          {{-- deposit action buttons --}}
          <div class="row">
            <div class="col-4">
              <a href="{{ route('quote-deposits.show', $selected_quote->id) }}" class="btn btn-secondary btn-block">
                View Deposit
              </a>
            </div> {{-- col-4 --}}
            <div class="col-4">
              <form action="{{ route('quote-deposits.update', $selected_quote->id) }}" method="POST">
                @method('PATCH')
                @csrf
                @if ($selected_quote->deposit_emailed == 0)
                  <button class="btn btn-success btn-block" name="action" value="email">Finalise / Send</button>
                @else
                  <button class="btn btn-warning btn-block" name="action" value="email">Sent to Customer</button>
                @endif
              </form>
            </div> {{-- col-4 --}}
            <div class="col-4">
              @if ($selected_quote->deposit_posted == 0)
                <form action="{{ route('quote-deposits.update', $selected_quote->id) }}" method="POST">
                  @method('PATCH')
                  @csrf
                  <button class="btn btn-success btn-block" name="action" value="post">Finalise / Post</button>
                </form>
              @else
                <button class="btn btn-warning btn-block">Posted to Customer</button>
              @endif
            </div> {{-- col-4 --}}
          </div> {{-- row --}}
          {{-- deposit action buttons --}}
        @endif
        {{-- deposits section --}}

        {{-- deposit mark as accepted by the customer --}}
        @if ($selected_quote->deposit_accepted_date == null)
          <h5 class="text-primary my-3"><b>Mark As Accepted By Customer</b></h5>
          <form action="{{ route('quote-mark-as-accepted-custmer.update', $selected_quote->id) }}" method="POST">
            @method('PATCH')
            @csrf

            <div class="row row-cols-sm-3">
              <div class="col-sm mb-3">
                <button type="submit" class="btn btn-warning btn-block" name="action" value="2">
                  <i class="fas fa-marker mr-2" aria-hidden="true"></i>Will Pay By Card 
                </button>
              </div> {{-- col-sm --}}
              <div class="col-sm mb-3">
                <button type="submit" class="btn btn-warning btn-block" name="action" value="3">
                  <i class="fas fa-marker mr-2" aria-hidden="true"></i>Will Pay By Bank 
                </button>
              </div> {{-- col-sm --}}
              <div class="col-sm mb-3">
                <button type="submit" class="btn btn-warning btn-block" name="action" value="4">
                  <i class="fas fa-marker mr-2" aria-hidden="true"></i>Will Pay By Cheque 
                </button>
              </div> {{-- col-sm --}}
              <div class="col-sm mb-3">
                <button type="submit" class="btn btn-warning btn-block" name="action" value="6">
                  <i class="fas fa-marker mr-2" aria-hidden="true"></i>Paid By Bank 
                </button>
              </div> {{-- col-sm --}}
              <div class="col-sm mb-3">
                <button type="submit" class="btn btn-warning btn-block" name="action" value="7">
                  <i class="fas fa-marker mr-2" aria-hidden="true"></i>Paid By Cheque
                </button>
              </div> {{-- col-sm --}}
              <div class="col-sm mb-3">
                <button type="submit" class="btn btn-warning btn-block" name="action" value="8">
                  <i class="fas fa-marker mr-2" aria-hidden="true"></i>Pay On Completion Card
                </button>
              </div> {{-- col-sm --}}
              <div class="col-sm mb-3">
                <button type="submit" class="btn btn-warning btn-block" name="action" value="9">
                  <i class="fas fa-marker mr-2" aria-hidden="true"></i>Pay On Completion Cash
                </button>
              </div> {{-- col-sm --}}
              <div class="col-sm mb-3">
                <button type="submit" class="btn btn-warning btn-block" name="action" value="10">
                  <i class="fas fa-marker mr-2" aria-hidden="true"></i>Pay On Completion Bank
                </button>
              </div> {{-- col-sm --}}
              <div class="col-sm mb-3">
                <button type="submit" class="btn btn-warning btn-block" name="action" value="11">
                  <i class="fas fa-marker mr-2" aria-hidden="true"></i>Pay On Completion Cheque
                </button>
              </div> {{-- col-sm --}}
            </div> {{-- row --}}

          </form>
        @endif
        {{-- deposit mark as accepted by the customer --}}

        {{-- tax invoices table --}}
        <h5 class="text-primary my-3"><b>Tax Invoice</b></h5>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-row">
              <div class="form-group">

                <form action="{{ route('quote-tax-invoice-update-date.update', $selected_quote->id) }}" method="POST">
                  @method('PATCH')
                  @csrf

                  <div class="input-group mb-3">
                    @if ($selected_quote->tax_invoice_date == null)
                      <input class="form-control" type="date" name="tax_invoice_date">
                    @else
                      <input class="form-control" type="date" name="tax_invoice_date" value="{{ date('Y-m-d', strtotime($selected_quote->tax_invoice_date)) }}">
                    @endif
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="submit"><i class="fa fa-edit"></i></button>
                    </div>
                  </div>

                </form>

              </div> {{-- form-row --}}
            </div> {{-- form-row --}}
          </div> {{-- col-sm-6 --}}
          <div class="col-sm-6">
            <h5 class="text-primary my-3"><b>Opening Balance</b> <span class="text-dark">{{ $selected_quote->getTaxInvoiceOpeningBalance() }}</span></h5>
          </div> {{-- col-sm-6 --}}
        </div> {{-- row --}}
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <thead class="table-secondary">
              <tr>
                <th>Qty</th>
                <th width="50%">Item</th>
                <th>Rate</th>
                <th>Total</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr>

                <form action="{{ route('quote-tax-invoice-items.store') }}" method="POST">
                  @csrf

                  <input type="hidden" name="selected_quote_id" value="{{ $selected_quote->id }}">

                  <td>
                    <input type="text" class="form-control @error('tax_invoice_item_quantity') is-invalid @enderror" name="tax_invoice_item_quantity" value="{{ old('tax_invoice_item_quantity') }}">
                    @error('tax_invoice_item_quantity')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </td>
                  <td>
                    <input type="text" class="form-control @error('tax_invoice_item_title') is-invalid @enderror" name="tax_invoice_item_title" value="{{ old('tax_invoice_item_title') }}">
                    @error('tax_invoice_item_title')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </td>
                  <td>
                    <input type="text" class="form-control @error('tax_invoice_item_price') is-invalid @enderror" name="tax_invoice_item_price" value="{{ old('tax_invoice_item_price') }}">
                    @error('tax_invoice_item_price')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </td>
                  <td></td>
                  <td>
                    <button type="submit" class="btn btn-primary btn-sm">
                      <i class="fa fa-plus"></i>
                    </button>
                  </td>

                </form>

              </tr>
              @foreach ($selected_quote->quote_tax_invoice_items as $quote_tax_invoice_item)
                <tr>
                  <td>{{ $quote_tax_invoice_item->quantity }}</td>
                  <td>{{ $quote_tax_invoice_item->title }}</td>
                  <td>{{ $quote_tax_invoice_item->getIndividualPriceAttribute() }}</td>
                  <td>{{ $quote_tax_invoice_item->getTotalPriceAttribute() }}</td>
                  <td>
                    <form action="{{ route('quote-tax-invoice-items.destroy', $quote_tax_invoice_item->id) }}" method="POST">
                      @method('DELETE')
                      @csrf
                      <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash-alt" aria-hidden="true"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <form action="{{ route('quote-tax-invoice-extra-info.update', $selected_quote->id) }}" method="POST">
          @method('PATCH')
          @csrf

          <div class="form-group row">
            <label for="description" class="col-md-3 col-form-label"><input type="checkbox" @if ($selected_quote->tax_invoice_note != null) checked @endif onclick="toggle_visibility('note');"> Note</label>
              <div class="col">
                <div id="note" @if ($selected_quote->tax_invoice_note == null) style="display:none;" @endif>
                <textarea type="text" class="form-control @error('description') is-invalid @enderror" name="description" rows="3" placeholder="Please enter the note" style="resize:none">{{ old('description', $selected_quote->tax_invoice_note) }}</textarea>
                @error('description')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
                </div> {{-- visibility --}}
            </div> {{-- col-md-10 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="description" class="col-md-3 col-form-label"><input type="checkbox" @if ($selected_quote->tax_invoice_discount != 0) checked @endif onclick="toggle_visibility('discount');"> Discount</label>
              <div class="col">
                <div id="discount" @if ($selected_quote->tax_invoice_discount == 0) style="display:none;" @endif>
                  <input type="text" class="form-control @error('discount') is-invalid @enderror" name="discount" id="discount" value="{{ old('discount', $selected_quote->getTaxInvoiceDiscount()) }}" placeholder="Please enter the discount">
                  @error('discount')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> {{-- visibility --}}
            </div> {{-- col-md-10 --}}
          </div> {{-- form-group row --}}

          <button type="submit" class="btn btn-primary mb-3">
            <i class="fas fa-check mr-2" aria-hidden="true"></i>Save
          </button>
        </form>

        @if ($selected_quote->scheduled_payments->count())
          <div class="table-responsive">
            <table class="table table-bordered table-fullwidth table-striped">
              <thead class="table-secondary">
                <tr>
                  <th>Tax Invoice Date</th>
                  <th>Amount</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($selected_quote->scheduled_payments as $scheduled_payment)
                  <tr>
                    <td>{{ $scheduled_payment->getFormattedDate() }}</td>
                    <td>{{ $scheduled_payment->getFormattedPaymentAmount() }}</td>
                    <td class="text-center">
                      <form action="{{ route('quote-scheduled-payments.destroy', $scheduled_payment->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                        </button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
        @if ($selected_quote->deposit_accepted_date != null)
          <div class="row">
            <div class="col-4">
              <form action="{{ route('quote-scheduled-payments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="selected_quote_id" value="{{ $selected_quote->id }}">
                <button type="submit" class="btn btn-primary btn-block mb-3">
                  <i class="fas fa-plus mr-2" aria-hidden="true"></i>Add Scheduled Payment
                </button>
              </form>
            </div>
          </div>

          <div class="row">
            <div class="col-4">
              <a href="{{ route('quote-tax-invoices.show', $selected_quote->id) }}" class="btn btn-secondary btn-block">
                View Tax Invoice
              </a>
            </div>
            <div class="col-4">
              <form action="{{ route('quote-tax-invoices.update', $selected_quote->id) }}" method="POST">
                @method('PATCH')
                @csrf
                @if ($selected_quote->tax_invoice_emailed == 0)
                  <button class="btn btn-success btn-block" name="action" value="email">Finalise / Send</button>
                @else
                  <button class="btn btn-warning btn-block" name="action" value="email">Sent to Customer</button>
                @endif
              </form>
            </div>
            <div class="col-4">
              @if ($selected_quote->tax_invoice_posted == 0)
                <form action="{{ route('quote-tax-invoices.update', $selected_quote->id) }}" method="POST">
                  @method('PATCH')
                  @csrf
                  <button class="btn btn-success btn-block" name="action" value="post">Finalise / Post</button>
                </form>
              @else
                <button class="btn btn-warning btn-block">Posted to Customer</button>
              @endif
            </div>
          </div>
        @endif
        {{-- tax invoices table --}}

        {{-- payments section --}}
        <h5 class="text-primary my-3"><b>Payments</b></h5>
        {{-- create payment form --}}
        <div class="card">
          <div class="card-body">

            <form action="{{ route('quote-payments.store') }}" method="POST">
              @csrf

              <input type="hidden" name="selected_quote_id" value="{{ $selected_quote->id }}">

              <div class="form-row">
                <div class="form-group col-md-4">
                  <input class="form-control @error('payment_date') is-invalid @enderror" type="date" name="payment_date" value="{{ @old('payment_date') }}">
                  @error('payment_date')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> {{-- form-group col-md-4 --}}
                <div class="form-group col-md-4">
                  <select name="payment_method" class="custom-select @error('payment_method') is-invalid @enderror">
                    <option selected disabled>Payment method</option>
                    @foreach ($all_payment_methods as $payment_method)
                      <option value="{{ $payment_method->id }}" @if (old('payment_method') == $payment_method->id) selected @endif>{{ $payment_method->title }}</option>
                    @endforeach
                  </select>
                  @error('payment_method')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> {{-- form-group col-md-4 --}}
                <div class="form-group col-md-4">
                  <input type="text" class="form-control @error('payment_amount') is-invalid @enderror" name="payment_amount" id="payment-amount" placeholder="Payment amount" value="{{ old('payment_amount') }}" onchange="paymentConfirmModal()">
                  @error('payment_amount')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> {{-- form-group col-md-4 --}}
              </div> {{-- form-row --}}

              <div class="row">
                <div class="col">
                  {{-- modal button --}}
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirm-payment">
                  <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create
                  </button>
                  {{-- modal button --}}
                </div>
              </div> {{-- form-row --}}

              {{-- modal --}}
              <div class="modal fade" id="confirm-payment" tabindex="-1" role="dialog" aria-labelledby="confirm-paymentTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="confirm-paymentTitle">Confirm Payment</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">

                      <h3 class="text-center" id="confirm-payment-amount">@if (old('payment_amount')) ${{ old('payment_amount') }} @else $0.00 @endif</h3>
                      <p class="text-center">Are you sure that you would like to create this payment?</p>

                      {{-- send email to customer input --}}
                      <div class="row text-center mb-3">
                        <div class="col-sm">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="notify_customer_via_email" id="notify_customer_via_email_payment">
                            <label class="custom-control-label" for="notify_customer_via_email_payment">Notify customer via email</label>
                          </div>
                        </div>
                      </div>

                      <button type="submit" class="btn btn-primary btn-block" name="action" value="payment">
                        <i class="fas fa-check mr-2" aria-hidden="true"></i>Confirm
                      </button>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}

            </form>
          </div> {{-- card-body --}}
        </div> {{-- card --}}
        {{-- create payment form --}}

        @if ($selected_quote->getQuotePaymentsModels()->count())
          {{-- payments --}}
          <div class="table-responsive my-3">
            <table class="table table-bordered table-fullwidth table-striped">
              <thead class="table-secondary">
                <tr>
                  <th>ID</th>
                  <th>Type</th>
                  <th>Amount</th>
                  <th>Method</th>
                  <th>Date</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($selected_quote->getQuotePaymentsModels() as $payment)
                  <tr>
                    <td>
                      <a href="{{ route('quote-payments.show', $payment->id) }}">
                        @if ($payment->void_date == null)
                          <span class="badge badge-success py-2 px-2">
                            {{ $payment->id }}
                          </span>
                        @else
                          <span class="badge badge-danger py-2 px-2">
                            {{ $payment->id }}
                          </span>
                        @endif
                      </a>
                    </td>
                    <td>{{ $payment->paymentType->title }}</td>
                    <td>
                      {{ $payment->getFormattedPaymentAmount() }}
                      @if ($payment->void_date != null)
                        <span class="text-danger"><b>VOID</b></span>
                      @endif
                    </td>
                    <td>{{ $payment->paymentMethod->title }}</td>
                    <td>{{ $payment->getFormattedCreationDate() }}</td>
                    <td class="text-center">
                      <a class="btn btn-primary btn-sm" href="{{ route('quote-payments.show', $payment->id) }}">
                        <i class="fas fa-eye" aria-hidden="true"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          {{-- payments --}}
          {{-- final receipt table --}}
          <h5 class="text-primary my-3"><b>Final Receipt</b></h5>

          <div class="row">
            <div class="col-4">
              <a href="{{ route('quote-final-receipts.show', $selected_quote->id) }}" class="btn btn-secondary btn-block">
                View Final Invoice
              </a>
            </div>
            <div class="col-4">
              <form action="{{ route('quote-final-receipts.update', $selected_quote->id) }}" method="POST">
                @method('PATCH')
                @csrf
                @if ($selected_quote->final_receipt_emailed == 0)
                  <button class="btn btn-success btn-block" name="action" value="email">Finalise / Send</button>
                @else
                  <button class="btn btn-warning btn-block" name="action" value="email">Sent to Customer</button>
                @endif
              </form>
            </div>
            <div class="col-4">
              @if ($selected_quote->final_receipt_posted == 0)
                <form action="{{ route('quote-final-receipts.update', $selected_quote->id) }}" method="POST">
                  @method('PATCH')
                  @csrf
                  <button class="btn btn-success btn-block" name="action" value="post">Finalise / Post</button>
                </form>
              @else
                <button class="btn btn-warning btn-block">Posted to Customer</button>
              @endif
            </div>
          </div>
          <br>
          {{-- final receipt table --}}
        @endif
        {{-- payments section --}}

      </div> {{-- col --}}
    </div> {{-- row --}}
    {{-- content --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- Date Time Picker JS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.28.0/moment.min.js" integrity="sha512-Q1f3TS3vSt1jQ8AwP2OuenztnLU6LwxgyyYOG1jgMW/cbEMHps/3wjvnl1P3WTrF3chJUWEoxDUEjMxDV8pujg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-2JBCbWoMJPH+Uj7Wq5OLub8E5edWHlTM4ar/YJkZh3plwB2INhhOC3eDoqHm1Za/ZOSksrLlURLoyXVdfQXqwg==" crossorigin="anonymous"></script>
<script type="text/javascript">
  $(function () {
    $('#deposit_date').datetimepicker({
      icons: {
        time: "fas fa-clock",
        date: "fas fa-calendar-alt",
        up: "fas fa-chevron-up",
        down: "fas fa-chevron-down"
      },
      format: 'L'
    });
  });
</script>
<script type="text/javascript">
  $(function () {
    $('#payment_date').datetimepicker({
      icons: {
        time: "fas fa-clock",
        date: "fas fa-calendar-alt",
        up: "fas fa-chevron-up",
        down: "fas fa-chevron-down"
      },
      format: 'L'
    });
  });
</script>
{{-- Date Time Picker JS --}}

{{-- Insert deposit amount into confirm modal --}}
<script>
  function depositConfirmModal() {
    var deposit = document.getElementById("deposit-amount").value;
    document.getElementById("confirm-deposit-amount").innerHTML = '$' + deposit;
  }
</script>
{{-- Insert deposit amount into confirm modal --}}
{{-- Insert payment amount into confirm modal --}}
<script>
  function paymentConfirmModal() {
    var payment = document.getElementById("payment-amount").value;
    document.getElementById("confirm-payment-amount").innerHTML = '$' + payment;
  }
</script>
{{-- Insert payment amount into confirm modal --}}

{{-- Toggle Visibility By Id Generic --}}
<script type="text/javascript">
  function toggle_visibility(id) {
    var e = document.getElementById(id);
    if (e.style.display == 'none')
      e.style.display = 'block';
    else
      e.style.display = 'none';
  }
</script>
{{-- Toggle Visibility By Id Generic --}}
@endpush