@extends('layouts.jquery')

@section('title', '- Job Notes - View Selected Internal Note')

@push('css')
{{-- bootstrap-select css --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css">
{{-- bootstrap-select css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">JOB INTERNAL NOTES</h3>
    <h5>View Selected Internal Note</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('jobs.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Jobs Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('jobs.show', $selected_note->job_id) }}">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Job
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        {{-- confirm modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-dark btn-block" data-toggle="modal" data-target="#confirm-show-to-customer">
          <i class="fas fa-shield-alt mr-2" aria-hidden="true"></i>Show to Customer
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="confirm-show-to-customer" tabindex="-1" role="dialog" aria-labelledby="confirm-show-to-customer-title" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="confirm-show-to-customer-title">Confirm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center">Are you sure you would like to show this internal job note to the selected customer?</p>
                <form action="{{ route('notes-show-to-customer.update', $selected_note->id) }}" method="POST">
                  @method('PATCH')
                  @csrf
                  {{-- send email to customer input --}}
                  <div class="row">
                    <div class="col-sm-6 offset-sm-3 pb-2">
                      <label class="checkbox">
                        <input type="checkbox" name="notify_customer_via_email">
                        Notify customer via email
                      </label>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-dark btn-block">
                    <i class="fas fa-shield-alt mr-2" aria-hidden="true"></i>Show to Customer
                  </button>
                </form>
              </div> {{-- modal-body --}}
            </div> {{-- modal-content --}}
          </div> {{-- modal-dialog --}}
        </div> {{-- modal fade --}}
        {{-- modal --}}
        {{-- confirm modal --}}
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">

        {{-- show to users modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-dark btn-block" data-toggle="modal" data-target="#confirm-show-to-users">
          <i class="fas fa-shield-alt mr-2" aria-hidden="true"></i>Show to Users
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="confirm-show-to-users" tabindex="-1" role="dialog" aria-labelledby="confirm-show-to-users-title" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="confirm-show-to-users-title">Confirm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div> {{-- modal-header --}}
              <div class="modal-body">
                <p class="title text-center text-dark">Please select which users should see this note.</p>
                <form method="POST" action="{{ route('notes-show-to-users.update', $selected_note->id) }}">
                  @method('PATCH')
                  @csrf

                  <div class="form-group row">
                    <div class="col">
                      <select name="staff_members[]" class="form-control border selectpicker @error('staff_members') is-invalid @enderror mb-2" multiple="multiple" data-style="bg-white" data-live-search="true" data-size="5" data-container="#for-bootstrap-select" title="Please select the staff members">
                        @if (old('staff_members'))
                          @foreach ($all_staff_members as $staff_member)
                            <option value="{{ $staff_member->id }}" class="form-control" @if (in_array($staff_member->id, old('staff_members'))) selected @endif>{{ $staff_member->getFullNameTitleAttribute() }}</option>
                          @endforeach
                        @else
                          @foreach ($all_staff_members as $staff_member)
                            <option value="{{ $staff_member->id }}" class="form-control">{{ $staff_member->getFullNameTitleAttribute() }}</option>
                          @endforeach
                        @endif
                      </select>
                      @error('staff_members')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div> {{-- col --}}
                  </div> {{-- form-group row --}}

                  <button type="submit" class="btn btn-dark btn-block" name="note_type" value="job">
                    <i class="fas fa-shield-alt mr-2" aria-hidden="true"></i>Show to Users
                  </button>
                </form>
              </div> {{-- modal-body --}}
            </div> {{-- modal-content --}}
          </div> {{-- modal-dialog --}}
        </div> {{-- modal fade --}}
        {{-- modal --}}
        {{-- show to users modal --}}

      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <form action="{{ route('notes-allow-trades-to-view.update', $selected_note->id) }}" method="POST">
          @method('PATCH')
          @csrf
            <button type="submit" class="btn {{ $selected_note->profile_job_can_see ? 'btn-success' : 'btn-danger' }} btn-block">
            <i class="fas fa-shield-alt mr-2" aria-hidden="true"></i>Allow Trades To View
          </button>
        </form>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

    {{-- note details table --}}
    <h5 class="text-primary my-3"><b>Note Details</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <thead class="table-secondary">
          <th>Job ID</th>
          <th>Sender</th>
          <th>Recipient</th>
          <th>Priority</th>
          <th>Date</th>
          <th>Type</th>
        </thead>
        <tbody>
          <td>{{ $selected_note->job_id }}</td>
          <td>
            @if ($selected_note->sender_id == null)
              <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
            @else
              {{ $selected_note->sender->getFullNameAttribute() }}
            @endif
          </td>
          <td>
            @if ($selected_note->recipient_id == null)
              <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
            @else
              {{ $selected_note->recipient->getFullNameAttribute() }}
            @endif    
          </td>
          <td class="text-center">
            @if ($selected_note->priority_id == null)
              <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
            @else
              <span class="badge badge-{{ $selected_note->priority->colour->brand }} py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>{{ $selected_note->priority->title . ' (' . $selected_note->priority->resolution_amount . ' ' . $selected_note->priority->resolution_period . ')' }}</span>
            @endif
          </td>
          <td>{{ date('d/m/y h:iA', strtotime($selected_note->created_at)) . ' (' . $selected_note->created_at->diffForHumans() . ')' }}</td>
          <td class="text-center"><span class="badge badge-danger py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>Internal</span></td>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- note details table --}}

    {{-- note message --}}
    <h5 class="text-primary my-3"><b>Message</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <tbody>
          <tr>
            <td>{{ $selected_note->text }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- note message --}}

    {{-- note response form --}}
    @if ($selected_note->sender_id != null)
      <a name="note-response-form"></a>
      <form action="{{ route('job-internal-note-response.store') }}" method="POST">
        @csrf

        <input type="hidden" name="note_id" value="{{ $selected_note->id }}">

        <div class="form-group row">
          <div class="col">
            <textarea class="form-control @error('text') is-invalid @enderror mb-2" type="text" name="text" rows="5" id="note-response-form" placeholder="Please enter your response" style="resize:none">{{ old('text') }}</textarea>
            @error('text')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div> {{-- col --}}
        </div> {{-- form-group row --}}

        <div class="form-group row">
          <div class="col">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-reply mr-2" aria-hidden="true"></i>Reply
            </button>
          </div> {{-- col --}}
        </div> {{-- form-group row --}}

      </form>
    @endif
    {{-- note response form --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- bootstrap-select js --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/js/bootstrap-select.min.js"></script>
{{-- bootstrap-select js --}}
@endpush