@extends('layouts.app')

@section('title', '- Default Image Texts - View Selected Default Image Text')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">DEFAULT IMAGE TEXTS</h3>
    <h5>View Selected Default Image Text</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('default-image-text-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Default Image Text Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a href="{{ route('default-image-text-settings.edit', $selected_default_image_text->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
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
                <form method="POST" action="{{ route('default-image-text-settings.destroy', $selected_default_image_text->id) }}">
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

    <p class="text-primary my-3"><b>Default Image Text Details</b></p>

    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <thead class="table-secondary">
          <tr>
            <th>ID</th>
            <th>Text</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <td>{{ $selected_default_image_text->id }}</td>
              <td>{{ $selected_default_image_text->text }}</td>
            </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection