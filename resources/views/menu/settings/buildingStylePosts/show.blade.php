@extends('layouts.app')

@section('title', '- Settings - View Selected Building Type Post')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">BUILDING TYPE POSTS</h3>
    <h5>View Selected Building Type Post</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
      <a href="{{ route('building-style-post-settings.index') }}" class="btn btn-dark btn-block">
        <i class="fas fa-bars mr-2" aria-hidden="true"></i>Building Type Posts Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a href="{{ route('building-style-post-settings.edit', $selected_building_style_post->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        {{-- delete modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModal{{$selected_building_style_post->id}}">
          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="deleteModal{{$selected_building_style_post->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{$selected_building_style_post->id}}Title" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="deleteModal{{$selected_building_style_post->id}}Title">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center">Are you sure that you would like to delete this item?</p>
                <form method="POST" action="{{ route('building-style-post-settings.destroy', $selected_building_style_post->id) }}">
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

    {{-- details table --}}
    <p class="text-primary my-3"><b>Building Type Post Type Details</b></p>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <tbody>
          <tr>
            <th>Title</th>
            <td>{{ $selected_building_style_post->title }}</td>
          </tr>
          <tr>
            <th>Type</th>
            <td>{{ $selected_building_style_post->building_style_post_type->title }}</td>
          </tr>
          <tr>
            <th>Completion date</th>
            <td>{{ date('d/m/Y', strtotime($selected_building_style_post->completed_date)) }}</td>
          </tr>
          <tr>
            <th>Image Path</th>
            <td>{{ $selected_building_style_post->roof_outline_image_path }}</td>
          </tr>
          <tr>
            <th>Image Path</th>
            <td>{{ $selected_building_style_post->building_image_path }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- details table --}}

    {{-- post example --}}
    <p class="text-primary my-3"><b>Building Type Post Example</b></p>
    <div class="row">
      <div class="col-sm-4 my-2 align-self-center">
        <h3 class="text-secondary">{{ $selected_building_style_post->title }}</h3>
        <h5 class="text-muted"><b>Date Completed:</b> {{ date('d/m/Y', strtotime($selected_building_style_post->completed_date)) }}</h5>
        <h5 class="text-muted"><b>Roof Type:</b> {{ $selected_building_style_post->material_type->title }}</h5>
      </div> {{-- col-sm-4 my-2 --}}
      <div class="col-sm-4 my-2">
        <img class="img-fluid img-thumbnail bg-secondary" src="{{ asset($selected_building_style_post->roof_outline_image_path) }}" alt="">
      </div> {{-- col-sm-4 my-2 --}}
      <div class="col-sm-4 my-2">
        <img class="img-fluid img-thumbnail bg-secondary" src="{{ asset($selected_building_style_post->building_image_path) }}" alt="">
      </div> {{-- col-sm-4 my-2 --}}
    </div> {{-- row --}}
    <div class="row">
      <div class="col-sm-8 offset-sm-4">
        <p class="text-secondary">{{ $selected_building_style_post->description }}</p>
      </div>
    </div>
    {{-- post example --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection