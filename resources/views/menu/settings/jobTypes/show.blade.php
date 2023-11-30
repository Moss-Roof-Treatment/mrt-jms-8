@extends('layouts.app')

@section('title', '- Job Types - View Selected Job Type')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">JOB TYPES</h3>
    <h5>View Selected Job Type</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('job-type-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Job Types Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <p class="text-primary my-3"><b>Job Type Details</b></p>

    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <thead class="table-secondary">
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Total Job Count</th>
            <th>Default Cost</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $selected_job_type->id }}</td>
            <td>{{ $selected_job_type->title }}</td>
            <td>{{ $selected_job_type->jobs->count() }}</td>
            <td>${{ number_format(($selected_job_type->default_price / 100), 2, '.', ',') }}</td>
          </tr>        
        </tbody>
      </table>
    </div> {{-- table-responsive --}}

    <p class="text-primary my-3"><b>Job Type Description</b></p>
    <div class="card">
      <div class="card-body">
        {{ $selected_job_type->description }}
      </div> {{-- card-body --}}
    </div> {{-- card --}}

    <p class="text-primary my-3"><b>Job Type Procedure</b></p>
    <div class="card">
      <div class="card-body">
        {{ $selected_job_type->procedure }}
      </div> {{-- card-body --}}
    </div> {{-- card --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection