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
        <a href="{{ route($selected_user->account_role->route_title, $selected_user->id) }}" class="btn btn-dark btn-block">
            <i class="fas fa-user mr-2" aria-hidden="true"></i>View {{ $selected_user->account_role->title }}
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('staff-qualifications.create', ['selected_user_id' => $selected_user->id]) }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Qualification
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- body --}}
    <h5 class="text-primary my-3"><b>All Qualifications</b></h5>
    @if (!$selected_user->qualifications->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no qualifications to display for this user</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="row row-cols-1 row-cols-md-3">
        @foreach ($selected_user->qualifications as $selected_qualification)
          <div class="col my-3">
            <div class="card h-100">
              <a href="{{ route('staff-qualifications.show', $selected_qualification->id) }}">
                @if ($selected_qualification->image_path == null)
                  <img class="card-img-top" src="{{ asset('storage/images/placeholders/document-256x256.jpg') }}" alt="">
                @else
                  <img class="card-img-top" src="{{ asset($selected_qualification->image_path) }}" alt="">
                @endif
              </a>
              <div class="card-body text-center">
                <h5 class="card-title">{{ $selected_qualification->title }}</h5>
                <a href="{{ route('staff-qualifications.show', $selected_qualification->id) }}" class="btn btn-primary">
                  <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                </a>
                <a href="{{ route('staff-qualifications.edit', $selected_qualification->id) }}" class="btn btn-primary">
                  <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                </a>
                {{-- reset modal --}}
                {{-- modal button --}}
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal">
                  <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                </button>
                {{-- modal button --}}
                {{-- modal --}}
                <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalTitle">Reset</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p class="text-center">Are you sure that you would like to reset this form?</p>
                        <form action="{{ route('staff-qualifications.destroy', $selected_qualification->id) }}" method="POST">
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
                {{-- reset modal --}}

              </div> {{-- card-body --}}
            </div> {{-- card h-100 --}}
          </div> {{-- col mb-4 --}}
        @endforeach
      </div> {{-- row --}}
    @endif
    {{-- body --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection