@extends('layouts.profileJquery')

@section('title', '- Jobs - View Selected Job')

@push('css')
    {{-- Datepicker CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-PMjWzHVtwxdq7m7GIxBot5vdxUY+5aKP9wpKtvnNBZrVv1srI8tU6xvFMzG8crLNcMj/8Xl/WWmo/oAP/40p1g==" crossorigin="anonymous" />
    {{-- Datepicker CSS --}}
@endpush

@section('content')
    <section>
        <div class="container-fluid py-5">

            {{-- title --}}
            <h3 class="text-secondary mb-0">MY JOBS</h3>
            <h5>View Selected Job</h5>
            {{-- title --}}

            {{-- navigation --}}
            <div class="row row-cols-1 row-cols-sm-6 pt-3">
                <div class="col mb-3">
                    <a class="btn btn-dark btn-block" href="{{ route('profile-jobs.index') }}">
                        <i class="fas fa-bars mr-2" aria-hidden="true"></i>My Jobs Menu
                    </a>
                </div> {{-- col mb-3 --}}
                <div class="col mb-3">
                    <a class="btn btn-primary btn-block" href="{{ route('profile-jobs-swms.show', $selected_quote->id) }}">
                        <i class="fas fa-clipboard-list mr-2" aria-hidden="true"></i>SWMS
                    </a>
                </div> {{-- col mb-3 --}}
                <div class="col mb-3">
                    <a class="btn btn-dark btn-block" href="{{ route('profile-job-completed.index', ['selected_quote_id' => $selected_quote->id]) }}">
                        <i class="fas fa-check mr-2" aria-hidden="true"></i>Work Completed
                    </a>
                </div> {{-- col mb-3 --}}
                <div class="col mb-3">
                    {{-- Email Modal --}}
                    {{-- modal button --}}
                    <button class="btn btn-warning btn-block" data-toggle="modal" data-target="#emailModal" type="button">
                        <i class="fas fa-edit mr-2" aria-hidden="true"></i>Change Start Date
                    </button>
                    {{-- modal button --}}
                    {{-- modal --}}
                    <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="emailModalTitle">Confirm Start Date Change</h5>
                                    <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Please click the corresponding check box and then confirm the text for the optional email and SMS to send them to the customer.</p>

                                    <form action="{{ route('job-send-update-email.update', $selected_quote->job_id) }}" method="POST">
                                        @method('PATCH')
                                        @csrf

                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label text-md-right" for="title">Start Date</label>
                                            <div class="col-md-8">
                                                <div class="input-group date" id="start" data-target-input="nearest">
                                                    <input class="form-control datetimepicker-input @error('start') is-invalid @enderror" data-target="#start" type="text" name="start_date" @if (old('start')) value="{{ date('m/d/Y', strtotime(old('start'))) }}" @endif placeholder="Please enter a start date and time" />
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
                                            <label class="col-md-3 col-form-label text-md-right" for="message"></label>
                                            <div class="col-md-8">
                                                <div class="form-group form-check">
                                                    <input class="form-check-input" id="emailCheck" type="checkbox" name="email_check">
                                                    <label class="form-check-label" for="emailCheck">Send Email to Customer</label>
                                                </div>
                                            </div> {{-- col-md-9 --}}
                                        </div> {{-- form-group row --}}

                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label text-md-right" for="email_message">Email</label>
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
                                            <label class="col-md-3 col-form-label text-md-right" for="message"></label>
                                            <div class="col-md-8">
                                                <div class="form-group form-check">
                                                    <input class="form-check-input" id="smsCheck" type="checkbox" name="sms_check">
                                                    <label class="form-check-label" for="smsCheck">Send SMS to Customer</label>
                                                </div>
                                            </div> {{-- col-md-9 --}}
                                        </div> {{-- form-group row --}}

                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label text-md-right" for="sms_message">SMS</label>
                                            <div class="col-md-8">
                                                <textarea class="form-control @error('sms_message') is-invalid @enderror mb-2" type="text" name="sms_message" rows="6" placeholder="Please enter the sms_message" style="resize:none">{{ old('sms_message', $selected_sms_template->text) }}</textarea>
                                                @error('sms_message')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div> {{-- col-md-9 --}}
                                        </div> {{-- form-group row --}}

                                        <input type="hidden" name="is_tradesperson_confirmed" value="1">

                                        <button class="btn btn-dark btn-block" type="submit">
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
            </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
            {{-- navigation --}}

            {{-- navigation dropdowns --}}
            <div class="row">
                <div class="col-sm-2">
                    <p class="text-primary text-center"><b>Job Progress</b></h5>
                    <form action="{{ route('profile-update-job-progress.update', $selected_quote->job_id) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="input-group mb-3">
                            <select class="custom-select @error('progress_id') is-invalid @enderror" name="progress_id">
                                @if (!$selected_quote->job->job_progress_id == null)
                                    <option value="{{ $selected_quote->job->job_progress_id }}">{{ $selected_quote->job->job_progress->title }}</option>
                                @endif
                                <option disabled>Please select a job progress</option>
                                @foreach ($job_progresses as $job_progress)
                                    <option value="{{ $job_progress->id }}" @if ($job_progress->id == $selected_quote->job->job_progress_id) hidden @endif>{{ $job_progress->title }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-dark" id="progress_id_button" type="submit"><i class="fas fa-edit"></i></button>
                            </div> {{-- form-control --}}
                        </div> {{-- input-group mb-3 --}}
                    </form>
                </div> {{-- col-sm-2 --}}
            </div> {{-- row --}}
            {{-- navigation dropdowns --}}

            {{-- body --}}
            <div class="row">

                {{-- LEFT 2/3 OF PAGE --}}

                <div class="col-sm-9">

                    {{-- Overview --}}

                    <h4 class="text-primary my-3">OVERVIEW</h4>

                    <div class="row">

                        {{-- Left Column --}}

                        <div class="col-sm-6">

                            {{-- Customer details --}}

                            <p class="text-primary"><b>Customer Details</b></h5>

                            <div class="table-responsive">
                                <table class="table table-bordered table-fullwidth table-striped bg-white">
                                    <tbody>
                                        <tr>
                                            <th>Customer ID</th>
                                            <td>{{ $selected_quote->customer_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ $selected_quote->customer->getFullNameAttribute() }}</td>
                                        </tr>
                                        <tr>
                                            <th>Street Address</th>
                                            <td>{{ $selected_quote->customer->street_address }}</td>
                                        </tr>
                                        <tr>
                                            <th>Suburb and Postcode</th>
                                            <td>{{ $selected_quote->customer->suburb }} - {{ $selected_quote->customer->postcode }}</td>
                                        </tr>
                                        <tr>
                                            <th>Customer Phone</th>
                                            <td>
                                                @if ($selected_quote->customer->home_phone == null)
                                                    <span class="badge badge-light py-2 px-2">
                                                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                                                    </span>
                                                @else
                                                    {{ $selected_quote->customer->home_phone }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Customer Mobile</th>
                                            <td>
                                                @if ($selected_quote->customer->mobile_phone == null)
                                                    <span class="badge badge-light py-2 px-2">
                                                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                                                    </span>
                                                @else
                                                    {{ $selected_quote->customer->mobile_phone }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>
                                                @if ($selected_quote->customer->email == null)
                                                    <span class="badge badge-light py-2 px-2">
                                                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                                                    </span>
                                                @else
                                                    {{ $selected_quote->customer->email }}
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> {{-- table-responsive --}}

                            {{-- Customer Details --}}

                        </div> {{-- col-sm-6 --}}
                        <div class="col-sm-6">

                            {{-- Job Details --}}

                            <p class="text-primary"><b>Job Details</b></h5>

                            <div class="table-responsive">
                                <table class="table table-bordered table-fullwidth table-striped bg-white">
                                    <tbody>
                                        <tr>
                                            <th>Job Number</th>
                                            <td>{{ $selected_quote->job_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Sales Person</th>
                                            <td>{{ $selected_quote->job->salesperson->getFullNameAttribute() }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tenant</th>
                                            <td>{{ $selected_quote->job->tenant_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tenant Home Phone</th>
                                            <td>
                                                @if ($selected_quote->job->tenant_home_phone == null)
                                                    <span class="badge badge-light py-2 px-2">
                                                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                                                    </span>
                                                @else
                                                    {{ $selected_quote->job->tenant_home_phone }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tenant Mobile Phone</th>
                                            <td>
                                                @if ($selected_quote->job->tenant_mobile_phone == null)
                                                    <span class="badge badge-light py-2 px-2">
                                                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                                                    </span>
                                                @else
                                                    {{ $selected_quote->job->tenant_mobile_phone }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Job Address</th>
                                            <td>{{ $selected_quote->job->tenant_street_address }}</td>
                                        </tr>
                                        <tr>
                                            <th>Suburb and Postcode</th>
                                            <td>{{ $selected_quote->job->tenant_suburb }} - {{ $selected_quote->job->tenant_postcode }}</td>
                                        </tr>
                                        <tr>
                                            <th>Roof Surface</th>
                                            <td>
                                                @if ($selected_quote->job->material_type_id == null)
                                                    <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
                                                @else
                                                    {{ $selected_quote->job->material_type->title }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Building Style</th>
                                            <td>
                                                @if ($selected_quote->job->building_style_id == null)
                                                    <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
                                                @else
                                                    {{ $selected_quote->job->building_style->title }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Building Type</th>
                                            <td>
                                                @if ($selected_quote->job->building_type_id == null)
                                                    <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
                                                @else
                                                    {{ $selected_quote->job->building_type->title }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Start Date</th>
                                            <td>
                                                @if ($selected_quote->job->start_date == null)
                                                    <span class="badge badge-warning py-2 px-2">
                                                        <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>To Be Confirmed
                                                    </span>
                                                @else
                                                    {{ date('d/m/y - h:iA', strtotime($selected_quote->job->start_date)) }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Completion Date</th>
                                            <td>
                                                @if ($selected_quote->job->completion_date == null)
                                                    <span class="badge badge-warning py-2 px-2">
                                                        <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>To Be Confirmed
                                                    </span>
                                                @else
                                                    {{ date('d/m/y - h:iA', strtotime($selected_quote->job->completion_date)) }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Job Type</th>
                                            <td>
                                                @if (!$selected_quote->job->job_types->count())
                                                    <span class="badge badge-warning py-2 px-2">
                                                        <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>To Be Confirmed
                                                    </span>
                                                @else
                                                    @foreach ($selected_quote->job->job_types as $job_type)
                                                        <span class="badge badge-dark py-2 px-2">
                                                            <i class="fas fa-tools mr-2" aria-hidden="true"></i>{{ $job_type->title }}
                                                        </span>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Job Status</th>
                                            <td>{{ $selected_quote->job->job_status->title }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> {{-- table-responsive --}}

                            {{-- Job Details --}}

                        </div> {{-- col-sm-6 --}}
                    </div> {{-- row --}}

                    {{-- DETAIL TABLES --}}

                    {{-- NOTES --}}

                    <h4 class="text-primary my-3">NOTES</h4>

                    <div class="row">
                        <div class="col-sm-6">

                            {{-- Public Notes --}}

                            <h5 class="text-primary my-3"><input type="checkbox" onclick="noteExpander()"> <b>Customer Notes</b></h5>
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <form action="{{ route('profile-job-customer-notes.create') }}" method="GET">
                                        <input type="hidden" name="selected_quote_id" value="{{ $selected_quote->id }}">
                                        <button class="btn btn-primary btn-block" type="submit">
                                            <i class="fas fa-plus mr-2" aria-hidden="true"></i>New Customer Note
                                        </button>
                                    </form>
                                </div> {{-- col-sm-6 mb-3 --}}
                            </div> {{-- row --}}

                            @if (!$all_public_notes->count())
                                <div class="card">
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
                                                        {{ substr($public_note->text, 0, 150) }}{{ strlen($public_note->text) > 150 ? '...' : '' }}
                                                        @if ($public_note->recipient_id != null && $public_note->recipient_seen_at == null)
                                                            <b>
                                                        @endif
                                                    </td>
                                                    <td nowrap="nowrap">
                                                        <a class="btn btn-primary btn-sm" href="{{ route('job-notes.show', $public_note->id) }}">View</a>
                                                        @if ($public_note->sender_id != null)
                                                            <a class="btn btn-primary btn-sm" href="{{ route('job-notes.show', $public_note->id) }}#note-response-form">Reply</a>
                                                        @endif
                                                        {{-- delete modal --}}
                                                        {{-- modal button --}}
                                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#{{ 'delete-public-note-' . $public_note->id }}" type="button">
                                                            Delete
                                                        </button>
                                                        {{-- modal button --}}
                                                        {{-- modal --}}
                                                        <div class="modal fade" id="{{ 'delete-public-note-' . $public_note->id }}" tabindex="-1" role="dialog" aria-labelledby="{{ 'delete-public-note-' . $public_note->id }}Title" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="{{ 'delete-public-note-' . $public_note->id }}Title">Delete</h5>
                                                                        <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p class="text-center">Are you sure that you would like to delete this note?</p>
                                                                        <form method="POST" action="{{ route('job-notes.destroy', $public_note->id) }}">
                                                                            @method('DELETE')
                                                                            @csrf
                                                                            <button class="btn btn-danger btn-block" type="submit">
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
                                                        {{ substr($public_note->text, 0, 150) }}{{ strlen($public_note->text) > 150 ? '...' : '' }}
                                                        @if ($public_note->recipient_id != null && $public_note->recipient_seen_at == null)
                                                            <b>
                                                        @endif
                                                    </td>
                                                    <td nowrap="nowrap">
                                                        <a class="btn btn-primary btn-sm" href="{{ route('job-notes.show', $public_note->id) }}">View</a>
                                                        @if ($public_note->sender_id != null)
                                                            <a class="btn btn-primary btn-sm" href="{{ route('job-notes.show', $public_note->id) }}#note-response-form">Reply</a>
                                                        @endif
                                                        {{-- delete modal --}}
                                                        {{-- modal button --}}
                                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#{{ 'delete-public-note-' . $public_note->id }}" type="button">
                                                            Delete
                                                        </button>
                                                        {{-- modal button --}}
                                                        {{-- modal --}}
                                                        <div class="modal fade" id="{{ 'delete-public-note-' . $public_note->id }}" tabindex="-1" role="dialog" aria-labelledby="{{ 'delete-public-note-' . $public_note->id }}Title" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="{{ 'delete-public-note-' . $public_note->id }}Title">Delete</h5>
                                                                        <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p class="text-center">Are you sure that you would like to delete this note?</p>
                                                                        <form method="POST" action="{{ route('job-notes.destroy', $public_note->id) }}">
                                                                            @method('DELETE')
                                                                            @csrf
                                                                            <button class="btn btn-danger btn-block" type="submit">
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
                                    <form action="{{ route('profile-job-internal-notes.create') }}" method="GET">
                                        <input type="hidden" name="selected_quote_id" value="{{ $selected_quote->id }}">
                                        <button class="btn btn-primary btn-block" type="submit">
                                            <i class="fas fa-plus mr-2" aria-hidden="true"></i>New Internal Note
                                        </button>
                                    </form>
                                </div> {{-- col-sm-6 mb-3 --}}
                            </div> {{-- row --}}

                            @if (!$all_internal_notes->count())
                                <div class="card">
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
                                                        <div class="btn-group" role="group" aria-label="Basic example">
                                                            <form action="{{ route('profile-job-internal-notes.show', $internal_note->id) }}" method="GET">
                                                                <input type="hidden" name="selected_quote_id" value="{{ $selected_quote->id }}">
                                                                <button class="btn btn-primary btn-sm mr-1" type="submit">
                                                                    View
                                                                </button>
                                                            </form>
                                                            @if ($internal_note->sender_id != null)
                                                                <form action="{{ route('profile-job-internal-notes.show', $internal_note->id) }}#response-box" method="GET">
                                                                    <input type="hidden" name="selected_quote_id" value="{{ $selected_quote->id }}">
                                                                    <button class="btn btn-primary btn-sm" type="submit">
                                                                        Reply
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div> {{-- btn-group --}}
                                                        @if ($internal_note->sender_id != auth()->id())
                                                            <button class="btn btn-sm btn-danger" type="button" disabled>Delete</button>
                                                        @else
                                                            {{-- delete modal --}}
                                                            {{-- modal button --}}
                                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#{{ 'delete-internal-note-' . $internal_note->id }}" type="button">
                                                                Delete
                                                            </button>
                                                            {{-- modal button --}}
                                                            {{-- modal --}}
                                                            <div class="modal fade" id="{{ 'delete-internal-note-' . $internal_note->id }}" tabindex="-1" role="dialog" aria-labelledby="{{ 'delete-internal-note-' . $internal_note->id }}Title" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="{{ 'delete-internal-note-' . $internal_note->id }}Title">Delete</h5>
                                                                            <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p class="text-center">Are you sure that you would like to delete this note?</p>
                                                                            <form method="POST" action="{{ route('job-internal-notes.destroy', $internal_note->id) }}">
                                                                                @method('DELETE')
                                                                                @csrf
                                                                                <input type="hidden" name="selected_quote_id" value="{{ $selected_quote->id }}">
                                                                                <button class="btn btn-danger btn-block" type="submit">
                                                                                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                                                                                </button>
                                                                            </form>
                                                                        </div> {{-- modal-body --}}
                                                                    </div> {{-- modal-content --}}
                                                                </div> {{-- modal-dialog --}}
                                                            </div> {{-- modal fade --}}
                                                            {{-- modal --}}
                                                            {{-- delete modal --}}
                                                        @endif
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
                                                        <div class="btn-group" role="group" aria-label="Basic example">
                                                            <form action="{{ route('profile-job-internal-notes.show', $internal_note->id) }}" method="GET">
                                                                <input type="hidden" name="selected_quote_id" value="{{ $selected_quote->id }}">
                                                                <button class="btn btn-primary btn-sm mr-2" type="submit">
                                                                    View
                                                                </button>
                                                            </form>
                                                            @if ($internal_note->sender_id != null)
                                                                <form action="{{ route('profile-job-internal-notes.show', $internal_note->id) }}#response-box" method="GET">
                                                                    <input type="hidden" name="selected_quote_id" value="{{ $selected_quote->id }}">
                                                                    <button class="btn btn-primary btn-sm" type="submit">
                                                                        Reply
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div> {{-- btn-group --}}
                                                        @if ($internal_note->sender_id != auth()->id())
                                                            <button class="btn btn-sm btn-danger" type="button" disabled>Delete</button>
                                                        @else
                                                            {{-- delete modal --}}
                                                            {{-- modal button --}}
                                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#{{ 'delete-internal-note-' . $internal_note->id }}" type="button">
                                                                Delete
                                                            </button>
                                                            {{-- modal button --}}
                                                            {{-- modal --}}
                                                            <div class="modal fade" id="{{ 'delete-internal-note-' . $internal_note->id }}" tabindex="-1" role="dialog" aria-labelledby="{{ 'delete-internal-note-' . $internal_note->id }}Title" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="{{ 'delete-internal-note-' . $internal_note->id }}Title">Delete</h5>
                                                                            <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p class="text-center">Are you sure that you would like to delete this note?</p>
                                                                            <form method="POST" action="{{ route('job-internal-notes.destroy', $internal_note->id) }}">
                                                                                @method('DELETE')
                                                                                @csrf
                                                                                <input type="hidden" name="selected_quote_id" value="{{ $selected_quote->id }}">
                                                                                <button class="btn btn-danger btn-block" type="submit">
                                                                                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                                                                                </button>
                                                                            </form>
                                                                        </div> {{-- modal-body --}}
                                                                    </div> {{-- modal-content --}}
                                                                </div> {{-- modal-dialog --}}
                                                            </div> {{-- modal fade --}}
                                                            {{-- modal --}}
                                                            {{-- delete modal --}}
                                                        @endif
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

                    {{-- NOTES --}}

                </div> {{-- col-sm-9 --}}

                {{-- LEFT 2/3 OF PAGE --}}

                {{-- LEFT 1/3 OF PAGE --}}

                <div class="col-sm-3">

                    {{-- RIGHT COLUMN --}}

                    {{-- Job Images --}}
                    <h4 class="text-primary my-3">IMAGES</h4>
                    <h5 class="text-primary my-3"><b>Job Images</b></h5>
                    <div class="row">
                        <div class="col-sm mb-3">
                            <a class="btn btn-primary btn-block" href="{{ route('profile-image-upload.index', ['selected_quote_id' => $selected_quote->id]) }}">
                                <i class="fas fa-images mr-2" aria-hidden="true"></i>Manage Images
                            </a>
                        </div> {{-- col-sm-2 --}}
                    </div> {{-- row --}}
                    @if (!$image_type_collections->count())
                        <div class="card">
                            <div class="card-body text-center">
                                <h5>There are no job images to display</h5>
                            </div> {{-- card-body --}}
                        </div> {{-- card --}}
                    @else
                        @foreach ($image_type_collections as $collections)
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" id="imageCollection{{ $loop->index }}" type="checkbox" onclick="toggle_visibility('{{ $collections->first()->job_image_type->title }}');" @if ($loop->last) checked @endif>
                                    <label class="custom-control-label" for="imageCollection{{ $loop->index }}">
                                        <b>{{ $collections->first()->job_image_type->title }}</b> - {{ $collections->last()->staff->getFullNameAttribute() . ' - ' . date('d/m/y', strtotime($collections->last()->created_at)) }}
                                    </label>
                                </div>
                            </div>
                            <div class="" id="{{ $collections->first()->job_image_type->title }}" @if (!$loop->last) style="display:none;" @endif>
                                <div class="container">
                                    <div class="row row-cols-2">
                                        @foreach ($collections as $image)
                                            <div class="col py-3">
                                                {{-- modal start --}}
                                                @if ($image->image_path == null)
                                                    <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                                                @else
                                                    <a data-toggle="modal" data-target="#image-modal-{{ $image->id }}">
                                                        <img class="img-fluid" src="{{ asset($image->image_path) }}" alt="image">
                                                    </a>
                                                @endif
                                                <div class="modal fade" id="image-modal-{{ $image->id }}" tabindex="-1" role="dialog" aria-labelledby="image-modal-{{ $image->id }}-title" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body py-0 pl-0 pr-0">
                                                                @if ($image->image_path == null)
                                                                    <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                                                                @else
                                                                    <img class="img-fluid" src="{{ asset($image->image_path) }}" alt="image">
                                                                @endif
                                                            </div>
                                                            <div class="modal-body bg-{{ $image->colour->brand }}">
                                                                <h5 class="modal-title text-center text-{{ $image->colour->text_brand }}" id="image-modal-{{ $image->id }}-title">{{ $image->title }}</h5>
                                                            </div>
                                                            <div class="modal-body bg-white">
                                                                <p class="mt-2">{{ $image->description }}</p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <button class="btn btn-secondary" data-dismiss="modal" type="button">
                                                                    <i class="fa fa-times pr-2" aria-hidden="true"></i>Close
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- modal end --}}
                                            </div> {{-- col --}}
                                        @endforeach
                                    </div> {{-- row row-cols-2 --}}
                                </div> {{-- container --}}
                            </div> {{-- visibility div --}}
                        @endforeach
                    @endif
                    {{-- Job Images --}}

                    {{-- RIGHT COLUMN --}}

                </div> {{-- col-sm-3 --}}

                {{-- LEFT 1/3 OF PAGE --}}

            </div> {{-- row --}}

            {{-- JOB CONTENT --}}

            {{-- QUOTE CONTENT --}}

            <h4 class="text-primary my-3">QUOTE</h4>
            <h5 class="text-primary my-3"><b>Selected Quote</b></h5>
            @if (!$selected_quote->job->quotes->count())
                <div class="card shadow-sm mt-3">
                    <div class="card-body text-center">
                        <h5>There are no quotes to display</h5>
                    </div> {{-- card-body --}}
                </div> {{-- card --}}
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-fullwidth table-striped bg-white">
                        <thead class="table-secondary">
                            <th>Quote ID</th>
                            <th>Job Type</th>
                            <th>Status</th>
                            <th>Description</th>
                            <th>Options</th>
                        </thead>
                        <tbody>
                            @foreach ($selected_quote->job->quotes as $quote)
                                <tr>
                                    <td>{{ $quote->quote_identifier }}</td>
                                    <td>
                                        @if ($quote->job_type_id == null)
                                            <span class="badge badge-warning py-2 px-2">
                                                <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>No job type has been specified
                                            </span>
                                        @else
                                            <span class="badge badge-dark py-2 px-2">
                                                <i class="fas fa-tools mr-2" aria-hidden="true"></i>{{ $quote->job_type->title }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $quote->quote_status->title }}</td>
                                    <td>
                                        @if ($quote->description == null)
                                            <span class="badge badge-warning py-2 px-2">
                                                <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>Not Applicable
                                            </span>
                                        @else
                                            {{ substr(quote->description, 0, 50) }}{{ strlen(quote->description) > 50 ? '...' : '' }}
                                        @endif
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <div class="btn-group" role="group" aria-label="Basic example">

                                            <a class="btn btn-primary btn-sm mr-2" href="{{ route('profile-job-measurements.show', $quote->id) }}">
                                                <i class="fas fa-file-invoice mr-2" aria-hidden="true"></i>Measurements
                                            </a>

                                            <form action="{{ route('profile-job-rates.show', $quote->id) }}" method="GET">
                                                <input type="hidden" name="selected_quote_id" value="{{ $quote->id }}">
                                                <button class="btn btn-primary btn-sm mr-2" type="submit">
                                                    <i class="fas fa-dollar-sign mr-2" aria-hidden="true"></i>Rates
                                                </button>
                                            </form>

                                            @if ($quote->allow_early_receipt == 1)
                                                @if ($quote->getRemainingBalance() != 0)
                                                    {{-- paid --}}
                                                    <a class="btn btn-dark btn-sm mr-2" href="{{ route('download-pre-receipt.create', ['selected_quote_id' => $quote->id]) }}">
                                                        <i class="fas fa-download mr-2" aria-hidden="true"></i>Download Pre-Receipt
                                                    </a>
                                                @endif
                                            @endif

                                            @if ($quote->allow_accept_card_payment == 1)
                                                @if ($quote->getRemainingBalance() != 0)
                                                    {{-- paid --}}
                                                    <a class="btn btn-success btn-sm mr-2" href="{{ route('tradesperson-accept-card-payment.index', ['selected_quote' => $quote->id]) }}">
                                                        <i class="fab fa-cc-stripe mr-2" aria-hidden="true"></i>Take Card Payment
                                                    </a>
                                                @endif
                                            @endif

                                        </div> {{-- btn-group --}}
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
        $(function() {
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
