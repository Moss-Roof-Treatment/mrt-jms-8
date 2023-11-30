@extends('layouts.app')

@section('title', 'Calendar - View Selected Calendar Event')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">CALENDAR</h3>
    <h5>View Selected Calendar Event</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('calendar.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-calendar-alt mr-2" aria-hidden="true"></i>View Calendar
        </a>
      </div> {{-- col pb-3 --}}
      {{-- show job show button if exists --}}
      @if (!$selected_event->job_id == null)
        <div class="col pb-3">
          <a href="{{ route('jobs.show', $selected_event->job_id) }}" class="btn btn-primary btn-block">
            <i class="fas fa-briefcase mr-2" aria-hidden="true"></i>View Job
          </a>
        </div> {{-- col pb-3 --}}
      @endif
      {{-- show job show button if exists --}}
      {{-- show quote show button if exists --}}
      @if (!$selected_event->quote_id == null)
        <div class="col-sm-3 pb-3">
          <a href="{{ route('quotes.show', $selected_event->quote_id) }}" class="btn btn-primary btn-block">
            <i class="fas fa-file-invoice mr-2" aria-hidden="true"></i>View Quote
          </a>
        </div> {{-- col-sm-3 pb-3 --}}
      @endif
      {{-- show quote show button if exists --}}
      <div class="col pb-3">
        <a href="{{ route('calendar.edit', $selected_event->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit Calendar Event
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- event details table --}}
    <h5 class="text-primary my-3"><b>Event Details</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <thead class="table-secondary">
          <tr>
            <th>Title</th>
            <th>Start</th>
            <th>End</th>
            <th>Colour</th>
            <th>Host</th>
            <th>Created By</th>
            <th>Is Personal</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $selected_event->title }}</td>
            <td>{{ date('d/m/y - h:iA', strtotime($selected_event->start)) }}</td>
            <td>{{ date('d/m/y - h:iA', strtotime($selected_event->end)) }}</td>
            <td class="text-center">
              <span class="badge py-2 px-2" style="background-color:{{ $selected_event->color }}; color:{{ $selected_event->textColor }};">
                <i class="fas fa-palette mr-2" aria-hidden="true"></i>{{ $selected_event->color }}
              </span>
            </td>
            <td>
              @if ($selected_event->staff_id == null)
                <span class="badge badge-light py-2 px-2">
                  <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                </span>
              @else
                {{ $selected_event->staff->getFullNameAttribute() }}
              @endif
            </td>
            <td>
              @if ($selected_event->user_id == null)
                <span class="badge badge-light py-2 px-2">
                  <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                </span>
              @else
                {{ $selected_event->user->getFullNameAttribute() }}
              @endif
            </td>
            <td class="text-center">
              @if ($selected_event->is_personal == 0)
                <span class="badge badge-success py-2 px-2 mr-1">
                  <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>Is Not Personal
                </span>
              @else
                <span class="badge badge-danger py-2 px-2 mr-1">
                  <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>Is Personal
                </span>
              @endif
            </td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- event details table --}}

    {{-- event details --}}
    <h5 class="text-primary my-3"><b>Event Description</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <tbody>
          <tr>
            <td>{{ $selected_event->description }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- event details --}}

    {{-- event notes --}}
    <h5 class="text-primary my-3"><b>Event Notes</b></h5>
    @if ($selected_event->notes->count())
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <tbody>
            @foreach ($selected_event->notes as $note)
              <tr>
                <td><i class="fas fa-user mr-2" aria-hidden="true"></i>{{ $note->sender->getFullNameAttribute() }}</td>
                <td class="text-right"><i class="fas fa-calendar-alt mr-2" aria-hidden="true"></i>{{ date('d/m/y h:iA', strtotime($note->created_at)) }}</td>
              </tr>
              <tr>
                <td colspan="2">{{ $note->text }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- event notes --}}

    {{-- event note response form --}}
    <form action="{{ route('event-notes.store') }}" method="POST">
      @csrf

      <input type="hidden" name="event_id" value="{{ $selected_event->id }}">

      <div class="form-group row">
        <div class="col">
          <textarea class="form-control @error('text') is-invalid @enderror" type="text" name="text" rows="5" placeholder="Please enter the note" style="resize:none">{{ old('text') }}</textarea>
          @error('text')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div> {{-- col --}}
      </div> {{-- form-group row --}}

      <div class="form-group row mb-0">
        <div class="col">
          {{-- create button --}}
          <button type="submit" class="btn btn-primary">
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
                  <a href="{{ route('calendar.show', $selected_event->id) }}" class="btn btn-dark btn-block">
                    <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                  </a>
                </div> {{-- modal-body --}}
              </div> {{-- modal-content --}}
            </div> {{-- modal-dialog --}}
          </div> {{-- modal fade --}}
          {{-- modal --}}
          {{-- reset modal --}}
          {{-- cancel button --}}
          <a href="{{ route('calendar.index') }}" class="btn btn-dark">
              <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
          </a>
          {{-- cancel button --}}
        </div> {{-- col --}}
      </div> {{-- form-group row --}}

    </form>
    {{-- create new note form --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection