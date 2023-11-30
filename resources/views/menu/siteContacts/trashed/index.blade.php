@extends('layouts.app')

@section('title', '- View All Trashed Site Contacts')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SITE CONTACTS</h3>
    <h5>View All Trashed Site Contacts</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('site-contacts.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>View Site Contacts Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        {{-- permenent delete modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#permenentDeleteModal">
          <i class="fas fa-dumpster mr-2" aria-hidden="true"></i>Permanently Delete All
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="permenentDeleteModal" tabindex="-1" role="dialog" aria-labelledby="permenentDeleteModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="permenentDeleteModalTitle">Permanently Delete All</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center">Are you sure you would like to permanently delete all items?</p>
                <a class="btn btn-danger btn-block" href="{{ route('site-contacts-trashed-delete-all.index') }}">
                  <i class="fas fa-dumpster mr-2" aria-hidden="true"></i>Permanent Delete
                </a>
              </div>
            </div>
          </div>
        </div>
        {{-- modal --}}
        {{-- permenent delete modal --}}
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <h5 class="text-primary my-3"><b>Trashed Site Contacts</b></h5>
    @if (!$trashed_site_contacts->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no trashed site contacts to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <thead class="table-secondary">
          <tr>
            <th>Name</th>
            <th>Message</th>
            <th>Creation Date</th>
            <th>Trashed Date</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($trashed_site_contacts as $trashed_site_contact)
            <tr>
              <td>{{ $trashed_site_contact->name }}</td>
              <td>
                {{ substr($trashed_site_contact->text, 0, 40) }}{{ strlen($trashed_site_contact->text) > 40 ? "..." : "" }}
              </td>
              <td>{{ date('d/m/y h:iA', strtotime($trashed_site_contact->created_at)) }}</td>
              <td>{{ date('d/m/y h:iA', strtotime($trashed_site_contact->deleted_at)) }}</td>
              <td class="text-center">
                <a href="{{ route('site-contacts-trashed.show', $trashed_site_contact->id) }}" class="btn btn-primary btn-sm">
                  <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                </a>

                {{-- restore modal --}}
                {{-- modal button --}}
                <button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#confirmTrashModal{{$trashed_site_contact->id}}">
                  <i class="fas fa-trash-restore mr-2" aria-hidden="true"></i>Restore
                </button>
                {{-- modal button --}}
                {{-- modal --}}
                <div class="modal fade" id="confirmTrashModal{{$trashed_site_contact->id}}" tabindex="-1" role="dialog" aria-labelledby="confirmTrashModal{{$trashed_site_contact->id}}Title" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="confirmTrashModal{{$trashed_site_contact->id}}Title">Confirm Restore</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p class="text-center">Are you sure that you would like to restore the selected item?</p>
                        <form method="POST" action="{{ route('site-contacts-trashed.update', $trashed_site_contact->id) }}">
                          @method('PATCH')
                          @csrf
                          <button type="submit" class="btn btn-dark btn-block">
                            <i class="fas fa-trash-restore mr-2" aria-hidden="true"></i>Restore
                          </button>
                        </form>
                      </div> {{-- modal-body --}}
                    </div> {{-- modal-content --}}
                  </div> {{-- modal-dialog --}}
                </div> {{-- modal fade --}}
                {{-- modal --}}
                {{-- restore modal --}}

                {{-- permanent delete modal --}}
                {{-- modal button --}}
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#permanentlyDeleteModal{{$trashed_site_contact->id}}">
                  <i class="fas fa-dumpster mr-2" aria-hidden="true"></i>Permanently Delete
                </button>
                {{-- modal button --}}
                {{-- modal --}}
                <div class="modal fade" id="permanentlyDeleteModal{{$trashed_site_contact->id}}" tabindex="-1" role="dialog" aria-labelledby="permanentlyDeleteModal{{$trashed_site_contact->id}}Title" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="permanentlyDeleteModal{{$trashed_site_contact->id}}Title">Permanently Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p class="subtitle text-center">Are you sure you would like to permanently delete the selected item...?</p>
                        <form method="POST" action="{{ route('site-contacts-trashed.destroy', $trashed_site_contact->id) }}">
                          @method('DELETE')
                          @csrf
                          <button type="submit" class="btn btn-danger btn-block">
                            <i class="fas fa-dumpster mr-2" aria-hidden="true"></i>Permanently Delete
                          </button>
                        </form>
                      </div> {{-- modal-body --}}
                    </div> {{-- modal-content --}}
                  </div> {{-- modal-dialog --}}
                </div> {{-- modal fade --}}
                {{-- modal --}}
                {{-- permanent delete modal --}}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection