@extends('layouts.app')

@section('title', '- Default Properties To View - All Default Properties To View')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">DEFAULT PROPERTIES TO VIEW</h3>
    <h5>All Default Properties To View</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a href="{{ route('default-properties-settings.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Properties
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    {{-- default properties table --}}
    <p class="text-primary my-3"><b>All Default Properties</b></p>
    @if (!$all_default_properties_to_view->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no default image texts to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_default_properties_to_view as $default_properties_to_view)  
              <tr>
                <td>
                  <a href="{{ route('default-properties-settings.show', $default_properties_to_view->id) }}">
                    {{ $default_properties_to_view->id }}
                  </a>
                </td>
                <td>{{ $default_properties_to_view->title }}</td>
                <td class="text-nowrap">
                  <a href="{{ route('default-properties-settings.show', $default_properties_to_view->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                  @if ($default_properties_to_view->is_editable == 0)
                    <a href="#" class="btn btn-primary btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">
                      <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                    </a>
                  @else
                    <a href="{{ route('default-properties-settings.edit', $default_properties_to_view->id) }}" class="btn btn-primary btn-sm">
                      <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                    </a>
                  @endif
                  @if ($default_properties_to_view->is_delible == 0)
                    <a href="#" class="btn btn-danger btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                    </a>
                  @else
                    {{-- delete modal --}}
                    {{-- modal button --}}
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{$default_properties_to_view->id}}">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                    </button>
                    {{-- modal button --}}
                    {{-- modal --}}
                    <div class="modal fade" id="deleteModal{{$default_properties_to_view->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{$default_properties_to_view->id}}Title" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModal{{$default_properties_to_view->id}}Title">Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-center">Are you sure that you would like to delete this item?</p>
                                    <form method="POST" action="{{ route('default-properties-settings.destroy', $default_properties_to_view->id) }}">
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
                  @endif
                </td>
              </tr> 
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- default properties table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection