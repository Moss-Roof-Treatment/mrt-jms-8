@extends('layouts.profile')

@section('title', '- Profile')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">MY MESSAGES</h3>
    <h5>View My Inbox</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('profile-messages.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Messages Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- message details table --}}
    <h5 class="text-primary my-3"><b>Message Details</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white text-nowrap">
        <thead class="table-secondary">
          <tr>
            <th>ID</th>
            <th>Sender</th>
            <th>Recipient</th>
            <th>Received Date</th>
            <th>Priority</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $selected_message->id }}</td>
            <td>{{ $selected_message->sender->getFullNameAttribute() }}</td>
            <td>{{ $selected_message->recipient->getFullNameAttribute() }}</td>
            <td>{{ date('d/m/y - h:iA', strtotime($selected_message->created_at)) }}</td>
            <td class="text-center">
              @if ($selected_message->priority_id == null)
                <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
              @else
                <span class="badge badge-{{ $selected_message->priority->colour->brand }} py-2 px-2">
                  <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>
                  {{ $selected_message->priority->title . ' (' . $selected_message->priority->resolution_amount . ' ' . $selected_message->priority->resolution_period . ')' }}
                </span>
              @endif
            </td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- message details table --}}

    <h5 class="text-primary my-3"><b>Message Attachments</b></h5>
        @if (!$selected_message->message_attachments->count())
          <div class="card">
            <div class="card-body">
              <h5 class="text-center mb-0">There are no attachments to display.</h5>
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @else
          <div class="table-responsive">
            <table class="table table-bordered table-fullwidth table-striped bg-white">
              <tbody>
                @foreach ($selected_message->message_attachments as $attachment)
                  <tr>
                    <td>{{ $attachment->title }}</td>
                    <td class="text-center">
                      <a class="btn btn-dark btn-sm" href="{{ route('messages-download-attachment.show', $attachment->id) }}">
                        <i class="fas fa-download" aria-hidden="true"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div> {{-- table-responsive --}}
        @endif

    {{-- message text --}}
    <h5 class="text-primary my-3"><b>Message</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <tbody>
          <tr>
            <td>{{ $selected_message->text }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- message text --}}

    {{-- message responses --}}
    <h5 class="text-primary my-3"><b>Responses</b></h5>
    @if ($replies->count())
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <tbody>
            @foreach ($replies as $reply)
              <tr>
                <td><i class="fas fa-user mr-2" aria-hidden="true"></i>{{ $reply->sender->getFullNameAttribute() }}</td>
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

    {{-- create message response form --}}
    <form action="{{ route('profile-messages-reply.store') }}" method="POST">
      @csrf

      <input type="hidden" class="input" name="message_id" value="{{ $selected_message->id }}">

      <div class="form-group row">
        <div class="col-md">
          <textarea class="form-control @error('text') is-invalid @enderror mb-2" type="text" name="text" rows="5" placeholder="Please enter your response" style="resize:none">{{ old('text') }}</textarea>
          @error('text')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div> {{-- col-md-9 --}}
      </div> {{-- form-group row --}}

      <div class="form-group row">
        <div class="col-md">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-reply mr-2" aria-hidden="true"></i>Reply
          </button>
          <a class="btn btn-dark" href="{{ route('profile-messages.index') }}">
            <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
          </a>
        </div> {{-- col-md-9 --}}
      </div> {{-- form-group row --}}

    </form>
    {{-- create message response form --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection