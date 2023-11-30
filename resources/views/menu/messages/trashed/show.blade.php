@extends('layouts.app')

@section('title', '- Messages - View Selected Trashed Message')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">MESSAGES</h3>
    <h5>View Selected Trashed Message</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('messages-trash.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Trashed Email Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <form action="{{ route('messages-trash.update', $selected_trashed_message->id) }}" method="POST">
          @method('PATCH')
          @csrf
          <button type="submit" class="btn btn-primary btn-block">
            <i class="fas fa-trash-restore mr-2" aria-hidden="true"></i>Restore
          </button>
        </form>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">

        {{-- modal start --}}
        <a class="btn btn-danger btn-block modal-button" data-target="confirm-delete">
          <i class="fas fa-dumpster mr-2" aria-hidden="true"></i>Permanently Delete
        </a>
        <div class="modal" id="confirm-delete">
          <div class="modal-background"></div>
          <div class="modal-content">
            <div class="box">
              <p class="title text-center text-danger">Confirm Delete</p>
              <p class="subtitle text-center">Are you sure you would like to permanently delete the selected message...?</p>
              <form method="POST" action="{{ route('messages-trash.destroy', $selected_trashed_message->id) }}">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-danger btn-block">
                  <i class="fas fa-dumpster mr-2" aria-hidden="true"></i>Permanently Delete
                </button>
              </form>
            </div> {{-- box --}}
          </div> {{-- modal-content --}}
          <button class="modal-close is-large" aria-label="close"></button>
        </div> {{-- modal --}}
        {{-- modal end --}}

      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm">

        {{-- message details table --}}
        <h5 class="text-primary my-3"><b>Message Details</b></h5>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>ID</th>
                <td>{{ $selected_trashed_message->id }}</td>
              </tr>
              <tr>
                <th>Sender</th>
                <td>{{ $selected_trashed_message->sender->getFullNameAttribute() }}</td>
              </tr>
              <tr>
                <th>Recipient</th>
                <td>{{ $selected_trashed_message->recipient->getFullNameAttribute() }}</td>
              </tr>
              <tr>
                <th>Priority</th>
                <td>
                  @if ($selected_trashed_message->priority_id == null)
                    <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
                  @else
                    <span class="badge badge-{{ $selected_trashed_message->priority->colour->brand }} py-2 px-2">
                      <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>
                      {{ $selected_trashed_message->priority->title . ' (' . $selected_trashed_message->priority->resolution_amount . ' ' . $selected_trashed_message->priority->resolution_period . ')' }}
                    </span>
                  @endif
                </td>
              </tr>
              <tr>
                <th>Sent Date</th>
                <td>{{ date('d/m/y - h:iA', strtotime($selected_trashed_message->created_at)) }}</td>
              </tr>
              <tr>
                <th>Trash Date</th>
                <td>{{ date('d/m/y - h:iA', strtotime($selected_trashed_message->deleted_at)) }}</td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}
        {{-- message details table --}}

      </div> {{-- col-sm --}}
      <div class="col-sm">

        <h5 class="text-primary my-3"><b>Message Attachments</b></h5>
        @if (!$selected_trashed_message->message_attachments->count())
          <div class="card">
            <div class="card-body">
              <h5 class="text-center mb-0">Please fill out the search form</h5>
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @else
          <div class="table-responsive">
            <table class="table table-bordered table-fullwidth table-striped bg-white">
              <tbody>
                @foreach ($selected_trashed_message->message_attachments as $attachment)
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

      </div> {{-- col-sm --}}
    </div> {{-- row --}}

    {{-- message text --}}
    <h5 class="text-primary my-3"><b>Message</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <tbody>
          <tr>
            <td>{{ $selected_trashed_message->text }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- message text --}}

    {{-- message responses --}}
    @if ($selected_trashed_message->replies->count())
      <h5 class="text-primary my-3"><b>Responses</b></h5>
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <tbody>
            @foreach ($selected_trashed_message->replies as $reply)
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

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection