@extends('layouts.app')

@section('title', '- Frequently Asked Questions - Edit Selected Frequently Asked Question')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">FAQ SETTINGS</h3>
    <h5>Edit Selected Frequently Asked Question</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('faq-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>FAQ Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    {{-- edit selected faq form --}}
    <p class="text-primary my-3"><b>Edit Frequently Asked Question</b></p>

    <div class="row">
      <div class="col-sm-7">

        <form action="{{ route('faq-settings.update', $selected_faq->id) }}" method="POST">
          @method('PATCH')
          @csrf

          <div class="form-group row">
            <label for="question" class="col-md-2 col-form-label text-md-right">Question</label>
            <div class="col-md-9">
              <textarea class="form-control @error('question') is-invalid @enderror mb-2" type="text" name="question" rows="5" placeholder="Please enter the question" style="resize:none">{{ old('question', $selected_faq->question) }}</textarea>
              @error('question')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="answer" class="col-md-2 col-form-label text-md-right">Anwser</label>
            <div class="col-md-9">
              <textarea class="form-control @error('answer') is-invalid @enderror mb-2" type="text" name="answer" rows="5" placeholder="Please enter the answer" style="resize:none">{{ old('answer', $selected_faq->answer) }}</textarea>
              @error('answer')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <div class="col-md-9 offset-md-2">
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="isVisiblecustomRadioInline1" name="is_visible" class="custom-control-input" value="1" @if ($selected_faq->is_visible == 1) checked @endif>
                <label class="custom-control-label" for="isVisiblecustomRadioInline1">Is Visible</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="isVisiblecustomRadioInline2" name="is_visible" class="custom-control-input" value="0" @if ($selected_faq->is_visible == 0) checked @endif>
                <label class="custom-control-label" for="isVisiblecustomRadioInline2">Is Not Visible</label>
              </div>
              @error('is_visible')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 offset-md-2 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row mb-0">
            <div class="col-md-9 offset-md-2">
              {{-- create button --}}
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
              </button>
              {{-- create button --}}
              {{-- reset modal --}}
              {{-- modal button --}}
              <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
              </button>
              {{-- modal button --}}
              {{-- modal --}}
              <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalCenterTitle">Reset</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="text-center">Are you sure that you would like to reset this form?</p>
                      <a href="{{ route('faq-settings.edit', $selected_faq->id) }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              {{-- cancel button --}}
              <a href="{{ route('faq-settings.index') }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
              {{-- cancel button --}}
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

        </form>

      </div> {{-- col-sm-7 --}}
    </div> {{-- row --}}
    {{-- edit selected faq form --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection