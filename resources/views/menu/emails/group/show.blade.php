@extends('layouts.app')

@section('title', '- Group Emails - View Selected Group Email')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">GROUP EMAILS</h3>
    <h5>View Selected Group Email</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('group-emails.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Group Emails Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
      {{-- trash modal --}}
      {{-- modal button --}}
      <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#confirmTrashModal">
          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Trash
      </button>
      {{-- modal button --}}
      {{-- modal --}}
      <div class="modal fade" id="confirmTrashModal" tabindex="-1" role="dialog" aria-labelledby="confirmTrashModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="confirmTrashModalTitle">Confirm Trash</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p class="text-center">Are you sure that you would like to trash this item?</p>
              <form action="{{ route('group-emails.destroy', $selected_email->id) }}" method="POST">
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
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-4">

        <h5 class="text-primary my-3"><b>Group Email Details</b></h5>

          <div class="table-responsive">
            <table class="table table-bordered table-fullwidth table-striped bg-white">
              <tbody>
                <tr>
                  <th width="25%">Sent By</th>
                  <td>{{ $selected_email->staff->getFullNameAttribute() }}</td>
                </tr>
                <tr>
                  <th>Subject</th>
                  <td>{{ $selected_email->subject }}</td>
                </tr>
                <tr>
                  <th>Message</th>
                  <td>{{ $selected_email->text }}</td>
                </tr>
                <tr>
                  <th>Template</th>
                  <td>{{ $selected_email->email_template->title }}</td>
                </tr>
                <tr>
                  <th>User Group</th>
                  <td>{{ $selected_email->email_user_group->title }}</td>
                </tr>
                <tr>
                  <th>Sent Date</th>
                  <td>{{ date('d/m/y - h:iA', strtotime($selected_email->created_at)) }}</td>
                </tr>
              </tbody>
            </table>
          </div>

      </div> {{-- col-sm-4 --}}
      <div class="col-sm-8">
      
        <h5 class="text-primary my-3"><b>Group Email Recipients</b></h5>

        @if (!$selected_email->sent_group_emails->count())

          <div class="card">
            <div class="card-body text-center">
              <h5>There are no sent emails to display</h5>
            </div> {{-- card-body --}}
          </div> {{-- card --}}

        @else
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <thead class="table-secondary">
              <tr>
                <th>Job ID</th>
                <th>Customer ID</th>
                <th>Email</th>
                <th>Response</th>
                <th>Options</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($selected_email->sent_group_emails as $sent_email)
                <tr>
                  <td>
                    @if ($sent_email->job_id != null)
                      <a href="{{ route('jobs.show', $sent_email->job_id) }}">{{ $sent_email->job_id }}</a>
                    @else
                      <p class="text-center">
                        <span class="badge badge-light py-2 px-2">
                          <i class="fas fa-times mr-2" aria-hidden="true"></i>None
                        </span>
                      </p>
                    @endif
                  </td>
                  <td><a href="{{ route('customers.show', $sent_email->customer_id) }}">{{ $sent_email->customer_id }}</a></td>
                  <td>{{ $sent_email->recipient }}</td>
                  <td>
                    <p class="text-center">
                      @if ($sent_email->response == null)
                        <span class="badge badge-warning py-2 px-2">
                          <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                        </span>
                      @elseif ($sent_email->response == 1)
                        <span class="badge badge-success py-2 px-2">
                          <i class="fas fa-check mr-2" aria-hidden="true"></i>Yes
                        </span>
                      @elseif ($sent_email->response == 0)
                        <span class="badge badge-warning py-2 px-2">
                          <i class="fas fa-times mr-2" aria-hidden="true"></i>No
                        </span>
                      @endif
                    </p>
                  </td>
                  <td>
                    {{-- trash modal --}}
                    {{-- modal button --}}
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailsModal">
                      <i class="fas fa-eye mr-2" aria-hidden="true"></i>Details
                    </button>
                    {{-- modal button --}}
                    {{-- modal --}}
                    <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="detailsModalTitle">Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            @if ($sent_email->response_text == null)
                              <div class="text-center">
                                <span class="badge badge-warning py-2 px-2">
                                  <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>This group email is still pending the customer rosponse
                                </span>
                              </div>
                            @else
                              <p>Date: {{ date('d/m/y - h:iA', strtotime($sent_email->updated_at)) }}</p>
                              <p>Response: {{ $sent_email->response_text }}</p>
                            @endif
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
      </div> {{-- col-sm-8 --}}
    </div> {{-- row --}}

    <h5 class="text-primary my-3"><b>Email Attachments</b></h5>
    @if (!$selected_email->attachments->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no attatchments to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>Title</th>
              <th>Storage Path</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($selected_email->attachments as $attachment)
              <tr>
                <td>{{ $attachment->title }}</td>
                <td>{{ $attachment->storage_path }}</td>
                <td class="text-center">
                  <a href="{{ route('group-emails-download-file.show', $attachment->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-download mr-2" aria-hidden="true"></i>Download
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