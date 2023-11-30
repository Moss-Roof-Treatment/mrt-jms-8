@extends('layouts.app')

@section('title', '- Group Emails - View All Trashed Group Emails')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">GROUP EMAILS</h3>
    <h5>View All Trashed Group Emails</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('group-emails.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Group Emails Menu
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
                <a class="btn btn-danger btn-block" href="{{ route('group-emails-empty-trash.index') }}" >
                  <i class="fas fa-dumpster mr-2" aria-hidden="true"></i>Permanently Delete
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

    <h5 class="text-primary my-3"><b>Trashed Emails</b></h5>

    @if (!$trashed_emails->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no trashed emails to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>Subject</th>
              <th>User Group</th>
              <th>Deleted Date</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($trashed_emails as $trashed_email)
              <tr>
                <td>{{ $trashed_email->subject }}</td>
                <td>{{ $trashed_email->email_user_group->title }}</td>
                <td>{{ date('d/m/y - h:iA', strtotime($trashed_email->deleted_at)) }}</td>
                <td>
                  <div class="btn-group" role="group">
                    <a href="{{ route('group-emails-trash.show', $trashed_email->id) }}" class="btn btn-primary btn-sm mr-2">
                      <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                    </a>
                    <form action="{{ route('group-emails-trash.update', $trashed_email->id) }}" method="POST">
                      @method('PATCH')
                      @csrf
                      <button type="submit" class="btn btn-dark btn-sm mr-2">
                        <i class="fas fa-trash-restore mr-2" aria-hidden="true"></i>Restore
                      </button>
                    </form>
                    {{-- permenent delete modal --}}
                    {{-- modal button --}}
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#permenentDeleteModal{{ $trashed_email->id }}">
                      <i class="fas fa-dumpster mr-2" aria-hidden="true"></i>Permanently Delete
                    </button>
                    {{-- modal button --}}
                    {{-- modal --}}
                    <div class="modal fade" id="permenentDeleteModal{{ $trashed_email->id }}" tabindex="-1" role="dialog" aria-labelledby="permenentDeleteModal{{ $trashed_email->id }}Title" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="permenentDeleteModal{{ $trashed_email->id }}Title">Permanently Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p class="text-center">Are you sure you would like to permanently delete this item?</p>
                            <form method="POST" action="{{ route('group-emails-trash.destroy', $trashed_email->id) }}">
                              @method('DELETE')
                              @csrf
                              <button type="submit" class="btn btn-danger btn-block">
                              <i class="fas fa-dumpster mr-2" aria-hidden="true"></i>Permanently Delete
                              </button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    {{-- modal --}}
                    {{-- permenent delete modal --}}
                  </div>
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