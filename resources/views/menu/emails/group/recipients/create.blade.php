@extends('layouts.app')

@section('title', '- Group Emails - Create New Emails')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">GROUP EMAILS</h3>
    <h5>Create New Group Emails</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('group-emails.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Group Emails Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <form action="{{ route('group-emails.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="row">
        <div class="col-sm-7">

          {{-- EMAIL CONTENT SECTION --}}

          <h5 class="text-primary my-3"><b>Email Details</b></h5>
          <div class="card">
            <div class="card-body">

              <div class="form-group row">
                <label for="subject" class="col-md-3 col-form-label text-md-right">Subject</label>
                <div class="col-md-8">
                  <input type="text" class="form-control @error('subject') is-invalid @enderror mb-2" name="subject" id="subject" value="{{ old('subject', $subject) }}" placeholder="Please enter the subject" required>
                  @error('subject')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> {{-- col-md-8 --}}
              </div> {{-- form-group row --}}

              <div class="form-group row">
                <label for="text" class="col-md-3 col-form-label text-md-right">Message</label>
                <div class="col-md-8">
                  <textarea class="form-control @error('text') is-invalid @enderror mb-2" type="text" name="text" rows="5" placeholder="Please enter the text" style="resize:none">{{ old('text', $text) }}</textarea>
                  @error('text')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> {{-- col-md-8 --}}
              </div> {{-- form-group row --}}

              <div class="form-group row">
                <label for="email_template" class="col-md-3 col-form-label text-md-right">Template</label>
                <div class="col-md-8">
                  <select name="email_template" id="email_template" class="custom-select @error('email_template') is-invalid @enderror mb-2">
                    @if (old('email_template'))
                      <option disabled>Please select a task type</option>
                      @foreach ($email_templates as $email_template)
                        <option value="{{ $email_template->id }}" @if (old('email_template') == $email_template->id) selected @endif>{{ $email_template->title }}</option>
                      @endforeach
                    @else
                      @if ($selected_email_template == null)
                        <option selected disabled>Please select a task type</option>
                      @else
                        <option selected value="{{ $selected_email_template->id }}">{{ $selected_email_template->title }}</option>
                        <option disabled>Please select a task type</option>
                      @endif
                      @foreach ($email_templates as $email_template)
                        <option value="{{ $email_template->id }}">{{ $email_template->title }}</option>
                      @endforeach
                    @endif
                  </select>
                  @error('email_template')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> {{-- col-md-9 --}}
              </div> {{-- form-group row --}}

              <div class="form-group row">
                <label for="recipient_group" class="col-md-3 col-form-label text-md-right">Recipient Group</label>
                <div class="col-md-8">
                  <div class="input-group">
                    <select name="recipient_group" id="recipient_group" class="custom-select @error('recipient_group') is-invalid @enderror">
                      @if (old('recipient_group'))
                        <option disabled>Please select a recipient group</option>
                        @foreach ($email_groups as $email_group)
                          <option value="{{ $email_group->id }}" @if (old('email_group') == $email_group->id) selected @endif>{{ $email_group->title }}</option>
                        @endforeach
                      @else
                        @if ($selected_email_group == null)
                          <option selected disabled>Please select a recipient group</option>
                        @else
                          <option selected value="{{ $selected_email_group->id }}">{{ $selected_email_group->title }}</option>
                          <option disabled>Please select a recipient group</option>
                        @endif
                        @foreach ($email_groups as $email_group)
                          <option value="{{ $email_group->id }}">{{ $email_group->title }}</option>
                        @endforeach
                      @endif
                    </select>
                    <div class="input-group-append">
                      <button type="submit" name="action" value="search" class="btn btn-primary">
                        <i class="fas fa-redo-alt mr-2" aria-hidden="true"></i>Update
                      </button>
                    </div>
                  </div>
                  @error('recipient_group')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> {{-- col-md-9 --}}
              </div> {{-- form-group row --}}

            </div> {{-- card-body --}}
          </div> {{-- card --}}

          {{-- EMAIL CONTENT SECTION --}}

          {{-- RECIPIENTS SECTION --}}

          <h5 class="text-primary my-3"><b>Confirm Recipients</b></h5>
          <div class="table-responsive">
            <table class="table table-bordered table-fullwidth table-striped bg-white">
              <thead class="table-secondary">
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($selected_users as $selected_user)
                <tr>
                  <td>{{ $selected_user->getFullNameAttribute() }}</td>
                  <td>{{ $selected_user->email }}</td>
                  <td class="text-center">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck{{ $selected_user->id }}" name="users[]" value="{{ $selected_user->id }}"" {{ 'checked', old('selected_user') ? 'checked' : null }}>
                      <label class="custom-control-label" for="customCheck{{ $selected_user->id }}">Select this user</label>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div> {{-- table-responsive --}}

          {{-- RECIPIENTS SECTION --}}

          {{-- ATTCHMENTS SECTION --}}

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

              <p><b>Selected Attachments</b></p>
              <p id="manual_files_to_upload">There are no attachments that have been selected.</p>

            </div> {{-- card-body --}}
          </div> {{-- card --}}

          {{-- ATTCHMENTS SECTION --}}

          <div class="form-group row mt-3">
            <div class="col">
              {{-- create button --}}
              <button type="submit" name="action" value="create" class="btn btn-primary" id="submitButton">
                <i class="fas fa-check mr-2" aria-hidden="true"></i>Create
              </button>
              {{-- create button --}}
              {{-- reset modal --}}
              {{-- modal button --}}
              <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
              </button>
              {{-- modal button --}}
              {{-- modal --}}
              <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalCenterTitle">Reset</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="text-center">Are you sure that you would like to reset this form?</p>
                      <a href="{{ route('group-emails.create') }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              {{-- cancel button --}}
              <a href="{{ route('group-emails.index') }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
              {{-- cancel button --}}
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

        </div> {{-- col-sm-7 --}}
      </div> {{-- row --}}

    </form>

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- Manual Files Upload Functionality --}}
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
{{-- Manual Files Upload Functionality --}}
@endpush