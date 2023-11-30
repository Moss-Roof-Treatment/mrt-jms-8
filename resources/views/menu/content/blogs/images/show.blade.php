@extends('layouts.app')

@section('title', 'Content - Blogs - View Selected Blog Image')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">BLOG IMAGES</h3>
    <h5>View Selected Blog Image</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('blogs.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Blog Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('blogs.show', $selected_article_image->article_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Blog
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('blogs-images.edit', $selected_article_image->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit Details
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <form action="{{ route('blogs-images.destroy', $selected_article_image->id) }}" method="POST">
          @method('DELETE')
          @csrf
          <button class="btn btn-danger btn-block">
            <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
          </button>
        </form>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-6">

        <h5 class="text-primary my-3"><b>Blog Image</b></h5>

        @if ($selected_article_image->image_path == null)
          <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/tools-256x256.jpg') }}" alt="">
        @else
          <img class="img-fluid" src="{{ asset($selected_article_image->image_path) }}" alt="">
        @endif

      </div> {{-- col-sm-6 --}}
      <div class="col-sm-6">

        <h5 class="text-primary my-3"><b>Image Details</b></h5>

        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th width="30%">Blog ID</th>
                <td>{{ $selected_article_image->article_id }}</td>
              </tr>
              <tr>
                <th>Image ID</th>
                <td>{{ $selected_article_image->id }}</td>
              </tr>
              <tr>
                <th>Uploaded By</th>
                <td>{{ $selected_article_image->staff->getFullNameAttribute() }}</td>
              </tr>
              <tr>
                <th>Visibility Status</th>
                <td>
                  @if ($selected_article_image->is_visible != 1)
                    <span class="badge badge-danger py-2 px-2">
                      <i class="fas fa-eye-slash mr-2" aria-hidden="true"></i>This image is not visible
                    </span>
                  @else
                    <span class="badge badge-success py-2 px-2">
                      <i class="fas fa-eye mr-2" aria-hidden="true"></i>This image is visible
                    </span>
                  @endif
                </td>
              </tr>
              <tr>
                <th>Featured Status</th>
                <td>
                  @if ($selected_article_image->is_featured == null)
                  <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-star mr-2" aria-hidden="true"></i>This image is not the featured image
                    </span>
                  @else
                    <span class="badge badge-success py-2 px-2">
                      <i class="fas fa-star mr-2" aria-hidden="true"></i>This image is the featured image
                    </span>
                  @endif
                </td>
              </tr>
              <tr>
                <th>Storage Location</th>
                <td>{{ $selected_article_image->image_path }}</td>
              </tr>
              <tr>
                <th>Upload Date</th>
                <td>{{ date('d/m/y - h:iA', strtotime($selected_article_image->created_at)) }}</td>
              </tr>
              <tr>
                <th>Alt Tag Label</th>
                <td>
                  @if ($selected_article_image->alt_tag_label == null)
                    <span class="badge badge-warning py-2 px-2">
                      This image has no alt tag label
                    </span>
                  @else
                    {{ $selected_article_image->alt_tag_label }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Description</th>
                <td>
                  @if ($selected_article_image->description == null)
                    <span class="badge badge-warning py-2 px-2">
                      This image has no description
                    </span>
                  @else
                    {{ $selected_article_image->description }}
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div>{{-- table-responsive --}}

      </div> {{-- col-sm-6 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section>{{-- section --}}
@endsection