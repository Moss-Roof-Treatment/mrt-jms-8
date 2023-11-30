@auth
<div class="d-none d-sm-block bg-white">
  <ul class="nav justify-content-center  nav-fill text-center">
    <li class="nav-item my-auto">
      <a class="nav-link text-dark" href="{{ route('profile-jobs.index') }}">
        <img class="img-fluid" style="width:32px;" src="{{ asset('storage/images/icons/briefcase-256x256.jpg') }}" alt="">
        <br><b>Jobs ({{ $current_jobs_count ?? '0' }})</b>
      </a>
    </li>
    <li class="nav-item my-auto">
      <a class="nav-link text-dark" href="{{ route('profile-calendar.index') }}">
        <img class="img-fluid" style="width:32px;" src="{{ asset('storage/images/icons/calendar-256x256.jpg') }}" alt="">
        <br><b>Calendar ({{ $my_today_events ?? '0' }})</b>
      </a>
    </li>
    <li class="nav-item my-auto">
      <a class="nav-link text-dark" href="{{ route('profile-notes.index') }}">
        <img class="img-fluid" style="width:32px;" src="{{ asset('storage/images/icons/notepad-256x256.jpg') }}" alt="">
        <br><b>Notes ({{ $new_notes_count ?? '0' }})</b>
      </a>
    </li>
    <li class="nav-item my-auto">
      <a class="nav-link text-dark" href="{{ route('profile-invoices.index') }}">
        <img class="img-fluid" style="width:32px;" src="{{ asset('storage/images/icons/invoice-256x256.jpg') }}" alt="">
        <br><b>Invoices ({{ $all_outstanding_invoices ?? '0' }})</b>
      </a>
    </li>
    <li class="nav-item my-auto">
      <a class="nav-link text-dark" href="{{ route('profile-messages.index') }}">
        <img class="img-fluid" style="width:32px;" src="{{ asset('storage/images/icons/messages-256x256.jpg') }}" alt="">
        <br><b>Messages ({{ $new_messages_count ?? '0' }})</b>
      </a>
    </li>
    <li class="nav-item my-auto">
      <a class="nav-link text-dark" href="{{ route('profile.index') }}">
        <img class="img-fluid" style="width:32px;" src="{{ asset('storage/images/icons/tradesperson-256x256.jpg') }}" alt="">
        <br><b>My Profile</b>
      </a>
    </li>
  </ul>
</div> {{-- d-none d-sm-block bg-white --}}
@endauth