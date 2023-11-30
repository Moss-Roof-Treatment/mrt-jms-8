@extends('layouts.app')

@section('title', '- Terms and Conditions - View Terms and Conditions Subitems')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">TERMS AND CONDITIONS SUBITEMS</h3>
    <h5>Terms and Conditions Subitems</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('terms-and-conditions.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Terms and Conditions Menu 
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('terms-and-conditions-subitems.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>New Subitem
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- items index table --}}
    <h5 class="text-primary my-3"><b>All Subitems</b></h5>

    @if (!$all_subitems->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no priorities to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th width="20%">Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_subitems as $subitem)
              <tr>
                <td>{{ $subitem->id }}</td>
                <td>{{ substr($subitem->text, 0, 100) }} {{ strlen($subitem->text) > 100 ? "..." : "" }}</td>
                <td class="text-center">
                  @if ($subitem->is_editable == 0)
                    <a href="#" class="btn btn-primary btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">
                      <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                    </a>
                  @else
                    <a href="{{ route('terms-and-conditions-subitems.edit', $subitem->id) }}" class="btn btn-primary btn-sm">
                      <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                    </a>
                  @endif
                  {{-- modal start --}}
                  @if ($subitem->is_delible == 0)
                    <a href="#" class="btn btn-danger btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                    </a>
                  @else
                    {{-- delete modal --}}
                    {{-- modal button --}}
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete-job">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                    </button>
                    {{-- modal button --}}
                    {{-- modal --}}
                    <div class="modal fade" id="confirm-delete-job" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-job-title" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="confirm-delete-job-title">Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p class="text-center">Are you sure that you would like to delete this item?</p>
                            <form action="{{ route('terms-and-conditions-subitems.destroy', $subitem->id) }}" method="POST">
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
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- items index table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection