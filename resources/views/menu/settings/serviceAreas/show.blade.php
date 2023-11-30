@extends('layouts.app')

@section('title', '- Service Areas - View Selected Service Area')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SERVICE AREAS</h3>
    <h5>View Selected Service Area</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('service-area-settings.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Service Area Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('service-area-settings.edit', $selected_service_area->id ) }}">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        {{-- delete modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModalCenter">
          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="deleteModalCenter" tabindex="-1" role="dialog" aria-labelledby="deleteModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="deleteModalCenterTitle">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div> {{-- modal-header --}}
              <div class="modal-body">
                <p class="subtitle text-center">Are you sure you would like to delete the selected item...?</p>
                <form action="{{ route('service-area-settings.destroy', $selected_service_area->id) }}" method="POST">
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
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-6">

        <p class="text-primary my-3"><b>Service Area Video</b></p>

        <div class="row pb-3">
          <div class="col">
            <div class="text-center">
              <figure>
                @if ($selected_service_area->video_link == null)
                  <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset('storage/images/placeholders/home-560x339.jpg') }}" alt="">
                @else
                  <iframe width="100%" height="315" src="{{ $selected_service_area->video_link }}" title="YouTube video player" frameborder="0"></iframe>
                @endif
              </figure>
            </div> {{-- text-center --}}
          </div> {{-- col-sm-6 --}}
        </div> {{-- row --}}

      </div> {{-- col-sm-6 --}}
      <div class="col-sm-6">

        <p class="text-primary my-3"><b>Service Area Details</b></p>

        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th width="35%">ID</th>
                <td>{{ $selected_service_area->id }}</td>
              </tr>
              <tr>
                <th>Title</th>
                <td>{{ $selected_service_area->title }}</td>
              </tr>
              <tr>
                <th>Visibility</th>
                <td>
                  @if ($selected_service_area->is_visible == 0)
                    <span class="badge badge-danger py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Visible
                    </span>
                  @else
                    <span class="badge badge-success py-2 px-2">
                      <i class="fas fa-check mr-2" aria-hidden="true"></i>Visible
                    </span>
                  @endif
                </td>
              </tr>
              <tr>
                <th>Featured</th>
                <td>
                  @if ($selected_service_area->is_featured == 0)
                    <span class="badge badge-danger py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Featured
                    </span>
                  @else
                    <span class="badge badge-success py-2 px-2">
                      <i class="fas fa-check mr-2" aria-hidden="true"></i>Featured
                    </span>
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}

      </div> {{-- col-sm-6 --}}
    </div> {{-- row --}}

    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <tbody>
          <tr>
            <th>Subtitle</th>
          </tr>
          <tr>
            <td>{{ $selected_service_area->subtitle }}</td>
          </tr>
          <tr>
            <th>Text</th>
          </tr>
          <tr>
            <td>{{ $selected_service_area->text }}</td>
          </tr>
          <tr>
            <th>Video Link</th>
          </tr>
          <tr>
            <td>{{ $selected_service_area->video_link }}</td>
          </tr>
          <tr>
            <th>Video Text</th>
          </tr>
          <tr>
            <td>{{ $selected_service_area->video_text }}</td>
          </tr>
          <tr>
            <th>Second Subtitle</th>
          </tr>
          <tr>
            <td>{{ $selected_service_area->second_subtitle }}</td>
          </tr>
          <tr>
            <th>Second Text</th>
          </tr>
          <tr>
            <td>{{ $selected_service_area->second_text }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection
