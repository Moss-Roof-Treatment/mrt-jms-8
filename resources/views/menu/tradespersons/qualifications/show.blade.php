@extends('layouts.app')

@section('title', '- Qualifications - View All Qualifications')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">QUALIFICATIONS</h3>
    <h5>View All Qualifications</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('tradesperson-qualifications.index', ['selected_user_id' => $selected_qualification->staff_id]) }}" class="btn btn-dark btn-block">
          <i class="fas fa-id-card-alt mr-2" aria-hidden="true"></i>View Qualifications
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('tradesperson-qualifications.edit', $selected_qualification->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
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
                <form action="{{ route('tradesperson-qualifications.destroy', $selected_qualification->id) }}" method="POST">
                  @method('DELETE')
                  @csrf
                  <input type="hidden" name="selected_user_id" value="{{ $selected_qualification->staff_id }}">
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
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-6">

        <h5 class="text-primary my-3"><b>Qualification Image</b></h5>
        @if ($selected_qualification->image_path == null)
          <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/document-256x256.jpg') }}" alt="">
        @else
          <img class="img-fluid" src="{{ asset($selected_qualification->image_path) }}" alt="">
        @endif

      </div> {{-- col-sm-6 --}}
      <div class="col-sm-6">

        <h5 class="text-primary my-3"><b>Qualification Details</b></h5>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th width="25%">User</th>
                <td>{{ $selected_qualification->staff->getFullNameAttribute() }}</td>
              </tr>
              <tr>
                <th>Title</th>
                <td>{{ $selected_qualification->title }}</td>
              </tr>
              <tr>
                <th>Description</th>
                <td>{{ $selected_qualification->description }}</td>
              </tr>
              <tr>
                <th>Creation Date</th>
                <td>{{ date('d/m/y - h:iA', strtotime($selected_qualification->created_at)) }}</td>
              </tr>
              <tr>
                <th>Issue Date</th>
                <td>{{ date('d/m/y', strtotime($selected_qualification->issue_date)) }}</td>
              </tr>
              <tr>
                <th>Expiry Date</th>
                <td>
                  @if ($selected_qualification->expiry_date == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ date('d/m/y', strtotime($selected_qualification->expiry_date)) }}
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}

      </div> {{-- col-sm-6 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection