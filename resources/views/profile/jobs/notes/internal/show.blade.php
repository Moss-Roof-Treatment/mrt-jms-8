@extends('layouts.profile')

@section('title', '- Profile - View Selected Internal Job Note')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">JOB INTERNAL NOTES</h3>
    <h5>View Selected Job Note</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('profile-jobs.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Jobs Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('profile-jobs.show', $selected_quote_id) }}">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Job
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
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
          <td>{{ $job_note->job_id }}</td>
          <td>{{ $job_note->sender->getFullNameAttribute() }}</td>
          <td>
            @if ($job_note->recipient_id == null)
              <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
            @else
              {{ $job_note->recipient->getFullNameAttribute() }}
            @endif    
          </td>
          <td class="text-center">
            @if ($job_note->priority_id == null)
              <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
            @else
              <span class="badge badge-{{ $job_note->priority->colour->brand }} py-2 px-2">
                <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>
                {{ $job_note->priority->title . ' (' . $job_note->priority->resolution_amount . ' ' . $job_note->priority->resolution_period . ')' }}
              </span>
            @endif
          </td>
          <td>{{ date('d/m/y h:iA', strtotime($job_note->created_at)) . ' (' . $job_note->created_at->diffForHumans() . ')' }}</td>
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
            <td>{{ $job_note->text }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- note message --}}

    {{-- note response form --}}
    <form action="{{ route('profile-job-internal-note-r.store') }}" method="POST">
      @csrf

      <input type="hidden" name="note_id" value="{{ $job_note->id }}">

      <div class="form-group row">
        <div class="col">
          <textarea class="form-control @error('text') is-invalid @enderror mb-2" id="response-box" type="text" name="text" rows="5" placeholder="Please enter your response" style="resize:none">{{ old('text') }}</textarea>
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
    {{-- note response form --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection