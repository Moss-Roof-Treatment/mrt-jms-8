@extends('layouts.jquery')

@section('title', '- Systems - View Selected Job Flag')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">JOB FLAGS</h3>
    <h5>View Selected Job Flag</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('jobs.show', $selected_quote_user->quote->job_id) }}">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Job
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- body --}}
    <div class="row">
      <div class="col-sm-6">

        <h5 class="text-primary my-3"><b>Flag Details</b></h5>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>Flag ID</th>
                <td>{{ $selected_quote_user->id }}</td>
              </tr>
              <tr>
                <th>Staff Member</th>
                <td>{{ $selected_quote_user->tradesperson->getFullNameAttribute() }}</td>
              </tr>
              <tr>
                <th>Created At</th>
                <td>{{ date('d/m/y - h:iA', strtotime($selected_quote_user->created_at)) }}</td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}

      </div> {{-- col-sm-6 --}}
      <div class="col-sm-6">

        <h5 class="text-primary my-3"><b>Flag Message</b></h5>
        @if ($selected_quote_user->optional_message == null)
          <div class="card">
            <div class="card-body text-center">
              <h5>There is no message to display</h5>
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @else
          <div class="card">
            <div class="card-body">
              <p class="mb-0">{{ $selected_quote_user->optional_message }}</p>
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @endif
      </div>
    </div> {{-- row --}}
    {{-- body --}}

  </div> {{-- container py-5 --}}
</section> {{-- section --}}
@endsection