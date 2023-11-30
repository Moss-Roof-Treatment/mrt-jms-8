@extends('layouts.jquery')

@section('title', 'Jobs - View Selected Job')

@push('css')
{{-- Datepicker CSS --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-PMjWzHVtwxdq7m7GIxBot5vdxUY+5aKP9wpKtvnNBZrVv1srI8tU6xvFMzG8crLNcMj/8Xl/WWmo/oAP/40p1g==" crossorigin="anonymous" />
{{-- Datepicker CSS --}}
@endpush

@section('content')
<section>
  <div class="container-fluid py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">JOBS</h3>
    <h5>View Selected Job</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-6 pt-3">
      <div class="col mb-3">
        <a href="{{ route('jobs.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Job Menu
        </a>
      </div> {{-- col mb-3 --}}
      @if ($selected_job->quote_request)
        <div class="col pb-3">
          <a href="{{ route('quote-requests.show', $selected_job->quote_request->id) }}" class="btn btn-primary btn-block">
            <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Quote Request
          </a>
        </div> {{-- col pb-3 --}}
      @endif
      <div class="col mb-3">
        <a href="{{ route('customers.show', $selected_job->customer_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Customer
        </a>
      </div> {{-- col mb-3 --}}
      <div class="col mb-3">
        <a href="{{ route('jobs.edit', $selected_job->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit Job
        </a>
      </div> {{-- col mb-3 --}}
      <div class="col mb-3">
        {{-- Email Modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#emailModal">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Change Start Date
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="emailModalTitle">Confirm Start Date Change</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Please click the corresponding check box and then confirm the text for the optional email and SMS to send them to the customer.</p>

                <form action="{{ route('job-send-update-email.update', $selected_job->id) }}" method="POST">
                  @method('PATCH')
                  @csrf

                  <div class="form-group row">
                    <label for="title" class="col-md-3 col-form-label text-md-right">Start Date</label>
                    <div class="col-md-8">
                      <div class="input-group date" id="start" data-target-input="nearest">
                        <input type="text" name="start_date" class="form-control datetimepicker-input @error('start') is-invalid @enderror" data-target="#start" @if (old('start'))value="{{ date('m/d/Y', strtotime(old('start'))) }}"@endif placeholder="Please enter a start date and time"/>
                        <div class="input-group-append" data-target="#start" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                        </div>
                        @error('start')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div> {{-- col-md-8 --}}
                  </div> {{-- form-group row --}}

                  <div class="form-group row">
                    <label for="message" class="col-md-3 col-form-label text-md-right"></label>
                    <div class="col-md-8">
                      <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="emailCheck" name="email_check">
                        <label class="form-check-label" for="emailCheck">Send Email to Customer</label>
                      </div>
                    </div> {{-- col-md-9 --}}
                  </div> {{-- form-group row --}}

                  <div class="form-group row">
                    <label for="email_message" class="col-md-3 col-form-label text-md-right">Email</label>
                    <div class="col-md-8">
                      <textarea class="form-control @error('email_message') is-invalid @enderror mb-2" type="text" name="email_message" rows="6" placeholder="Please enter the email_message" style="resize:none">{{ old('email_message', $selected_email_template->text) }}</textarea>
                      @error('email_message')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div> {{-- col-md-9 --}}
                  </div> {{-- form-group row --}}

                  <div class="form-group row">
                    <label for="message" class="col-md-3 col-form-label text-md-right"></label>
                    <div class="col-md-8">
                      <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="smsCheck" name="sms_check">
                        <label class="form-check-label" for="smsCheck">Send SMS to Customer</label>
                      </div>
                    </div> {{-- col-md-9 --}}
                  </div> {{-- form-group row --}}

                  <div class="form-group row">
                    <label for="sms_message" class="col-md-3 col-form-label text-md-right">SMS</label>
                    <div class="col-md-8">
                      <textarea class="form-control @error('sms_message') is-invalid @enderror mb-2" type="text" name="sms_message" rows="6" placeholder="Please enter the sms_message" style="resize:none">{{ old('sms_message', $selected_sms_template->text) }}</textarea>
                      @error('sms_message')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div> {{-- col-md-9 --}}
                  </div> {{-- form-group row --}}

                  <button type="submit" class="btn btn-dark btn-block">
                    <i class="fas fa-check mr-2"></i>Submit
                  </button>
                </form>

              </div> {{-- modal-body --}}
            </div> {{-- modal-content --}}
          </div> {{-- modal-dialog --}}
        </div> {{-- modal fade --}}
        {{-- modal --}}
        {{-- Email Modal --}}
      </div> {{-- col mb-3 --}}
      <div class="col mb-3">
        {{-- delete modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#confirm-delete-job">
          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete Job
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="confirm-delete-job" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-job-title" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="confirm-delete-job-title">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center">Are you sure that you would like to delete this job?</p>
                <form action="{{ route('jobs.destroy', $selected_job->id) }}" method="POST">
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
        {{-- delete modal --}}
      </div> {{-- col mb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

    {{-- status dropdown --}}
    <div class="row row-cols-1 row-cols-sm-6 pt-3">
      <div class="col">
        <p class="text-primary text-center"><b>Quote Sent</b></p>
        <form action="{{ route('update-quote-sent-status.update', $selected_job->id) }}" method="POST">
          @method('PATCH')
          @csrf
          <div class="input-group mb-3">
            <select name="quote_sent_id" class="custom-select @error('quote_sent_id') is-invalid @enderror">
              @if ($selected_job->quote_sent_status_id != null)
                <option value="{{ $selected_job->quote_sent_status_id }}">{{ $selected_job->quote_sent_status->title }}</option>
              @endif
              <option disabled>Please select a quote sent status</option>
              @foreach ($quote_sent_statuses as $quote_sent_status)
                <option @if ($quote_sent_status->id == $selected_job->quote_sent_status_id) hidden @endif value="{{ $quote_sent_status->id }}">{{ $quote_sent_status->title }}</option>
              @endforeach
            </select>
            <div class="input-group-append">
              <button class="btn btn-dark" type="submit" id="quote_sent_id_button"><i class="fas fa-save"></i></button>
            </div> {{-- form-control --}}
          </div> {{-- input-group mb-3 --}}
        </form>
      </div> {{-- col --}}
      <div class="col">
        <p class="text-primary text-center"><b>Follow up call</b></p>
        <form action="{{ route('update-follow-up-call-status.update', $selected_job->id) }}" method="POST">
          @method('PATCH')
          @csrf
          <div class="input-group mb-3">
            <select name="follow_up_call_id" class="custom-select @error('follow_up_call_id') is-invalid @enderror">
              @if ($selected_job->follow_up_call_status_id != null)
                <option value="{{ $selected_job->follow_up_call_status_id }}" style="background-color:{{ $selected_job->follow_up_call_status->colour->colour }}; color:{{ $selected_job->follow_up_call_status->colour->text_colour }};">{{ $selected_job->follow_up_call_status->title }}</option>
              @endif
              <option disabled>Please select a follow up call status</option>
              @foreach ($all_follow_up_call_statuses as $follow_up_call)
                <option @if ($follow_up_call->id == $selected_job->follow_up_call_status_id) hidden @endif value="{{ $follow_up_call->id }}" style="background-color:{{ $follow_up_call->colour->colour }}; color:{{ $follow_up_call->colour->text_colour }};">{{ $follow_up_call->title }}</option>
              @endforeach
            </select>
            <div class="input-group-append">
              <button class="btn btn-dark" type="submit" id="follow_up_call_id_button"><i class="fas fa-save"></i></button>
            </div> {{-- form-control --}}
          </div> {{-- input-group mb-3 --}}
        </form>
      </div> {{-- col --}}
      <div class="col">
        <p class="text-primary text-center"><b>Job Progress</b></p>
        <form action="{{ route('update-job-progress.update', $selected_job->id) }}" method="POST">
          @method('PATCH')
          @csrf
          <div class="input-group mb-3">
            <select name="progress_id" class="custom-select @error('progress_id') is-invalid @enderror">
              @if (!$selected_job->job_progress_id == null)
                <option value="{{ $selected_job->job_progress_id }}">{{ $selected_job->job_progress->title }}</option>
              @endif
              <option disabled>Please select a job progress</option>
              @foreach ($job_progresses as $job_progress)
                <option @if ($job_progress->id == $selected_job->job_progress_id) hidden @endif value="{{ $job_progress->id }}">{{ $job_progress->title }}</option>
              @endforeach
            </select>
            <div class="input-group-append">
              <button class="btn btn-dark" type="submit" id="progress_id_button"><i class="fas fa-save"></i></button>
            </div> {{-- form-control --}}
          </div> {{-- input-group mb-3 --}}
        </form>
      </div> {{-- col --}}
      <div class="col">
        <p class="text-primary text-center"><b>Job Status</b></p>
        <form action="{{ route('update-job-status.update', $selected_job->id) }}" method="POST">
          @method('PATCH')
          @csrf
          <div class="input-group mb-3">
            <select name="job_status_id" class="custom-select @error('job_status_id') is-invalid @enderror">
              @if ($selected_job->job_status_id != null)
                <option value="{{ $selected_job->job_status_id }}">{{ $selected_job->job_status->title }}</option>
              @endif
              <option disabled>Please select a job status</option>
              @foreach ($all_job_statuses as $job_status)
                <option @if ($job_status->id == $selected_job->job_status_id) hidden @endif value="{{ $job_status->id }}">{{ $job_status->title }}</option>
              @endforeach
            </select>
            <div class="input-group-append">
              <button class="btn btn-dark" type="submit" id="job_status_id_button"><i class="fas fa-save"></i></button>
            </div> {{-- form-control --}}
          </div> {{-- input-group mb-3 --}}
        </form>
      </div> {{-- col --}}
      <div class="col">
        <p class="text-primary text-center"><b>Send SMS</b></p>
        <form action="{{ route('send-selected-sms.store') }}" method="POST">
          @csrf
          <input type="hidden" name="selected_customer_id" value="{{ $selected_job->customer_id }}">
          <input type="hidden" name="selected_job_id" value="{{ $selected_job->id }}">
          <div class="input-group mb-3">
            <select name="sms_to_send" class="custom-select @error('sms_to_send') is-invalid @enderror">
              <option selected disabled>Please select an SMS to send</option>
              @foreach ($all_sms_templates as $sms_template)
                <option value="{{ $sms_template->id }}">{{ $sms_template->title }}</option>
              @endforeach
            </select>
            <div class="input-group-append">
              <button class="btn btn-dark" type="submit" id="sms_to_send_button"><i class="fas fa-mobile-alt"></i></button>
            </div> {{-- form-control --}}
          </div> {{-- input-group mb-3 --}}
          @error('sms_to_send')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </form>
      </div> {{-- col --}}
    </div> {{-- row row-cols-1 row-cols-sm-5 pt-3 --}}
    {{-- status dropdown --}}

    {{-- job content --}}
    <div class="row">
      <div class="col-sm-9">

        <h4 class="text-primary mt-3">OVERVIEW</h4>

        {{-- detail tables --}}
        <div class="row">
          <div class="col-sm-6">

            {{-- business details table --}}
            @if ($selected_job->customer->business_name != null || $selected_job->customer->business_phone != null)
              <h5 class="text-primary py-3"><b>Business Details</b></h5>
              <div class="table-responsive">
                <table class="table table-bordered table-fullwidth table-striped bg-white">
                  <tbody>
                    <tr>
                      <th>Business Name</th>
                      <td>
                        @if ($selected_job->customer->business_name == null)
                          <span class="badge badge-light py-2 px-2">
                            <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                          </span>
                        @else
                          {{ $selected_job->customer->business_name }}
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <th>Business Phone</th>
                      <td>
                        @if ($selected_job->customer->business_phone == null)
                          <span class="badge badge-light py-2 px-2">
                            <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                          </span>
                        @else
                          {{ $selected_job->customer->business_phone }}
                        @endif
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div> {{-- table-responsive --}}
            @endif
            {{-- business details table --}}

            {{-- customer details table --}}
            <h5 class="text-primary py-3"><b>Customer Details</b></h5>
            <div class="table-responsive">
              <table class="table table-bordered table-fullwidth table-striped bg-white">
                <tbody>
                  <tr>
                    <th>Customer ID</th>
                    <td>{{ $selected_job->customer_id }}</td>
                  </tr>
                  <tr>
                    <th>Name</th>
                    <td>{{ $selected_job->customer->getFullNameAttribute() }}</td>
                  </tr>
                  <tr>
                    <th>Email</th>
                    <td>
                    @if ($selected_job->customer->email == null)
                      <span class="badge badge-warning py-2 px-2">
                        <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>This customer has no email
                      </span>
                    @else
                      {{ $selected_job->customer->email }}
                    @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Street Address</th>
                    <td>{{ $selected_job->customer->street_address }}</td>
                  </tr>
                  <tr>
                    <th>Suburb and Postcode</th>
                    <td>{{ $selected_job->customer->suburb }} - {{ $selected_job->customer->postcode }}</td>
                  </tr>
                  <tr>
                    <th>Customer Phone</th>
                    <td>
                      @if ($selected_job->customer->home_phone == null)
                        <span class="badge badge-light py-2 px-2">
                          <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                        </span>
                      @else
                        {{ $selected_job->customer->home_phone }}
                      @endif  
                    </td>
                  </tr>
                  <tr>
                    <th>Customer Mobile</th>
                    <td>
                      @if ($selected_job->customer->mobile_phone == null)
                        <span class="badge badge-light py-2 px-2">
                          <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                        </span>
                      @else
                        {{ $selected_job->customer->mobile_phone }}
                      @endif                      
                    </td>
                  </tr>
                  <tr>
                    <th>Referral</th>
                    <td>{{ $selected_job->customer->referral->title }}</td>
                  </tr>
                  <tr>
                    <th>Last Login</th>
                    <td>
                      @if ($selected_job->customer->email == null && $selected_job->quote_sent_status_id == 2 || $selected_job->quote_sent_status_id == 2)
                        <i class="fas fa-circle text-info mr-2" aria-hidden="true"></i>Posted
                      @else
                        {!! $selected_job->customer->getLastLoginDateTime() !!}
                      @endif
                    </td>
                  </tr>
                </tbody>
              </table>
            </div> {{-- table-responsive --}}
            {{-- customer details table --}}

          </div> {{-- col-sm-6 --}}
          <div class="col-sm-6">

            {{-- job details table --}}
            <h5 class="text-primary py-3"><b>Job Details</b></h5>
            <div class="table-responsive">
              <table class="table table-bordered table-fullwidth table-striped bg-white">
                <tbody>
                  <tr>
                    <th>Job Number</th>
                    <td>{{ $selected_job->id }}</td>
                  </tr>
                  <tr>
                    <th>Sales Person</th>
                    <td>{{ $selected_job->salesperson->getFullNameAttribute() }}</td>
                  </tr>
                  <tr>
                    <th>Label</th>
                    <td>
                      @if ($selected_job->label == null)
                        <span class="badge badge-light py-2 px-2">
                          <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                        </span>
                      @else
                        {{ $selected_job->label }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Tenant</th>
                    <td>{{ $selected_job->tenant_name }}</td>
                  </tr>
                  <tr>
                    <th>Tenant Home Phone</th>
                    <td>
                      @if ($selected_job->tenant_home_phone == null)
                        <span class="badge badge-light py-2 px-2">
                          <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                        </span>
                      @else
                        {{ $selected_job->tenant_home_phone }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Tenant Mobile Phone</th>
                    <td>
                      @if ($selected_job->tenant_mobile_phone == null)
                        <span class="badge badge-light py-2 px-2">
                          <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                        </span>
                      @else
                        {{ $selected_job->tenant_mobile_phone }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Address</th>
                    <td>{{ $selected_job->tenant_street_address }}</td>
                  </tr>
                  <tr>
                    <th>Suburb and Postcode</th>
                    <td>{{ $selected_job->tenant_suburb }} - {{ $selected_job->tenant_postcode }}</td>
                  </tr>
                  <tr>
                    <th>Roof Surface</th>
                    <td>
                      @if ($selected_job->material_type_id == null)
                        <span class="badge badge-warning py-2 px-2">
                          <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>To Be Confirmed
                        </span>
                      @else
                        {{ $selected_job->material_type->title }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Building Type</th>
                    <td>
                      @if ($selected_job->building_type_id == null)
                        <span class="badge badge-warning py-2 px-2">
                          <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>To Be Confirmed
                        </span>
                      @else
                        {{ $selected_job->building_type->title }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Building Style</th>
                    <td>
                      @if ($selected_job->building_style_id == null)
                        <span class="badge badge-warning py-2 px-2">
                          <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>To Be Confirmed
                        </span>
                      @else
                        {{ $selected_job->building_style->title }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Arrival Date</th>
                    <td>{{ date('d/m/y - h:iA', strtotime($selected_job->created_at)) }}</td>
                  </tr>
                  <tr>
                    <th>Inspection Type</th>
                    <td>{{ $selected_job->inspection_type->title }}</td>
                  </tr>
                  <tr>
                    <th>Inspection Date</th>
                    <td>
                      @if ($selected_job->inspection_date == null)
                        <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
                      @else
                        {{ date('d/m/y - h:iA', strtotime($selected_job->inspection_date)) }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Sold Date</th>
                    <td>
                      @if ($selected_job->sold_date == null)
                        <span class="badge badge-warning py-2 px-2">
                          <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>To Be Confirmed
                        </span>
                      @else
                        {{ date('d/m/y - h:iA', strtotime($selected_job->sold_date)) }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Start Date</th>
                    <td>
                      @if ($selected_job->start_date == null)
                        <span class="badge badge-warning py-2 px-2">
                          <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>To Be Confirmed
                        </span>
                      @else
                        {{ date('d/m/y - h:iA', strtotime($selected_job->start_date)) }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Completion Date</th>
                    <td>
                      @if ($selected_job->completion_date == null)
                        <span class="badge badge-warning py-2 px-2">
                          <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>To Be Confirmed
                        </span>
                      @else
                        {{ date('d/m/y - h:iA', strtotime($selected_job->completion_date)) }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Job Type</th>
                    <td>
                      @if (!$selected_job->job_types->count())  
                        <span class="badge badge-warning py-2 px-2">
                          <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>To Be Confirmed
                        </span>
                      @else
                        @if ($selected_job->has('job_types'))
                          @foreach ($selected_job->job_types as $job_type)
                            <span class="badge badge-dark py-2 px-2">
                              <i class="fas fa-tools mr-2" aria-hidden="true"></i>{{ $job_type->title }}
                            </span>
                          @endforeach
                        @endif
                      @endif
                    </td>
                  </tr>
                </tbody>
              </table>
            </div> {{-- table-responsive --}}
            {{-- job details table --}}

          </div> {{-- col-sm-6 --}}
        </div> {{-- row --}}
        {{-- detail tables --}}

        {{-- notes --}}
        <h4 class="text-primary my-3">NOTES</h4>
        <div class="row">
          <div class="col-sm-6">

            {{-- Public Notes --}}

            <h5 class="text-primary my-3"><input type="checkbox" onclick="noteExpander()"> <b>Customer Notes</b></h5>

            <div class="row">
              <div class="col-sm-6 mb-3">
                <form action="{{ route('job-notes.create') }}" method="GET">
                  <input type="hidden" name="job_id" value="{{ $selected_job->id }}">
                  <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-plus mr-2" aria-hidden="true"></i>New Customer Note
                  </button>
                </form>
              </div> {{-- col-sm-6 mb-3 --}}
            </div> {{-- row --}}

            @if (!$all_public_notes->count())
              <div class="card my-3">
                <div class="card-body text-center">
                  <h5>There are no customer notes to display</h5>
                </div> {{-- card-body --}}
              </div> {{-- card --}}
            @else
              {{-- Public Notes Collapsed --}}
              <div id="noteCollapsed">

                <div class="table-responsive">
                  <table class="table table-bordered table-fullwidth table-striped bg-white">
                    <tbody>
                      @foreach ($all_public_notes->take(5) as $public_note)
                        @if ($public_note->sender_id == null)
                          <tr>
                        @elseif ($public_note->sender->account_role_id == 2)
                          <tr class="table-secondary">
                        @elseif ($public_note->sender->account_role_id == 3)
                          <tr class="table-success">
                        @elseif ($public_note->sender->account_role_id == 4)
                          <tr class="table-success">
                        @elseif ($public_note->sender->account_role_id == 5)
                          <tr class="table-primary">
                        @else
                          <tr class="table-warning">
                        @endif
                          <td>{{ date('d/m/y', strtotime($public_note->created_at)) }}</td>
                          <td>
                            @if ($public_note->recipient_id != null && $public_note->recipient_seen_at == null)
                              <b>
                            @endif
                            {{ substr($public_note->text, 0, 150) }}{{ strlen($public_note->text) > 150 ? "..." : "" }}
                            @if ($public_note->recipient_id != null && $public_note->recipient_seen_at == null)
                              <b>
                            @endif
                          </td>
                          <td nowrap="nowrap">
                            <a href="{{ route('job-notes.show', $public_note->id) }}" class="btn btn-primary btn-sm">View</a>
                            @if ($public_note->sender_id != null)
                              <a href="{{ route('job-notes.show', $public_note->id) }}#note-response-form" class="btn btn-primary btn-sm">Reply</a>
                            @endif
                            {{-- delete modal --}}
                            {{-- modal button --}}
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#{{ 'delete-public-note-' . $public_note->id }}">
                              Delete
                            </button>
                            {{-- modal button --}}
                            {{-- modal --}}
                            <div class="modal fade" id="{{ 'delete-public-note-' . $public_note->id }}" tabindex="-1" role="dialog" aria-labelledby="{{ 'delete-public-note-' . $public_note->id }}Title" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="{{ 'delete-public-note-' . $public_note->id }}Title">Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <p class="text-center">Are you sure that you would like to delete this note?</p>
                                    <form method="POST" action="{{ route('job-notes.destroy', $public_note->id) }}">
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
                            {{-- delete modal --}}
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div> {{-- table-responsive --}}

              </div> {{-- box --}}
              {{-- Public Notes Collapsed --}}

              {{-- Public Notes Expanded --}}
              <div id="noteExpanded" style="display:none;">

                <div class="table-responsive">
                  <table class="table table-bordered table-fullwidth table-striped bg-white">
                    <tbody>
                      @foreach ($all_public_notes as $public_note)
                        @if ($public_note->sender_id == null)
                          <tr>
                        @elseif ($public_note->sender->account_role_id == 2)
                          <tr class="table-secondary">
                        @elseif ($public_note->sender->account_role_id == 3)
                          <tr class="table-success">
                        @elseif ($public_note->sender->account_role_id == 4)
                          <tr class="table-success">
                        @elseif ($public_note->sender->account_role_id == 5)
                          <tr class="table-primary">
                        @else
                          <tr class="table-warning">
                        @endif
                          <td>{{ date('d/m/y', strtotime($public_note->created_at)) }}</td>
                          <td>
                            @if ($public_note->recipient_id != null && $public_note->recipient_seen_at == null)
                              <b>
                            @endif
                            {{ substr($public_note->text, 0, 150) }}{{ strlen($public_note->text) > 150 ? "..." : "" }}
                            @if ($public_note->recipient_id != null && $public_note->recipient_seen_at == null)
                              <b>
                            @endif
                          </td>
                          <td nowrap="nowrap">
                            <a href="{{ route('job-notes.show', $public_note->id) }}" class="btn btn-primary btn-sm">View</a>
                            @if ($public_note->sender_id != null)
                              <a href="{{ route('job-notes.show', $public_note->id) }}#note-response-form" class="btn btn-primary btn-sm">Reply</a>
                            @endif
                            {{-- delete modal --}}
                            {{-- modal button --}}
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#{{ 'delete-public-note-' . $public_note->id }}">
                              Delete
                            </button>
                            {{-- modal button --}}
                            {{-- modal --}}
                            <div class="modal fade" id="{{ 'delete-public-note-' . $public_note->id }}" tabindex="-1" role="dialog" aria-labelledby="{{ 'delete-public-note-' . $public_note->id }}Title" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="{{ 'delete-public-note-' . $public_note->id }}Title">Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <p class="text-center">Are you sure that you would like to delete this note?</p>
                                    <form method="POST" action="{{ route('job-notes.destroy', $public_note->id) }}">
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
                            {{-- delete modal --}}
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div> {{-- table-responsive --}}

              </div> {{-- box --}}
              {{-- Public Notes Expanded --}}
            @endif

            {{-- Public Notes --}}

          </div> {{-- col-sm-6 --}}
          <div class="col-sm-6">

            {{-- Internal Notes --}}

            <h5 class="text-primary my-3"><input type="checkbox" onclick="internalNoteExpander()"> <b>Internal Notes</b></h5>

            <div class="row">
              <div class="col-sm-6 mb-3">
                <form action="{{ route('job-internal-notes.create') }}" method="GET">
                  <input type="hidden" name="job_id" value="{{ $selected_job->id }}">
                  <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-plus mr-2" aria-hidden="true"></i>New Internal Note
                  </button>
                </form>
              </div> {{-- col-sm-6 mb-3 --}}
            </div> {{-- row --}}

            @if (!$all_internal_notes->count())          
              <div class="card my-3">
                <div class="card-body text-center">
                  <h5>There are no internal notes to display</h5>
                </div> {{-- card-body --}}
              </div> {{-- card --}}
            @else
              {{-- Internal Notes Collapsed --}}
              <div id="internalNoteCollapsed">

                <div class="table-responsive">
                  <table class="table table-bordered table-fullwidth table-striped bg-white">
                    <tbody>
                      @foreach ($all_internal_notes->take(5) as $internal_note)
                        @if ($internal_note->sender_id == null)
                          <tr>
                        @elseif ($internal_note->sender->account_role_id == 2)
                          <tr class="table-secondary">
                        @elseif ($internal_note->sender->account_role_id == 3)
                          <tr class="table-success">
                        @elseif ($internal_note->sender->account_role_id == 4)
                          <tr class="table-success">
                        @elseif ($internal_note->sender->account_role_id == 5)
                          <tr class="table-primary">
                        @else
                          <tr class="table-warning">
                        @endif
                          <td>{{ date('d/m/y', strtotime($internal_note->created_at)) }}</td>
                          <td>
                            @if ($internal_note->recipient_id != null && $internal_note->recipient_seen_at == null)
                              <b>
                            @endif    
                            {!! nl2br($internal_note->text) !!}
                            @if ($internal_note->recipient_id != null && $internal_note->recipient_seen_at == null)
                              </b>
                            @endif
                          </td>
                          <td nowrap="nowrap">
                            <a href="{{ route('job-internal-notes.show', $internal_note->id) }}" class="btn btn-primary btn-sm">View</a>
                            @if ($internal_note->sender_id != null)
                              <a href="{{ route('job-internal-notes.show', $internal_note->id) }}#note-response-form" class="btn btn-primary btn-sm">Reply</a>
                            @endif
                            {{-- delete modal --}}
                            {{-- modal button --}}
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#{{ 'delete-internal-note-' . $internal_note->id }}">
                              Delete
                            </button>
                            {{-- modal button --}}
                            {{-- modal --}}
                            <div class="modal fade" id="{{ 'delete-internal-note-' . $internal_note->id }}" tabindex="-1" role="dialog" aria-labelledby="{{ 'delete-internal-note-' . $internal_note->id }}Title" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="{{ 'delete-internal-note-' . $internal_note->id }}Title">Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <p class="text-center">Are you sure that you would like to delete this note?</p>
                                    <form method="POST" action="{{ route('job-internal-notes.destroy', $internal_note->id) }}">
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
                            {{-- delete modal --}}
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div> {{-- table-responsive --}}

              </div> {{-- box --}}
              {{-- Internal Notes Collapsed --}}

              {{-- Internal Notes Expanded --}}
              <div id="internalNoteExpanded" style="display:none;">

                <div class="table-responsive">
                  <table class="table table-bordered table-fullwidth table-striped bg-white">
                    <tbody>
                      @foreach ($all_internal_notes as $internal_note)
                        @if ($internal_note->sender_id == null)
                          <tr>
                        @elseif ($internal_note->sender->account_role_id == 2)
                          <tr class="table-secondary">
                        @elseif ($internal_note->sender->account_role_id == 3)
                          <tr class="table-success">
                        @elseif ($internal_note->sender->account_role_id == 4)
                          <tr class="table-success">
                        @elseif ($internal_note->sender->account_role_id == 5)
                          <tr class="table-primary">
                        @else
                          <tr class="table-warning">
                        @endif
                          <td>{{ date('d/m/y', strtotime($internal_note->created_at)) }}</td>
                          <td>
                            @if ($internal_note->recipient_id != null && $internal_note->recipient_seen_at == null)
                              <b>
                            @endif
                            {!! nl2br($internal_note->text) !!}
                            @if ($internal_note->recipient_id != null && $internal_note->recipient_seen_at == null)
                              </b>
                            @endif
                          </td>
                          <td nowrap="nowrap">
                            <a href="{{ route('job-internal-notes.show', $internal_note->id) }}" class="btn btn-primary btn-sm">View</a>
                            @if ($internal_note->sender_id != null)
                              <a href="{{ route('job-internal-notes.show', $internal_note->id) }}#note-response-form" class="btn btn-primary btn-sm">Reply</a>
                            @endif
                            {{-- delete modal --}}
                            {{-- modal button --}}
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#{{ 'delete-internal-note-' . $internal_note->id }}">
                              Delete
                            </button>
                            {{-- modal button --}}
                            {{-- modal --}}
                            <div class="modal fade" id="{{ 'delete-internal-note-' . $internal_note->id }}" tabindex="-1" role="dialog" aria-labelledby="{{ 'delete-internal-note-' . $internal_note->id }}Title" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="{{ 'delete-internal-note-' . $internal_note->id }}Title">Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <p class="text-center">Are you sure that you would like to delete this note?</p>
                                    <form method="POST" action="{{ route('job-internal-notes.destroy', $internal_note->id) }}">
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
                            {{-- delete modal --}}
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div> {{-- table-responsive --}}

              </div> {{-- box --}}
              {{-- Internal Notes Expanded --}}
            @endif
            {{-- Internal Notes --}}

          </div> {{-- col-sm-6 --}}
        </div> {{-- row --}}
        {{-- notes --}}

        {{-- job flags table --}}
        <h5 class="text-primary my-3"><b>Job Flags</b></h5>
        <div class="row">
          <div class="col-sm-6">

            <div class="row">
              <div class="col-sm-6 mb-3">
                <form action="{{ route('job-flags.create') }}" method="GET">
                  <input type="hidden" name="selected_job_id" value="{{ $selected_job->id }}">
                  <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Job Flag
                  </button>
                </form>
              </div> {{-- col-sm-2 --}}
            </div> {{-- row --}}

            @if (!$selected_job->getAllQuoteUsers->count())
              <div class="card my-3">
                <div class="card-body text-center">
                  <h5>There are no job flags to display</h5>
                </div> {{-- card-body --}}
              </div> {{-- card --}}
            @else
              <div class="table-responsive">
                <table class="table table-bordered table-fullwidth table-striped">
                  <thead class="table-secondary">
                    <tr class="table-secondary">
                      <th>Date</th>
                      <th>Tradesperson</th>
                      <th>Quote</th>
                      <th>Options</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($selected_job->quotes as $quote)
                      @foreach ($quote->quote_users as $quote_user)
                        <tr>
                          <td>{{ $quote_user->getFormattedCreationDate() }}</td>
                          <td>{{ $quote_user->tradesperson->getFullNameAttribute() }}</td>
                          <td>{{ $quote_user->quote->quote_identifier }}</td>
                          <td class="text-center">
                            <div class="btn-toolba" role="toolbar">
                              <div class="btn-group mr-2" role="group" aria-label="First group">
                                <a href="{{ route('job-flags.show', $quote_user->id) }}" class="btn btn-primary btn-sm">
                                  <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                                </a>
                              </div>
                              <div class="btn-group" role="group" aria-label="Second group">
                                <form action="{{ route('job-flags.destroy', $quote_user->id) }}" method="POST">
                                  @method('DELETE')
                                  @csrf
                                  <button type="submit" class="btn btn-dark btn-sm">
                                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Clear
                                  </button>
                                </form>
                              </div>
                            </div> {{-- btn-toolbar --}}
                          </td>
                        </tr>
                      @endforeach
                    @endforeach
                  </tbody>
                </table>
              </div> {{-- table-responsive --}}
            @endif

          </div> {{-- col-sm-6 --}}
        </div> {{-- row --}}
        {{-- job flags table --}}

      </div> {{-- col-sm-9 --}}
      <div class="col-sm-3">

        {{-- Job Images --}}
        <h4 class="text-primary my-3">IMAGES</h4>
        {{-- Job Images --}}
        <h5 class="text-primary my-3"><b>Job Images</b></h5>
        <div class="row">
          <div class="col-sm mb-3">
            <form action="{{ route('job-images.create') }}" method="GET">
              <input type="hidden" name="job_id" value="{{ $selected_job->id }}">
              <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-images mr-2" aria-hidden="true"></i>Upload Images
              </button>
            </form>
          </div> {{-- col-sm-2 --}}
        </div> {{-- row --}}
        @if (!$image_type_collections->count())
          <div class="card my-3">
            <div class="card-body text-center">
              <h5>There are no job images to display</h5>
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @else
          @foreach ($image_type_collections as $collections)
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="imageCollection{{$loop->index}}" onclick="toggle_visibility('{{ $collections->first()->job_image_type->title }}');" @if ($loop->last) checked @endif>
              <label class="custom-control-label" for="imageCollection{{$loop->index}}">
                <b>{{ $collections->first()->job_image_type->title }}</b> - {{ $collections->last()->staff->getFullNameAttribute() . ' - ' . date('d/m/y', strtotime($collections->last()->created_at)) }}
              </label>
            </div>
            <div class="" id="{{ $collections->first()->job_image_type->title }}" @if (!$loop->last) style="display:none;" @endif>
              <div class="container">
                <div class="row row-cols-2">
                  @foreach ($collections as $image)
                    <div class="col py-3">
                      {{-- image modal --}}
                      {{-- modal button --}}
                      <a href="#" data-toggle="modal" data-target="#view-image-modal-{{$image->id}}">
                        @if ($image->image_path == null)
                          <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                        @else
                          <img class="img-fluid" src="{{ asset($image->image_path) }}" alt="job_image">
                        @endif
                      </a>
                      {{-- modal button --}}
                      {{-- modal --}}
                      <div class="modal fade" id="view-image-modal-{{$image->id}}" tabindex="-1" role="dialog" aria-labelledby="view-image-modal-{{$image->id}}Title" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="view-image-modal-{{$image->id}}Title">{{ $image->image_identifier }}</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body pt-0 pl-0 pr-0 pb-0 mt-0">
                              <a href="{{ route('job-images.show', $image->id) }}">
                                @if ($image->image_path == null)
                                  <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                                @else
                                  <img class="img-fluid" src="{{ asset($image->image_path) }}" alt="job_image">
                                @endif
                              </a>
                            </div> {{-- modal-body --}}
                            <div class="modal-footer">
                              <p>Click image to view details</p>
                            </div>
                          </div> {{-- modal-content --}}
                        </div> {{-- modal-dialog --}}
                      </div> {{-- modal fade --}}
                      {{-- modal --}}
                      {{-- image modal --}}
                    </div> {{-- col --}}
                  @endforeach
                </div> {{-- row row-cols-2 --}}
              </div> {{-- container --}}
            </div> {{-- visibility div --}}
          @endforeach
        @endif
        {{-- Job Images --}}

        {{-- SWMS Images --}}
        @if ($all_swms->isNotEmpty())
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="swmsImagesCheckbox" onclick="toggle_visibility('swms-image-div');">
            <label class="custom-control-label" for="swmsImagesCheckbox"><b>SWMS Document</b></label>
          </div>
          <div id="swms-image-div" style="display:none;">
            <div class="container">
              <div class="row row-cols-2">
                @foreach ($all_swms as $swms)
                  <div class="col py-3">
                    <a href="{{ route('swms-settings.show', $swms->id) }}" target="_blank">
                      <figure class="figure">
                        <img class="img-fluid" src="{{ asset('storage/images/icons/pdf-256x256.png') }}" alt="pdf-256x256">
                        <figcaption class="figure-caption text-center">{{ $swms->tradesperson->getFullNameAttribute() }}</figcaption>
                      </figure>
                    </a>
                  </div> {{-- col --}}
                @endforeach
              </div> {{-- row row-cols-2 --}}
            </div> {{-- container --}}
          </div> {{-- visibility div --}}
        @endif
        {{-- SWMS Images --}}

        {{-- quote request images --}}
        <h5 class="text-primary my-3"><b>Quote Request Images</b></h5>
        @if ($selected_job->quote_request?->quote_request_images == null)
          <div class="card my-3">
            <div class="card-body text-center">
              <h5>There are no quote request images to display</h5>
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @else
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="quoteRequestImagesCheckbox" onclick="toggle_visibility('quote-request-image-div');">
            <label class="custom-control-label" for="quoteRequestImagesCheckbox"><b>Customer Uploaded Images</b></label>
          </div>
          <div id="quote-request-image-div" style="display:none;">
            <div class="container">
              <div class="row row-cols-2">
                @foreach ($selected_job->quote_request->quote_request_images as $quote_request_image)
                  <div class="col py-3">

                    {{-- image modal --}}
                    {{-- modal button --}}
                    <a href="#" data-toggle="modal" data-target="#view-quote-request-image-modal-{{$quote_request_image->id}}">
                      @if ($quote_request_image->image_path == null)
                        <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                      @else
                        <img class="img-fluid" src="{{ asset($quote_request_image->image_path) }}" alt="job_image">
                      @endif
                    </a>
                    {{-- modal button --}}
                    {{-- modal --}}
                    <div class="modal fade" id="view-quote-request-image-modal-{{$quote_request_image->id}}" tabindex="-1" role="dialog" aria-labelledby="view-quote-request-image-modal-{{$quote_request_image->id}}Title" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="view-quote-request-image-modal-{{$quote_request_image->id}}Title">Quote Request Image</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body pt-0 pl-0 pr-0 pb-0 mt-0">
                            @if ($quote_request_image->image_path == null)
                              <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                            @else
                              <img class="img-fluid" src="{{ asset($quote_request_image->image_path) }}" alt="job_image">
                            @endif
                          </div> {{-- modal-body --}}
                        </div> {{-- modal-content --}}
                      </div> {{-- modal-dialog --}}
                    </div> {{-- modal fade --}}
                    {{-- modal --}}
                    {{-- image modal --}}

                  </div> {{-- col --}}
                @endforeach
              </div> {{-- row row-cols-2 --}}
            </div> {{-- container --}}
          </div> {{-- visibility div --}}
        @endif
        {{-- quote request images --}}

        {{-- quote request comments --}}
        <h5 class="text-primary my-3"><b>Quote Request Comments</b></h5>
        @if ($selected_job->quote_request == null)
          <div class="card my-3">
            <div class="card-body text-center">
              <h5>There are no quote request comments to display</h5>
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @else
          @if ($selected_job->quote_request->additions_other == null && $selected_job->quote_request->further_information == null)
            <div class="card my-3">
              <div class="card-body text-center">
                <h5>There are no quote request comments to display</h5>
              </div> {{-- card-body --}}
            </div> {{-- card --}}
          @else
            @if ($selected_job->quote_request->additions_other != null)
              <p><b>Additions:</b> {{ $selected_job->quote_request->additions_other }}</p>
            @endif
            @if ($selected_job->quote_request->further_information != null)
              <p><b>Further Information:</b> {{ $selected_job->quote_request->further_information }}</p>
            @endif
          @endif
        @endif
        {{-- quote request comments --}}

        {{-- Pdf Images --}}
        <h5 class="text-primary my-3"><b>PDF Images</b></h5>
        <div class="row">
          <div class="col-sm mb-3">
            <a href="{{ route('manage-pdf-images.show', $selected_job->id) }}" class="btn btn-primary btn-block">
              <i class="fas fa-images mr-2" aria-hidden="true"></i>Select PDF Images
            </a>
          </div> {{-- col-sm-2 --}}
        </div> {{-- row --}}
        @if (!$all_pdf_images->count())
          <div class="card my-3">
            <div class="card-body text-center">
              <h5>There are no images to display</h5>
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @else
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="pdfImagesCheckbox" onclick="toggle_visibility('pdf-image-div');">
            <label class="custom-control-label" for="pdfImagesCheckbox"><b>PDF Images</b></label>
          </div>
          <div id="pdf-image-div" style="display:none;">
            <div class="container">
              <div class="row row-cols-2">
                @foreach ($all_pdf_images as $image)
                  <div class="col py-3">
                    @if ($image->image_path == null)
                      <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                    @else
                      <img class="img-fluid" src="{{ asset($image->image_path) }}" alt="job_image">
                    @endif
                  </div> {{-- col --}}
                @endforeach
              </div> {{-- row row-cols-2 --}}
            </div> {{-- container --}}
          </div> {{-- visibility div --}}
        @endif
        {{-- Pdf Images --}}

      </div> {{-- col-sm-3 --}}
    </div> {{-- row --}}
    {{-- job content --}}

    {{-- QUOTE CONTENT --}}
    <h4 class="text-primary my-3">QUOTES</h4>
    <div class="row">
      <div class="col-sm-2 pb-3">
        <form action="{{ route('quick-quote.create') }}" method="GET">
          <input type="hidden" name="selected_job_id" value="{{ $selected_job->id }}">
          <button type="submit" class="btn btn-primary btn-block">
            <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Quick Quote
          </button>
        </form>
      </div> {{-- col-sm-2 --}}
    </div> {{-- row --}}

    <h5 class="text-primary my-3"><b>All Quotes</b></h5>

    @if (!$selected_job->quotes->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no quotes to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <th>Quote Identifier</th>
            <th>Status</th>
            <th>Job Type</th>
            <th>Description</th>
            <th>Price</th>
            <th>View Count</th>
            <th>Options</th>
          </thead>
          <tbody>
            @foreach ($selected_job->quotes as $quote)
              <tr>
                <td>
                  <a href="{{ route('quotes.show', $quote->id) }}">{{ $quote->quote_identifier }}</a>
                </td>
                <td>{{ $quote->quote_status->title }}</td>
                <td>
                  @if ($quote->job_type_id == null)
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>To Be Confirmed
                    </span>
                  @else
                    <span class="badge badge-dark py-2 px-2">
                      <i class="fas fa-tools mr-2" aria-hidden="true"></i>{{ $quote->job_type->title }}
                    </span>
                  @endif
                </td>
                <td>
                  @if ($quote->description == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ $quote->description }}
                  @endif
                </td>
                <td>
                  @if ($quote->finalised_date == null)
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>To Be Confirmed
                    </span>
                  @else
                    {{ $quote->getFormattedQuoteTotal() }}
                    @if ($quote->discount > 0)
                      (Discounted)
                    @endif
                  @endif
                </td>
                <td>{{ $quote->customer_view_count }}</td>
                <td class="text-center text-nowrap" width="40%">

                  <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{ route('quotes.show', $quote->id) }}" class="btn btn-secondary btn-sm mr-2">
                      <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit Quote
                    </a>

                    <a href="{{ route('quick-quote.show', $quote->id) }}" class="btn btn-primary btn-sm mr-2">
                      <i class="fas fa-file-invoice mr-2" aria-hidden="true"></i>View Quick Quote
                    </a>

                    <a href="{{ route('contractor-job-report.show', $quote->id) }}" class="btn btn-primary btn-sm mr-2">
                      <i class="fas fa-file-invoice mr-2" aria-hidden="true"></i>Meas
                    </a>

                    <a href="{{ route('job-view-customer-quote.show', $quote->id) }}" class="btn btn-primary btn-sm mr-2">
                      <i class="fas fa-file-invoice mr-2" aria-hidden="true"></i>View Quote
                    </a>

                    <a href="{{ route('job-view-work-order.show', $quote->id) }}" class="btn btn-primary btn-sm mr-2">
                      <i class="fas fa-file-invoice mr-2" aria-hidden="true"></i>Contract
                    </a>

                    <form action="{{ route('job-email-quote-to-customer.create') }}" method="POST">
                      @csrf
                      <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                      <button type="submit" class="btn btn-primary btn-sm mr-2">
                        <i class="fas fa-envelope mr-2" aria-hidden="true"></i>Email
                      </button>
                    </form>

                    {{-- delete modal --}}
                    {{-- modal button --}}
                    <button type="button" class="btn btn-{{ $quote->allow_accept_card_payment == 0 ? 'danger' : 'success' }} btn-sm mr-2" data-toggle="modal" data-target="#confirm-allow-staff-to-accept-payment-{{$quote->id}}">
                      <i class="fab fa-cc-stripe mr-2" aria-hidden="true"></i>Tradepsrson
                    </button>
                    {{-- modal button --}}
                    {{-- modal --}}
                    <div class="modal fade" id="confirm-allow-staff-to-accept-payment-{{$quote->id}}" tabindex="-1" role="dialog" aria-labelledby="confirm-allow-staff-to-accept-payment-{{$quote->id}}-title" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="confirm-allow-staff-to-accept-payment-{{$quote->id}}-title">Allow Card Payment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p class="text-center">Allow the tradesperson to accept a card payment from the customer?</p>
                            <form action="{{ route('allow-accept-card-payment.update', $quote->id) }}" method="POST">
                              @method('PATCH')
                              @csrf
                              @if($quote->allow_accept_card_payment == 0)
                                <button type="submit" class="btn btn-success btn-block">
                                  <i class="fas fa-check mr-2" aria-hidden="true"></i>Allow Accept Payment
                                </button>
                              @else
                                <button type="submit" class="btn btn-danger btn-block">
                                  <i class="fas fa-times mr-2" aria-hidden="true"></i>Don't Allow Accept Payment
                                </button>
                              @endif
                            </form>
                          </div> {{-- modal-body --}}
                        </div> {{-- modal-content --}}
                      </div> {{-- modal-dialog --}}
                    </div> {{-- modal fade --}}
                    {{-- modal --}}
                    {{-- delete modal --}}

                    {{-- delete modal --}}
                    {{-- modal button --}}
                    <button type="button" class="btn btn-{{ $quote->allow_early_receipt == 0 ? 'danger' : 'success' }} btn-sm mr-2" data-toggle="modal" data-target="#confirm-allow-pre-receipt-{{$quote->id}}">
                      <i class="fas fa-file-invoice mr-2" aria-hidden="true"></i>Pre-Receipt
                    </button>
                    {{-- modal button --}}
                    {{-- modal --}}
                    <div class="modal fade" id="confirm-allow-pre-receipt-{{$quote->id}}" tabindex="-1" role="dialog" aria-labelledby="confirm-allow-pre-receipt-{{$quote->id}}-title" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="confirm-allow-pre-receipt-{{$quote->id}}-title">Allow Pre-Receipt</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p class="text-center">Allow the tradesperson to generate a pre-receipt?</p>
                            <form action="{{ route('allow-pre-receipt.update', $quote->id) }}" method="POST">
                              @method('PATCH')
                              @csrf
                              @if($quote->allow_early_receipt == 0)
                                <button type="submit" class="btn btn-success btn-block">
                                  <i class="fas fa-check mr-2" aria-hidden="true"></i>Allow Pre-Receipt
                                </button>
                              @else
                                <button type="submit" class="btn btn-danger btn-block">
                                  <i class="fas fa-times mr-2" aria-hidden="true"></i>Don't Allow Pre-Receipt
                                </button>
                              @endif
                            </form>
                          </div> {{-- modal-body --}}
                        </div> {{-- modal-content --}}
                      </div> {{-- modal-dialog --}}
                    </div> {{-- modal fade --}}
                    {{-- modal --}}
                    {{-- delete modal --}}

                    {{-- delete modal --}}
                    {{-- modal button --}}
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete-quote-{{$quote->id}}">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                    </button>
                    {{-- modal button --}}
                    {{-- modal --}}
                    <div class="modal fade" id="confirm-delete-quote-{{$quote->id}}" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-quote-{{$quote->id}}-title" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="confirm-delete-quote-{{$quote->id}}-title">Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p class="text-center">Are you sure that you would like to delete this quote?</p>
                            <form action="{{ route('quotes.destroy', $quote->id) }}" method="POST">
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
                    {{-- delete modal --}}
                  </div>

                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- QUOTE CONTENT --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
  {{-- Toggle Visibility By Id Generic --}}
  <script type="text/javascript">
    function toggle_visibility(id) {
      var e = document.getElementById(id);
      if (e.style.display == 'none')
        e.style.display = 'block';
      else
        e.style.display = 'none';
    }
  </script>
  {{-- Toggle Visibility By Id Generic --}}

  {{-- Note toggle box --}}
  <script type="text/javascript">
    function noteExpander() {
      var noteCollapsed = document.getElementById("noteCollapsed"); 
      var noteExpanded = document.getElementById("noteExpanded");

      noteCollapsed.style.display = (
          noteCollapsed.style.display == "none" ? "block" : "none"); 
      noteExpanded.style.display = (
          noteExpanded.style.display == "none" ? "block" : "none"); 
    }
  </script>
  {{-- Note toggle box --}}

  {{-- Internal Note toggle box --}}
  <script type="text/javascript">
    function internalNoteExpander() {
      var internalNoteCollapsed = document.getElementById("internalNoteCollapsed"); 
      var internalNoteExpanded = document.getElementById("internalNoteExpanded");

      internalNoteCollapsed.style.display = (
          internalNoteCollapsed.style.display == "none" ? "block" : "none"); 
      internalNoteExpanded.style.display = (
          internalNoteExpanded.style.display == "none" ? "block" : "none"); 
    }
  </script>
  {{-- Internal Note toggle box --}}

  {{-- Date Time Picker JS --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.28.0/moment.min.js" integrity="sha512-Q1f3TS3vSt1jQ8AwP2OuenztnLU6LwxgyyYOG1jgMW/cbEMHps/3wjvnl1P3WTrF3chJUWEoxDUEjMxDV8pujg==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-2JBCbWoMJPH+Uj7Wq5OLub8E5edWHlTM4ar/YJkZh3plwB2INhhOC3eDoqHm1Za/ZOSksrLlURLoyXVdfQXqwg==" crossorigin="anonymous"></script>
  <script type="text/javascript">
    $(function () {
      $('#start').datetimepicker({
        icons: {
          time: "fas fa-clock",
          date: "fas fa-calendar-alt",
          up: "fas fa-chevron-up",
          down: "fas fa-chevron-down"
        },
        format: 'DD-MM-YYYY LT',
      });
    });
  </script>
  {{-- Date Time Picker JS --}}
@endpush