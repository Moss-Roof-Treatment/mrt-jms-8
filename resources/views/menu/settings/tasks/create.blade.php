@extends('layouts.app')

@section('title', '- Tasks - Create New Task')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">TASKS</h3>
    <h5>Create New Task</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('task-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Task Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    {{-- create new task form --}}
    <p class="text-primary my-3"><b>Create New Task</b></p>

    <div class="row">
      <div class="col-sm-7">

        <form action="{{ route('task-settings.store') }}" method="POST" enctype="multipart/form-data">
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
            <label for="task_type_id" class="col-md-3 col-form-label text-md-right">Task Type</label>
            <div class="col-md-8">
              <select name="task_type_id" id="task_type_id" class="custom-select @error('task_type_id') is-invalid @enderror mb-2">
                <option selected disabled>Please select a task type</option>
                @foreach ($all_task_types as $task_type)
                  <option value="{{ $task_type->id }}" @if (old('task_type') == $task_type->id) selected @endif>{{ $task_type->title }}</option>
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
            <label for="building_style_id" class="col-md-3 col-form-label text-md-right">Building Style</label>
            <div class="col-md-8">
              <select name="building_style_id" id="building_style_id" class="custom-select @error('building_style_id') is-invalid @enderror mb-2">
                <option selected disabled>Please select a building style</option>
                @foreach ($all_building_styles as $building_style)
                  <option value="{{ $building_style->id }}" @if (old('building_style') == $building_style->id) selected @endif>{{ $building_style->title }}</option>
                @endforeach
              </select>
              @error('building_style_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="building_type_id" class="col-md-3 col-form-label text-md-right">Building Type</label>
            <div class="col-md-8">
              <select name="building_type_id" id="building_type_id" class="custom-select @error('building_type_id') is-invalid @enderror mb-2">
                <option selected disabled>Please select a building type</option>
                @foreach ($all_building_types as $building_type)
                  <option value="{{ $building_type->id }}" @if (old('building_type') == $building_type->id) selected @endif>{{ $building_type->title }}</option>
                @endforeach
              </select>
              @error('building_type_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="dimension_id" class="col-md-3 col-form-label text-md-right">Dimension</label>
            <div class="col-md-8">
              <select name="dimension_id" class="custom-select @error('dimension_id') is-invalid @enderror mb-2">
                <option selected disabled>Please select a dimension</option>
                @foreach ($all_dimensions as $dimension)
                  <option value="{{ $dimension->id }}" @if (old('dimension') == $dimension->id) selected @endif>{{ $dimension->title }}</option>
                @endforeach
              </select>
              @error('dimension_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="material_type_id" class="col-md-3 col-form-label text-md-right">Roof Surface</label>
            <div class="col-md-8">
              <select name="material_type_id" class="custom-select @error('material_type_id') is-invalid @enderror mb-2">
                <option selected disabled>Please select a roof surface</option>
                @foreach ($all_material_types as $material_type)
                  <option value="{{ $material_type->id }}" @if (old('material_type_id') == $material_type->id) selected @endif>{{ $material_type->title }}</option>
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
            <label for="price" class="col-md-3 col-form-label text-md-right">Price</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('price') is-invalid @enderror mb-2" name="price" id="price" value="{{ old('price') }}" placeholder="Please enter the price">
              @error('price')
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
            <label for="procedure" class="col-md-3 col-form-label text-md-right">Procedure</label>
            <div class="col-md-8">
              <textarea class="form-control @error('procedure') is-invalid @enderror mb-2" type="text" name="procedure" rows="5" placeholder="Please enter the procedure" style="resize:none">{{ old('procedure') }}</textarea>
              @error('procedure')
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
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-3">
              {{-- create button --}}
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-check mr-2" aria-hidden="true"></i>Create
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
                      <a href="{{ route('task-settings.create') }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              {{-- cancel button --}}
              <a href="{{ route('task-settings.index') }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
              {{-- cancel button --}}
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

        </form>

      </div> {{-- col-sm-7 --}}
    </div> {{-- row --}}
    {{-- create new task form --}}

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