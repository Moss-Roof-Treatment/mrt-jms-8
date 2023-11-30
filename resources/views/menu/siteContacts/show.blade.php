@extends('layouts.app')

@section('title', '- Systems - View All Settings')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SITE CONTACT</h3>
    <h5>View All Site Contacts</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('site-contacts.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Site Contact Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        {{-- acknowledge modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#confirmAcknowledgement">
          @if ($selected_site_contact->acknowledged_at == null)
            <i class="fas fa-check-circle mr-2" aria-hidden="true"></i>Acknowledge
          @else
            <i class="fas fa-times-circle mr-2" aria-hidden="true"></i>Un-Acknowledge
          @endif
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="confirmAcknowledgement" tabindex="-1" role="dialog" aria-labelledby="confirmAcknowledgementTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                @if ($selected_site_contact->acknowledged_at == null)
                  <h5 class="modal-title" id="confirmAcknowledgementTitle">Confirm Acknowledgement</h5>
                @else
                  <h5 class="modal-title" id="confirmAcknowledgementTitle">Confirm Un-acknowledgement</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div> {{-- modal-header --}}
              <div class="modal-body">
                @if ($selected_site_contact->acknowledged_at == null)
                  <p class="subtitle text-center">Are you sure that you would like to acknowledge the selected item...?</p>
                @else
                  <p class="subtitle text-center">Are you sure that you would like to un-acknowledge the selected item...?</p>
                @endif
                <form method="POST" action="{{ route('site-contacts.update', $selected_site_contact->id) }}">
                  @method('PATCH')
                  @csrf
                  <button type="submit" class="btn btn-dark btn-block">
                    @if ($selected_site_contact->acknowledged_at == null)
                      <i class="fas fa-check-circle mr-2" aria-hidden="true"></i>Acknowledge
                    @else
                      <i class="fas fa-times-circle mr-2" aria-hidden="true"></i>Un-Acknowledge
                    @endif
                  </button>
                </form>
              </div> {{-- modal-body --}}
            </div> {{-- modal-content --}}
          </div> {{-- modal-dialog --}}
        </div> {{-- modal fade --}}
        {{-- modal --}}
        {{-- acknowledge modal --}}
      </div> {{-- col --}}
      <div class="col">
        {{-- trash modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#newTrashModal{{$selected_site_contact->id}}">
          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Trash
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="newTrashModal{{$selected_site_contact->id}}" tabindex="-1" role="dialog" aria-labelledby="newTrashModal{{$selected_site_contact->id}}Title" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="newTrashModal{{$selected_site_contact->id}}Title">Confirm Trash</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center">Are you sure that you would like to trash the selected item?</p>
                <form method="POST" action="{{ route('site-contacts.destroy', $selected_site_contact->id) }}">
                  @method('DELETE')
                  @csrf
                  <button type="submit" class="btn btn-danger btn-block">
                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Confirm Trash
                  </button>
                </form>
              </div> {{-- modal-body --}}
            </div> {{-- modal-content --}}
          </div> {{-- modal-dialog --}}
        </div> {{-- modal fade --}}
        {{-- modal --}}
        {{-- trash modal --}}
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        @if ($selected_site_contact->is_spam == 1)
          <a href="#" class="btn btn-warning btn-block disabled" tabindex="-1" role="button" aria-disabled="true">
            <i class="fas fa-lock mr-2" aria-hidden="true"></i>Is Spam
          </a>
        @else
          <form action="{{ route('site-contacts-spam-filter.store') }}" method="POST">
            @csrf
            <input type="hidden" name="site_contact_id" value="{{ $selected_site_contact->id }}">
            <button type="submit" class="btn btn-warning btn-block">
              <i class="fas fa-lock mr-2" aria-hidden="true"></i>Add To Spam List
            </button>
          </form>
        @endif
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- message contact details table --}}
    <h5 class="text-primary my-3"><b>Message Details</b></h5>
    <div class="table-responsive">
    <table class="table table-bordered table-fullwidth table-striped bg-white text-nowrap">
      <thead class="table-secondary">
        <tr>
          <th>Sender Name</th>
          <th>Date Received</th>
          <th>Response Date</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ $selected_site_contact->name }}</td>
          <td>{{ date('d/m/y - h:iA', strtotime($selected_site_contact->created_at)) . ' (' . $selected_site_contact->created_at->diffForHumans() . ')' }}</td>
          <td>
            @if (!$selected_site_contact->responses->count())
              <span class="badge badge-warning py-2 px-2">
                <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending Response
              </span>
            @else
              {{ date('d/m/y h:iA', strtotime($selected_site_contact->responses->first()->created_at)) . ' (' . $selected_site_contact->responses->first()->created_at->diffForHumans() . ')' }}
            @endif
          </td>
        </tr>
      </tbody>
    </table>
    </div> {{-- table-responsive --}}
    {{-- message contact details table --}}

    {{-- message details table --}}
    <h5 class="text-primary my-3"><b>Contact Details</b></h5>
    <div class="table-responsive">
    <table class="table table-bordered table-fullwidth table-striped bg-white text-nowrap">
      <thead class="table-secondary">
        <tr>
          <th>Email</th>
          <th>Phone</th>
          <th>Street Address</th>
          <th>Suburb</th>
          <th>Postcode</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            @if (!$selected_site_contact->email)
              <span class="badge badge-light py-2 px-2">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
              </span>
            @else
              {{ $selected_site_contact->email }}
            @endif
          </td>
          <td>
            @if (!$selected_site_contact->contact_phone)
              <span class="badge badge-light py-2 px-2">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
              </span>
            @else
              {{ $selected_site_contact->contact_phone }}
            @endif
          </td>
          <td>
            @if (!$selected_site_contact->street_address)
              <span class="badge badge-light py-2 px-2">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
              </span>
            @else
              {{ $selected_site_contact->street_address }}
            @endif
          </td>
          <td>
            @if (!$selected_site_contact->suburb)
              <span class="badge badge-light py-2 px-2">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
              </span>
            @else
              {{ $selected_site_contact->suburb }}
            @endif
          </td>
          <td>
            @if (!$selected_site_contact->postcode)
              <span class="badge badge-light py-2 px-2">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
              </span>
            @else
              {{ $selected_site_contact->postcode }}
            @endif
          </td>
        </tr>
      </tbody>
    </table>
    </div> {{-- table-responsive --}}
    {{-- message details table --}}

    {{-- device details table --}}
    <h5 class="text-primary my-3"><b>Device Details</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white text-nowrap">
        <thead class="table-secondary">
          <th>IP Address</th>
          <th>Referrer</th>
          <th>User Agent</th>
        </thead>
        <tbody>
          <tr>
            <td>{{ $selected_site_contact->ip_address }}</td>
            <td>{{ $selected_site_contact->referrer }}</td>
            <td>{{ $selected_site_contact->user_agent }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- device details table --}}

    {{-- message --}}
    <h5 class="text-primary my-3"><b>Message</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <tbody>
          <tr>
            <td>{{ $selected_site_contact->text }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- message --}}

    {{-- message responses --}}
    <h5 class="text-primary my-3"><b>Responses</b></h5>
    @if ($selected_site_contact->responses->count())
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <tbody>
            @foreach ($selected_site_contact->responses as $reply)
              <tr>
                <td><i class="fas fa-user mr-2" aria-hidden="true"></i>{{ $reply->staff->getFullNameAttribute() }}</td>
                <td class="text-right"><i class="fas fa-calendar-alt mr-2" aria-hidden="true"></i>{{ date('d/m/y h:iA', strtotime($reply->created_at)) }}</td>
              </tr>
              <tr>
                <td colspan="2">{{ $reply->text }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- message responses --}}

    {{-- message response form --}}
    <form action="{{ route('site-contacts-response.store') }}" method="POST">
      @csrf

      <input type="hidden" name="message_id" value="{{ $selected_site_contact->id }}">

      <div class="form-group row">
        <div class="col">
          <textarea class="form-control @error('message') is-invalid @enderror" type="text" name="message" rows="5" placeholder="Please enter the response" style="resize:none">{{ old('message') }}</textarea>
          @error('message')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div> {{-- col --}}
      </div> {{-- form-group row --}}

      <button type="submit" class="btn btn-primary">
        <i class="fas fa-reply mr-2" aria-hidden="true"></i>Reply
      </button>
    </form>
    {{-- message response form --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection