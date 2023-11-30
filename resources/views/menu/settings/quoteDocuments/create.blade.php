@extends('layouts.app')

@section('title', '- Quote Documents - Create New Quote Document')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">QUOTE DOCUMENTS</h3>
    <h5>Create New Quote Document</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('quote-document-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Quote Documents Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-7">

        <p class="text-primary my-3"><b>Create New Quote Document</b></p>

        <form action="{{ route('quote-document-settings.store') }}" method="POST" enctype="multipart/form-data">
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
            <label for="material_type_id" class="col-md-3 col-form-label text-md-right">Material Type</label>
            <div class="col-md-8">
              <select name="material_type_id" id="material_type_id" class="custom-select @error('material_type_id') is-invalid @enderror mb-2">
                <option selected disabled>Please select a task type</option>
                @foreach ($all_material_types as $material_type)
                  <option value="{{ $material_type->id }}">{{ $material_type->title }}</option>
                @endforeach
              </select>
              @error('material_type_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="task_type_id" class="col-md-3 col-form-label text-md-right">Task Type</label>
            <div class="col-md-8">
              <select name="task_type_id" id="task_type_id" class="custom-select @error('task_type_id') is-invalid @enderror mb-2">
                <option selected disabled>Please select a task type</option>
                @foreach ($all_task_types as $task_type)
                  <option value="{{ $task_type->id }}">{{ $task_type->title }}</option>
                @endforeach
              </select>
              @error('task_type_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="task_id" class="col-md-3 col-form-label text-md-right">Task</label>
            <div class="col-md-8">
              <select name="task_id" id="task_id" class="custom-select @error('task_id') is-invalid @enderror mb-2">
                <option selected disabled>Please select a task type</option>
                @foreach ($all_tasks as $task)
                  <option value="{{ $task->id }}" @if (old('task_id') == $task->id) selected @endif>{{ $task->title }}</option>
                @endforeach
              </select>
              @error('task_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="description" class="col-md-3 col-form-label text-md-right">Description</label>
            <div class="col-md-8">
              <textarea class="form-control @error('description') is-invalid @enderror mb-2" type="text" name="description" rows="5" placeholder="Please enter the description" style="resize:none">{{ old('description') }}</textarea>
              @error('description')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <div class="col-md-8 offset-md-3">
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="isDefaultRadioInline1" name="is_default" class="custom-control-input @error('is_default') is-invalid @enderror mt-2" value="0" @if (old('is_default') == 0) checked @endif>
                <label class="custom-control-label" for="isDefaultRadioInline1">Is Not Default</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="isDefaultRadioInline2" name="is_default" class="custom-control-input @error('is_default') is-invalid @enderror mt-2" value="1" @if (old('is_default') == 1) checked @endif>
                <label class="custom-control-label" for="isDefaultRadioInline2">Is Default</label>
              </div>
              @error('is_default')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="quote_document" class="col-md-3 col-form-label text-md-right">Document</label>
            <div class="col-md-8">
              <div class="custom-file">
                <label class="custom-file-label" for="quote_document" id="quote_document_name">Please select a document to upload</label>
                <input type="file" class="custom-file-input" name="quote_document" id="quote_document" aria-describedby="quote_document">
              </div> {{-- custom-file --}}
              @error('quote_document')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="image" class="col-md-3 col-form-label text-md-right">Image</label>
            <div class="col-md-8">
              <div class="custom-file">
                <label class="custom-file-label" for="image" id="image_name">Please select an image to upload</label>
                <input type="file" class="custom-file-input" name="image" id="image" aria-describedby="image">
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
              <button type="submit" class="btn btn-primary">
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
                      <a href="{{ route('quote-document-settings.create') }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              <a href="{{ route('quote-document-settings.index') }}" class="btn btn-dark">
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

@push('js')
{{-- Quote Document --}}
<script>
  // Display the filename of the selected file to the user in the view from the upload form.
  var quote_document = document.getElementById("quote_document");
  quote_document.onchange = function(){
    if (quote_document.files.length > 0)
    {
      document.getElementById('quote_document_name').innerHTML = quote_document.files[0].name;
    }
  };
</script>
{{-- Quote Document --}}

{{-- Quote Document Image --}}
<script>
  // Display the filename of the selected file to the user in the view from the upload form.
  var quote_document_image = document.getElementById("image");
  image.onchange = function(){
    if (image.files.length > 0)
    {
      document.getElementById('image_name').innerHTML = image.files[0].name;
    }
  };
</script>
{{-- Quote Document Image --}}
@endpush