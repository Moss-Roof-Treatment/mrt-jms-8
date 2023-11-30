@extends('layouts.app')

@section('title', '- Testionials - View Selected Testionial')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">TESTIMONIALS</h3>
    <h5>View Selected Testionial</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('manual-testimonials-settings.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Testionial Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('manual-testimonials-settings.edit', $selected_testimonial->id ) }}">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit Testionial
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
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
                <p class="text-center">Are you sure that you would like to delete this item?</p>
                <form action="{{ route('manual-testimonials-settings.destroy', $selected_testimonial->id) }}" method="POST">
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
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-6">

        <p class="text-primary my-3"><b>Testimonial Image</b></p>
        @if ($selected_testimonial->image_path == null)
          <img class="img-fluid mx-auto d-block py-3" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
        @else
          <img class="img-fluid mx-auto d-block py-3" src="{{ asset($selected_testimonial->image_path) }}" alt="job_image">
        @endif

      </div> {{-- col-sm-6 --}}
      <div class="col-sm-6">

        {{-- testimonial details --}}
        <p class="text-primary my-3"><b>Testimonial Details</b></p>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <thead class="table-secondary">
              <tr>
                <th>ID</th>
                <th>Staff Member</th>
                <th>Visibility Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ $selected_testimonial->id }}</td>
                <td>{{ $selected_testimonial->user->getFullNameAttribute() }}</td>
                <td>
                  @if ($selected_testimonial->is_visible == 1)
                    <span class="badge badge-success py-2 px-2">
                      <i class="fas fa-eye mr-2" aria-hidden="true"></i>Is Visible
                    </span>
                  @else
                    <span class="badge badge-danger py-2 px-2">
                      <i class="fas fa-eye-slash mr-2" aria-hidden="true"></i>Is Not Visible
                    </span>
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}
        {{-- testimonial details --}}

      </div> {{-- col-sm-6 --}}
    </div> {{-- row --}}

    {{-- testimonial text --}}
    <p class="text-primary my-3"><b>Testimonial Text</b></p>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <tbody>
          <tr>
            <td>{{ $selected_testimonial->text }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- testimonial text --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection
