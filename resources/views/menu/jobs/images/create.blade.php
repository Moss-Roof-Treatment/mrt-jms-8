@extends('layouts.jquery')

@section('title', '- Manage Job Images')

@push('css')
{{-- DropzoneJS CSS --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css" integrity="sha512-WvVX1YO12zmsvTpUQV8s7ZU98DnkaAokcciMZJfnNWyNzm7//QRV61t4aEr0WdIa4pe854QHLTV302vH92FSMw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
{{-- DropzoneJS CSS --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">JOB IMAGES</h3>
    <h5>Manage Job Images</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-arrow-left mr-2" aria-hidden="true"></i>Back to Job
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <form action="{{ route('quote-images.create') }}" method="GET">
          <div class="input-group mb-3">
            <select name="quote_id" class="custom-select @error('quote_id') is-invalid @enderror">
              <option selected disabled>Please select a quote</option>
              @foreach ($job->quotes as $quote)
                <option value="{{ $quote->id }}">{{ $quote->quote_identifier }}</option>
              @endforeach
            </select>
            <div class="input-group-append">
              <button class="btn btn-dark" type="submit" id="quote_id_button"><i class="fas fa-file-alt"></i></button>
            </div> {{-- form-control --}}
          </div> {{-- input-group mb-3 --}}
          @error('quote_id')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </form>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

    {{-- customer details table --}}
    <div class="row">
      <div class="col-sm-7">
        <h5 class="text-primary my-3"><b>Customer Details</b></h5>
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <tbody>
            <tr>
              <th>Customer Number</th>
              <td>{{ $job->customer_id }}</td>
            </tr>
            <tr>
              <th>Customer Name</th>
              <td>{{ $job->customer->getFullNameAttribute() }}</td>
            </tr>
            <tr>
              <th>Job Number</th>
              <td>{{ $job->id }}</td>
            </tr>
            <tr>
              <th>Job Address</th>
              <td>{{ $job->tenant_street_address . ', ' . $job->tenant_suburb . ' ' . $job->tenant_postcode }}</td>
            </tr>
          </tbody>
        </table>
      </div> {{-- col-sm-7 --}}
    </div> {{-- row --}}
    {{-- customer details table --}}

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
          <form action="{{ route('job-images.store') }}" class="dropzone" id="uploadImagesForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="job_id" value="{{ $job->id }}">
            <input type="hidden" name="image_type" value="{{ $type->id }}">
          </form>
        </div> {{-- tab-pane fade --}}
      @endforeach
    </div>
    {{-- menu panels --}}
    {{-- dropzone image upload --}}

    <h5 class="text-primary mt-3 mb-0"><b>All Job Images</b></h5>
    <p class="mb-0"><b>Please select which images will be visible to the customer</b></p>

    <form action="{{ route('job-images-permissions.update') }}" method="POST">
      @csrf

      <input type="hidden" name="job_id" value="{{ $job->id }}">

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
              <div class="container">
                <div class="row row-cols-6">
                  @foreach ($collections as $image)
                    <div class="col py-3">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input bg-success" id="imageCheckbox{{$image->id}}" name="checked[]" value="{{ $image->id }}" {{ $image->is_visible == 1 ? 'checked' : null }}>
                        <label class="custom-control-label" for="imageCheckbox{{$image->id}}"></label>
                      </div>
                      @if ($image->image_path == null)
                        <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                      @else
                        <img class="img-fluid" style="background-color:{{ $image->is_visible == 1 ? '#00d1b2' : '#ff3860' }}; padding: 4px 4px 4px 4px;" src="{{ asset($image->image_path) }}" alt="">
                      @endif
                    </div> {{-- col --}}
                  @endforeach
                </div> {{-- row row-cols-2 --}}
              </div> {{-- container --}}
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @endforeach
      @endif

      <div class="form-group row py-3">
        <div class="col-md">
          {{-- confirm modal --}}
          {{-- modal button --}}
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmUpdateModal">
            <i class="fas fa-check mr-2" aria-hidden="true"></i>Update Image Visibility
          </button>
          {{-- modal button --}}
          {{-- modal --}}
          <div class="modal fade" id="confirmUpdateModal" tabindex="-1" role="dialog" aria-labelledby="confirmUpdateModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="confirmUpdateModalTitle">Confirm</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div> {{-- modal-header --}}
                <div class="modal-body">
                  <p class="text-center">Are you sure that you would like to update the visibility of the selected images?</p>
                  <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-check mr-2" aria-hidden="true"></i>Confirm
                  </button>
                </div> {{-- modal-body --}}
              </div> {{-- modal-content --}}
            </div> {{-- modal-dialog --}}
          </div> {{-- modal --}}
          {{-- modal --}}
          {{-- confirm modal --}}
          <a href="{{ route('job-images.create', ['job_id' => $job->id]) }}" class="btn btn-dark modal-button">
            <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
          </a>
        </div> {{-- col-md --}}
      </div> {{-- form-group row --}}

    </form>

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