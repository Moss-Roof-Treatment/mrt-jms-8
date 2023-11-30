@extends('layouts.profile')

@section('title', '- Profile - Job Internal Notes Create')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">JOB INTERNAL NOTES</h3>
    <h5>Create New Internal Job Note</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('profile-jobs.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Jobs Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('profile-jobs.show', $selected_quote->id) }}">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Job
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-7">

        <h5 class="text-primary my-3"><b>Create New Internal Job Note</b></h5>

        <form action="{{ route('profile-job-internal-notes.store') }}" method="POST">
          @csrf

          <input type="hidden" name="selected_quote_id" value="{{ $selected_quote->id }}">

          <div class="form-group row">
            <label for="quote_identifier" class="col-md-3 col-form-label text-md-right">Job Number</label>
            <div class="col-md-8 mb-2">
              <div class="input-group">
                <input type="text" class="form-control" name="quote_identifier" id="quote_identifier" aria-describedby="quote_identifier" value="{{ $selected_quote->quote_identifier }}" disabled>
                <input type="hidden" name="quote_id" value="{{ $selected_quote->id }}">
              </div>
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="recipient_id" class="col-md-3 col-form-label text-md-right">Recipient</label>
            <div class="col-md-8">
              <select name="recipient_id" id="recipient_id" class="custom-select @error('recipient_id') is-invalid @enderror mb-2">
                <option selected disabled>Please select a recipient</option>
                @foreach ($recipients as $recipient)
                  <option value="{{ $recipient->id }}" @if (old('recipient_id') == $recipient->id) selected @endif>
                    {{ $recipient->account_role->title  .' - ' . $recipient->getFullNameAttribute() }}
                  </option>
                @endforeach
              </select>
              @error('recipient_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-6 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="priority_id" class="col-md-3 col-form-label text-md-right">Priority</label>
            <div class="col-md-8">
              <select name="priority_id" id="priority_id" class="custom-select @error('priority_id') is-invalid @enderror mb-2">
                <option selected disabled>Please select a priority</option>
                @foreach ($priorities as $priority)
                  <option value="{{ $priority->id }}" @if (old('priority_id') == $priority->id) selected @endif>{{ $priority->title }}</option>
                @endforeach
              </select>
              @error('priority_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-6 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="text" class="col-md-3 col-form-label text-md-right">Text</label>
            <div class="col-md-8">
              <textarea type="text" class="form-control @error('text') is-invalid @enderror mb-2" name="text" rows="5" placeholder="Please enter the text" style="resize:none">{{ old('text') }}</textarea>
              @error('text')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <div class="col-md-8 offset-md-3">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-check mr-2" aria-hidden="true"></i>Create
              </button>
              {{-- reset modal --}}
              {{-- modal button --}}
              <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#confirmResetModal">
                <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
              </button>
              {{-- modal button --}}
              {{-- reset modal --}}
              <a href="{{ route('profile-jobs.show', $selected_quote->id) }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

        </form>

        {{-- reset modal --}}
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
                <form action="{{ route('profile-job-internal-notes.create') }}" method="GET">
                  <input type="hidden" name="selected_quote_id" value="{{ $selected_quote->id }}">
                  <button class="btn btn-dark btn-block">
                    <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                  </button>
                </form>
              </div> {{-- modal-body --}}
            </div> {{-- modal-content --}}
          </div> {{-- modal-dialog --}}
        </div> {{-- modal fade --}}
        {{-- modal --}}
        {{-- reset modal --}}

      </div> {{-- col-sm-7 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection