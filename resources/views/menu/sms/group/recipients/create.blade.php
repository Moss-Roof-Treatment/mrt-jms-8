@extends('layouts.app')

@section('title', '- SMS - Group SMS - Create New SMS')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">GROUP SMS</h3>
    <h5>Create New Group SMS</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('group-sms.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Group SMS Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <form action="{{ route('group-sms.store') }}" method="POST">
      @csrf

      <div class="row">
        <div class="col-sm-7">

          {{-- SMS CONTENT SECTION --}}

          <h5 class="text-primary my-3"><b>SMS Details</b></h5>
          <div class="card">
            <div class="card-body">

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
                <label for="sms_template" class="col-md-3 col-form-label text-md-right">Template</label>
                <div class="col-md-8">
                  <select name="sms_template" id="sms_template" class="custom-select @error('sms_template') is-invalid @enderror mb-2">
                    @if (old('sms_template'))
                      <option disabled>Please select a task type</option>
                      @foreach ($sms_templates as $sms_template)
                        <option value="{{ $sms_template->id }}" @if (old('sms_template') == $sms_template->id) selected @endif>{{ $sms_template->title }}</option>
                      @endforeach
                    @else
                      @if ($selected_sms_template == null)
                        <option selected disabled>Please select a task type</option>
                      @else
                        <option selected value="{{ $selected_sms_template->id }}">{{ $selected_sms_template->title }}</option>
                        <option disabled>Please select a task type</option>
                      @endif
                      @foreach ($sms_templates as $sms_template)
                        <option value="{{ $sms_template->id }}">{{ $sms_template->title }}</option>
                      @endforeach
                    @endif
                  </select>
                  @error('sms_template')
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
                        @foreach ($sms_groups as $sms_group)
                          <option value="{{ $sms_group->id }}" @if (old('sms_group') == $sms_group->id) selected @endif>{{ $sms_group->title }}</option>
                        @endforeach
                      @else
                        @if ($selected_sms_group == null)
                          <option selected disabled>Please select a recipient group</option>
                        @else
                          <option selected value="{{ $selected_sms_group->id }}">{{ $selected_sms_group->title }}</option>
                          <option disabled>Please select a recipient group</option>
                        @endif
                        @foreach ($sms_groups as $sms_group)
                          <option value="{{ $sms_group->id }}">{{ $sms_group->title }}</option>
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

          {{-- SMS CONTENT SECTION --}}

          {{-- RECIPIENTS SECTION --}}

          <h5 class="text-primary my-3"><b>Confirm Recipients</b></h5>
          <div class="table-responsive">
            <table class="table table-bordered table-fullwidth table-striped bg-white">
              <thead class="table-secondary">
                <tr>
                  <th>Name</th>
                  <th>Mobile Phone</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($selected_users as $selected_user)
                <tr>
                  <td>{{ $selected_user->getFullNameAttribute() }}</td>
                  <td>
                    @if ($selected_user->mobile_phone == null)
                      <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
                    @else
                      {{ $selected_user->mobile_phone }}
                    @endif
                  </td>
                  <td class="text-center">
                    <label class="checkbox">
                      <input type="checkbox" name="users[]" value="{{ $selected_user->id }}" {{ 'checked', old('selected_user') ? 'checked' : null }}>
                      <span class="ml-2">Select this user</span>
                    </label>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div> {{-- table-responsive --}}

          {{-- RECIPIENTS SECTION --}}

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
                      <a href="{{ route('group-sms.create') }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              {{-- cancel button --}}
              <a href="{{ route('group-sms.index') }}" class="btn btn-dark">
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