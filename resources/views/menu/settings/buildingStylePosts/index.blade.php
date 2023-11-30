@extends('layouts.app')

@section('title', '- Settings - All Building Type Posts')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">BUILDING TYPE POSTS</h3>
    <h5>View All Building Type Posts</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('building-style-post-settings.create') }}">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Post
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <p class="text-primary my-3"><b>All Building Type Posts</b></p>
    @if (!$all_building_style_posts->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no building type posts to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Roof Surface</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_building_style_posts as $building_style)  
              <tr>
                <td>{{ $building_style->id }}</td>
                <td>{{ $building_style->title }}</td>
                <td>{{ $building_style->material_type->title }}</td>
                <td class="text-center">
                  <a href="{{ route('building-style-post-settings.show', $building_style->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                  <a href="{{ route('building-style-post-settings.edit', $building_style->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                  </a>
                  {{-- delete modal --}}
                  {{-- modal button --}}
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{$building_style->id}}">
                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                  </button>
                  {{-- modal button --}}
                  {{-- modal --}}
                  <div class="modal fade" id="deleteModal{{$building_style->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{$building_style->id}}Title" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteModal{{$building_style->id}}Title">Delete</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p class="text-center">Are you sure that you would like to delete this item?</p>
                          <form method="POST" action="{{ route('building-style-post-settings.destroy', $building_style->id) }}">
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
                </td>
              </tr> 
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection