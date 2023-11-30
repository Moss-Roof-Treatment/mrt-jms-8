@extends('layouts.app')

@section('title', '- Email Templates - View Selected Email Template')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">EMAIL TEMPLATES</h3>
    <h5>View Slected Email Template</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('email-templates.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Email Template Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('email-template-render-example.show', $selected_template->id) }}" target="_blank" class="btn btn-dark btn-block">
          <i class="fas fa-image mr-2" aria-hidden="true"></i>View Email Example
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        @if ($selected_template->is_delible == 1)
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
                  <form action="{{ route('email-templates.destroy', $selected_template->id) }}" method="POST">
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
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-7">

        <h5 class="text-primary my-3"><b>Edit Email Template</b></h5>

        <form action="{{ route('email-templates.update', $selected_template->id) }}" method="POST">
          @method('PATCH')
          @csrf

          <div class="form-group row">
            <label for="title" class="col-md-2 col-form-label text-md-right">Title</label>
            <div class="col-md-9">
              <input type="text" class="form-control @error('title') is-invalid @enderror mb-2" name="title" id="title" value="{{ old('title', $selected_template->title) }}" placeholder="Please enter the title">
              @error('title')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-6 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="subject" class="col-md-2 col-form-label text-md-right">Subject</label>
            <div class="col-md-9">
              <input type="text" class="form-control @error('subject') is-invalid @enderror mb-2" name="subject" id="subject" value="{{ old('subject', $selected_template->subject) }}" placeholder="Please enter the subject">
              @error('subject')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-6 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="text" class="col-md-2 col-form-label text-md-right">Message</label>
            <div class="col-md-9">
              <textarea class="form-control @error('text') is-invalid @enderror mb-2" type="text" name="text" rows="10" placeholder="Please enter the message" style="resize:none">{{ old('text', $selected_template->text) }}</textarea>
              @error('text')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row mb-0">
            <div class="col-md-9 offset-md-2">
              <button type="submit" class="btn btn-primary" {{ $selected_template->is_editable == 0 ? 'disabled' : '' }}>
                <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
              </button>
              {{-- reset modal --}}
              {{-- modal button --}}
              <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#confirmResetModal">
                <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
              </button>
              {{-- modal button --}}
              {{-- modal --}}
              <div class="modal fade" id="confirmResetModal" tabindex="-1" role="dialog" aria-labelledby="confirmResetModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="confirmResetModalTitle">Reset</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="text-center">Are you sure that you would like to reset this form?</p>
                      <a class="btn btn-dark btn-block" href="{{ route('email-templates.show', $selected_template->id) }}">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              {{-- cancel button --}}
              <a href="{{ route('email-templates.index') }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
              {{-- cancel button --}}
            </div>
          </div> {{-- form-group row --}}

        </form>

      </div> {{-- col-sm-7 --}}
      <div class="col-sm-5">

        <h5 class="text-primary my-3"><b>Email Template Details</b></h5>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>Template ID</th>
                <td>{{ $selected_template->id }}</td>
              </tr>
              <tr>
                <th>Is Group Emailable</th>
                <td>
                  @if ($selected_template->is_groupable == 0)
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Is not group emailable
                    </span>
                  @else
                    <span class="badge badge-success py-2 px-2">
                      <i class="fas fa-check mr-2" aria-hidden="true"></i>Is group emailable
                    </span>
                  @endif
                </td>
              </tr>
              <tr>
                <th>Is Editable</th>
                <td>
                  @if ($selected_template->is_editable == 0)
                    <span class="badge badge-danger py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Is not editable
                    </span>
                  @else
                    <span class="badge badge-success py-2 px-2">
                      <i class="fas fa-check mr-2" aria-hidden="true"></i>Is editable
                    </span>
                  @endif  
                </td>
              </tr>
              <tr>
                <th>Is Delible</th>
                <td>
                  @if ($selected_template->is_delible == 0)
                    <span class="badge badge-danger py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Is not delible
                    </span>
                  @else
                    <span class="badge badge-success py-2 px-2">
                      <i class="fas fa-check mr-2" aria-hidden="true"></i>Is delible
                    </span>
                  @endif   
                </td>
              </tr>
            </tbody>
          </table>
          </div> {{-- table-responsive --}}

      </div> {{-- col-sm-5 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection