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
        <a href="{{ route('tradesperson-qualifications.create', ['selected_user_id' => $selected_user->id]) }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Qualification
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- body --}}
    <h5 class="text-primary my-3"><b>All Qualifications</b></h5>
    @if (!$selected_qualifications->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no qualifications to display for this tradesperson.</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="container">
        <div class="row row-cols-3">
          @foreach ($selected_qualifications as $selected_qualification)
            <div class="col">
              <div class="card">
                <div class="card-body text-center">
                  <a href="{{ route('tradesperson-qualifications.show', $selected_qualification->id) }}">
                    @if ($selected_qualification->image_path == null)
                      <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/document-256x256.jpg') }}" alt="">
                    @else
                      <img class="img-fluid" src="{{ asset($selected_qualification->image_path) }}" alt="">
                    @endif
                  </a>
                  <p class="pt-3">{{ $selected_qualification->title }}</p>
                  <a href="{{ route('tradesperson-qualifications.show', $selected_qualification->id) }}" class="btn btn-primary">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                  <a href="{{ route('tradesperson-qualifications.edit', $selected_qualification->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                  </a>
                  {{-- delete modal --}}
                  {{-- modal button --}}
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{$selected_qualification->id}}">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                  </button>
                  {{-- modal button --}}
                  {{-- modal --}}
                  <div class="modal fade" id="deleteModal{{$selected_qualification->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{$selected_qualification->id}}Title" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteModal{{$selected_qualification->id}}Title">Delete</h5>
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
                </div> {{-- card-body--}}
              </div> {{-- card --}}
            </div> {{-- col --}}
          @endforeach
        </div> {{-- row row-cols-2 --}}
      </div> {{-- container --}}
    @endif
    {{-- body --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection
