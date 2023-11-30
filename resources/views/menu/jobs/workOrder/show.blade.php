@extends('layouts.jquery')

@section('title', '- View Selected Work Order')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">WORK ORDER</h3>
    <h5>View Selected Work Order</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('jobs.show', $selected_quote->job_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Job
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('quotes.show', $selected_quote->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-file-invoice mr-2" aria-hidden="true"></i>View Quote
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('customers.show', $selected_quote->customer_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-user mr-2" aria-hidden="true"></i>View Customer
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

  </div> {{-- container --}}
</section> {{-- section --}}

<section class="bg-dark">
  <div class="container py-5">

    <div class="card mt-5 py-5">
      <div class="card-body">

        {{-- letterhead --}}
        <img class="img-fluid" src="{{ asset('storage/images/letterheads/mrt-work-order-letterhead.jpg') }}" alt="">
        {{-- letterhead --}}

        <div class="row">
          <div class="col-sm-6">
            <h4 class="text-primary text-center py-2"><b>Customer No: <span class="text-danger">{{ $selected_quote->customer_id }}</span></b></h4>
          </div> {{-- col-sm-6 --}}
          <div class="col-sm-6">
            <h4 class="text-primary text-center py-2"><b>Quote No: <span class="text-danger">{{ $selected_quote->quote_identifier }}</span></b></h4>
          </div> {{-- col-sm-6 --}}
        </div> {{-- row --}}

        <div class="row">
          <div class="col-sm">

            <table class="table table-bordered table-fullwidth table-striped bg-white">
              <tbody>
                <tr>
                  <th>Name</th>
                  <td>{{ $selected_quote->customer->getFullNameAttribute() }}</td>
                </tr>
                <tr>
                  <th>Address</th>
                  <td>{{ $selected_quote->job->tenant_street_address }}</td>
                </tr>
                <tr>
                  <th>Suburb</th>
                  <td>{{ $selected_quote->job->tenant_suburb . ' ' . $selected_quote->job->tenant_postcode }}</td>
                </tr>
                <tr>
                  <th>Email</th>
                  <td>{{ $selected_quote->customer->email }}</td>
                </tr>
              </tbody>
            </table>

          </div> {{-- col-sm --}}
          <div class="col-sm">

            <table class="table table-bordered table-fullwidth table-striped bg-white">
              <tbody>
                <tr>
                  <th>Phone</th>
                  <td>
                    @if ($selected_quote->customer->home_phone == null)
                      <span class="badge badge-light py-2 px-2">
                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                      </span>
                    @else
                      {{ $selected_quote->customer->home_phone }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Mobile</th>
                  <td>
                    @if ($selected_quote->customer->mobile_phone == null)
                      <span class="badge badge-light py-2 px-2">
                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                      </span>
                    @else
                      {{ $selected_quote->customer->mobile_phone }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Business</th>
                  <td>
                    @if ($selected_quote->customer->business_phone == null)
                      <span class="badge badge-light py-2 px-2">
                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                      </span>
                    @else
                      {{ $selected_quote->customer->business_phone }}
                    @endif
                  </td>
                </tr>
              </tbody>
            </table>

          </div> {{-- col-sm --}}
          <div class="col-sm">

            <table class="table table-bordered table-fullwidth table-striped bg-white">
              <tbody>
                <tr>
                  <th width="40%">Start Approx</th>
                  <td>
                    @if ($selected_quote->job->start_date == null)
                      <span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>To Be Confirmed</span>
                    @else
                      {{ date('d/m/y - h:iA', strtotime($selected_quote->job->start_date)) }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Signed Date</th>
                  <td></td>
                </tr>
              </tbody>
            </table>

          </div> {{-- col-sm --}}
        </div> {{-- row --}}

        <h5 class="text-secondary py-2"><b>WORK LIST / JOB SPECIFICATIONS</b></h5>
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <tbody>
            @foreach ($all_quote_tasks as $quote_task)
              <tr>
                <td>{{ $quote_task->task->task_type->title }}</td>
                <td>{{ $quote_task->task->title }}</td>
                <td width="65%">{{ $quote_task->task->procedure }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="row text-center">
          <div class="col-sm">

            <p><span class="text-primary">Quote For: </span>Moss Roof Treatment</p>
            <p><span class="text-primary">Total Fixed Price: </span>{{ $selected_quote->getFormattedQuoteTotal() }}</p>

          </div> {{-- col-sm --}}
          <div class="col-sm">

            <p class="text-primary"><b>25% Deposit</b></p>
            <p>{{ $selected_quote->getFormattedDepositTotal() }}</p>

          </div> {{-- col-sm --}}
          <div class="col-sm">

            <p class="text-primary"><b>Payable Upon Completion</b></p>
            <p><span class="text-primary">Balance: </span>{{ $selected_quote->getFormattedDepositBalanceOnCompletion() }}</p>

          </div> {{-- col-sm --}}
        </div> {{-- row --}}

        {{-- footer --}}
        <img class="img-fluid" src="{{ asset('storage/images/letterheads/mrt-letter-footer.jpg') }}" alt="">
        {{-- footer --}}

      </div> {{-- card-body --}}
    </div> {{-- card --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection
