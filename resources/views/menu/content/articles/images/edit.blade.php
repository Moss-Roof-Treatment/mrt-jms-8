@extends('layouts.app')

@section('title', 'Content - Articles - Edit Selected Article Image')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">ARTICLES IMAGES</h3>
    <h5>Edit Selected Article Image</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('articles.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Article Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('articles.show', $selected_article_image->article_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Article
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-8 my-2">

        <h5 class="text-primary my-3"><b>Edit Image Details</b></h5>

        <form action="{{ route('article-images.update', $selected_article_image->id) }}" method="POST" enctype="multipart/form-data">
          @method('PATCH')
          @csrf

          <div class="form-group row">
            <label for="description" class="col-md-2 col-form-label text-md-right">Description</label>
            <div class="col-md-9">
              <textarea class="form-control @error('description') is-invalid @enderror mb-2" type="text" name="description" rows="5" placeholder="Please enter the description" style="resize:none">{{ old('description', $selected_article_image->description) }}</textarea>
              @error('description')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="alt_tag_label" class="col-md-2 col-form-label text-md-right">Alt Tag Label</label>
            <div class="col-md-9">
              <input id="alt_tag_label" type="text" class="form-control @error('alt_tag_label') is-invalid @enderror mb-2" name="alt_tag_label" value="{{ $selected_article_image->alt_tag_label }}" placeholder="Please enter the alt tag label">
              @error('alt_tag_label')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="image" class="col-md-2 col-form-label text-md-right">Image</label>
            <div class="col-md-9">
              <div class="custom-file">
                <label class="custom-file-label" for="image" id="image_name">Please select a article image to upload</label>
                <input type="file" class="custom-file-input" name="image" id="image" aria-describedby="articleImage">
              </div> {{-- custom-file --}}
              @error('image')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="is_visible" class="col-md-2 col-form-label text-md-right">Visibility</label>
            <div class="col-md-9">
              <div class="custom-control custom-radio custom-control-inline my-2">
                <input type="radio" id="isVisiblecustomRadioInline1" name="is_visible" class="custom-control-input" value="1" @if ($selected_article_image->is_visible == 1) checked @endif>
                <label class="custom-control-label" for="isVisiblecustomRadioInline1">Is Visible</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline my-2">
                <input type="radio" id="isVisiblecustomRadioInline2" name="is_visible" class="custom-control-input" value="0" @if ($selected_article_image->is_visible == 0) checked @endif>
                <label class="custom-control-label" for="isVisiblecustomRadioInline2">Is Not Visible</label>
              </div>
              @error('is_visible')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="is_featured" class="col-md-2 col-form-label text-md-right">Featured</label>
            <div class="col-md-9">
              <div class="custom-control custom-radio custom-control-inline my-2">
                <input type="radio" id="isFeaturedcustomRadioInline1" name="is_featured" class="custom-control-input" value="1" @if ($selected_article_image->is_featured == 1) checked @endif>
                <label class="custom-control-label" for="isFeaturedcustomRadioInline1">Is Featured</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline my-2">
                <input type="radio" id="isFeaturedcustomRadioInline2" name="is_featured" class="custom-control-input" value="0" @if ($selected_article_image->is_featured == 0) checked @endif>
                <label class="custom-control-label" for="isFeaturedcustomRadioInline2">Is Not Featured</label>
              </div>
              @error('is_featured')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
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
                      <a href="{{ route('article-images.edit', $selected_article_image->id) }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              <a href="{{ route('article-images.show', $selected_article_image->id) }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
            </div>
          </div> {{-- form-group row --}}

        </form>

      </div> {{-- col-sm-7 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section>{{-- section --}}
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