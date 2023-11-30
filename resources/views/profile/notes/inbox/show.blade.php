@extends('layouts.profile')

@section('title', '- Profile')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">MY NOTES</h3>
    <h5>View Selected Note</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('profile-notes.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Notes Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- note details table --}}
    <h5 class="text-primary my-3"><b>Note Details</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
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
            <td>{{ $selected_note->id }}</td>
            <td>{{ $selected_note->sender->getFullNameAttribute() }}</td>
            <td>
              @if ($selected_note->recipient_id == null)
                <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
              @else
                {{ $selected_note->recipient->getFullNameAttribute() }}
              @endif
            </td>
            <td>{{ date('d/m/y - h:iA', strtotime($selected_note->created_at)) }}</td>
            <td class="text-center">
              @if ($selected_note->priority_id == null)
                <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
              @else
                <span class="badge badge-{{ $selected_note->priority->colour->brand }} py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>{{ $selected_note->priority->title . ' (' . $selected_note->priority->resolution_amount . ' ' . $selected_note->priority->resolution_period . ')' }}</span>
              @endif
            </td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- note details table --}}

    {{-- note message --}}
    <h5 class="text-primary my-3"><b>Message</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <tbody>
          <tr>
            <td>{{ $selected_note->text }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- note message --}}

    {{-- response form --}}
    <form action="{{ route('profile-note-responses.store') }}" method="POST">
      @csrf

      <input type="hidden" class="input" name="note_id" value="{{ $selected_note->id }}">

      <div class="form-group row">
        <div class="col-sm">
          <textarea type="text" class="form-control @error('text') is-invalid @enderror mb-2" name="text" rows="5" placeholder="Please enter your response here" style="resize:none">{{ old('text') }}</textarea>
          @error('text')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div> {{-- col-md-8 --}}
      </div> {{-- form-group row --}}

      <div class="form-group row">
        <div class="col-sm">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-reply mr-2" aria-hidden="true"></i>Reply
          </button>
          {{-- reset modal --}}
          {{-- modal button --}}
          <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#confirmResetModal">
            <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
          </button>
          {{-- modal button --}}
          {{-- modal --}}
          <div class="modal fade" id="confirmResetModal" tabindex="-1" role="dialog" aria-labelledby="confirmResetModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="confirmResetModalTitle">Reset</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p class="text-center">Are you sure that you would like to reset this form?</p>
                  <a href="{{ route('profile-notes.show', $selected_note->id) }}" class="btn btn-dark btn-block">
                    <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                  </a>
                </div> {{-- modal-body --}}
              </div> {{-- modal-content --}}
            </div> {{-- modal-dialog --}}
          </div> {{-- modal fade --}}
          {{-- modal --}}
          {{-- reset modal --}}
          <a href="{{ route('profile-notes.index') }}" class="btn btn-dark">
            <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
          </a>
        </div> {{-- col-md-8 --}}
      </div> {{-- form-group row --}}

    </form>
    {{-- response form --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection