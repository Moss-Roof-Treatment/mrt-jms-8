@extends('layouts.jquery')

@section('title', '- Systems - Create New Job Flag')

@push('css')
{{-- bootstrap-select css --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css">
{{-- bootstrap-select css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">JOB FLAGS</h3>
    <h5>Create New Job Flag</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('jobs.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Jobs Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('jobs.show', $selected_job->id) }}">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Job
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <h5 class="text-primary my-3"><b>Create New Job Flag</b></h5>

    <div class="row">
      <div class="col-sm-7">

        <form action="{{ route('job-flags.store') }}" method="POST">
          @csrf

          <input type="hidden" name="selected_job_id" value="{{ $selected_job->id }}">

          <div class="form-group row">
            <label for="flag_id" class="col-md-3 col-form-label text-md-right">Flag</label>
            <div class="col-md-8">
              <select name="flag_id" id="flag_id" class="custom-select @error('flag_id') is-invalid @enderror mb-2">
                <option selected disabled>Please select a flag</option>
                @foreach ($all_users as $flag)
                  <option value="{{ $flag->id }}" @if (old('flag_id') == $flag->id) selected @endif>{{ $flag->getFullNameTitleAttribute() }}</option>
                @endforeach
              </select>
              @error('flag_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="quote_id" class="col-md-3 col-form-label text-md-right">Quote</label>
            <div class="col-md-8">
              <select name="quote_id" id="quote_id" class="custom-select @error('quote_id') is-invalid @enderror mb-2">
                <option selected disabled>Please select a quote</option>
                @foreach ($selected_job->quotes as $quote)
                  <option value="{{ $quote->id }}" @if (old('quote_id') == $quote->id) selected @endif>{{ $quote->quote_identifier }}</option>
                @endforeach
              </select>
              @error('quote_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="quote_rate_id" class="col-md-3 col-form-label text-md-right">Rate</label>
            <div class="col-md-8">
              <select name="quote_rate_id[]" class="form-control border selectpicker @error('quote_rate_id') is-invalid @enderror mb-2" multiple="multiple" data-style="bg-white" data-live-search="true" data-size="5" data-container="#for-bootstrap-select" title="Please select the rate">
                @if (old('quote_rate_id'))
                  @foreach ($all_quote_rates as $quote_rate)
                    <option value="{{ $quote_rate->id }}" class="form-control" @if (in_array($quote_rate->id, old('quote_rate_id'))) selected @endif>{{ $quote_rate->quote->quote_identifier . ' - ' . $quote_rate->rate->title }}</option>
                  @endforeach
                @else
                  @foreach ($all_quote_rates as $quote_rate)
                    <option value="{{ $quote_rate->id }}" class="form-control">{{ $quote_rate->quote->quote_identifier . ' - ' . $quote_rate->rate->title }}</option>
                  @endforeach
                @endif
              </select>
              @error('quote_rate_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <div class="col-md-8 offset-sm-3 mb-2">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="send_email_to_customer" name="send_email_to_customer" onclick="createButtonSwitcher()" {{ old('send_email_to_customer') ? 'checked' : null }}>

                <label class="custom-control-label" for="send_email_to_customer">Send Customer Email (Check to send email to customer)</label>
              </div>
            </div> {{-- col-md-8 offset-sm-3 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="optional_message" class="col-md-3 col-form-label text-md-right">Optional Note</label>
            <div class="col-md-8">
              <textarea class="form-control @error('optional_message') is-invalid @enderror mb-2" type="text" name="optional_message" rows="5" placeholder="Please enter an optional note for the selected tradesperson" style="resize:none">{{ old('optional_message') }}</textarea>
              @error('optional_message')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <div class="col-md-8 offset-md-3">
              {{-- button only div --}}
              <div id="buttonOnly">
                {{-- create button --}}
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-check mr-2" aria-hidden="true"></i>Create
                </button>
                {{-- create button --}}
                {{-- reset modal button --}}
                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#confirmResetModal">
                  <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                </button>
                {{-- reset modal button --}}
                {{-- cancel button --}}
                <a href="{{ route('jobs.show', $selected_job->id) }}" class="btn btn-dark">
                  <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
                </a>
                {{-- cancel button --}}
              </div> {{-- div --}}
              {{-- button only div --}}
              {{-- button and modal div --}}
              <div id="buttonAndModal" style="display:none;">
                {{-- create modal --}}
                {{-- modal button --}}
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmCreateModal">
                  <i class="fas fa-check mr-2" aria-hidden="true"></i>Create with Email
                </button>
                {{-- modal button --}}
                {{-- modal --}}
                <div class="modal fade" id="confirmCreateModal" tabindex="-1" role="dialog" aria-labelledby="confirmCreateModalTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="confirmCreateModalTitle">Confirm Email</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">

                        <p class="text-center">Please confirm the text for the tradesperson assigned email.</p>

                        <div class="form-group row">
                          <label for="subject" class="col-md-2 col-form-label text-md-right">Subject</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control @error('subject') is-invalid @enderror mb-2" name="subject" id="subject" value="{{ old('subject', $selected_email_template->subject) }}" placeholder="Please enter the subject">
                            @error('subject')
                              <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                          </div> {{-- col-md-9 --}}
                        </div> {{-- form-group row --}}

                        <div class="form-group row">
                          <label for="message" class="col-md-2 col-form-label text-md-right">Message</label>
                          <div class="col-md-9">
                            <textarea class="form-control @error('message') is-invalid @enderror mb-2" type="text" name="message" rows="10" placeholder="Please enter the message" style="resize:none">{{ old('message', $selected_email_template->text) }}</textarea>
                            @error('message')
                              <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                          </div> {{-- col-md-9 --}}
                        </div> {{-- form-group row --}}

                        <button type="submit" class="btn btn-dark btn-block">
                          <i class="fas fa-envelope mr-2" aria-hidden="true"></i>Send "Tradesperson Assigned" Email
                        </button>

                      </div> {{-- modal-body --}}
                    </div> {{-- modal-content --}}
                  </div> {{-- modal-dialog --}}
                </div> {{-- modal fade --}}
                {{-- modal --}}
                {{-- create modal --}}
                {{-- reset modal button --}}
                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#confirmResetModal">
                  <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                </button>
                {{-- reset modal button --}}
                {{-- cancel button --}}
                <a href="{{ route('jobs.show', $selected_job->id) }}" class="btn btn-dark">
                  <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
                </a>
                {{-- cancel button --}}
              </div> {{-- div --}}
              {{-- button and modal div --}}
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

        </form>

        {{-- confirm reset modal --}}
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
                <form action="{{ route('job-flags.create') }}" method="GET">
                  <input type="hidden" name="job_id" value="{{ $selected_job->id }}">
                  <button class="btn btn-dark btn-block">
                    <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                  </button>
                </form>
              </div> {{-- modal-body --}}
            </div> {{-- modal-content --}}
          </div> {{-- modal-dialog --}}
        </div> {{-- modal fade --}}
        {{-- confirm reset modal --}}

      </div> {{-- col-sm-7 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- Note toggle box --}}
<script type="text/javascript">
  function createButtonSwitcher() {
    var buttonOnly = document.getElementById("buttonOnly"); 
    var buttonAndModal = document.getElementById("buttonAndModal");

    buttonOnly.style.display = (
        buttonOnly.style.display == "none" ? "block" : "none"); 
    buttonAndModal.style.display = (
        buttonAndModal.style.display == "none" ? "block" : "none"); 
  }
</script>
{{-- Note toggle box --}}

{{-- bootstrap-select js --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/js/bootstrap-select.min.js"></script>
{{-- bootstrap-select js --}}
@endpush