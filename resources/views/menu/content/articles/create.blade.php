@extends('layouts.jquery')

@section('title', 'Content - Articles - Create New Article')

@push('css')
{{-- bootstrap-select css --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css">
{{-- bootstrap-select css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">ARTICLES</h3>
    <h5>Create A New Article</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('articles.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Article Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-8">

        <h5 class="text-primary my-3"><b>Create New Article</b></h5>

        <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="form-group row">
            <label for="title" class="col-md-2 col-form-label text-md-right">Title</label>
            <div class="col-md-9">
              <input id="title" type="text" class="form-control @error('title') is-invalid @enderror mb-2" name="title" value="{{ old('title') }}" placeholder="Please enter the title" autofocus>
              @error('title')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="subtitle" class="col-md-2 col-form-label text-md-right">Subtitle</label>
            <div class="col-md-9">
              <input id="subtitle" type="text" class="form-control @error('subtitle') is-invalid @enderror mb-2" name="subtitle" value="{{ old('subtitle') }}" placeholder="Please enter the subtitle">
              @error('subtitle')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="text" class="col-md-2 col-form-label text-md-right">Text</label>
            <div class="col-md-9">
              <textarea class="form-control @error('text') is-invalid @enderror mb-2" type="text" name="text" rows="10" placeholder="Please enter the text" style="resize:none">{{ old('text') }}</textarea>
              @error('text')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="category_id" class="col-md-2 col-form-label text-md-right">Category</label>
            <div class="col-md-9">
              <select name="category_id" id="category_id" class="custom-select @error('category_id') is-invalid @enderror mb-2">
                <option selected disabled>Please select a category</option>
                @foreach ($all_categories as $category)
                  <option value="{{ $category->id }}" @if (old('category_id') == $category->id) selected @endif>{{ $category->title }}</option>
                @endforeach
              </select>
              @error('category_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="tags" class="col-md-2 col-form-label text-md-right">Tags</label>
            <div class="col-md-9">
              <select name="tags[]" class="form-control border selectpicker @error('tags') is-invalid @enderror mb-2" multiple="multiple" data-style="bg-white" data-live-search="true" data-size="5" data-container="#for-bootstrap-select" title="Please select the tags">
                @foreach ($all_tags as $tag)
                  <option 
                    value="{{ $tag->id }}"
                    class="form-control" 
                    @if(old('tags'))
                      @if (in_array($tag->id, old('tags'))) 
                        selected 
                      @endif
                    @endif
                  >
                    {{ $tag->title }}
                  </option>
                @endforeach
              </select>
              @error('tags')
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
                <input type="radio" id="isVisibleRadioInline1" name="is_visible" class="custom-control-input @error('is_visible') is-invalid @enderror mt-2" value="0" @if (old('is_visible') == 0) checked @endif>
                <label class="custom-control-label" for="isVisibleRadioInline1">Is Not Visible</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline my-2">
                <input type="radio" id="isVisibleRadioInline2" name="is_visible" class="custom-control-input @error('is_visible') is-invalid @enderror mt-2" value="1" @if (old('is_visible') == 1) checked @endif>
                <label class="custom-control-label" for="isVisibleRadioInline2">Is Visible</label>
              </div>
              @error('is_visible')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="location" class="col-md-3 col-form-label text-md-right">Location</label>
            <div class="col-md-8">
              <input id="location" type="text" class="form-control @error('location') is-invalid @enderror mb-2" name="location" value="{{ old('location') }}" placeholder="Please enter the location">
              @error('location')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="completed_date" class="col-md-3 col-form-label text-md-right">Completed Date</label>
            <div class="col-md-8">
              <input type="date" class="form-control @error('completed_date') is-invalid @enderror mb-2" name="completed_date" id="completed_date" value="{{ old('completed_date') }}">
              @error('completed_date')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="published_date" class="col-md-3 col-form-label text-md-right">Published Date</label>
            <div class="col-md-8">
              <input type="date" class="form-control @error('published_date') is-invalid @enderror mb-2" name="published_date" id="published_date" value="{{ old('published_date') }}">
              @error('published_date')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row mb-0">
            <div class="col-md-9 offset-md-2">
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
                    </div>
                    <div class="modal-body">
                      <p class="text-center">Are you sure that you would like to reset this form?</p>
                      <a href="{{ route('articles.create') }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              <a href="{{ route('articles.index') }}" class="btn btn-dark">
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

@push('js')
{{-- bootstrap-select js --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/js/bootstrap-select.min.js"></script>
{{-- bootstrap-select js --}}
@endpush