@extends('layouts.app')

@section('title', 'Content - Articles - Create New Article Image')

@push('css')
{{-- DropzoneJS CSS --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css" integrity="sha512-WvVX1YO12zmsvTpUQV8s7ZU98DnkaAokcciMZJfnNWyNzm7//QRV61t4aEr0WdIa4pe854QHLTV302vH92FSMw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
{{-- DropzoneJS CSS --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">ARTICLES IMAGES</h3>
    <h5>Upload Article Images</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('articles.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Articles Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('articles.show', $selected_article->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Article
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- dropzone upload --}}
    <div class="row">
      <div class="col-sm-8 my-2">
        <h5 class="text-primary my-3"><b>Drag And Drop Upload</b></h5>
        <form action="{{ route('article-image-dropzone.store') }}" class="dropzone" id="uploadImagesForm" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="article_id" value="{{ $selected_article->id }}">
        </form>
      </div> {{-- col-sm-7 --}}
    </div> {{-- row --}}
    {{-- dropzone upload --}}

    {{-- uploaded images --}}
    <h5 class="text-primary my-3"><b>Uploaded Images</b></h5>
    <div class="row">
      <div class="col-sm-8 my-2">
        @if (!$selected_article->article_images->count())
          <div class="card">
            <div class="card-body pb-0">
              <p class="text-center">No images have been uploaded</p>
            </div>
          </div>
        @else
          @foreach ($selected_article->article_images->chunk(4) as $image_chunk)
            <div class="row">
              @foreach ($image_chunk as $image)
                <div class="col-sm-3 pb-3">
                  {{-- image modal --}}
                  {{-- modal button --}}
                  <button type="button" class="btn btn-light" data-toggle="modal" data-target="#imageModal-{{ $image->id }}">
                    @if ($image->image_path == null)
                      <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/article-256x256.png') }}" alt="placeholder image">
                    @else
                      <img class="img-fluid" src="{{ asset($image->image_path) }}" alt="Article image">
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
                          <img class="img-fluid" src="{{ asset($image->image_path) }}" alt="Article image">
                        @endif

                        <a href="{{ route('article-images.show', $image->id) }}" class="btn btn-primary">
                          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Image Details
                        </a>

                      </div> {{-- modal-content --}}
                    </div> {{-- modal-xl --}}
                  </div> {{-- modal fade --}}
                  {{-- modal --}}
                  {{-- image modal --}}
                </div> {{-- col-sm-2 --}}
              @endforeach
            </div> {{-- row --}}
          @endforeach
        @endif
      </div> {{-- col-sm-8 --}}
    </div> {{-- row --}}
    {{-- uploaded images --}}

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