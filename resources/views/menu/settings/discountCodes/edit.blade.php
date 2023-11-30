@extends('layouts.app')

@section('title', '- Discount Codes - Edit Selected Discount Code')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">DISCOUNT CODES</h3>
    <h5>Edit Selected Discount Code</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('discount-code-settings.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Discount Code Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-7">

        <p class="text-primary my-3"><b>Edit Discount Code</b></p>

        <form action="{{ route('discount-code-settings.update', $selected_discount_code->id) }}" method="POST" enctype="multipart/form-data">
          @method('PATCH')
          @csrf

          <div class="form-group row">
            <label for="code" class="col-md-3 col-form-label text-md-right">Code</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('code') is-invalid @enderror mb-2" name="code" id="code" value="{{ @old('code', $selected_discount_code->code) }}" placeholder="Please enter the code" autofocus>
              @error('code')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="value" class="col-md-3 col-form-label text-md-right">Fixed Value</label>
            <div class="col-md-8">
              @if ($selected_discount_code->value == null)
                <input type="text" class="form-control @error('value') is-invalid @enderror mb-2" name="value" id="value" value="{{ @old('value') }}" placeholder="Please enter the value">
              @else
                <input type="text" class="form-control @error('value') is-invalid @enderror mb-2" name="value" id="value" value="{{ @old('value', number_format(($selected_discount_code->value / 100), 2, '.', ',')) }}" placeholder="Please enter the value">
              @endif
              @error('value')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="percent_off" class="col-md-3 col-form-label text-md-right">Percentage Off</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('percent_off') is-invalid @enderror mb-2" name="percent_off" id="percent_off" value="{{ @old('percent_off', $selected_discount_code->percent_off) }}" placeholder="Please enter the percent off">
              @error('percent_off')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <div class="col-md-8 offset-md-3">
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="isActiveRadioInline1" name="is_active" class="custom-control-input @error('is_active') is-invalid @enderror mt-2" value="0" @if ($selected_discount_code->is_active == 0) checked @endif>
                <label class="custom-control-label" for="isActiveRadioInline1">Is Not Active</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="isActiveRadioInline2" name="is_active" class="custom-control-input @error('is_active') is-invalid @enderror mt-2" value="1" @if ($selected_discount_code->is_active == 1) checked @endif>
                <label class="custom-control-label" for="isActiveRadioInline2">Is Active</label>
              </div>
              @error('is_active')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="description" class="col-md-3 col-form-label text-md-right">Description</label>
            <div class="col-md-8">
              <textarea class="form-control @error('description') is-invalid @enderror mb-2" type="text" name="description" rows="5" placeholder="Please enter the description" style="resize:none">{{ old('description', $selected_discount_code->description) }}</textarea>
              @error('description')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <div class="col-md-8 offset-md-3">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
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
                      <a href="{{ route('discount-code-settings.edit', $selected_discount_code->id) }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              <a href="{{ route('discount-code-settings.index') }}" class="btn btn-dark">
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