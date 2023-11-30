@extends('layouts.app')

@section('title', 'Content - Articles - View Selected Article')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">ARTICLES</h3>
    <h5>View Selected Article</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('articles.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Article Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('articles.edit', $selected_article->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <form action="{{ route('article-images.create') }}" method="GET">
          <input type="hidden" name="selected_article_id" value="{{ $selected_article->id }}">
          <button type="submit" class="btn btn-primary btn-block">
            <i class="fas fa-images mr-2" aria-hidden="true"></i>Upload Images
          </button>
        </form>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
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
                <p class="text-center">Are you sure that you would like to delete this article?</p>
                <form action="{{ route('articles.destroy', $selected_article->id) }}" method="POST">
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
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-7">

        <h5 class="text-primary my-3"><b>Blog Preview</b></h5>

        @if (!$selected_article->article_images->count())
          <img class="img-fluid" src="{{ asset('storage/images/placeholders/article-1200x630.jpg') }}" alt="Placeholder Image">
        @else
          @if ($selected_article->article_images->count() == 1)
              {{-- single image --}}
              <img class="img-fluid" src="{{ asset($selected_article->article_images->first()->image_path) }}" alt="Article Image">
              <p class="text-center">{{ $selected_article->article_images->first()->description }}</p>
              {{-- single image --}}
          @elseif ($selected_article->article_images->count() == 2)
            <div class="row">
              @foreach($selected_article->article_images as $image)
                <div class="col-sm-6">
                  <img class="img-fluid" src="{{ asset($image->image_path) }}" alt="Article Image">
                </div>
              @endforeach
            </div>
          @else
            {{-- carousel --}}
            <div id="blogCarouselControls" class="carousel slide carousel-fade" data-ride="carousel">
              <div class="carousel-inner">
                @foreach($selected_article->article_images as $image)
                <div class="carousel-item {{ $loop->index == 0 ? 'active' : '' }}">
                  @if ($image->image_path == NULL)
                    <img src="{{ asset('storage/images/placeholders/article-1280x720.png.png') }}" class="d-block w-100" alt="...">
                  @else
                    <img src="{{ asset($image->image_path) }}" class="d-block w-100" alt="...">
                  @endif
                </div>
                @endforeach
              </div>
              <button class="carousel-control-prev" type="button" data-target="#blogCarouselControls" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-target="#blogCarouselControls" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </button>
            </div>
            {{-- carousel --}}
          @endif
        @endif

        <div class="card my-3">
          <div class="card-body">
            <h4 class="card-title text-primary">{{ $selected_article->title }}</h4>
            <div class="row">
              <div class="col-sm-6">
                <h5>{{ $selected_article->subtitle }}</h5>
              </div>
              @if ($selected_article->published_date != null)
                <div class="col-sm-6">
                  <p class="float-md-right"><b>Post Date:</b> {{ date('M j, Y', strtotime($selected_article->published_date)) }}</p>
                </div>
              @endif
            </div>
            <span class="badge badge-primary p-2 mr-1">{{ $selected_article->article_category->title }}</span>
            @if ($selected_article->article_tags->count())
              @foreach($selected_article->article_tags as $tag)
                <span class="badge badge-secondary p-2 mr-1 my-1">{{ $tag->title }}</span>
              @endforeach
            @endif
            <p class="mt-3">
              @if($selected_article->location != null)
                <b>Location:</b> {{ $selected_article->location }}
                <br>
              @endif
              @if($selected_article->completed_date != null)
                <b>Completed Date:</b> {{ date('M j, Y', strtotime($selected_article->completed_date)) }}
              @endif
            </p>
            <p>{!! nl2br($selected_article->text) !!}</p>
          </div>
        </div>

      </div> {{-- col-sm-7 --}}
      <div class="col-sm-5 my-2">

        <h5 class="text-primary my-3"><b>Article Images</b></h5>
        @if (!$selected_article->article_images->count())
          <div class="card">
            <div class="card-body pb-0">
              <p class="text-center">No images have been uploaded</p>
            </div>{{-- card-body --}}
          </div>{{-- card --}}
        @else
          @foreach ($selected_article->article_images->chunk(2) as $imageChunk)
            <div class="row">
              @foreach ($imageChunk as $image)
                <div class="col-sm-6 pb-3">
                  {{-- image modal --}}
                  {{-- modal button --}}
                  <button type="button" class="btn btn-light" data-toggle="modal" data-target="#imageModal-{{ $image->id }}">
                    @if ($image->image_path == null)
                      <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/article-256x256.png') }}" alt="placeholder image">
                    @else
                      <img class="img-fluid" src="{{ asset($image->image_path) }}" alt="Blog image">
                    @endif
                  </button>
                  {{-- modal button --}}
                  {{-- modal --}}
                  <div class="modal fade" id="imageModal-{{ $image->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                      <div class="modal-content bg-transparent">
                        @if ($image->image_path == null)
                          <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/article-1200x630.jpg') }}" alt="placeholder image">
                        @else
                          <img class="img-fluid" src="{{ asset($image->image_path) }}" alt="Blog image">
                        @endif
                        <a href="{{ route('blogs-images.show', $image->id) }}" class="btn btn-primary">
                          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Image Details
                        </a>
                      </div>
                    </div>
                  </div>
                  {{-- modal --}}
                  {{-- image modal --}}
                </div> {{-- col-sm-4 --}}
              @endforeach
            </div> {{-- row --}}
          @endforeach
        @endif

        <h5 class="text-primary my-3"><b>Blog Details</b></h5>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>ID</th>
                <td>{{ $selected_article->id }}</td>
              </tr>
              <tr>
                <th>Visibility</th>
                <td>
                  @if ($selected_article->is_visible == 0)
                    <span class="badge badge-danger py-2 px-2">
                      <i class="fas fa-eye-slash mr-2" aria-hidden="true"></i>This article is not visible
                    </span>
                  @else
                    <span class="badge badge-success py-2 px-2">
                      <i class="fas fa-eye mr-2" aria-hidden="true"></i>This article is visible
                    </span>
                  @endif
                </td>
              </tr>
              <tr>
                <th>Created By</th>
                <td>{{ $selected_article->staff->getFullNameAttribute() }}</td>
              </tr>
              <tr>
                <th>Location</th>
                <td>
                  @if ($selected_article->location == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ $selected_article->location }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Completed Date</th>
                <td>
                  @if ($selected_article->completed_date == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ date('d/m/y', strtotime($selected_article->completed_date)) }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Published Date</th>
                <td>{{ date('d/m/y', strtotime($selected_article->published_date)) }}</td>
              </tr>
              <tr>
                <th>Created At</th>
                <td>{{ date('d/m/y - h:iA', strtotime($selected_article->created_at)) }}</td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}

      </div> {{-- col-sm-5 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection