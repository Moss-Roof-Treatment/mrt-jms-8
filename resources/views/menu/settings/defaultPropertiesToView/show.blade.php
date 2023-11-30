@extends('layouts.app')

@section('title', '- Default Properties To View - View Selected Default Properties To View')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">DEFAULT PROPERTIES TO VIEW</h3>
    <h5>View Selected Default Properties To View</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('default-properties-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Default Properties Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a href="{{ route('default-properties-settings.edit', $selected_default_properties_to_view->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        @if ($selected_default_properties_to_view->is_delible == 0)
          <a href="#" class="btn btn-danger btn-block disabled" tabindex="-1" role="button" aria-disabled="true">
            <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
          </a>
        @else
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
                  <form method="POST" action="{{ route('default-properties-settings.destroy', $selected_default_properties_to_view->id) }}">
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
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <p class="text-primary my-3"><b>{{ $selected_default_properties_to_view->title }} Default Properties To View</b></p>

    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <tbody>
            <tr>
              <th>Property 1</th>
              <td>
                @if ($selected_default_properties_to_view->property_1 == null)
                  <span class="badge badge-warning py-2 px-2">
                    <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>This item is yet to be set
                  </span>
                @else
                  {{ $selected_default_properties_to_view->property_1 }}
                @endif
              </td>
            </tr>
            <tr>
              <th>Property 2</th>
              <td>
                @if ($selected_default_properties_to_view->property_2 == null)
                  <span class="badge badge-warning py-2 px-2">
                    <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>This item is yet to be set
                  </span>
                @else
                  {{ $selected_default_properties_to_view->property_2 }}
                @endif
              </td>
            </tr>
            <tr>
              <th>Property 3</th>
              <td>
                @if ($selected_default_properties_to_view->property_3 == null)
                  <span class="badge badge-warning py-2 px-2">
                    <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>This item is yet to be set
                  </span>
                @else
                  {{ $selected_default_properties_to_view->property_3 }}
                @endif
              </td>
            </tr>
            <tr>
              <th>Property 4</th>
              <td>
                @if ($selected_default_properties_to_view->property_4 == null)
                  <span class="badge badge-warning py-2 px-2">
                    <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>This item is yet to be set
                  </span>
                @else
                  {{ $selected_default_properties_to_view->property_4 }}
                @endif
              </td>
            </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection