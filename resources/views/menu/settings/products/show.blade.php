@extends('layouts.jquery')

@section('title', '- Products - View Selected Product')

@push('css')
{{-- DropzoneJS CSS --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css" integrity="sha512-WvVX1YO12zmsvTpUQV8s7ZU98DnkaAokcciMZJfnNWyNzm7//QRV61t4aEr0WdIa4pe854QHLTV302vH92FSMw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
{{-- DropzoneJS CSS --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">PRODUCTS</h3>
    <h5>View Selected Product</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('product-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Products Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        @if ($selected_product->is_editable == 0)
          <a href="#" class="btn btn-primary btn-block disabled" tabindex="-1" role="button" aria-disabled="true">
            <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
          </a>
        @else
          <a class="btn btn-primary btn-block" href="{{ route('product-settings.edit', $selected_product->id) }}">
            <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
          </a>
        @endif
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        @if ($selected_product->is_delible == 0)
          <a href="#" class="btn btn-danger btn-block disabled" tabindex="-1" role="button" aria-disabled="true">
            <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
          </a>
        @else
          {{-- delete modal --}}
          {{-- modal button --}}
          <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModal">
            <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
          </button>
          {{-- modal button --}}
          {{-- modal --}}
          <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="deleteModalTitle">Delete</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p class="text-center">Are you sure that you would like to delete this item?</p>
                  <form method="POST" action="{{ route('product-settings.destroy', $selected_product->id) }}">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger btn-block">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          {{-- modal --}}
          {{-- delete modal --}}
        @endif
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-6">

        <p class="text-primary my-3"><b>Product Details</b></p>

        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>ID</th>
                <td>{{ $selected_product->id }}</td>
              </tr>
              <tr>
                <th>Title</th>
                <td>{{ $selected_product->name }}</td>
              </tr>
              <tr>
                <th>Slug</th>
                <td>{{ $selected_product->slug }}</td>
              </tr>
              <tr>
                <th>Cost Price</th>
                <td>${{ number_format(($selected_product->cost_price / 100), 2, '.', ',') }}</td>
              </tr>
              <tr>
                <th>Profit Amount</th>
                <td>${{ number_format(($selected_product->profit_amount / 100), 2, '.', ',') }}</td>
              </tr>
              <tr>
                <th>Postage Price</th>
                <td>${{ number_format(($selected_product->postage_price / 100), 2, '.', ',') }}</td>
              </tr>
              <tr>
                <th>Total Price</th>
                <td>${{ number_format(($selected_product->price / 100), 2, '.', ',') }}</td>
              </tr>
              <tr>
                <th>Dimensions</th>
                <td>
                  @if ($selected_product->dimensions == null)
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>The dimensions have not been set
                    </span>
                  @else
                    {{ $selected_product->dimensions }} (H x W x L)
                  @endif
                </td>
              </tr>
              <tr>
                <th>Weight</th>
                <td>
                  @if ($selected_product->weight == null)
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>The weight has not been set
                    </span>
                  @else
                    {{ $selected_product->weight }} &#13199;
                  @endif
                </td>
              </tr>
              <tr>
                <th>Visibility</th>
                <td>
                  @if ($selected_product->is_visible != 1)
                    <span class="badge badge-danger py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Visible
                    </span>
                  @else
                    <span class="badge badge-success py-2 px-2">
                      <i class="fas fa-check mr-2" aria-hidden="true"></i>Is Visible
                    </span>
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}

      </div> {{-- col-sm-6 --}}
      <div class="col-sm-6">

      <p class="text-primary my-3"><b>Drag And Drop Image Upload</b></p>

      <div class="box">
        {{-- UPLOAD FORM --}}
        <form action="{{ route('product-image-settings.store') }}" id="uploadImagesForm" class="dropzone" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="file" multiple>
          <input type="hidden" name="selected_product_id" value="{{ $selected_product->id }}">
        </form>
        {{-- UPLOAD FORM --}}
        <p class="text-center">(This page will automatically reload after successful image uploads)</p>
      </div> {{-- box --}}

      </div> {{-- col-sm-6 --}}
    </div> {{-- row --}}

    <p class="text-primary my-3"><b>Product Images</b></p>

    <div class="card">
      <div class="card-body">
        @if (!$selected_product->product_images->count())
          <p class="text-center">There are no product images to display</p>
        @else
          @foreach ($selected_product->product_images->chunk(6) as $product_image_chunk)
            <div class="row is-mobile">
              @foreach ($product_image_chunk as $product_image)
                <div class="col-sm-2">
                  <a href="{{ route('product-image-settings.show', $product_image->id) }}">
                    @if ($product_image->image_path == null)
                      <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/stock-256x256.jpg') }}" alt="">
                    @else
                      <img class="img-fluid" src="{{ asset($product_image->image_path) }}" alt="">
                    @endif
                  </a>
                </div> {{-- col-sm-2 --}}
              @endforeach
            </div> {{-- row --}}
          @endforeach
        @endif
      </div> {{-- card-body --}}
    </div> {{-- card --}}

    <p class="text-primary my-3"><b>Product Description</b></p>

    <div class="card">
      <div class="card-body">
        {{ $selected_product->description }}
      </div> {{-- card-body --}}
    </div> {{-- card --}}

    <p class="text-primary my-3"><b>Product Details</b></p>

    <div class="card">
      <div class="card-body">
        {{ $selected_product->details }}
      </div> {{-- card-body --}}
    </div> {{-- card --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- DropzoneJS JS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
  Dropzone.options.uploadImagesForm = {
    maxFilesize: 3, // 3MB
    acceptedFiles: ".jpeg,.jpg,.png",
    init: function() {
      this.on('success', function(){
        if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
          location.reload();
        }
      });
    }
  };
</script>
{{-- DropzoneJS JS --}}
@endpush