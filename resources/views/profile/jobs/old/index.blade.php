@extends('layouts.profile')

@section('title', '- Profile - View All User Jobs')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">MY JOBS</h3>
    <h5>View All completed Jobs</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('main-menu.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Main Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('profile-jobs.index') }}">
          <i class="fas fa-briefcase mr-2" aria-hidden="true"></i>Jobs
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- body --}}
    <h5 class="text-primary my-3"><b>All My Completed Jobs</b></h5>
    @if (!$all_tradespersons_quotes->count())
      <div class="card">
        <div class="card-body text-center">
          <h5>There are no jobs to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Customer</th>
              <th>Suburb</th>
              <th>Job Status</th>
              <th>Job Type</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_tradespersons_quotes as $quote)
              <tr>
                <td>
                  <a href="{{ route('profile-jobs.show', $quote->id) }}">
                    {{ $quote->job_id }}
                  </a>
                </td>
                <td>{{ $quote->customer->getFullNameAttribute() }}</td>
                <td>{{ $quote->job->tenant_suburb . ', ' . $quote->job->tenant_postcode }}</td>
                <td>{{ $quote->job->job_status->title }}</td>
                <td class="text-center">
                  @if ($quote->job_type_id == null)
                    <span class="badge badge-warning py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>No job type has been specified</span>
                  @else
                    <span class="badge badge-dark py-2 px-2">
                      <i class="fas fa-tools mr-2" aria-hidden="true"></i>{{ $quote->job_type->title }}
                    </span>
                  @endif
                </td>
                <td class="text-center">
                  <a href="{{ route('profile-old-jobs.show', $quote->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye" aria-hidden="true"></i>
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection