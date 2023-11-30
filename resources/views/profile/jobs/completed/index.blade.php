@extends('layouts.profileJquery')

@section('title', '- Jobs - Upload Job Images')

@push('css')
{{-- DropzoneJS CSS --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css" integrity="sha512-WvVX1YO12zmsvTpUQV8s7ZU98DnkaAokcciMZJfnNWyNzm7//QRV61t4aEr0WdIa4pe854QHLTV302vH92FSMw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
{{-- DropzoneJS CSS --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">JOB COMPLETED</h3>
    <h5>Upload Job Images</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('profile-jobs.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Job Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('profile-jobs.show', $selected_quote->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Job
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- dropzone image upload --}}
    <h5 class="text-primary my-3"><b>Drag And Drop Image Upload</b></h5>
    {{-- dropzone image upload --}}
    {{-- menu tabs --}}
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="pills-none-tab" data-toggle="pill" href="#pills-none" role="tab" aria-controls="pills-none" aria-selected="true">None</a>
      </li>
      @foreach ($types as $type)
        <li class="nav-item">
          <a class="nav-link" id="pills-{{ $type->id }}-tab" data-toggle="pill" href="#pills-{{ $type->id }}" role="tab" aria-controls="pills-{{ $type->id }}" aria-selected="false">{{ $type->title }}</a>
        </li>
      @endforeach
    </ul>
    {{-- menu tabs --}}
    {{-- menu panels --}}
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="pills-none" role="tabpanel" aria-labelledby="pills-none-tab">
        <div class="card shadow-sm mt-3">
          <div class="card-body text-center">
            <h5>Please select an image type from the tabs above</h5>
          </div> {{-- card-body --}}
        </div> {{-- card --}}
      </div>
      @foreach ($types as $type)
        <div class="tab-pane fade" id="pills-{{ $type->id }}" role="tabpanel" aria-labelledby="pills-{{ $type->id }}-tab">
          <form action="{{ route('profile-image-upload.store') }}" class="dropzone" id="uploadImagesForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="job_id" value="{{ $selected_quote->job_id }}">
            <input type="hidden" name="image_type" value="{{ $type->id }}">
          </form>
        </div> {{-- tab-pane fade --}}
      @endforeach
    </div>
    {{-- menu panels --}}
    {{-- dropzone image upload --}}

    {{-- action buttons --}}
    <div class="form-group row py-3">
      <div class="col-md">
        <a href="{{ route('profile-job-invoice.index', ['selected_quote_id' => $selected_quote->id]) }}" class="btn btn-primary">
          <i class="fas fa-check mr-2" aria-hidden="true"></i>Invoice This Job
        </a>
        <a href="{{ route('profile-jobs.show', $selected_quote->id) }}" class="btn btn-dark">
          <i class="fas fa-arrow-left mr-2" aria-hidden="true"></i>Return To Job
        </a>
      </div> {{-- col-md --}}
    </div> {{-- form-group row --}}
    {{-- action buttons --}}

    {{-- uploaded images --}}
    <h5 class="text-primary mt-3 mb-0"><b>All Job Images</b></h5> 
    @if (!$image_type_collections->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center"> 
          <h5>There are no job images to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      @foreach ($image_type_collections as $collections)
        <p class="text-primary mt-3"><b>{{ $collections->first()->job_image_type->title }} Images</b></p>
        <div class="card">
          <div class="card-body">
            @foreach ($collections->chunk(6) as $collection_chunk)
              <div class="row">
                @foreach ($collection_chunk as $collection)
                  <div class="col-sm-2">
                    @if ($collection->image_path == null)
                      <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                    @else
                      <img class="img-fluid" style="background-color:{{ $collection->is_visible == 1 ? '#00d1b2' : '#ff3860' }}; padding: 4px 4px 4px 4px;" src="{{ asset($collection->image_path) }}" alt="">
                    @endif
                  </div> {{-- col-sm-2 --}}
                @endforeach
              </div> {{-- row --}}
            @endforeach
          </div> {{-- card-body --}}
        </div> {{-- card --}}
      @endforeach
    @endif
    {{-- uploaded images --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- DropzoneJS JS  --}}
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
{{-- DropzoneJS JS  --}}
@endpush