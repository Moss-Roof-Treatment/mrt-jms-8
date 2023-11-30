@extends('layouts.profile')

@section('title', '- Jobs - View Selected Job')

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
        <a href="{{ route('profile-jobs.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>My Jobs Menu
        </a>
      </div> {{-- col mb-3 --}}
      <div class="col mb-3">
        <a href="{{ route('profile-jobs-swms.show', $selected_quote->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-clipboard-list mr-2" aria-hidden="true"></i>SWMS 
        </a>
      </div> {{-- col mb-3 --}}
      <div class="col mb-3">
        <a href="{{ route('profile-job-completed.index', ['selected_quote_id' => $selected_quote->id]) }}" class="btn btn-dark btn-block">
          <i class="fas fa-check mr-2" aria-hidden="true"></i>Work Completed 
        </a>
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
            <select name="progress_id" class="custom-select @error('progress_id') is-invalid @enderror">
              @if (!$selected_quote->job->job_progress_id == null)
                <option value="{{ $selected_quote->job->job_progress_id }}">{{ $selected_quote->job->job_progress->title }}</option>
              @endif
              <option disabled>Please select a job progress</option>
              @foreach ($job_progresses as $job_progress)
                <option value="{{ $job_progress->id }}" @if ($job_progress->id == $selected_quote->job->job_progress_id) hidden @endif>{{ $job_progress->title }}</option>
              @endforeach
            </select>
            <div class="input-group-append">
              <button class="btn btn-dark" type="submit" id="progress_id_button"><i class="fas fa-edit"></i></button>
            </div> {{-- form-control --}}
          </div> {{-- input-group mb-3 --}}
        </form>
      </div> {{-- col-sm-3 --}}
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
                  <td>{{ $selected_quote->customer->email }}</td>
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
                      @if ($selected_quote->job->has('job_types'))
                        @foreach ($selected_quote->job->job_types as $job_type)
                          <span class="badge badge-dark py-2 px-2">
                            <i class="fas fa-tools mr-2" aria-hidden="true"></i>{{ $job_type->title }}
                          </span>
                        @endforeach
                      @endif
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

            {{-- Internal Notes --}}
            <div class="form-group">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="customCheckNotesExpander" onclick="internalNoteExpander()">
                <label class="custom-control-label" for="customCheckNotesExpander"><b>Internal Notes</b></label>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6 mb-3">
                <a href="{{ route('profile-job-internal-notes.create') }}" class="btn btn-primary btn-block">
                  <i class="fas fa-plus mr-2" aria-hidden="true"></i>New Internal Note
                </a>
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
                        <tr>
                          <td>{{ date('d/m/y', strtotime($internal_note->created_at)) }}</td>
                          <td>
                            {{ substr($internal_note->text, 0, 150) }}{{ strlen($internal_note->text) > 150 ? "..." : "" }}
                          </td>
                          <td nowrap="nowrap">
                            <a href="{{ route('profile-job-internal-notes.show', $internal_note->id) }}" class="btn btn-primary btn-sm">Show</a>
                            <a href="{{ route('profile-job-internal-notes.show', $internal_note->id) }}#reply" class="btn btn-primary btn-sm">Reply</a>
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
                        <tr>
                          <td>{{ date('d/m/y', strtotime($internal_note->created_at)) }}</td>
                          <td>
                            {{ substr($internal_note->text, 0, 150) }}{{ strlen($internal_note->text) > 150 ? "..." : "" }}
                          </td>
                          <td nowrap="nowrap">
                            <a href="{{ route('job-internal-notes.show', $internal_note->id) }}" class="btn btn-primary btn-sm">Show</a>
                            <a href="{{ route('job-internal-notes.show', $internal_note->id) }} #reply" class="btn btn-primary btn-sm">Reply</a>
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
            <a href="{{ route('profile-image-upload.index', ['selected_quote_id' => $selected_quote->id]) }}" class="btn btn-primary btn-block">
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
                <input type="checkbox" class="custom-control-input" id="imageCollection{{$loop->index}}" onclick="toggle_visibility('{{ $collections->first()->job_image_type->title }}');" @if ($loop->last) checked @endif>
                <label class="custom-control-label" for="imageCollection{{$loop->index}}">
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
                      <div class="modal fade" id="image-modal-{{$image->id}}" tabindex="-1" role="dialog" aria-labelledby="image-modal-{{$image->id}}-title" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-body py-0 pl-0 pr-0">
                              @if ($image->image_path == null)
                                <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                              @else
                                <img src="{{ asset($image->image_path) }}" class="img-fluid" alt="image">
                              @endif
                            </div>
                            <div class="modal-body bg-{{$image->colour->brand}}">
                              <h5 class="modal-title text-center text-{{$image->colour->text_brand}}" id="image-modal-{{$image->id}}-title">{{ $image->title }}</h5>
                            </div>
                            <div class="modal-body bg-white">
                              <p class="mt-2">{{ $image->description }}</p>
                            </div>
                            <div class="modal-footer bg-light">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">
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
                <td class="text-center">
                  <a href="{{ route('profile-job-rates.show', $quote->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-dollar-sign mr-2" aria-hidden="true"></i>Rates
                  </a>
                  <a href="{{ route('profile-job-measurements.show', $quote->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-file-invoice mr-2" aria-hidden="true"></i>Measurements
                  </a>
                  @if($quote->allow_accept_card_payment == 1)
                    @if($quote->getRemainingBalance() != 0) {{-- paid --}}
                      <a href="{{ route('tradesperson-accept-card-payment.index', ['selected_quote' => $quote->id]) }}" class="btn btn-success btn-sm mr-2">
                        <i class="fab fa-cc-stripe mr-2" aria-hidden="true"></i>Take Card Payment
                      </a>
                    @endif
                  @endif
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
@endpush