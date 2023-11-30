@extends('layouts.app')

@section('title', '- Settings - Edit Selected Testimonial')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">TESTIMONIALS</h3>
    <h5>Edit Selected Testimonial</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('manual-testimonials-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Testimonials Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-7">

        <p class="text-primary my-3"><b>Edit Testimonial</b></p>

        <form action="{{ route('manual-testimonials-settings.update', $selected_testimonial->id) }}" method="POST" enctype="multipart/form-data">
          @method('PATCH')
          @csrf

          <div class="form-group row">
            <label for="staff_id" class="col-md-3 col-form-label text-md-right">Staff Member</label>
            <div class="col-md-8">
              <select name="staff_id" id="staff_id" class="custom-select @error('staff_id') is-invalid @enderror mb-2">
                @if (old('staff_id'))
                  <option disabled>Please select a staff member</option>
                  @foreach ($staff_members as $staff_member)
                    <option value="{{ $staff_member->id }}" @if (old('staff_id') == $staff_member->id) selected @endif>{{ $staff_member->getFullNameTitleAttribute() }}</option>
                  @endforeach
                @else
                  @if ($selected_testimonial->user_id == null)
                    <option selected disabled>Please select a staff member</option>
                  @else
                    <option selected value="{{ $selected_testimonial->user_id }}">{{ $selected_testimonial->user->getFullNameTitleAttribute()}}</option>
                    <option disabled>Please select a staff member</option>
                  @endif
                  @foreach ($staff_members as $staff_member)
                    <option value="{{ $staff_member->id }}">{{ $staff_member->getFullNameTitleAttribute() }}</option>
                  @endforeach
                @endif
              </select>
              @error('staff_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="name" class="col-md-3 col-form-label text-md-right">Name</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('name') is-invalid @enderror mb-2" name="name" id="name" value="{{ old('name', $selected_testimonial->name) }}" placeholder="Please enter the name">
              @error('name')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="text" class="col-md-3 col-form-label text-md-right">Text</label>
            <div class="col-md-8">
              <textarea class="form-control @error('text') is-invalid @enderror mb-2" type="text" name="text" rows="5" placeholder="Please enter the text" style="resize:none">{{ @old('text', $selected_testimonial->text) }}</textarea>
              @error('text')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <div class="col-md-8 offset-md-3 mb-2">
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="isVisibleCustomRadioInline1" name="is_visible" class="custom-control-input" value="0" {{ $selected_testimonial->is_visible == 0 ? 'checked' : null }}>
                <label class="custom-control-label" for="isVisibleCustomRadioInline1">Not Visible</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="isVisibleCustomRadioInline2" name="is_visible" class="custom-control-input" value="1" {{ $selected_testimonial->is_visible == 1 ? 'checked' : null }}>
                <label class="custom-control-label" for="isVisibleCustomRadioInline2">Is Visible</label>
              </div>
              @error('is_visible')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 offset-md-3 mb-2 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="image" class="col-md-3 col-form-label text-md-right">Image</label>
            <div class="col-md-8">
              <div class="custom-file">
                <label class="custom-file-label" for="image" id="image_name">Please select an image to upload</label>
                <input type="file" class="custom-file-input" name="image" id="image" aria-describedby="contentImage">
              </div> {{-- custom-file --}}
              @error('image')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <div class="col-md-8 offset-md-3">
              {{-- edit button --}}
              <button type="submit" class="btn btn-primary">
                  <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
              </button>
              {{-- edit button --}}
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
                      <a href="{{ route('manual-testimonials-settings.edit', $selected_testimonial->id) }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              {{-- cancel button --}}
              <a href="{{ route('manual-testimonials-settings.index') }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
              {{-- cancel button --}}
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

        </form>

      </div>
    </div>

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
<script>
  // Display the filename of the selected file to the user in the view from the upload form.
  var image = document.getElementById("image");
  image.onchange = function(){
    if (image.files.length > 0)
    {
      document.getElementById('image_name').innerHTML = image.files[0].name;
    }
  };
</script>
@endpush