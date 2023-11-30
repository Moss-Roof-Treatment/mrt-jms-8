@extends('layouts.app')

@section('title', '- Products - Edit Selected Product')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">PRODUCTS</h3>
    <h5>Edit Selected Product</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('product-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Products Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-7">

        <p class="text-primary my-3"><b>Edit Products</b></p>
        <form action="{{ route('product-settings.update', $selected_product->id) }}" method="POST">
          @method('PATCH')
          @csrf

          <div class="form-group row">
            <label for="name" class="col-md-3 col-form-label text-md-right">Title</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('name') is-invalid @enderror mb-2" name="name" id="name" value="{{ old('name', $selected_product->name) }}" placeholder="Please enter the title" autofocus>
              @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="cost_price" class="col-md-3 col-form-label text-md-right">Cost Price</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('cost_price') is-invalid @enderror mb-2" name="cost_price" id="cost_price" value="{{ old('cost_price', number_format(($selected_product->cost_price / 100), 2, '.', ',')) }}" placeholder="Please enter the cost price">
              @error('cost_price')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="profit_amount" class="col-md-3 col-form-label text-md-right">Profit Amount</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('profit_amount') is-invalid @enderror mb-2" name="profit_amount" id="profit_amount" value="{{ old('profit_amount', number_format(($selected_product->profit_amount / 100), 2, '.', ',')) }}" placeholder="Please enter the profit amount">
              @error('profit_amount')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="postage_price" class="col-md-3 col-form-label text-md-right">Postage Price</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('postage_price') is-invalid @enderror mb-2" name="postage_price" id="postage_price" value="{{ old('postage_price', number_format(($selected_product->postage_price / 100), 2, '.', ',')) }}" placeholder="Please enter the postage_price">
              @error('postage price')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="dimensions" class="col-md-3 col-form-label text-md-right">Dimensions</label>
            <div class="col-md-8 input-group mb-2">
              <input type="text" class="form-control @error('dimensions') is-invalid @enderror" name="dimensions" id="dimensions" value="{{ old('dimensions', $selected_product->dimensions) }}" placeholder="Please enter the dimensions">
              <div class="input-group-append">
                <span class="input-group-text">H x W x L</span>
              </div>
              @error('dimensions')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="weight" class="col-md-3 col-form-label text-md-right">Weight</label>
            <div class="col-md-8 input-group mb-2">
              <input type="text" class="form-control @error('weight') is-invalid @enderror" name="weight" id="weight" value="{{ old('weight', $selected_product->weight) }}" placeholder="Please enter the weight">
              <div class="input-group-append">
                <span class="input-group-text">&#13199;</span>
              </div>
              @error('weight')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <div class="col-md-8 offset-md-3">
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="isVisiblecustomRadioInline1" name="is_visible" class="custom-control-input" value="1" @if ($selected_product->is_visible == 1) checked @endif>
                <label class="custom-control-label" for="isVisiblecustomRadioInline1">Is Visible</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="isVisiblecustomRadioInline2" name="is_visible" class="custom-control-input" value="0" @if ($selected_product->is_visible == 0) checked @endif>
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
            <label for="description" class="col-md-3 col-form-label text-md-right">Description</label>
            <div class="col-md-8">
              <textarea class="form-control @error('description') is-invalid @enderror mb-2" type="text" name="description" rows="5" placeholder="Please enter the description" style="resize:none">{{ old('description', $selected_product->description) }}</textarea>
              @error('description')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="details" class="col-md-3 col-form-label text-md-right">Details</label>
            <div class="col-md-8">
              <textarea class="form-control @error('details') is-invalid @enderror mb-2" type="text" name="details" rows="5" placeholder="Please enter the details" style="resize:none">{{ old('details', $selected_product->details) }}</textarea>
              @error('details')
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
                      <a href="{{ route('product-settings.edit', $selected_product->id) }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              <a href="{{ route('product-settings.show', $selected_product->id) }}" class="btn btn-dark">
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