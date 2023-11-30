@extends('layouts.app')

@section('title', '- Product Tags - View Selected Product Tag')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">PRODUCT TAG</h3>
    <h5>View Selected Product Tag</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('product-tag-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Product Tags Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('product-tag-settings.edit', $selected_product_tag->id) }}">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">

        {{-- modal start --}}
        <a class="btn btn-danger modal-btn btn-block" data-target="delete-product">
          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
        </a>
        <div class="modal" id="delete-product">
          <div class="modal-background"></div>
          <div class="modal-content">
            <div class="box">
              <p class="title text-center text-danger">Confirm Delete</p>
              <p class="subtitle text-center">Are you sure you would like to delete the selected product tag...?</p>
              <form method="POST" action="{{ route('product-tag-settings.destroy', $selected_product_tag->id) }}">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-danger btn-block">
                  <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                </button>
              </form>
            </div> {{-- box --}}
          </div> {{-- modal-content --}}
          <button class="modal-close is-large" aria-label="close"></button>
        </div> {{-- modal --}}
        {{-- modal end --}}

      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-6">

        <p class="text-primary my-3"><b>Tag Image</b></p>

        <div class="text-center">
          @if ($selected_product_tag->image_path == null)
            <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset('storage/images/placeholders/stock-256x256.jpg') }}" alt="">
          @else
            <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset($selected_product_tag->image_path) }}" alt="">
          @endif
        </div>

      </div> {{-- col-sm-6 --}}
      <div class="col-sm-6">

        <p class="text-primary my-3"><b>Tag Details</b></p>

        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>ID</th>
                <td>{{ $selected_product_tag->id }}</td>
              </tr>
              <tr>
                <th>Title</th>
                <td>{{ $selected_product_tag->title }}</td>
              </tr>
              <tr>
                <th>Image Storage Path</th>
                <td>
                  @if ($selected_product_tag->image_path == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>There is no image for this tag
                    </span>
                  @else
                    {{ $selected_product_tag->image_path }}
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}

      </div> {{-- col-sm-6 --}}
    </div> {{-- row --}}

    <p class="text-primary my-3"><b>Tag Products</b></p>

    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <thead class="table-secondary">
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($selected_tag_products as $product)
            <tr>
              <td>
                <a href="{{ route('product-tag-settings.show', $product->id) }}">
                  {{ $product->id }}
                </a>
              </td>
              <td>{{ $product->name }}</td>
              <td>
                {{ substr($product->description, 0, 60) }}{{ strlen($product->description) > 60 ? "..." : "" }}
              </td>
              <td class="text-center">
                <a href="{{ route('product-settings.show', $product->id) }}" class="btn btn-primary btn-sm">
                  <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div> {{-- table-responsive --}}

    {{ $selected_tag_products->links() }}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection