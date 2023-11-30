@extends('layouts.app')

@section('title', '- Equipment - Edit Selected Equipment')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">EQUIPMENT</h3>
    <h5>Edit Selected Equipment</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('equipment.show', $selected_equipment->id) }}">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Equipment
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-7">

        <h5 class="text-primary my-3"><b>Edit Selected Equipment</b></h5>

        <form action="{{ route('equipment.update', $selected_equipment->id) }}" method="POST" enctype="multipart/form-data">
          @method('PATCH')
          @csrf

          <div class="form-group row">
            <label for="title" class="col-md-3 col-form-label text-md-right">Title</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('title') is-invalid @enderror mb-2" name="title" id="title" value="{{ @old('title', $selected_equipment->title) }}" placeholder="Please enter the title" autofocus>
              @error('title')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="brand" class="col-md-3 col-form-label text-md-right">Brand</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('brand') is-invalid @enderror mb-2" name="brand" id="brand" value="{{ @old('brand', $selected_equipment->brand) }}" placeholder="Please enter the brand">
              @error('brand')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="serial_number" class="col-md-3 col-form-label text-md-right">Serial Number</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('serial_number') is-invalid @enderror mb-2" name="serial_number" id="serial_number" value="{{ @old('serial_number', $selected_equipment->serial_number) }}" placeholder="Please enter the serial number">
              @error('serial_number')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="equipment_category_id" class="col-md-3 col-form-label text-md-right">Category</label>
            <div class="col-md-8">
              <select name="equipment_category_id" id="equipment_category_id" class="custom-select @error('equipment_category_id') is-invalid @enderror mb-2">
                @if (old('equipment_category_id'))
                  <option disabled>Please select an equipment category</option>
                  @foreach ($all_groups as $category)
                    <option value="{{ $category->id }}" @if (old('equipment_category_id') == $category->id) selected @endif>{{ $category->title }}</option>
                  @endforeach
                @else
                  @if ($selected_equipment->equipment_category_id == null)
                    <option selected disabled>Please select an equipment category</option>
                  @else
                    <option value="{{ $selected_equipment->equipment_category_id }}" selected>
                      {{ $selected_equipment->equipment_category->title }}
                    </option>
                    <option disabled>Please select an equipment category</option>
                  @endif
                  @foreach ($all_categories as $category)
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                  @endforeach
                @endif
              </select>
              @error('equipment_category_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-6 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="equipment_group_id" class="col-md-3 col-form-label text-md-right">Group</label>
            <div class="col-md-8">
              <select name="equipment_group_id" id="equipment_group_id" class="custom-select @error('equipment_group_id') is-invalid @enderror mb-2">
                @if (old('equipment_group_id'))
                  <option disabled>Please select an equipment group</option>
                  @foreach ($all_categories as $group)
                    <option value="{{ $group->id }}" @if (old('equipment_group_id') == $group->id) selected @endif>{{ $group->title }}</option>
                  @endforeach
                @else
                  @if ($selected_equipment->equipment_group_id == null)
                    <option selected disabled>Please select an equipment group</option>
                  @else
                    <option value="{{ $selected_equipment->equipment_group_id }}" selected>
                      {{ $selected_equipment->equipment_group->title }}
                    </option>
                    <option disabled>Please select an equipment group</option>
                  @endif
                  @foreach ($all_groups as $group)
                    <option value="{{ $group->id }}">{{ $group->title }}</option>
                  @endforeach
                @endif
              </select>
              @error('equipment_group_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-6 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="owner_id" class="col-md-3 col-form-label text-md-right">Owner</label>
            <div class="col-md-8">
              <select name="owner_id" id="owner_id" class="custom-select @error('owner_id') is-invalid @enderror mb-2">
                @if (old('owner_id'))
                  <option disabled>Please select a staff member</option>
                  @foreach ($staff_members as $staff_member)
                    <option value="{{ $staff_member->id }}" @if (old('owner_id') == $staff_member->id) selected @endif>{{ $staff_member->getFullNameTitleAttribute() }}</option>
                  @endforeach
                @else
                  @if ($selected_equipment->owner_id == null)
                    <option selected disabled>Please select a staff member</option>
                  @else
                    <option selected value="{{ $selected_equipment->owner_id }}">{{ $selected_equipment->owner->account_role->title . ' - ' . $selected_equipment->owner->getFullNameAttribute() }}</option>
                    <option disabled>Please select a staff member</option>
                    <option value=""></option>
                  @endif
                  @foreach ($staff_members as $staff_member)
                    <option value="{{ $staff_member->id }}">{{ $staff_member->getFullNameTitleAttribute() }}</option>
                  @endforeach
                @endif
              </select>
              @error('owner_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="description" class="col-md-3 col-form-label text-md-right">Description</label>
            <div class="col-md-8">
              <textarea class="form-control @error('description') is-invalid @enderror mb-2" type="text" name="description" rows="5" placeholder="Please enter the description" style="resize:none">{{ $selected_equipment->description }}</textarea>
              @error('description')
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
                      <a href="{{ route('equipment.edit', $selected_equipment->id) }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              <a href="{{ route('equipment.show', $selected_equipment->id) }}" class="btn btn-dark">
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