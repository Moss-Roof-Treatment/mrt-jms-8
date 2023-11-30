@extends('layouts.app')

@section('title', '- SMS - Generic SMS - Create New Generic SMS')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SMS</h3>
    <h5>Create New Generic SMS</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('generic-sms.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>SMS Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <form action="{{ route('generic-sms.store') }}" method="POST">
      @csrf

      <div class="row">
        <div class="col-sm-7">

          <h5 class="text-primary my-3"><b>Create New SMS</b></h5>

          <div class="form-group row">
            <label for="recipient_name" class="col-md-3 col-form-label text-md-right">Name</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('recipient_name') is-invalid @enderror mb-2" name="recipient_name" id="recipient_name" value="{{ old('recipient_name') }}" placeholder="Please enter the recipient name">
              @error('recipient_name')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="mobile_phone" class="col-md-3 col-form-label text-md-right">Mobile Phone</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('mobile_phone') is-invalid @enderror mb-2" name="mobile_phone" id="mobile_phone" value="{{ old('mobile_phone') }}" placeholder="Please enter the mobile phone number">
              @error('mobile_phone')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="message" class="col-md-3 col-form-label text-md-right">Message</label>
            <div class="col-md-8">
              <textarea class="form-control @error('message') is-invalid @enderror mb-2" type="text" name="message" rows="10" placeholder="Please enter the message" style="resize:none">{{ old('message') }}</textarea>
              @error('message')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

        </div> {{-- col-sm-7 --}}
        <div class="col-sm-5">

          <h5 class="text-primary my-3"><b>Internal Comment (Optional)</b></h5>
          <div class="form-group row">
            <div class="col-md">
              <textarea class="form-control @error('comment') is-invalid @enderror mb-2" type="text" name="comment" rows="6" placeholder="Please enter an optional additional comment if required" style="resize:none">{{ old('comment') }}</textarea>
              @error('comment')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

        </div> {{-- col-sm-5 --}}
      </div> {{-- row --}}

      <div class="row">
        <div class="col-sm-7">

          <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-3">
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
                      <a href="{{ route('generic-sms.create') }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              {{-- cancel button --}}
              <a href="{{ route('generic-sms.index') }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
              {{-- cancel button --}}
            </div>
          </div> {{-- form-group row --}}

        </div> {{-- col-sm-7 --}}
      </div> {{-- row --}}

    </form>

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection