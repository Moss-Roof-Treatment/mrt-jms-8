@extends('layouts.app')

@section('title', '- Settings - Follow Up Call Statuses - View All Follow Up Call Statuses')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">FOLLOW UP CALL STATUSES</h3>
    <h5>View All Follow Up Call Statuses</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('settings.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('follow-up-call-settings.create') }}">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Status
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    {{-- follow up call statuses table --}}
    <p class="text-primary my-3"><b>All Follow Up Call Statuses</b></p>
    @if (!$all_follow_up_call_statuses->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no follow up call statuses to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th width="40%">Descrition</th>
              <th>Colour</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_follow_up_call_statuses as $follow_up_call_status)
              <tr>
                <td>{{ $follow_up_call_status->id }}</td>
                <td>{{ $follow_up_call_status->title }}</td>
                <td>
                  @if ($follow_up_call_status->description == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ $follow_up_call_status->description }}
                  @endif
                </td>
                <td>
                  <i class="fas fa-square-full mr-2 border border-dark" style="color:{{ $follow_up_call_status->colour->colour }};"></i>
                  {{ $follow_up_call_status->colour->title }}
                </td>
                <td class="text-center text-nowrap">
                  <a href="{{ route('follow-up-call-settings.edit', $follow_up_call_status->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- follow up call statuses table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection