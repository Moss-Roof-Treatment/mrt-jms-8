@extends('layouts.app')

@section('title', '- Settings - Customer Leads Statuses - View All Customer Leads Status')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">CUSTOMER LEADS STATUSES</h3>
    <h5>View All Customer Leads Statuses</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('settings.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('customer-lead-statuses.create') }}">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Status
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    {{-- customer leads statuses table --}}
    <p class="text-primary my-3"><b>All Customer Leads Statuses</b></p>
    @if (!$all_lead_statuses->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no customer leads statuses to display</h5>
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
            @foreach ($all_lead_statuses as $lead_status)
              <tr>
                <td>{{ $lead_status->id }}</td>
                <td>{{ $lead_status->title }}</td>
                <td>
                  @if ($lead_status->description == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ $lead_status->description }}
                  @endif
                </td>
                <td>
                  <i class="fas fa-square-full mr-2 border border-dark" style="color:{{ $lead_status->colour->colour }};"></i>
                  {{ $lead_status->colour->title }}
                </td>
                <td class="text-center text-nowrap">
                  <a href="{{ route('customer-lead-statuses.edit', $lead_status->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- customer leads statuses table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection