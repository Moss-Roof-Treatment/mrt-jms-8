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

    <form action="{{ route('group-emails.store') }}" method="POST">
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
                  <input type="text" class="form-control @error('subject') is-invalid @enderror mb-2" name="subject" id="subject" value="{{ old('subject') }}" placeholder="Please enter the subject" autofocus>
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
                  <textarea class="form-control @error('text') is-invalid @enderror mb-2" type="text" name="text" rows="5" placeholder="Please enter the text" style="resize:none">{{ old('text') }}</textarea>
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
                    <option selected disabled>Please select a template</option>
                    @foreach ($templates as $template)
                      <option value="{{ $template->id }}" @if (old('email_template') == $template->id) selected @endif>{{ $template->title }}</option>
                    @endforeach
                  </select>
                  @error('email_template')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> {{-- col-md-8 --}}
              </div> {{-- form-group row --}}

              <div class="form-group row">
                <label for="recipient_group" class="col-md-3 col-form-label text-md-right">Recipient Group</label>
                <div class="col-md-8">
                  <select name="recipient_group" id="recipient_group" class="custom-select @error('recipient_group') is-invalid @enderror mb-2">
                    @if (old('recipient_group'))
                      <option disabled>Please select a recipient group</option>
                      @foreach ($user_groups as $user_group)
                        <option value="{{ $user_group->id }}" @if (old('recipient_group') == $user_group->id) selected @endif>{{ $user_group->title }}</option>
                      @endforeach
                    @else
                      <option selected disabled>Please select a recipient group</option>
                      @foreach ($user_groups as $user_group)
                        <option value="{{ $user_group->id }}">{{ $user_group->title }}</option>
                      @endforeach
                    @endif
                  </select>
                  @error('recipient_group')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> {{-- col-md-8 --}}
              </div> {{-- form-group row --}}

            </div> {{-- card-body --}}
          </div> {{-- card --}}

          <div class="form-group row mt-3">
            <div class="col">
              {{-- create button --}}
              <button type="submit" class="btn btn-primary" name="action" value="search">
                <i class="fas fa-arrow-right mr-2" aria-hidden="true"></i>Next
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

        </form>

        {{-- EMAIL CONTENT SECTION --}}

        {{-- RECIPIENTS SECTION --}}

        <h5 class="text-primary my-3"><b>Confirm Recipients</b></h5>
        <div class="card">
          <div class="card-body text-center">
            Please select a user group
          </div> {{-- card-body --}}
        </div> {{-- card --}}

        {{-- RECIPIENTS SECTION --}}

        {{-- ATTCHMENTS SECTION --}}

        <h5 class="text-primary my-3"><b>Attachments (Optional)</b></h5>
        <div class="card">
          <div class="card-body text-center">
            Please select a user group
          </div> {{-- card-body --}}
        </div> {{-- card --}}

        {{-- ATTCHMENTS SECTION --}}

      </div> {{-- col-sm-7 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection
