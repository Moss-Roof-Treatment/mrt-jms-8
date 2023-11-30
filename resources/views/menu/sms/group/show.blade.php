@extends('layouts.app')

@section('title', '- SMS - Group SMS - View Selected Group SMS')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">GROUP SMS</h3>
    <h5>View Selected Group SMS</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('group-sms.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Group SMS Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-4">

        <h5 class="text-primary my-3"><b>Group SMS Details</b></h5>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th width="25%">Sent By</th>
                <td>{{ $selected_sms->staff->getFullNameAttribute() }}</td>
              </tr>
              <tr>
                <th>Subject</th>
                <td>{{ $selected_sms->subject }}</td>
              </tr>
              <tr>
                <th>Message</th>
                <td>{{ $selected_sms->text }}</td>
              </tr>
              <tr>
                <th>Template</th>
                <td>{{ $selected_sms->sms_template->title }}</td>
              </tr>
              <tr>
                <th>User Group</th>
                <td>{{ $selected_sms->sms_recipient_group->title }}</td>
              </tr>
              <tr>
                <th>Sent Date</th>
                <td>{{ date('d/m/y - h:iA', strtotime($selected_sms->created_at)) }}</td>
              </tr>
            </tbody>
          </table>
        </div>

      </div> {{-- col-sm-4 --}}
      <div class="col-sm-8">

        <h5 class="text-primary my-3"><b>Group SMS Recipients</b></h5>
        @if (!$selected_sms->sent_group_sms->count())
          <div class="card">
            <div class="card-body text-center">
              <h5>There are no sent sms to display</h5>
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @else
          <div class="table-responsive">
            <table class="table table-bordered table-fullwidth table-striped bg-white">
              <thead class="table-secondary">
                <tr>
                  <th>Customer ID</th>
                  <th>Customer ID</th>
                  <th>SMS</th>
                  <th>Response</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($selected_sms->sent_group_sms as $sent_sms)
                  <tr>
                    <td><a href="{{ route('customers.show', $sent_sms->customer_id) }}">{{ $sent_sms->customer_id }}</a></td>
                    <td>{{ $sent_sms->recipient }}</td>
                    <td class="text-center">
                      @if ($sent_sms->response == null)
                        <span class="badge badge-warning py-2 px-2">
                          <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                        </span>
                      @elseif ($sent_sms->response == 1)
                        <span class="badge badge-success py-2 px-2">
                          <i class="fas fa-check mr-2" aria-hidden="true"></i>Yes
                        </span>
                      @elseif ($sent_sms->response == 0)
                        <span class="badge badge-warning py-2 px-2">
                          <i class="fas fa-times mr-2" aria-hidden="true"></i>No
                        </span>
                      @endif
                    </td>
                    <td class="text-center">
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
                              @if ($sent_sms->response_text == null)
                                <div class="text-center">
                                  <span class="badge badge-warning py-2 px-2">
                                    <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>This group sms is still pending the customer rosponse
                                  </span>
                                </div>
                              @else
                                <p>Date: {{ date('d/m/y - h:iA', strtotime($sent_sms->updated_at)) }}</p>
                                <p>Response: {{ $sent_sms->response_text }}</p>
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

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection