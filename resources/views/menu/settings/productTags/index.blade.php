@extends('layouts.app')

@section('title', '- Product Tags - View All Product Tags')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">PRODUCT TAGS</h3>
    <h5>View All Product Tags</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a href="{{ route('product-tag-settings.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Product Tag
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <p class="text-primary my-3"><b>All Product Tags</b></p>

    @if (!$all_product_tags->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no product tags to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
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
            @foreach ($all_product_tags as $selected_product_tag)
              <tr>
                <td>
                  <a href="{{ route('product-tag-settings.show', $selected_product_tag->id) }}">
                    {{ $selected_product_tag->id }}
                  </a>                  
                </td>
                <td>{{ $selected_product_tag->title }}</td>
                <td>{{ $selected_product_tag->description }}</td>
                <td class="text-center">
                  <a href="{{ route('product-tag-settings.show', $selected_product_tag->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                  <a href="{{ route('product-tag-settings.edit', $selected_product_tag->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                  </a>
                  {{-- modal start --}}
                  <a class="button modal-btn btn-danger btn-sm" data-target="confirm-delete-button-{{ $selected_product_tag->id }}">
                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                  </a>
                  <div class="modal" id="confirm-delete-button-{{ $selected_product_tag->id }}">
                    <div class="modal-background"></div>
                    <div class="modal-content">
                      <div class="box">
                        <p class="title text-center text-danger">Confirm Delete</p>
                        <p class="subtitle text-center">Are you sure you would like to delete the selected item...?</p>
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
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif

    {{ $all_product_tags->links() }}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection