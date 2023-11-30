@extends('layouts.welcome')

@section('title', 'Main Menu')

@section('content')
<section class="text-center">
  <div class="container py-5">

    {{-- title --}}
    @if ($selected_system->logo_path == null)
      <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/logo-359x190.jpg') }}" alt="">
    @else
      <img class="img-fluid" src="{{ asset($selected_system->logo_path) }}" alt="">
    @endif
    <h1 class="my-3 text-primary"><b>MAIN MENU</b></h1>
    {{-- title --}}

    {{-- card menu --}}
    <div class="row row-cols-1 row-cols-md-4">
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('incoming-call.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/incoming-call-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Incoming Call</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h3 class="card-title text-dark"><b>Incoming Call</b></h3>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('quotes.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/quote-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Quotes ({{ $pending_quote_requests_count ?? '0' }})</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h3 class="card-title text-dark"><b>Quotes ({{ $pending_quote_requests_count ?? '0' }})</b></h3>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('jobs.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/briefcase-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Jobs</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h3 class="card-title text-dark"><b>Jobs</b></h3>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('search.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/magnifying-glass-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Search</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h3 class="card-title text-dark"><b>Search</b></h3>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('customers.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/user-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Customers ({{ $customer_notes_count ?? '0' }})</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h3 class="card-title text-dark"><b>Customers ({{ $customer_notes_count ?? '0' }})</b></h3>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      @if(auth()->user()->account_role_id == 1)
        <div class="col mb-4">
          <div class="card h-100 shadow-sm">
            <a href="{{ route('staff.index') }}" class="text-decoration-none">
              <img class="img-fluid" src="{{ asset('storage/images/icons/staff-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
              <div class="d-none d-sm-block">
                <h5 class="card-title text-dark"><b>Staff ({{ $salesperson_notes_count ?? '0' }})</b></h5>
              </div>
              <div class="d-block d-sm-none">
                <h3 class="card-title text-dark"><b>Staff ({{ $salesperson_notes_count ?? '0' }})</b></h3>
              </div>
            </a>
          </div> {{-- card h-100 shadow --}}
        </div> {{-- col mb-4 --}}
        <div class="col mb-4">
          <div class="card h-100 shadow-sm">
            <a href="{{ route('tradespersons.index') }}" class="text-decoration-none">
              <img class="img-fluid" src="{{ asset('storage/images/icons/tradesperson-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
              <div class="d-none d-sm-block">
                <h5 class="card-title text-dark"><b>Tradespersons ({{ $tradesperson_notes_count ?? '0' }})</b></h5>
              </div>
              <div class="d-block d-sm-none">
                <h3 class="card-title text-dark"><b>Tradespersons ({{ $tradesperson_notes_count ?? '0' }})</b></h3>
              </div>
            </a>
          </div> {{-- card h-100 shadow --}}
        </div> {{-- col mb-4 --}}
        <div class="col mb-4">
          <div class="card h-100 shadow-sm">
            <a href="{{ route('contractors.index') }}" class="text-decoration-none">
              <img class="img-fluid" src="{{ asset('storage/images/icons/contractor-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
              <div class="d-none d-sm-block">
                <h5 class="card-title text-dark"><b>Contractors</b></h5>
              </div>
              <div class="d-block d-sm-none">
                <h3 class="card-title text-dark"><b>Contractors</b></h3>
              </div>
            </a>
          </div> {{-- card h-100 shadow --}}
        </div> {{-- col mb-4 --}}
      @endif
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('notes.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/notepad-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Notes ({{ $notes_count ?? '0' }})</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h3 class="card-title text-dark"><b>Notes ({{ $notes_count ?? '0' }})</b></h3>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('calendar.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/calendar-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Calendar ({{ $event_count ?? '0' }})</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h3 class="card-title text-dark"><b>Calendar ({{ $event_count ?? '0' }})</b></h3>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      @if(auth()->user()->account_role_id == 1)
        <div class="col mb-4">
          <div class="card h-100 shadow-sm">
            <a href="{{ route('reports.index') }}" class="text-decoration-none">
              <img class="img-fluid" src="{{ asset('storage/images/icons/chart-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
              <div class="d-none d-sm-block">
                <h5 class="card-title text-dark"><b>Reports</b></h5>
              </div>
              <div class="d-block d-sm-none">
                <h3 class="card-title text-dark"><b>Reports</b></h3>
              </div>
            </a>
          </div> {{-- card h-100 shadow --}}
        </div> {{-- col mb-4 --}}
        <div class="col mb-4">
          <div class="card h-100 shadow-sm">
            <a href="{{ route('invoices.index') }}" class="text-decoration-none">
              <img class="img-fluid" src="{{ asset('storage/images/icons/invoice-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
              <div class="d-none d-sm-block">
                <h5 class="card-title text-dark"><b>Invoices ({{ $pending_invoice_count ?? '0' }})</b></h5>
              </div>
              <div class="d-block d-sm-none">
                <h3 class="card-title text-dark"><b>Invoices ({{ $pending_invoice_count ?? '0' }})</b></h3>
              </div>
            </a>
          </div> {{-- card h-100 shadow --}}
        </div> {{-- col mb-4 --}}
        <div class="col mb-4">
          <div class="card h-100 shadow-sm">
            <a href="{{ route('stock-control.index') }}" class="text-decoration-none">
              <img class="img-fluid" src="{{ asset('storage/images/icons/stock-control-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
              <div class="d-none d-sm-block">
                <h5 class="card-title text-dark"><b>Stock Control ({{ $pending_order_count ?? '0' }})</b></h5>
              </div>
              <div class="d-block d-sm-none">
                <h3 class="card-title text-dark"><b>Stock Control ({{ $pending_order_count ?? '0' }})</b></h3>
              </div>
            </a>
          </div> {{-- card h-100 shadow --}}
        </div> {{-- col mb-4 --}}
      @endif
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('emails.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/email-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Emails ({{ $email_reminder_count ?? '0' }})</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h3 class="card-title text-dark"><b>Emails ({{ $email_reminder_count ?? '0' }})</b></h3>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      @if(auth()->user()->account_role_id == 1)
        <div class="col mb-4">
          <div class="card h-100 shadow-sm">
            <a href="{{ route('sms.index') }}" class="text-decoration-none">
              <img class="img-fluid" src="{{ asset('storage/images/icons/mobile-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
              <div class="d-none d-sm-block">
                <h5 class="card-title text-dark"><b>SMS</b></h5>
              </div>
              <div class="d-block d-sm-none">
                <h3 class="card-title text-dark"><b>SMS</b></h3>
              </div>
            </a>
          </div> {{-- card h-100 shadow --}}
        </div> {{-- col mb-4 --}}
      @endif
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('messages.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/messages-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Messages ({{ $new_message_count ?? '0' }})</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h3 class="card-title text-dark"><b>Messages ({{ $new_message_count ?? '0' }})</b></h3>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('site-contacts.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/envelope-blue-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Site Contact ({{ $pending_site_contact_count ?? '0' }})</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h3 class="card-title text-dark"><b>Site Contact ({{ $pending_site_contact_count ?? '0' }})</b></h3>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      @if(auth()->user()->account_role_id == 1)
        <div class="col mb-4">
          <div class="card h-100 shadow-sm">
            <a href="{{ route('equipment.index') }}" class="text-decoration-none">
              <img class="img-fluid" src="{{ asset('storage/images/icons/tools-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
              <div class="d-none d-sm-block">
                <h5 class="card-title text-dark"><b>Equipment</b></h5>
              </div>
              <div class="d-block d-sm-none">
                <h3 class="card-title text-dark"><b>Equipment</b></h3>
              </div>
            </a>
          </div> {{-- card h-100 shadow --}}
        </div> {{-- col mb-4 --}}
      @endif
      <div class="col mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ route('content.index') }}" class="text-decoration-none">
            <img class="img-fluid" src="{{ asset('storage/images/icons/newspaper-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
            <div class="d-none d-sm-block">
              <h5 class="card-title text-dark"><b>Content</b></h5>
            </div>
            <div class="d-block d-sm-none">
              <h3 class="card-title text-dark"><b>Content</b></h3>
            </div>
          </a>
        </div> {{-- card h-100 shadow --}}
      </div> {{-- col mb-4 --}}
      @if(auth()->user()->account_role_id == 1)
        <div class="col mb-4">
          <div class="card h-100 shadow-sm">
            <a href="{{ route('systems.show', 1) }}" class="text-decoration-none">
              <img class="img-fluid" src="{{ asset('storage/images/icons/program-window-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
              <div class="d-none d-sm-block">
                <h5 class="card-title text-dark"><b>System</b></h5>
              </div>
              <div class="d-block d-sm-none">
                <h3 class="card-title text-dark"><b>System</b></h3>
              </div>
            </a>
          </div> {{-- card h-100 shadow --}}
        </div> {{-- col mb-4 --}}
        <div class="col mb-4">
          <div class="card h-100 shadow-sm">
            <a href="{{ route('settings.index') }}" class="text-decoration-none">
              <img class="img-fluid" src="{{ asset('storage/images/icons/gear-256x256.jpg') }}" class="card-img-top" style="max-width:128px;" alt="...">
              <div class="d-none d-sm-block">
                <h5 class="card-title text-dark"><b>Settings</b></h5>
              </div>
              <div class="d-block d-sm-none">
                <h3 class="card-title text-dark"><b>Settings</b></h3>
              </div>
            </a>
          </div> {{-- card h-100 shadow --}}
        </div> {{-- col mb-4 --}}
      @endif
    </div> {{-- row row-cols-1 row-cols-md-3 --}}
    {{-- card menu --}}

  </div> {{-- container --}}
</section> {{-- section--}}

<section class="bg-primary">
  <div class="container py-5">

    {{-- search fields --}}
    <div class="row">
      <div class="col-sm-8 offset-sm-2">

        {{-- customer search --}}
        <p class="text-white"><b>Customer Search</b></p>
        <form action="{{ route('menu.customer.search') }}" method="POST">
          @csrf
          <div class="input-group">
            <input type="text" class="form-control" name="customer_name" placeholder="Please enter the customer name" aria-label="Customer Search" aria-describedby="customer-search">
            <div class="input-group-append">
              <button class="btn btn-secondary" type="submit">
                <i class="fas fa-search mr-2" aria-hidden="true"></i>Search
              </button>
            </div>
          </div>
          @error('customer_name')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </form>
        {{-- customer search --}}

        {{-- quote search --}}
        <p class="text-white mt-3"><b>Quote Search</b></p>
        <form action="{{ route('menu.quote.search') }}" method="POST">
          @csrf
          <div class="input-group">
            <input type="text" class="form-control" name="quote_id" placeholder="Please enter the quote number" aria-label="Quote Search" aria-describedby="quote-search">
            <div class="input-group-append">
              <button class="btn btn-secondary" type="submit">
                <i class="fas fa-search mr-2" aria-hidden="true"></i>Search
              </button>
            </div>
          </div>
          @error('quote_id')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </form>
        {{-- quote search --}}

        {{-- job search --}}
        <p class="text-white mt-3"><b>Job Search</b></p>
        <form action="{{ route('menu.job.search') }}" method="POST">
          @csrf
          <div class="input-group">
            <input type="text" class="form-control" name="job_id" placeholder="Please enter the job number" aria-label="Job Search" aria-describedby="job-search">
            <div class="input-group-append">
              <button class="btn btn-secondary" type="submit">
                <i class="fas fa-search mr-2" aria-hidden="true"></i>Search
              </button>
            </div>
          </div>
          @error('quote_id')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </form>
        {{-- job search --}}

      </div> {{-- col-sm-8 offset-sm-2 --}}
    </div> {{-- row --}}
    {{-- search fields --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection