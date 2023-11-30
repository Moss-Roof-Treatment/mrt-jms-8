@extends('layouts.app')

@section('title', '- Systems - View Selected Job Note')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SITE CONTACTS</h3>
    <h5>View Selected Trashed Site Contacts</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('site-contacts-trashed.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Trashed Site Contacts Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        {{-- permenent delete modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-dark btn-block" data-toggle="modal" data-target="#restoreModal">
          <i class="fas fa-trash-restore mr-2" aria-hidden="true"></i>Restore
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="restoreModal" tabindex="-1" role="dialog" aria-labelledby="restoreModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="restoreModalTitle">Restore</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="subtitle text-center">Are you sure you would like to restore this item...?</p>
                <form method="POST" action="{{ route('site-contacts-trashed.update', $trashed_site_contact->id) }}">
                  @method('PATCH')
                  @csrf
                  <button type="submit" class="btn btn-dark btn-block">
                    <i class="fas fa-trash-restore mr-2" aria-hidden="true"></i>Restore
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
        {{-- modal --}}
        {{-- permenent delete modal --}}
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        {{-- permenent delete modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#permenentDeleteModal">
          <i class="fas fa-dumpster mr-2" aria-hidden="true"></i>Permanently Delete
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="permenentDeleteModal" tabindex="-1" role="dialog" aria-labelledby="permenentDeleteModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="permenentDeleteModalTitle">Permanently Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center">Are you sure you would like to permanently delete this item...?</p>
                <form method="POST" action="{{ route('site-contacts-trashed.destroy', $trashed_site_contact->id) }}">
                  @method('DELETE')
                  @csrf
                  <button type="submit" class="btn btn-danger btn-block">
                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Permanent Delete
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
        {{-- modal --}}
        {{-- permenent delete modal --}}
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- message contact details table --}}
    <h5 class="text-primary my-3"><b>Message Details</b></h5>
    <div class="table-responsive">
    <table class="table table-bordered table-fullwidth table-striped bg-white text-nowrap">
      <thead class="table-secondary">
        <tr>
          <th>Sender Name</th>
          <th>Date Received</th>
          <th>Response Date</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ $trashed_site_contact->name }}</td>
          <td>{{ date('d/m/y - h:iA', strtotime($trashed_site_contact->created_at)) . ' (' . $trashed_site_contact->created_at->diffForHumans() . ')' }}</td>
          <td>
            @if (!$trashed_site_contact->responses->count())
              <span class="badge badge-warning py-2 px-2">
                <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>Is Pending Response
              </span>
            @else
              {{ date('d/m/y h:iA', strtotime($trashed_site_contact->responses->first()->created_at)) . ' (' . $trashed_site_contact->responses->first()->created_at->diffForHumans() . ')' }}
            @endif
          </td>
        </tr>
      </tbody>
    </table>
    </div> {{-- table-responsive --}}
    {{-- message contact details table --}}

    {{-- message details table --}}
    <p class="text-primary my-3"><b>Contact Details</b></p>
    <div class="table-responsive">
    <table class="table table-bordered table-fullwidth table-striped bg-white text-nowrap">
      <thead class="table-secondary">
        <tr>
          <th>Email</th>
          <th>Phone</th>
          <th>Street Address</th>
          <th>Suburb</th>
          <th>Postcode</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            @if (!$trashed_site_contact->email)
              <span class="badge badge-light py-2 px-2">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
              </span>
            @else
              {{ $trashed_site_contact->email }}
            @endif
          </td>
          <td>
            @if (!$trashed_site_contact->contact_phone)
              <span class="badge badge-light py-2 px-2">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
              </span>
            @else
              {{ $trashed_site_contact->contact_phone }}
            @endif
          </td>
          <td>
            @if (!$trashed_site_contact->street_address)
              <span class="badge badge-light py-2 px-2">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
              </span>
            @else
              {{ $trashed_site_contact->street_address }}
            @endif
          </td>
          <td>
            @if (!$trashed_site_contact->suburb)
              <span class="badge badge-light py-2 px-2">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
              </span>
            @else
              {{ $trashed_site_contact->suburb }}
            @endif
          </td>
          <td>
            @if (!$trashed_site_contact->postcode)
              <span class="badge badge-light py-2 px-2">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
              </span>
            @else
              {{ $trashed_site_contact->postcode }}
            @endif
          </td>
        </tr>
      </tbody>
    </table>
    </div> {{-- table-responsive --}}
    {{-- message details table --}}

    {{-- device details table --}}
    <p class="text-primary my-3"><b>Device Details</b></p>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white text-nowrap">
        <thead class="table-secondary">
          <th>IP Address</th>
          <th>Referrer</th>
          <th>User Agent</th>
        </thead>
        <tbody>
          <tr>
            <td>{{ $trashed_site_contact->ip_address }}</td>
            <td>{{ $trashed_site_contact->referrer }}</td>
            <td>{{ $trashed_site_contact->user_agent }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- device details table --}}

    {{-- message --}}
    <p class="text-primary my-3"><b>Message</b></p>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <tbody>
          <tr>
            <td>{{ $trashed_site_contact->text }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- message --}}

    {{-- message responses --}}
    @if ($trashed_site_contact->responses->count())
      <p class="text-primary my-3"><b>Responses</b></p>
      @foreach ($trashed_site_contact->responses as $reply)
        <div class="card">
          <div class="card-body">
            <p>
              <i class="fas fa-user mr-2" aria-hidden="true"></i>
              <span class="mr-2">{{ $reply->staff->getFullNameAttribute() }}</span>
              <i class="fas fa-calendar-alt mr-2" aria-hidden="true"></i>{{ date('d/m/y - h:iA', strtotime($reply->created_at)) . ' (' . $reply->created_at->diffForHumans() . ')' }}
            </p>
            <p>{{ $reply->text }}</p>
          </div> {{-- card-body --}}
        </div> {{-- card --}}
      @endforeach
    @endif
    {{-- message responses --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection