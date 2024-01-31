@extends('layouts.app')

@section('title', '- Equipment - Create New Inspection')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">EQUIPMENT INSPECTIONS</h3>
    <h5>Create New Inspection</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('equipment-items.show', $equipment->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Equipment
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-5">

        <h5 class="text-primary my-4"><b>Equipment Image</b></h5>
        <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset($equipment->get_equipment_image()) }}">

        <h5 class="text-primary my-4"><b>Equipment Details</b></h5>
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <tbody>
            <tr>
              <th width="35%">Name</th>
              <td>{{ $equipment->title }}</td>
            </tr>
            <tr>
              <th>Description</th>
              <td>
                @if ($equipment->description == null)
                  <span class="badge badge-light py-2 px-2">
                    <i class="fas fa-times mr-2" aria-hidden="true"></i>No description has been entered
                  </span>
                @else
                  {{ $equipment->description }}
                @endif
              </td>
            </tr>
            <tr>
              <th>Serial Number</th>
              <td>
                @if ($equipment->serial_number == null)
                  <span class="badge badge-light py-2 px-2">
                    <i class="fas fa-times mr-2" aria-hidden="true"></i>No serial number has been entered
                  </span>
                @else
                  {{ $equipment->serial_number }}
                @endif
              </td>
            </tr>
            <tr>
              <th>Category</th>
              <td>
                @if ($equipment->equipment_category == null)
                  <span class="badge badge-light py-2 px-2">
                    <i class="fas fa-times mr-2" aria-hidden="true"></i>No category has been entered
                  </span>
                @else
                  {{ $equipment->equipment_category->title }}
                @endif
              </td>
            </tr>
            <tr>
              <th>Inspection By</th>
              <td>
                @if ($equipment->equipment_inspections->last() == null)
                  <span class="badge badge-warning py-2 px-2">
                    <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>This equipment is untested
                  </span>
                @else
                  {{ $equipment->equipment_inspections->last()->inspection_company }}
                @endif
              </td>
            </tr>
            <tr>
              <th>Inspected By</th>
              <td>
                @if ($equipment->equipment_inspections->last() == null)
                  <span class="badge badge-warning py-2 px-2">
                    <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>This equipment is untested
                  </span>
                @else
                  {{ $equipment->equipment_inspections->last()->inspector_name }}
                @endif
              </td>
            </tr>
            <tr>
              <th>Tag & Test No</th>
              <td>
                @if ($equipment->equipment_inspections->last() == null)
                  <span class="badge badge-warning py-2 px-2">
                    <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>This equipment is untested
                  </span>
                @else
                  {{ $equipment->equipment_inspections->last()->tag_and_test_id }}
                @endif
              </td>
            </tr>
            <tr>
              <th>Last Inspection</th>
              <td>
                @if ($equipment->equipment_inspections->last() == null)
                  <span class="badge badge-warning py-2 px-2">
                    <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>This equipment is untested
                  </span>
                @else
                  {{ date('d/m/y', strtotime($equipment->equipment_inspections->last()->inspection_date)) }}
                @endif
              </td>
            </tr>
            <tr>
              <th>Next Inspection</th>
              <td>
                @if ($equipment->equipment_inspections->last() == null)
                  <span class="badge badge-warning py-2 px-2">
                    <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>This equipment is untested
                  </span>
                @else
                  {{ date('d/m/y', strtotime($equipment->equipment_inspections->last()->next_inspection_date)) }}
                @endif
              </td>
            </tr>
            <tr>
              <th>Inspection Count</th>
              <td>
                @if ($equipment->equipment_inspections->last() == null)
                  <span class="badge badge-warning py-2 px-2">
                    <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>This equipment is untested
                  </span>
                @else
                  {{ $equipment->equipment_inspections->count() }}
                @endif
              </td>
            </tr>
            <tr>
              <th>Used By</th>
              <td>{{ $equipment->owner->getFullNameAttribute() }}</td>
            </tr>
          </tbody>
        </table>

      </div>
      <div class="col-sm-7">

        <h5 class="text-primary my-4"><b>Create New Inpection</b></h5>

        <form action="{{ route('equipment-inspections.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <input type="hidden" name="equipment_id" value="{{ $equipment->id }}">

          <div class="form-group row">
            <label for="inspection_date" class="col-md-4 col-form-label text-md-right">Inspection Date</label>
            <div class="col-md-8">
              <input type="date" class="form-control @error('inspection_date') is-invalid @enderror mb-2" name="inspection_date" id="inspection_date" value="{{ old('inspection_date') }}" autofocus>
              @error('inspection_date')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="inspection_company" class="col-md-4 col-form-label text-md-right">Inspection Company</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('inspection_company') is-invalid @enderror mb-2" name="inspection_company" id="inspection_company" value="{{ old('inspection_company') }}" placeholder="Please enter the inspection company">
              @error('inspection_company')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="inspector_name" class="col-md-4 col-form-label text-md-right">Inspected By</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('inspector_name') is-invalid @enderror mb-2" name="inspector_name" id="inspector_name" value="{{ old('inspector_name') }}" placeholder="Please enter the inspector name">
              @error('inspector_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="tag_and_test_id" class="col-md-4 col-form-label text-md-right">Tag And Test Number</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('tag_and_test_id') is-invalid @enderror mb-2" name="tag_and_test_id" id="tag_and_test_id" value="{{ old('tag_and_test_id') }}" placeholder="Please enter the tag and test number">
              @error('tag_and_test_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="text" class="col-md-4 col-form-label text-md-right">Comments</label>
            <div class="col-md-8">
              <textarea class="form-control @error('text') is-invalid @enderror mb-2" type="text" name="text" rows="5" placeholder="Please enter comments" style="resize:none">{{ old('text') }}</textarea>
              @error('text')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="next_inspection_date" class="col-md-4 col-form-label text-md-right">Next Inspection Date</label>
            <div class="col-md-8">
              <input type="date" class="form-control @error('next_inspection_date') is-invalid @enderror mb-2" name="next_inspection_date" id="next_inspection_date" value="{{ old('next_inspection_date') }}">
              @error('next_inspection_date')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="image" class="col-md-4 col-form-label text-md-right">Image</label>
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
            <div class="col-md-8 offset-md-4">
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
                      <a href="{{ route('equipment-items.show', $equipment->id) }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              {{-- cancel button --}}
              <a href="{{ route('equipment-items.show', $equipment->id) }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
              {{-- cancel button --}}
            </div> {{-- col-md-8 offset-md-4 --}}
          </div> {{-- form-group row --}}

        </form>

      </div> {{-- col-sm-6 --}}
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