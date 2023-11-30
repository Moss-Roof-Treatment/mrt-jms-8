@extends('layouts.app')

@section('title', '- Quote Reminders - Edit Selected Default Email Response Text')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">QUOTE REMINDERS</h3>
    <h5>Edit Selected Default Email Response Text</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('default-email-response-text.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Default Text Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-7">

        <p class="text-primary my-3"><b>Edit Default Email Response Text</b></p>

        <form action="{{ route('default-email-response-text.update', $selected_default_email_response_text->id) }}" method="POST" enctype="multipart/form-data">
          @method('PATCH')
          @csrf

          <div class="form-group row">
            <label for="text" class="col-md-3 col-form-label text-md-right">Text</label>
            <div class="col-md-8">
              <textarea class="form-control @error('text') is-invalid @enderror mb-2" type="text" name="text" rows="5" placeholder="Please enter the text" style="resize:none">{{ old('text', $selected_default_email_response_text->text) }}</textarea>
              @error('text')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <div class="col-md-8 offset-md-3">
              <div class="custom-control custom-radio custom-control-inline mb-2">
                <input type="radio" id="typeRadioInline1" name="type" class="custom-control-input @error('type') is-invalid @enderror mt-2" value="0" @if ($selected_default_email_response_text->type == 0) checked @endif>
                <label class="custom-control-label" for="typeRadioInline1">Waiting</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline mb-2">
                <input type="radio" id="typeRadioInline2" name="type" class="custom-control-input @error('type') is-invalid @enderror mt-2" value="1" @if ($selected_default_email_response_text->type == 1) checked @endif>
                <label class="custom-control-label" for="typeRadioInline2">Do Not Proceed</label>
              </div>
              @error('type')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <div class="col-md-8 offset-md-3">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
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
                      <a href="{{ route('default-email-response-text.edit', $selected_default_email_response_text->id) }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              <a href="{{ route('default-email-response-text.index') }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

        </form>

      </div> {{-- col-sm-7 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection