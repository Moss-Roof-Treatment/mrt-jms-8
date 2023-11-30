@extends('layouts.app')

@section('title', '- Settings - View Selected Building Style Post')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">BUILDING STYLE POSTS</h3>
    <h5>View Selected Building Style Post</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('building-style-post-t-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Building Style Posts Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a href="{{ route('building-style-post-t-settings.edit', $selected_building_style_post_type->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        {{-- delete modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModal{{$selected_building_style_post_type->id}}">
          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="deleteModal{{$selected_building_style_post_type->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{$selected_building_style_post_type->id}}Title" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="deleteModal{{$selected_building_style_post_type->id}}Title">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center">Are you sure that you would like to delete this item?</p>
                <form method="POST" action="{{ route('building-style-post-t-settings.destroy', $selected_building_style_post_type->id) }}">
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

    {{-- content --}}
    <div class="row">
      <div class="col-sm-6">

        {{-- details table --}}
        <p class="text-primary my-3"><b>Building Style Post Type Details</b></p>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>Title</th>
                <td>{{ $selected_building_style_post_type->title }}</td>
              </tr>
              <tr>
                <th>Description</th>
                <td width="80%">{{ $selected_building_style_post_type->description }}</td>
              </tr>
              <tr>
                <th>Image Path</th>
                <td>{{ $selected_building_style_post_type->image_path }}</td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}
        {{-- details table --}}

      </div> {{-- col-sm-6 my-2 --}}
      <div class="col-sm-4 offset-sm-1 my-2">

        {{-- post example --}}
        <p class="text-primary my-3"><b>Building Style Post Type Example</b></p>
        <div class="card">
          <span>
            <img src="{{ asset($selected_building_style_post_type->image_path) }}" class="card-img-top" alt="image">
            <div class="card-body bg-dark">
              <h2 class="card-title text-center text-white">{{ $selected_building_style_post_type->title }}</h2>
            </div>
          </span>
        </div> {{-- card --}}
        {{-- post example --}}

      </div> {{-- col-sm-4 my-2 --}}
    </div> {{-- row --}}
    {{-- content --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection