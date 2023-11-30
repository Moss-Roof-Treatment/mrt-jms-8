@extends('layouts.app')

@section('title', '- Group Emails - View All Group Emails')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">GROUP EMAILS</h3>
    <h5>View All Group Emails</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('emails.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Emails Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('group-emails.create') }}">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Email
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a class="btn btn-danger btn-block" href="{{ route('group-emails-trash.index') }}">
          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>View Trash 
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- sent emails table --}}
    <h5 class="text-primary my-3"><b>Sent Emails</b></h5>
    @if (!$emails->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no emails to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>Subject</th>
              <th>User Group</th>
              <th>Email Template</th>
              <th>Sent Date</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($emails as $email)
              <tr>
                <td>{{ $email->subject }}</td>
                <td>{{ $email->email_user_group->title }}</td>
                <td>{{ $email->email_template->title }}</td>
                <td>{{ date('d/m/y - h:iA', strtotime($email->created_at)) }}</td>
                <td>
                  <a href="{{ route('group-emails.show', $email->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                  {{-- trash modal --}}
                  {{-- modal button --}}
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmTrashModal{{$email->id}}">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Trash
                  </button>
                  {{-- modal button --}}
                  {{-- modal --}}
                  <div class="modal fade" id="confirmTrashModal{{$email->id}}" tabindex="-1" role="dialog" aria-labelledby="confirmTrashModal{{$email->id}}Title" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="confirmTrashModal{{$email->id}}Title">Confirm Trash</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p class="text-center">Are you sure that you would like to trash this item?</p>
                          <form action="{{ route('group-emails.destroy', $email->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-block">
                              <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Confirm Trash
                            </button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  {{-- modal --}}
                  {{-- trash modal --}}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- sent emails table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection