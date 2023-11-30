@extends('layouts.app')

@section('title', '- Quote Reminder Emails - View All Sent Quote Reminder Emails')

@section('content')
<section>
  <div class="container-fluid py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">QUOTE REMINDER</h3>
    <h5>View All Sent Quote Reminder Emails</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-6 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('quote-reminder-emails.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Reminder Email Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('set-quote-email-reminders.index') }}">
          <i class="fas fa-envelope mr-2" aria-hidden="true"></i>Sent Quote Reminders
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection
