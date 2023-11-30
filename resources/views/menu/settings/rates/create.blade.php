@extends('layouts.app')

@section('title', '- Tradesperson Rates - Create New Tradesperson Rates')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">TRADESPERSON RATES</h3>
    <h5>Create New Tradesperson Rate</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('rate-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Rates Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    {{-- create new tradesperson rate form --}}
    <p class="text-primary my-3"><b>Create New Tradesperson Rate</b></p>

    <div class="row">
      <div class="col-sm-7">

        <form action="{{ route('rate-settings.store') }}" method="POST">
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
            <label for="price" class="col-md-3 col-form-label text-md-right">Default Price</label>
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
            <label for="is_selectable" class="col-md-3 col-form-label text-md-right">Selectable</label>
            <div class="col-md-8">
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="isSelectablecustomRadioInline1" name="is_selectable" class="custom-control-input" value="1" checked>
                <label class="custom-control-label" for="isSelectablecustomRadioInline1">Is Selectable</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="isSelectablecustomRadioInline2" name="is_selectable" class="custom-control-input" value="0">
                <label class="custom-control-label" for="isSelectablecustomRadioInline2">Is Not Selectable</label>
              </div>
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="is_editable" class="col-md-3 col-form-label text-md-right">Editable</label>
            <div class="col-md-8">
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="isEditablecustomRadioInline1" name="is_editable" class="custom-control-input" value="1" checked>
                <label class="custom-control-label" for="isEditablecustomRadioInline1">Is Editable</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="isEditablecustomRadioInline2" name="is_editable" class="custom-control-input" value="0">
                <label class="custom-control-label" for="isEditablecustomRadioInline2">Is Not Editable</label>
              </div>
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="is_delible" class="col-md-3 col-form-label text-md-right">Delible</label>
            <div class="col-md-8">
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="isDeliblecustomRadioInline1" name="is_delible" class="custom-control-input" value="1" checked>
                <label class="custom-control-label" for="isDeliblecustomRadioInline1">Is Delible</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="isDeliblecustomRadioInline2" name="is_delible" class="custom-control-input" value="0">
                <label class="custom-control-label" for="isDeliblecustomRadioInline2">Is Not Delible</label>
              </div>
            </div> {{-- col-md-9 --}}
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
                      <a href="{{ route('rate-settings.create') }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              {{-- cancel button --}}
              <a href="{{ route('rate-settings.index') }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
              {{-- cancel button --}}
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

        </form>

      </div> {{-- col-sm-7 --}}
    </div> {{-- row --}}
    {{-- create new tradesperson rate form --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection