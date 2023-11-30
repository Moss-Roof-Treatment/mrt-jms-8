@extends('layouts.app')

@section('title', '- Emails - View Selected Trashed Generic Email')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">EMAILS</h3>
    <h5>View Selected Trashed Generic Email</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('generic-emails-trash.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Trashed Email Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <form action="{{ route('generic-emails-trash.update', $selected_trashed_email->id) }}" method="POST">
          @method('PATCH')
          @csrf
          <button type="submit" class="btn btn-primary btn-block">
            <i class="fas fa-trash-restore mr-2" aria-hidden="true"></i>Restore
          </button>
        </form>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">

        {{-- delete modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModal">
          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Permanently Delete
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="deleteModalTitle">Permanently Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center">Are you sure that you would like to permanently delete this item?</p>
                <form method="POST" action="{{ route('generic-emails-trash.destroy', $selected_trashed_email->id) }}">
                  @method('DELETE')
                  @csrf
                  <button type="submit" class="btn btn-danger btn-block">
                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Trash
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
        {{-- modal --}}
        {{-- delete modal --}}
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- email details table --}}
    <h5 class="text-primary my-3"><b>Email Details</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <thead class="table-secondary">
          <tr>
            <th>Recipient</th>
            <th>Email</th>
            <th>Sender</th>
            <th>Sent Date</th>
            <th>Deleted Date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              @if (isset($selected_trashed_email->recipient_name))
                {{ $selected_trashed_email->recipient_name }}
              @else
                <p class="text-center">
                  <span class="badge badge-warning py-2 px-2">
                    <i class="fas fa-times mr-2" aria-hidden="true"></i>The recipient name was not set
                  </span>
                </p>
              @endif
            </td>
            <td>{{ $selected_trashed_email->recipient_email }}</td>
            <td>{{ $selected_trashed_email->staff->getFullNameAttribute() }}</td>
            <td>{{ date('d/m/y - h:iA', strtotime($selected_trashed_email->created_at)) }}</td>
            <td>{{ date('d/m/y - h:iA', strtotime($selected_trashed_email->deleted_at)) }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- email details table --}}

    {{-- email content --}}
    <h5 class="text-primary my-3"><b>Email Content</b></h5>
    <div class="card">
      <div class="card-body pb-0">
        <p><b>{{ $selected_trashed_email->subject }}</b></p>
        <p>{!! nl2br($selected_trashed_email->text) !!}</p>
      </div> {{-- card-body --}}
    </div> {{-- card --}}
    {{-- email content --}}

    {{-- email internal comment --}}
    <h5 class="text-primary my-3"><b>Internal Comment</b></h5>
    <div class="card">
      <div class="card-body pb-0">
        @if (!isset($selected_trashed_email->comment))
          <p class="text-center">There is no internal comment to display</p>
        @else  
          <p>{{ $selected_trashed_email->comment }}</p>
        @endif
      </div> {{-- card-body --}}
    </div> {{-- card --}}
    {{-- email internal comment --}}

    {{-- email attachments --}}
    <h5 class="text-primary my-3"><b>Email Attachments</b></h5>
    @if (!$selected_trashed_email->attachments->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no attatchments to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>Title</th>
              <th>Storage Path</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($selected_trashed_email->attachments as $attachment)
              <tr>
                <td>{{ $attachment->title }}</td>
                <td>{{ $attachment->storage_path }}</td>
                <td class="text-center" width="15%">
                  <a href="{{ route('generic-emails-download-file.show', $attachment->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-download mr-2" aria-hidden="true"></i>Download
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- email attachments --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection