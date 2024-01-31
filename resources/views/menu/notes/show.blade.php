@extends('layouts.jquery')

@section('title', 'Notes - View Selected Note')

@push('css')
{{-- bootstrap-select css --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css">
{{-- bootstrap-select css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">NOTES</h3>
    <h5>View Selected Note</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">

      <div class="col pb-3">
        <a href="{{ route('notes.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Notes Menu
        </a>
      </div> {{-- col pb-3 --}}

      @if ($selected_note->job_id != null)
        <div class="col pb-3">
          <a class="btn btn-primary btn-block" href="{{ route('jobs.show', $selected_note->job_id) }}">
            <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Job
          </a>
        </div> {{-- col pb-3 --}}
      @endif

      @if ($selected_note->event_id != null)
        <div class="col pb-3">
          <a class="btn btn-primary btn-block" href="{{ route('calendar.show', $selected_note->event_id) }}">
            <i class="fas fa-calendar-alt mr-2" aria-hidden="true"></i>View Event
          </a>
        </div> {{-- col pb-3 --}}
      @endif

      @if ($selected_note->equipment_id != null)
        <div class="col pb-3">
          <a class="btn btn-primary btn-block" href="{{ route('equipment-items.show', $selected_note->equipment_id) }}">
            <i class="fas fa-tools mr-2" aria-hidden="true"></i>View Equipment
          </a>
        </div> {{-- col pb-3 --}}
      @endif

      <div class="col pb-3">
        @if ($selected_note->recipient_id != null)
          <form action="{{ route('notes-mark-as-recipient-read.update', $selected_note->id) }}" method="POST">
            @method('PATCH')
            @csrf
            @if ($selected_note->recipient_seen_at == null)
              <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-marker mr-2" aria-hidden="true"></i>Mark as Read
              </button>
            @else
              <button type="submit" class="btn btn-primary btn-block" disabled>
                <i class="fas fa-marker mr-2" aria-hidden="true"></i>Mark as Read
              </button>
            @endif
          </form>
        @endif
      </div> {{-- col pb-3 --}}

      <div class="col pb-3">
        {{-- acknowledge modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#confirmAcknowledgement">
          @if ($selected_note->jms_acknowledged_at == null)
            <i class="fas fa-check-circle mr-2" aria-hidden="true"></i>Acknowledge Note
          @else
            <i class="fas fa-times-circle mr-2" aria-hidden="true"></i>Un-Acknowledge Note
          @endif
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="confirmAcknowledgement" tabindex="-1" role="dialog" aria-labelledby="confirmAcknowledgementTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="confirmAcknowledgementTitle">Confirm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div> {{-- modal-header --}}
              <div class="modal-body">
                @if ($selected_note->jms_acknowledged_at == null)
                  <p class="title text-center text-dark">Confirm Acknowledgement</p>
                  <p class="subtitle text-center">Are you sure that you would like to acknowledge the selected note...?</p>
                @else
                  <p class="title text-center text-dark">Confirm Unacknowledgement</p>
                  <p class="subtitle text-center">Are you sure that you would like to un-acknowledge the selected note...?</p>
                @endif
                <form method="POST" action="{{ route('notes.update', $selected_note->id) }}">
                  @method('PATCH')
                  @csrf
                  <button type="submit" class="btn btn-dark btn-block" name="note_type" value="job">
                    @if ($selected_note->jms_acknowledged_at == null)
                      <i class="fas fa-check-circle mr-2" aria-hidden="true"></i>Acknowledge Note
                    @else
                      <i class="fas fa-times-circle mr-2" aria-hidden="true"></i>Un-Acknowledge Note
                    @endif
                  </button>
                </form>
              </div> {{-- modal-body --}}
            </div> {{-- modal-content --}}
          </div> {{-- modal-dialog --}}
        </div> {{-- modal fade --}}
        {{-- modal --}}
        {{-- acknowledge modal --}}
      </div> {{-- col pb-3 --}}

      @if ($selected_note->job_id != null)
        <div class="col pb-3">
          {{-- show to customer modal --}}
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
          {{-- show to customer modal --}}
        </div> {{-- col pb-3 --}}
      @endif

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

      <div class="col pb-3">
        {{-- trash modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#newTrashModal{{$selected_note->id}}">
          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Trash
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="newTrashModal{{$selected_note->id}}" tabindex="-1" role="dialog" aria-labelledby="newTrashModal{{$selected_note->id}}Title" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="newTrashModal{{$selected_note->id}}Title">Confirm Trash</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center">Are you sure that you would like to trash the selected item?</p>
                <form action="{{ route('notes.destroy', $selected_note->id) }}" method="POST">
                  @method('DELETE')
                  @csrf
                  <button type="submit" class="btn btn-danger btn-block">
                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Confirm Trash
                  </button>
                </form>
              </div> {{-- modal-body --}}
            </div> {{-- modal-content --}}
          </div> {{-- modal-dialog --}}
        </div> {{-- modal fade --}}
        {{-- modal --}}
        {{-- trash modal --}}
      </div> {{-- col pb-3 --}}

    </div> {{-- row row-cols-1 row-cols-sm-2 row-cols-md-4 --}}
    {{-- navigation --}}

    {{-- note details table --}}
    <h5 class="text-primary my-3"><b>Note Details</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-fullwidth bg-white text-nowrap">
        <thead class="table-secondary">
          <th>Sender</th>
          <th>Recipient</th>
          <th>Priority</th>
          <th>Created At</th>
          <th>Type</th>
        </thead>
        <tbody>
          <td>
            @if ($selected_note->sender_id == null)
              <span class="badge badge-light py-2 px-2">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
              </span>
            @else
              {{ $selected_note->sender->getFullNameAttribute() }}
            @endif
          </td>
          <td>
            @if ($selected_note->recipient_id == null)
              <span class="badge badge-light py-2 px-2">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
              </span>
            @else
              {{ $selected_note->recipient->getFullNameAttribute() }}
              @if ($selected_note->recipient_seen_at == null)
                <div class="badge badge-danger py-2 px-2 ml-2">
                  <i class="fas fa-eye-slash" aria-hidden="true"></i>
                </div>
              @else
                <div class="badge badge-success py-2 px-2 ml-2">
                  <i class="fas fa-eye" aria-hidden="true"></i>
                </div>
              @endif
            @endif
          </td>
          <td class="text-center">
            @if ($selected_note->priority_id == null)
              <span class="badge badge-light py-2 px-2">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
              </span>
            @else
              <span class="badge badge-{{ $selected_note->priority->colour->brand }} py-2 px-2">
                <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>
                {{ $selected_note->priority->title . ' (' . $selected_note->priority->resolution_amount . ' ' . $selected_note->priority->resolution_period . ')' }}
              </span>
            @endif
          </td>
          <td>{{ date('d/m/y - h:iA', strtotime($selected_note->created_at)) . ' (' . $selected_note->created_at->diffForHumans() . ')' }}</td>
          <td class="text-center">
            @if ($selected_note->is_internal == 0)
              <span class="badge badge-success py-2 px-2"><i class="fas fa-check mr-2" aria-hidden="true"></i>Customer</span>
            @else
              <span class="badge badge-danger py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>Internal</span>
            @endif
          </td>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- note details table --}}

    {{-- note message --}}
    <h5 class="text-primary my-3"><b>Message</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-fullwidth bg-white">
        <tbody>
          <tr>
            <td>{{ $selected_note->text }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- note message --}}

    {{-- note response form --}}
    <form action="{{ route('note-responses.store') }}" method="POST">
      @csrf

      <input type="hidden" name="note_id" value="{{ $selected_note->id }}">

      <div class="form-group row">
        <div class="col-md-12">
          <textarea class="form-control @error('text') is-invalid @enderror mb-2" type="text" name="text" rows="5" placeholder="Please enter the response" style="resize:none">{{ old('text') }}</textarea>
          @error('text')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div> {{-- col-md-8 --}}
      </div> {{-- form-group row --}}

      <div class="form-group row mb-0">
        <div class="col">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-reply mr-2" aria-hidden="true"></i>Reply
          </button>
        </div> {{-- col --}}
      </div> {{-- form-group row mb-0 --}}

    </form>
    {{-- note response form --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- bootstrap-select js --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/js/bootstrap-select.min.js"></script>
{{-- bootstrap-select js --}}
@endpush
