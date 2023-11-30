@extends('layouts.app')

@section('title', '- Products - Create New Product')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">PRODUCTS</h3>
    <h5>Create New Product</h5>
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

        <p class="text-primary my-3"><b>Create New Product</b></p>

        <form action="{{ route('product-settings.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="form-group row">
            <label for="name" class="col-md-3 col-form-label text-md-right">Title</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('name') is-invalid @enderror mb-2" name="name" id="name" value="{{ old('name') }}" placeholder="Please enter the title" autofocus>
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
              <input type="text" class="form-control @error('cost_price') is-invalid @enderror mb-2" name="cost_price" id="cost_price" value="{{ old('cost_price') }}" placeholder="Please enter the cost price">
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
              <input type="text" class="form-control @error('profit_amount') is-invalid @enderror mb-2" name="profit_amount" id="profit_amount" value="{{ old('profit_amount') }}" placeholder="Please enter the profit amount">
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
              <input type="text" class="form-control @error('postage_price') is-invalid @enderror mb-2" name="postage_price" id="postage_price" value="{{ old('postage_price') }}" placeholder="Please enter the postage price">
              @error('postage_price')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="dimensions" class="col-md-3 col-form-label text-md-right">Dimensions</label>
            <div class="col-md-8 input-group mb-2">
              <input type="text" class="form-control @error('dimensions') is-invalid @enderror" name="dimensions" id="dimensions" value="{{ old('dimensions') }}" placeholder="Please enter the dimensions">
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
              <input type="text" class="form-control @error('weight') is-invalid @enderror" name="weight" id="weight" value="{{ old('weight') }}" placeholder="Please enter the weight">
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
                <input type="radio" id="isVisibleRadioInline1" name="is_visible" class="custom-control-input @error('is_visible') is-invalid @enderror mt-2" value="0" @if (old('is_visible') == 0) checked @endif>
                <label class="custom-control-label" for="isVisibleRadioInline1">Is Not Visible</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
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
            <label for="details" class="col-md-3 col-form-label text-md-right">Details</label>
            <div class="col-md-8">
              <textarea class="form-control @error('details') is-invalid @enderror mb-2" type="text" name="details" rows="5" placeholder="Please enter the details" style="resize:none">{{ old('details') }}</textarea>
              @error('details')
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
                      <a href="{{ route('product-settings.create') }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              <a href="{{ route('product-settings.index') }}" class="btn btn-dark">
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
@endpush