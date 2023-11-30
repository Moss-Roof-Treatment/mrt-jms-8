@extends('layouts.jquery')

@section('title', '- Messages - Create New Message')

@push('css')
{{-- bootstrap-select css --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css">
{{-- bootstrap-select css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">MESSAGES</h3>
    <h5>Create New Messages</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('messages.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Message Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}

    <form action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="row">
        <div class="col-sm-7">

          <h5 class="text-primary my-3"><b>Create New Message</b></h5>
          <div class="form-group row">
            <label for="recipients" class="col-md-2 col-form-label text-md-right">Recipients</label>
            <div class="col-md-9">
              <select name="recipients[]" class="form-control border selectpicker @error('recipients') is-invalid @enderror mb-2" multiple="multiple" data-style="bg-white" data-live-search="true" data-size="5" data-container="#for-bootstrap-select" title="Please select the recipients">
                @if (old('recipients'))
                  @foreach ($staff_members as $staff_member)
                    <option value="{{ $staff_member->id }}" class="form-control" @if (in_array($staff_member->id, old('recipients'))) selected @endif>{{ $staff_member->getFullNameAttribute() . ' - ' . $staff_member->account_role->title }}</option>
                  @endforeach
                @else
                  @foreach ($staff_members as $staff_member)
                    <option value="{{ $staff_member->id }}" class="form-control">{{ $staff_member->getFullNameAttribute() . ' - ' . $staff_member->account_role->title }}</option>
                  @endforeach
                @endif
              </select>
              @error('recipients')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="priority_id" class="col-md-2 col-form-label text-md-right">Priority</label>
            <div class="col-md-9">
              <select name="priority_id" id="priority_id" class="custom-select @error('priority_id') is-invalid @enderror mb-2">
                <option selected disabled>Please select a priority</option>
                @foreach ($priorities as $priority)
                  <option value="{{ $priority->id }}" @if (old('priority_id') == $priority->id) selected @endif>{{ $priority->title }}</option>
                @endforeach
              </select>
              @error('priority_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="text" class="col-md-2 col-form-label text-md-right">Message</label>
            <div class="col-md-9">
              <textarea class="form-control @error('text') is-invalid @enderror mb-2" type="text" name="text" rows="10" placeholder="Please enter the text" style="resize:none">{{ old('text') }}</textarea>
              @error('text')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

        </div> {{-- col-sm-7 --}}
        <div class="col-sm-5">

          <h5 class="text-primary my-3"><b>Attachments (Optional)</b></h5>
          <div class="card">
            <div class="card-body">

              <div class="form-group row">
                <div class="col-md">
                  <div class="custom-file">
                    <label class="custom-file-label" for="documents" id="document_name">Please select optional files to upload</label>
                    <input type="file" class="custom-file-input" name="documents[]" multiple onChange="manualUpload();" id="manual_upload" aria-describedby="documents">
                  </div> {{-- custom-file --}}
                  @error('documents')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> {{-- col-md-9 --}}
              </div> {{-- form-group row --}}

              <p class="text-center">(Maximum file size 2Mb)</p>

              <p><b>Selected Attachments</b></p>
              <p id="manual_document_to_upload">There are no attachments that have been selected.</p>

            </div> {{-- card-body --}}
          </div> {{-- card --}}

        </div> {{-- col-sm-5 --}}
      </div> {{-- row --}}

      <div class="row">
        <div class="col-sm-7">

          <div class="form-group row">
            <div class="col-md-9 offset-md-2">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-check mr-2" aria-hidden="true"></i>Create
              </button>
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
                      <a href="{{ route('messages.create') }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              <a href="{{ route('messages.index') }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

        </div> {{-- col-sm-7 --}}
      </div> {{-- row --}}

    </form>

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- bootstrap-select js --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/js/bootstrap-select.min.js"></script>
{{-- bootstrap-select js --}}

{{-- Manual Image Upload Functionality --}}
<script>
  function manualUpload(){
    var x = document.getElementById("manual_upload");
    var txt = "";
    if ('files' in x) {
      if (x.files.length == 0) {
        txt = "Select one or more files.";
      } else {
        for (var i = 0; i < x.files.length; i++) {
          txt += "<strong>" + (i+1) + ". </strong>";
          var file = x.files[i];
          if ('name' in file) {
            txt += "<b>Name:</b> " + file.name;
          }
          if ('size' in file) {
            txt += " - <b>Size:</b> " + file.size + " bytes<br>";
          }
        }
      }
    } 
    else {
      if (x.value == "") {
        txt += "Select one or more files.";
      } else {
        txt += "The files property is not supported by your browser!";
        txt  += "<br>The path of the selected file: " + x.value; // If the browser does not support the files property, it will return the path of the selected file instead. 
      }
    }

    // Display the amount of files that are selected to be uploaded in the upload input.
    document.getElementById("document_name").innerHTML = x.files.length + " files are selected";

    // Display the names and sizes of the files that are selected to be uploaded.
    document.getElementById("manual_document_to_upload").innerHTML = txt;
  }
</script>
{{-- Manual Image Upload Functionality --}}
@endpush