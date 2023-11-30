@extends('layouts.app')

@section('title', '- Manage Quote Images')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">QUOTE IMAGES</h3>
    <h5>Manage Quote Images</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <form action="{{ route('job-images.create') }}" method="GET">
          <input type="hidden" name="job_id" value="{{ $selected_quote->job_id }}">
          <button type="submit" class="btn btn-primary btn-block">
            <i class="fas fa-arrow-left mr-2" aria-hidden="true"></i>Back to Job Images
          </button>
        </form>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

    {{-- customer details table --}}
    <div class="row">
      <div class="col-sm-7">
        <h5 class="text-primary my-3"><b>Quote Details</b></h5>
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <tbody>
            <tr>
              <th>Quote Identifier</th>
              <td>{{ $selected_quote->quote_identifier }}</td>
            </tr>
            <tr>
              <th>Job Type</th>
              <td>
                @if ($selected_quote->job_type_id == null)
                  <span class="badge badge-warning py-2 px-2">
                    <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>To Be Confirmed
                  </span>
                @else
                  {{ $selected_quote->job_type->title }}
                @endif
              </td>
            </tr>
            <tr>
              <th>Customer Name</th>
              <td>{{ $selected_quote->customer->getFullNameAttribute() }}</td>
            </tr>
            <tr>
              <th>Job Address</th>
              <td>{{ $selected_quote->job->tenant_street_address . ', ' . $selected_quote->job->tenant_suburb . ' ' . $selected_quote->job->tenant_postcode }}</td>
            </tr>
          </tbody>
        </table>
      </div> {{-- col-sm-7 --}}
    </div> {{-- row --}}
    {{-- customer details table --}}

    <h5 class="text-primary mt-3 mb-0"><b>All Job Images</b></h5>
    <p class="mb-0"><b>Please select which images will appear on the selected quote</b></p>

    <form action="{{ route('quote-images.update', $selected_quote->id) }}" method="POST">
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
              <div class="container">
                <div class="row row-cols-6">
                  @foreach ($collections as $image)
                    <div class="col py-3">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input bg-success" id="imageCheckbox{{$image->id}}" name="checked[]" value="{{ $image->id }}" {{ in_array($image->id, $quote_images) ? 'checked' : null }}>
                        <label class="custom-control-label" for="imageCheckbox{{$image->id}}"></label>
                      </div>
                      @if ($image->image_path == null)
                        <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                      @else
                        <img class="img-fluid" style="background-color:{{ in_array($image->id, $quote_images) == 1 ? '#00d1b2' : '#ff3860' }}; padding: 4px 4px 4px 4px;" src="{{ asset($image->image_path) }}" alt="">
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
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-check mr-2" aria-hidden="true"></i>Update Quote Images
          </button>
          <a href="{{ route('quote-images.create', ['quote_id' => $selected_quote->id]) }}" class="btn btn-dark modal-button">
            <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
          </a>
        </div> {{-- col-md --}}
      </div> {{-- form-group row --}}

    </form>

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection