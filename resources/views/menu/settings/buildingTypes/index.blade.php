@extends('layouts.app')

@section('title', '- Settings - All Building Types')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">BUILDING TYPES</h3>
    <h5>View All Building Types</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('building-type-settings.create') }}">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Building Type
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <p class="text-primary my-3"><b>All Building Types</b></p>

    @if (!$building_types->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no Building types to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Description</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($building_types as $building_type)  
              <tr>
                <td>{{ $building_type->id }}</td>
                <td>{{ $building_type->title }}</td>
                <td>
                  @if ($building_type->description == null)
                    <span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>The description has not been set</span>
                  @else
                    {{ substr($building_type->description, 0, 40) }}{{ strlen($building_type->description) > 40 ? "..." : "" }}
                  @endif
                </td>
                <td class="text-center">
                  @if ($building_type->is_editable == 0)
                    <a href="#" class="btn btn-primary btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">
                      <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                    </a>
                  @else
                    <a href="{{ route('building-type-settings.edit', $building_type->id) }}" class="btn btn-primary btn-sm">
                      <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                    </a>
                  @endif
                  @if ($building_type->is_delible == 0)
                    <a href="#" class="btn btn-danger btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                    </a>
                  @else
                    {{-- delete modal --}}
                    {{-- modal button --}}
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{$building_type->id}}">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                    </button>
                    {{-- modal button --}}
                    {{-- modal --}}
                    <div class="modal fade" id="deleteModal{{$building_type->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{$building_type->id}}Title" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteModal{{$building_type->id}}Title">Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p class="text-center">Are you sure that you would like to delete this item?</p>
                            <form method="POST" action="{{ route('building-type-settings.destroy', $building_type->id) }}">
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

    {{ $building_types->links() }}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection