@extends('layouts.app')

@section('title', '- Emails - Create New Generic Email')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">EMAILS</h3>
    <h5>Create New Generic Email</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('generic-emails.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Generic Email Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <form action="{{ route('generic-emails.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="row">
        <div class="col-sm-7">

          <h5 class="text-primary my-3"><b>Create New Email</b></h5>

          <div class="form-group row">
            <label for="recipient_email" class="col-md-3 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
            <div class="col-md-8">
              <input type="email" class="form-control @error('recipient_email') is-invalid @enderror mb-2" name="recipient_email" id="recipient_email" value="{{ old('recipient_email') }}" placeholder="Please enter the recipient email">
              @error('recipient_email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-6 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="recipient_name" class="col-md-3 col-form-label text-md-right">Name</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('recipient_name') is-invalid @enderror mb-2" name="recipient_name" id="recipient_name" value="{{ old('recipient_name') }}" placeholder="Please enter the recipient name">
              @error('recipient_name')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="subject" class="col-md-3 col-form-label text-md-right">Subject</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('subject') is-invalid @enderror mb-2" name="subject" id="subject" value="{{ old('subject') }}" placeholder="Please enter the subject">
              @error('subject')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="message" class="col-md-3 col-form-label text-md-right">Message</label>
            <div class="col-md-8">
              <textarea class="form-control @error('message') is-invalid @enderror mb-2" type="text" name="message" rows="10" placeholder="Please enter the message" style="resize:none">{{ old('message') }}</textarea>
              @error('message')
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
                    <label class="custom-file-label" for="documents" id="file_name">Please select optional files to upload</label>
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
              <p id="manual_files_to_upload">There are no attachments that have been selected.</p>

            </div> {{-- card-body --}}
          </div> {{-- card --}}

          <h5 class="text-primary my-3"><b>Internal Comment (Optional)</b></h5>

          <div class="form-group row">
            <div class="col-md">
              <textarea class="form-control @error('comment') is-invalid @enderror mb-2" type="text" name="comment" rows="6" placeholder="Please enter an additional comment" style="resize:none">{{ old('comment') }}</textarea>
              @error('comment')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

        </div> {{-- col-sm-5 --}}
      </div> {{-- row --}}

      <div class="row">
        <div class="col-sm-7">

          <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-3">
              <button class="btn btn-primary" type="submit">
                <i class="fas fa-check mr-2" aria-hidden="true"></i>Create
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
                      <a href="{{ route('generic-emails.create') }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              {{-- cancel button --}}
              <a href="{{ route('generic-emails.index') }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
              {{-- cancel button --}}
            </div>
          </div> {{-- form-group row --}}

        </div> {{-- col-sm-7 --}}
      </div> {{-- row --}}

    </form>

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- Manual File Upload Functionality --}}
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
      document.getElementById("file_name").innerHTML = x.files.length + " files are selected";
      
      // Display the names and sizes of the files that are selected to be uploaded.
      document.getElementById("manual_files_to_upload").innerHTML = txt;
    }
  </script>
{{-- Manual File Upload Functionality --}}
@endpush