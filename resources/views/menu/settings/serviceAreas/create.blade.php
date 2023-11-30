@extends('layouts.app')

@section('title', '- Service Areas - Create New Service Area')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SERVICE AREAS</h3>
    <h5>Create New Service Area</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('service-area-settings.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Service Area Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <p class="text-primary my-3"><b>Create New Service Area</b></p>

    <div class="row">
      <div class="col-sm-7">

        <form action="{{ route('service-area-settings.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="form-group row">
            <label for="title" class="col-md-3 col-form-label text-md-right">Title</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('title') is-invalid @enderror mb-2" name="title" id="title" value="{{ old('title') }}" placeholder="Please enter the title" autofocus>
              @error('title')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="subtitle" class="col-md-3 col-form-label text-md-right">Subtitle</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('subtitle') is-invalid @enderror mb-2" name="subtitle" id="subtitle" value="{{ old('subtitle') }}" placeholder="Please enter the subtitle">
              @error('subtitle')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="text" class="col-md-3 col-form-label text-md-right">Text</label>
            <div class="col-md-8">
              <textarea class="form-control @error('text') is-invalid @enderror mb-2" type="text" name="text" rows="5" placeholder="Please enter the text" style="resize:none">{{ old('text') }}</textarea>
              @error('text')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="video_link" class="col-md-3 col-form-label text-md-right">Video Link</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('video_link') is-invalid @enderror mb-2" name="video_link" id="video_link" value="{{ old('video_link') }}" placeholder="Please enter the video link">
              @error('video_link')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="video_text" class="col-md-3 col-form-label text-md-right">Video Text</label>
            <div class="col-md-8">
              <textarea class="form-control @error('video_text') is-invalid @enderror mb-2" type="text" name="video_text" rows="5" placeholder="Please enter the video text" style="resize:none">{{ old('video_text') }}</textarea>
              @error('video_text')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="second_subtitle" class="col-md-3 col-form-label text-md-right">Second Subtitle</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('second_subtitle') is-invalid @enderror mb-2" name="second_subtitle" id="second_subtitle" value="{{ old('second_subtitle') }}" placeholder="Please enter the second subtitle">
              @error('second_subtitle')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="second_text" class="col-md-3 col-form-label text-md-right">Second Text</label>
            <div class="col-md-8">
              <textarea class="form-control @error('second_text') is-invalid @enderror mb-2" type="text" name="second_text" rows="5" placeholder="Please enter the second text" style="resize:none">{{ old('second_text') }}</textarea>
              @error('second_text')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-3">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-check mr-2" aria-hidden="true"></i>Create
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
                    </div> {{-- modal-header --}}
                    <div class="modal-body">
                      <p class="text-center">Are you sure that you would like to reset this form?</p>
                      <a href="{{ route('service-area-settings.create') }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              <a href="{{ route('service-area-settings.index') }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
            </div> {{-- col-md-9 offset-md-2 --}}
          </div> {{-- form-group row mb-0 --}}

        </form>

      </div> {{-- col-sm-7 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection