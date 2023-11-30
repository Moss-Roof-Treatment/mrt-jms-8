@extends('layouts.app')

@section('title', '- Product Images - View Selected Product Image')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">PRODUCT IMAGES</h3>
    <h5>View Selected Product Image</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('product-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Products Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a href="{{ route('product-settings.show', $selected_product_image->product_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Product
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        {{-- make featured button --}}
        <form action="{{ route('product-image-settings.update', $selected_product_image->id) }}" method="POST">
          @method('PATCH')
          @csrf
          <button type="submit" class="btn btn-warning btn-block">
            <i class="fas fa-star mr-2" aria-hidden="true"></i>Make Featured Image
          </button>
        </form>
        {{-- make featured button --}}
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
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
                <form method="POST" action="{{ route('product-image-settings.destroy', $selected_product_image->id) }}">
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
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-6">

        <p class="text-primary my-3"><b>Details</b></p>

        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>ID</th>
                <td>{{ $selected_product_image->id }}</td>
              </tr>
              <tr>
                <th>Image Path</th>
                <td>{{ $selected_product_image->image_path }}</td>
              </tr>
              <tr>
                <th>Featured Status</th>
                <td>
                  @if ($selected_product_image->is_featured != 1)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Is Not Featured Image
                    </span>
                  @else
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-check mr-2" aria-hidden="true"></i>Is Featured Image
                    </span>
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}

      </div> {{-- col-sm-6 --}}
      <div class="col-sm-6">

        <p class="text-primary my-3"><b>Image</b></p>

        @if ($selected_product_image->image_path == null)
          <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset('storage/images/placeholders/stock-256x256.jpg') }}" alt="">
        @else
          <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset($selected_product_image->image_path) }}" alt="">
        @endif

      </div> {{-- col-sm-6 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection