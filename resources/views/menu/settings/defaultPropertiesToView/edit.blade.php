@extends('layouts.app')

@section('title', '- Default Properties To View - Edit Selected Default Properties To View')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">DEFAULT PROPERTIES TO VIEW</h3>
    <h5>Edit Selected Default Properties To View</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('default-properties-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Default Properties Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-7">

        <p class="text-primary my-3"><b>Edit Default Properties To View</b></p>

        <form action="{{ route('default-properties-settings.update', $selected_default_properties_to_view->id) }}" method="POST">
          @method('PATCH')
          @csrf

          <div class="form-group row">
            <label for="title" class="col-md-2 col-form-label text-md-right">Title</label>
            <div class="col-md-9">
              <input type="text" class="form-control @error('title') is-invalid @enderror mb-2" name="title" id="title" value="{{ old('title', $selected_default_properties_to_view->title) }}" placeholder="Please enter the title" autofocus>
              @error('title')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="property_1" class="col-md-2 col-form-label text-md-right">Property 1</label>
            <div class="col-md-9">
              <input type="text" class="form-control @error('property_1') is-invalid @enderror mb-2" name="property_1" id="property_1" value="{{ old('property_1', $selected_default_properties_to_view->property_1) }}" placeholder="Please enter the property 1">
              @error('property_1')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="property_2" class="col-md-2 col-form-label text-md-right">Property 2</label>
            <div class="col-md-9">
              <input type="text" class="form-control @error('property_2') is-invalid @enderror mb-2" name="property_2" id="property_2" value="{{ old('property_2', $selected_default_properties_to_view->property_2) }}" placeholder="Please enter the property 2">
              @error('property_2')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="property_3" class="col-md-2 col-form-label text-md-right">Property 3</label>
            <div class="col-md-9">
              <input type="text" class="form-control @error('property_3') is-invalid @enderror mb-2" name="property_3" id="property_3" value="{{ old('property_3', $selected_default_properties_to_view->property_3) }}" placeholder="Please enter the property 3">
              @error('property_3')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="property_4" class="col-md-2 col-form-label text-md-right">Property 4</label>
            <div class="col-md-9">
              <input type="text" class="form-control @error('property_4') is-invalid @enderror mb-2" name="property_4" id="property_4" value="{{ old('property_4', $selected_default_properties_to_view->property_4) }}" placeholder="Please enter the property 4">
              @error('property_4')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
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
                      <a href="{{ route('default-properties-settings.edit', $selected_default_properties_to_view->id) }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              {{-- cancel button --}}
              <a href="{{ route('default-properties-settings.index') }}" class="btn btn-dark">
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