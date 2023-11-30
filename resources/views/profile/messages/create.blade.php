@extends('layouts.profile')

@section('title', '- Profile')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">MY MESSAGES</h3>
    <h5>Create New Message</h5>
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

    <div class="row pt-3">
      <div class="col-sm-7">

        <h5 class="text-primary my-3"><b>Create New Message</b></h5>
        <form action="{{ route('profile-messages.store') }}" method="POST">
          @csrf

          <div class="form-group row">
            <label for="recipient" class="col-md-2 col-form-label text-md-right">Recipient</label>
            <div class="col-md-9">
              <select name="recipient" id="recipient" class="custom-select @error('recipient') is-invalid @enderror mb-2">
                <option selected disabled>Please select a salesperson</option>
                @foreach ($recipients as $recipient)
                  <option value="{{ $recipient->id }}" @if (old('recipient') == $recipient->id) selected @endif>{{ $recipient->getFullNameAttribute() }}</option>
                @endforeach
              </select>
              @error('recipient')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-6 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="priority" class="col-md-2 col-form-label text-md-right">Priority</label>
            <div class="col-md-9">
              <select name="priority" id="priority" class="custom-select @error('priority') is-invalid @enderror mb-2">
                <option selected disabled>Please select a salesperson</option>
                @foreach ($priorities as $priority)
                  <option value="{{ $priority->id }}" @if (old('priority') == $priority->id) selected @endif>{{ $priority->title }}</option>
                @endforeach
              </select>
              @error('priority')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-6 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="text" class="col-md-2 col-form-label text-md-right">Message</label>
            <div class="col-md-9">
              <textarea class="form-control @error('text') is-invalid @enderror mb-2" type="text" name="text" rows="10" placeholder="Please enter the message" style="resize:none">{{ old('text') }}</textarea>
              @error('text')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row mb-0">
            <div class="col-md-9 offset-md-2">
              <button class="btn btn-primary" type="submit">
                <i class="fas fa-check mr-2" aria-hidden="true"></i>Create
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
                      <a href="{{ route('profile-create-new-message.create') }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              {{-- cancel button --}}
              <a href="{{ route('profile-messages.index') }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
              {{-- cancel button --}}
            </div>
          </div> {{-- form-group row --}}

        </form>

      </div> {{-- col-sm-7 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection