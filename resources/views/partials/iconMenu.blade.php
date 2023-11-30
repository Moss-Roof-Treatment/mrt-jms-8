@auth
<div class="d-none d-sm-block bg-white">
  <ul class="nav justify-content-center  nav-fill text-center">
    <li class="nav-item my-auto">
      <a class="nav-link text-dark" href="{{ route('incoming-call.index') }}">
        <img class="img-fluid" style="width:32px;" src="{{ asset('storage/images/icons/incoming-call-256x256.jpg') }}" alt="">
        <br><b>Incoming Call</b>
      </a>
    </li>
    <li class="nav-item my-auto">
      <a class="nav-link text-dark" href="{{ route('customers.index') }}">
        <img class="img-fluid" style="width:32px;" src="{{ asset('storage/images/icons/user-256x256.jpg') }}" alt="">
        <br><b>Customers</b>
      </a>
    </li>
    <li class="nav-item my-auto">
      <a class="nav-link text-dark" href="{{ route('quotes.index') }}">
        <img class="img-fluid" style="width:32px;" src="{{ asset('storage/images/icons/invoice-256x256.jpg') }}" alt="">
        <br><b>Quotes ({{ $pending_quote_requests_count ?? '0' }})</b>
      </a>
    </li>
    <li class="nav-item my-auto">
      <a class="nav-link text-dark" href="{{ route('jobs.index') }}">
        <img class="img-fluid" style="width:32px;" src="{{ asset('storage/images/icons/briefcase-256x256.jpg') }}" alt="">
        <br><b>Jobs</b>
      </a>
    </li>
    <li class="nav-item my-auto">
      <a class="nav-link text-dark" href="{{ route('search.index') }}">
        <img class="img-fluid" style="width:32px;" src="{{ asset('storage/images/icons/magnifying-glass-256x256.jpg') }}" alt="">
        <br><b>Search</b>
      </a>
    </li>
    <li class="nav-item my-auto">
      <a class="nav-link text-dark" href="{{ route('calendar.index') }}">
        <img class="img-fluid" style="width:32px;" src="{{ asset('storage/images/icons/calendar-256x256.jpg') }}" alt="">
        <br><b>Calendar ({{ $event_count ?? '0' }}) <br> Sold Jobs ({{ $unknown_event_count ?? '0' }})</b>
      </a>
    </li>
    @if(auth()->user()->account_role_id == 1)
      <li class="nav-item my-auto">
        <a class="nav-link text-dark" href="{{ route('reports.index') }}">
          <img class="img-fluid" style="width:32px;" src="{{ asset('storage/images/icons/chart-256x256.jpg') }}" alt="">
          <br><b>Reports</b>
        </a>
      </li>
    @endif
    <li class="nav-item my-auto">
      <a class="nav-link text-dark py-0 px-0 my-0 mx-0" href="{{ route('emails.index') }}">
        <img class="img-fluid" style="width:32px;" src="{{ asset('storage/images/icons/email-256x256.jpg') }}" alt="">
        <br><b>Emails ({{ $email_reminder_count ?? 0 }}) </b>
      </a>
      <a href="{{ route('site-contacts.index') }}" class="nav-link text-dark py-0 px-0 my-0 mx-0">
        <b>Site Contacts ({{ $site_contacts_count ?? 0 }}) </b>
      </a>
    </li>
    @if(auth()->user()->account_role_id == 1)
      <li class="nav-item my-auto">
        <a class="nav-link text-dark" href="{{ route('invoices.index') }}">
          <img class="img-fluid" style="width:32px;" src="{{ asset('storage/images/icons/invoice-256x256.jpg') }}" alt="">
          <br><b>Invoices ({{ $pending_invoice_count ?? '0' }})</b>
        </a>
      </li>
    @endif
    <li class="nav-item my-auto">
      <a class="nav-link text-dark py-0 px-0 my-0 mx-0" href="{{ route('notes.index') }}">
        <img class="img-fluid" style="width:32px;" src="{{ asset('storage/images/icons/notepad-256x256.jpg') }}" alt="">
        <br><b>Notes ({{ $notes_count ?? '0' }})</b>
      </a>
      <form action="{{ route('notes-filter.index') }}" method="POST">
        @csrf
        <input type="hidden" name="account_role_id" value="5">
        <button type="submit" class="btn btn-link text-dark text-decoration-none py-0 px-0 my-0 mx-0"><b>Customer ({{ $customer_notes_count ?? '0' }})</b></button>
      </form>
      <form action="{{ route('notes-filter.index') }}" method="POST">
        @csrf
        <input type="hidden" name="account_role_id" value="2">
        <button type="submit" class="btn btn-link text-dark text-decoration-none py-0 px-0 my-0 mx-0"><b>Salesperson ({{ $salesperson_notes_count ?? '0' }})</b></button>
      </form>
    </li>
    @if(auth()->user()->account_role_id == 1)
      <li class="nav-item my-auto">
        <a class="nav-link text-dark" href="{{ route('tradespersons.index') }}">
          <img class="img-fluid" style="width:32px;" src="{{ asset('storage/images/icons/tradesperson-256x256.jpg') }}" alt="">
          <br><b>Tradespersons ({{ $tradesperson_notes_count ?? '0' }})</b>
        </a>
      </li>
      <li class="nav-item my-auto">
        <a class="nav-link text-dark" href="{{ route('sms.index') }}">
          <img class="img-fluid" style="width:32px;" src="{{ asset('storage/images/icons/mobile-256x256.jpg') }}" alt="">
          <br><b>SMS</b>
        </a>
      </li>
      <li class="nav-item my-auto">
        <a class="nav-link text-dark" href="{{ route('settings.index') }}">
          <img class="img-fluid" style="width:32px;" src="{{ asset('storage/images/icons/gear-256x256.jpg') }}" alt="">
          <br><b>Settings</b>
        </a>
      </li>
    @endif
  </ul>
</div> {{-- d-none d-sm-block bg-white --}}
@endauth