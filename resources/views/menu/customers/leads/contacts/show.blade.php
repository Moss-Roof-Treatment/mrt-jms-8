@extends('layouts.app')

@section('title', 'Customers - View Selected Customer Lead Contact')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">CUSTOMERS</h3>
    <h5>View Selected Customer Lead Contact</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-6 pt-3">
      <div class="col pb-3">
        <a href="{{ route('leads.show', $selected_lead_contact->lead_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-user mr-2" aria-hidden="true"></i>View Selected Customer Lead
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        {{-- confirm modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModal">
          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="deleteModalTitle">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center">Are you sure that you would like to delete this lead contact?</p>
                <form action="{{ route('lead-contacts.destroy', $selected_lead_contact->id) }}" method="POST">
                  @method('DELETE')
                  @csrf
                  <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
        {{-- modal --}}
        {{-- confirm modal --}}
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-6 pt-3 --}}
    {{-- navigation --}}

    {{-- contact details --}}
    <h5 class="text-primary my-3"><b>Lead Contact Details</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <thead class="table-secondary">
          <tr>
            <th>ID</th>
            <th>Staff Name</th>
            <th>Contact Date</th>
            <th>Requested Call Back Date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $selected_lead_contact->id }}</td>
            <td>{{ $selected_lead_contact->staff->getFullNameAttribute() }}</td>
            <td>{{ date('d/m/y - h:iA', strtotime($selected_lead_contact->created_at)) }}</td>
            <td>
              @if ($selected_lead_contact->call_back_date == null)
                <span class="badge badge-light py-2 px-2">
                  <i class="fas fa-times mr-2" aria-hidden="true"></i>A call back date has not been set
                </span>
              @else
                {{ date('d/m/y - h:iA', strtotime($selected_lead_contact->call_back_date)) }}
              @endif
            </td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}

    <h5 class="text-primary my-3"><b>Lead Contact Note</b></h5>

    <div class="card">
      <div class="card-body pb-0">
        <p>{{ $selected_lead_contact->text }}</p>
      </div> {{-- card-body --}}
    </div> {{-- card --}}
    {{-- contact details --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection