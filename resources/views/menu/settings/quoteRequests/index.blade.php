@extends('layouts.app')

@section('title', '- Quote Request Status - View All Quote Request Statuses')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">QUOTE REQUEST STATUS</h3>
    <h5>View All Quote Request Statuses</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    {{-- quote request status table --}}
    <p class="text-primary my-3"><b>All Quote Request Statuses</b></p>
    @if (!$all_quote_rrequest_statuses->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no quote request statuses to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_quote_rrequest_statuses as $quote_rrequest_status)
              <tr>
                <td>{{ $quote_rrequest_status->id }}</td>
                <td>{{ $quote_rrequest_status->title }}</td>
                <td>
                  @if ($quote_rrequest_status->description == null)
                    <span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>The description has not been set</span>
                  @else
                    {{ $quote_rrequest_status->description }}
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- quote request status table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection