@extends('layouts.jquery')

@section('title', '- View Selected Job Image')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">JOB IMAGES</h3>
    <h5>View Selected Job Image</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('jobs.show', $selected_image->job_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Job
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('customers.show', $selected_image->job->customer_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-user mr-2" aria-hidden="true"></i>View Customer
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <form action="{{ route('job-images.create') }}" method="GET">
          <input type="hidden" name="job_id" value="{{ $selected_image->job_id }}">
          <button type="submit" class="btn btn-primary btn-block">
            <i class="fas fa-images mr-2" aria-hidden="true"></i>Upload Images
          </button>
        </form>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        {{-- delete modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#confirm-delete-job">
          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete Selected Image
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="confirm-delete-job" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-jobTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="confirm-delete-jobTitle">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center">Are you sure that you would like to delete this item?</p>
                <form action="{{ route('job-images.destroy', $selected_image->id) }}" method="POST">
                  @method('DELETE')
                  @csrf
                  <button type="submit" class="btn btn-danger btn-block">
                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                  </button>
                </form>
              </div> {{-- modal-body --}}
            </div> {{-- modal-content --}}
          </div> {{-- modal-dialog --}}
        </div> {{-- modal fade --}}
        {{-- modal --}}
        {{-- delete modal --}}
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-6">

        <h5 class="text-primary my-3"><b>Image Preview</b></h5>
        <div class="card shadow-sm">
          @if ($selected_image->image_path == null)
            <img class="card-img-top" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
          @else
            <img class="card-img-top" src="{{ asset($selected_image->image_path) }}" style="margin:auto;" alt="">
          @endif
          <div class="card-body bg-{{$selected_image->colour->brand}}">
            <div class="content text-center text-{{ $selected_image->colour->text_brand }}">
              <b>{{ $selected_image->title }}</b>
            </div>
          </div>
          <div class="card-body">
            {{ $selected_image->description }}
          </div> {{-- card-body --}}
        </div> {{-- card --}}

      </div> {{-- col-sm-6 --}}
      <div class="col-sm-6">


        <h5 class="text-primary my-3"><b>Edit Image Details</b></h5>
        <form action="{{ route('job-images.update', $selected_image->id) }}" method="POST" enctype="multipart/form-data">
          @method('PATCH')
          @csrf

          <input type="hidden" name="job_id" value="{{ $selected_image->job_id }}">

          <div class="form-group row">
            <label for="title" class="col-md-3 col-form-label text-md-right">Title</label>
            <div class="col-md-9">
              <input type="text" class="form-control @error('title') is-invalid @enderror mb-2" name="title" id="title" value="{{ old('title', $selected_image->title) }}" placeholder="Please enter the title">
              @error('title')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="default_image_title" class="col-md-3 col-form-label text-md-right">Default Title</label>
            <div class="col-md-9">
              <select name="default_image_title" id="default_image_title" class="custom-select @error('default_image_title') is-invalid @enderror mb-2">
                @if (old('default_image_title'))
                  <option disabled>Please select a default title</option>
                  @foreach ($all_default_image_titles as $default_image_title)
                    <option value="{{ $default_image_title->id }}" @if (old('default_image_title') == $default_image_title->id) selected @endif>{{ substr($default_image_title->text, 0, 40) }} {{ strlen($default_image_title->text) > 40 ? "..." : "" }}</option>
                  @endforeach
                @else
                  <option selected disabled>Please select a default title</option>
                  @foreach ($all_default_image_titles as $default_image_title)
                    <option value="{{ $default_image_title->id }}">{{ substr($default_image_title->text, 0, 40) }} {{ strlen($default_image_title->text) > 40 ? "..." : "" }}</option>
                  @endforeach
                @endif
              </select>
              @error('default_image_title')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="title_colour" class="col-md-3 col-form-label text-md-right">Colour</label>
            <div class="col-md-9">
              <select name="title_colour" id="title_colour" class="custom-select @error('title_colour') is-invalid @enderror mb-2">
                @if (old('title_colour'))
                  <option disabled>Please select a colour</option>
                  @foreach ($all_colours as $colour)
                    <option value="{{ $colour->id }}" @if (old('title_colour') == $colour->id) selected @endif>{{ $colour->title }}</option>
                  @endforeach
                @else
                  @if ($selected_image->colour_id == null)
                    <option selected disabled>Please select a colour</option>
                  @else
                    <option selected value="{{ $selected_image->colour_id }}">{{ $selected_image->colour->title . ' - ' . $selected_image->colour->colour }}</option>
                    <option disabled>Please select a colour</option>
                  @endif
                  @foreach ($all_colours as $colour)
                    <option value="{{ $colour->id }}">{{ $colour->title . ' - ' . $colour->colour }}</option>
                  @endforeach
                @endif
              </select>
              @error('title_colour')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="image_type_id" class="col-md-3 col-form-label text-md-right">Image Type</label>
            <div class="col-md-9">
              <select name="image_type_id" id="image_type_id" class="custom-select @error('image_type_id') is-invalid @enderror mb-2">
                @if (old('image_type_id'))
                  <option disabled>Please select an image type</option>
                  @foreach ($all_image_types as $image_type)
                    <option value="{{ $image_type->id }}" @if (old('image_type') == $image_type->id) selected @endif>{{ $image_type->title }}</option>
                  @endforeach
                @else
                  @if ($selected_image->job_image_type_id == null)
                    <option selected disabled>Please select an image type</option>
                  @else
                    <option selected value="{{ $selected_image->job_image_type_id }}">{{ $selected_image->job_image_type->title }}</option>
                    <option disabled>Please select an image type</option>
                  @endif
                  @foreach ($all_image_types as $image_type)
                    <option value="{{ $image_type->id }}">{{ $image_type->title }}</option>
                  @endforeach
                @endif
              </select>
              @error('image_type_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="default_image_text" class="col-md-3 col-form-label text-md-right">Default Text</label>
            <div class="col-md-9">
              <select name="default_image_text" id="default_image_text" class="custom-select @error('default_image_text') is-invalid @enderror mb-2">
                @if (old('default_image_text'))
                  <option disabled>Please select a default text</option>
                  @foreach ($all_default_image_texts as $default_image_text)
                    <option value="{{ $default_image_text->id }}" @if (old('default_image_text') == $default_image_text->id) selected @endif>{{ substr($default_image_text->text, 0, 40) }} {{ strlen($default_image_text->text) > 40 ? "..." : "" }}</option>
                  @endforeach
                @else
                  <option selected disabled>Please select a default text</option>
                  @foreach ($all_default_image_texts as $default_image_text)
                    <option value="{{ $default_image_text->id }}">{{ substr($default_image_text->text, 0, 40) }} {{ strlen($default_image_text->text) > 40 ? "..." : "" }}</option>
                  @endforeach
                @endif
              </select>
              @error('default_image_text')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="description" class="col-md-3 col-form-label text-md-right">Description</label>
            <div class="col-md-9">
              <textarea type="text" class="form-control @error('description') is-invalid @enderror mb-2" name="description" rows="5" placeholder="Please enter the user description" style="resize:none">{{ old('description', $selected_image->description) }}</textarea>
              @error('description')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="image" class="col-md-3 col-form-label text-md-right">Image</label>
            <div class="col-md-9">
              <div class="custom-file">
                <label class="custom-file-label" for="image" id="image_name">Please select an image to upload</label>
                <input type="file" class="custom-file-input" name="image" id="image" aria-describedby="image">
              </div> {{-- custom-file --}}
              @error('image')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <div class="col-md-8 offset-md-3">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
              </button>
              {{-- reset modal --}}
              {{-- modal button --}}
              <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#confirmResetModal">
                <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
              </button>
              {{-- modal button --}}
              {{-- modal --}}
              <div class="modal fade" id="confirmResetModal" tabindex="-1" role="dialog" aria-labelledby="confirmResetModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="confirmResetModalTitle">Reset</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="text-center">Are you sure that you would like to reset this form?</p>
                      <a href="{{ route('job-images.show', $selected_image->id) }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              <a href="{{ route('jobs.show', $selected_image->job_id) }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

        </form>

        <h5 class="text-primary my-3"><b>Image Details</b></h5>
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <tbody>
            <tr>
              <th>Address</th>
              <td>{{ $selected_image->job->tenant_street_address . ', ' . $selected_image->job->tenant_suburb . ', ' . $selected_image->job->tenant_postcode }}</td>
            </tr>
            <tr>
              <th>Image ID</th>
              <td>{{ $selected_image->id }}</td>
            </tr>
            <tr>
              <th>Image Identifier</th>
              <td>
                @if ($selected_image->image_identifier == null)
                  <span class="badge badge-warning py-2 px-2">
                    <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>The image identifier does not exist
                  </span>
                @else
                  {{ $selected_image->image_identifier }}
                @endif
              </td>
            </tr>
            <tr>
              <th>Title Colour</th>
              <td>
                @if ($selected_image->colour_id == null)
                  <span class="badge badge-light py-2 px-2">
                    <i class="fas fa-times mr-2" aria-hidden="true"></i>Title colour has not been set
                  </span>
                @else
                  <span class="icon" style="color:{{ $selected_image->colour->colour }};">
                    <i class="fas fa-square mr-2" aria-hidden="true"></i>
                  </span>
                  {{ $selected_image->colour->colour }}
                @endif
              </td>
            </tr>
            <tr>
              <th>Image Path</th>
              <td>
                @if ($selected_image->image_path == null)
                  <span class="badge badge-warning py-2 px-2">
                    <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>The image path does not exist
                  </span>
                @else
                  {{ $selected_image->image_path }}
                @endif
              </td>
            </tr>
            <tr>
              <th>Uploaded By</th>
              <td>{{ $selected_image->staff->getFullNameAttribute() }}</td>
            </tr>
            <tr>
              <th>Upload Date</th>
              <td>{{ date('d/m/y - h:iA', strtotime($selected_image->created_at)) }}</td>
            </tr>
          </tbody>
        </table>

      </div> {{-- col-sm-6 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
  {{-- Image upload display name --}}
  <script>
    var image = document.getElementById("image");
    image.onchange = function(){
      if (image.files.length > 0)
      {
        document.getElementById('image_name').innerHTML = image.files[0].name;
      }
    };
  </script>
@endpush