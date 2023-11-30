@extends('layouts.app')

@section('title', '- SMS - Generic SMS - View Selected Generic SMS')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SMS</h3>
    <h5>View Selected Generic SMS</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('generic-sms.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Generic SMS Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- sms details table --}}
    <h5 class="text-primary my-3"><b>SMS Details</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <thead class="table-secondary">
          <tr>
            <th>Recipient Name</th>
            <th>Mobile Number</th>
            <th>Sender Name</th>
            <th>Sent Date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              @if (isset($selected_sms->recipient_name))
                {{ $selected_sms->recipient_name }}
              @else
                <p class="text-center">
                  <span class="badge badge-warning py-2 px-2">
                    <i class="fas fa-times mr-2" aria-hidden="true"></i>The recipient name was not set
                  </span>
                </p>
              @endif
            </td>
            <td>{{ $selected_sms->mobile_phone }}</td>
            <td>{{ $selected_sms->sender->getFullNameAttribute() }}</td>
            <td>{{ date('d/m/y - h:iA', strtotime($selected_sms->created_at)) . ' (' . $selected_sms->created_at->diffForHumans() . ')' }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- sms details table --}}

    {{-- sms content --}}
    <h5 class="text-primary my-3"><b>SMS Content</b></h5>
    <div class="card">
      <div class="card-body pb-0">
        <p>{!! nl2br($selected_sms->text) !!}</p>
      </div> {{-- card-body --}}
    </div> {{-- card --}}
    {{-- sms content --}}

    {{-- sms internal comment --}}
    <h5 class="text-primary my-3"><b>Internal Comment</b></h5>
    <div class="card">
      <div class="card-body pb-0">
        @if (!isset($selected_sms->comment))
          <h5 class="text-center">There is no internal comment to display</h5>
        @else  
          <p>{{ $selected_sms->comment }}</p>
        @endif
      </div> {{-- card-body --}}
    </div> {{-- card --}}
    {{-- sms internal comment --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection