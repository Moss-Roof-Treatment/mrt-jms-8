@extends('layouts.app')

@section('title', '- Survey Testimonials - Edit Selected Survey Testimonial')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SURVEY TESTIMONIALS</h3>
    <h5>Edit Selected Survey Testimonial</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('survey-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Survey Testimonials Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-7">

        <p class="text-primary my-3"><b>Edit Selected Survey Testimonial</b></p>

        <form action="{{ route('survey-settings.update', $selected_survey->id) }}" method="POST" enctype="multipart/form-data">
          @method('PATCH')
          @csrf

          <div class="form-group row">
            <label for="text" class="col-md-2 col-form-label text-md-right">Testimonial</label>
            <div class="col-md-9">
              <textarea class="form-control @error('text') is-invalid @enderror mb-2" type="text" name="text" rows="10" placeholder="Please enter the text" style="resize:none">{{ $selected_survey->survey_testimonial->text }}</textarea>
              @error('text')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <div class="col">
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="visibilityCustomRadioInline1" name="is_visible" class="custom-control-input" value="0" {{ $selected_survey->survey_testimonial->is_visible == 0 ? 'checked' : null }}>
                <label class="custom-control-label" for="visibilityCustomRadioInline1">Not Visible</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="visibilityCustomRadioInline2" name="is_visible" class="custom-control-input" value="1" {{ $selected_survey->survey_testimonial->is_visible == 1 ? 'checked' : null }}>
                <label class="custom-control-label" for="visibilityCustomRadioInline2">Is Visible</label>
              </div>
              @error('visibility')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col --}}
          </div> {{-- form-group row --}}

          <div class="form-group row mb-0">
            <div class="col-md-9 offset-md-2">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
              </button>
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
                      <a href="{{ route('survey-settings.edit', $selected_survey->survey_testimonial->id) }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              <a href="{{ route('survey-settings.index') }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
            </div>
          </div> {{-- form-group row --}}

        </form>

      </div> {{-- col-sm-7 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection
