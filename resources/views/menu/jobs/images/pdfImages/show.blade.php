@extends('layouts.jquery')

@section('title', '- Manage PDF Images')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">JOB IMAGES</h3>
    <h5>Manage Pdf Images</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('jobs.show', $selected_job->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-arrow-left mr-2" aria-hidden="true"></i>Back to Job
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

    <h5 class="text-primary mt-3 mb-0"><b>All Job Images</b></h5>
    <p class="mb-0"><b>Please select upto 4 images to be displayed on the quote</b></p>

    <form action="{{ route('manage-pdf-images.update', $selected_job->id) }}" method="POST">
      @method('PATCH')
      @csrf

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
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input bg-success" id="imageCheckbox{{$collection->id}}" name="images[]" value="{{ $collection->id }}" {{ $collection->is_pdf_image == 1 ? 'checked' : null }}>
                        <label class="custom-control-label" for="imageCheckbox{{$collection->id}}"></label>
                      </div>
                      @if ($collection->image_path == null)
                        <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                      @else
                        <img class="img-fluid" style="background-color:{{ $collection->is_pdf_image == 1 ? '#00d1b2' : '#ff3860' }}; padding: 4px 4px 4px 4px;" src="{{ asset($collection->image_path) }}" alt="">
                      @endif
                    </div> {{-- col-sm-2 --}}
                  @endforeach
                </div> {{-- row --}}
              @endforeach
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @endforeach
      @endif

      <div class="form-group row py-3">
        <div class="col-md">
          {{-- confirm modal --}}
          {{-- modal button --}}
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmUpdateModal">
            <i class="fas fa-check mr-2" aria-hidden="true"></i>Update Selected Images
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
                  <p class="text-center">Are you sure that you would like to update the selected PDF images?</p>
                  <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-check mr-2" aria-hidden="true"></i>Confirm
                  </button>
                </div> {{-- modal-body --}}
              </div> {{-- modal-content --}}
            </div> {{-- modal-dialog --}}
          </div> {{-- modal --}}
          {{-- modal --}}
          {{-- confirm modal --}}
          <a href="{{ route('manage-pdf-images.show', $selected_job->id) }}" class="btn btn-dark modal-button">
            <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
          </a>
        </div> {{-- col-md --}}
      </div> {{-- form-group row --}}

    </form>

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection