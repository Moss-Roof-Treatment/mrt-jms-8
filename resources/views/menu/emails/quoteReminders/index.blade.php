@extends('layouts.jquery')

@section('title', '- Quote Reminder Emails - View All Quote Reminder Emails')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
  <div class="container-fluid py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">QUOTE REMINDER</h3>
    <h5>View All Quote Reminder Recipients</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-6 pt-3">
      <div class="col pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('emails.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Emails Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a class="btn btn-warning btn-block" href="{{ route('send-quote-reminder-emails.index') }}">
          <i class="fas fa-paper-plane mr-2" aria-hidden="true"></i>Send Reminder Emails
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- quote reminders table --}}
    <h5 class="text-primary my-3"><b>All Quote Reminder Recipients</b></h5>
    @if ($all_quotes->isEmpty())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no quote reminder recipients to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive mt-3">
        <table id="datatable" class="table table-bordered table-fullwidth table-striped bg-white" style="width:100%">
          <thead class="table-secondary">
            <tr>
              <th></th>
              <th>Quote</th>
              <th>Email</th>
              <th>Send Count</th>
              <th>Sent Date</th>
              <th>Response Date</th>
              <th>Response</th>
              <th>Options</th>
              <th>Follow Up Call Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_quotes as $quote)
              <tr>
                <td class="text-center">
                  <form action="{{ route('quote-reminder-emails.update', $quote->id) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    @if ($quote->is_sendable == 1)
                      <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-check" aria-hidden="true"></i>
                      </button>
                    @else
                      <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-times" aria-hidden="true"></i>
                      </button>
                    @endif
                  </form>
                </td>
                <td><a href="{{ route('jobs.show', $quote->job_id) }}">{{ $quote->quote_identifier }}</a></td>
                <td>{{ $quote->customer->email }}</td>
                <td>{{ $quote->sent_quote_reminders->count() }}</td>
                <td>
                  @if (!$quote->sent_quote_reminders->count())
                    <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
                  @else
                    {{ date('d-m-Y - h:iA', strtotime($quote->sent_quote_reminders->first->latest()->created_at)) }}
                  @endif
                </td>
                <td>
                  @if ($quote->quote_reminder_response == null)
                    <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
                  @else
                    {{ date('d-m-Y - h:iA', strtotime($quote->quote_reminder_response->updated_at)) }}
                  @endif
                </td>
                <td>
                  @if ($quote->quote_reminder_response == null)
                    <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
                  @else
                    @if ($quote->quote_reminder_response->is_acknowledged == 0)
                      <b>{!! $quote->quote_reminder_response->reminder_response_status->title !!}</b>
                    @else
                      {!! $quote->quote_reminder_response->reminder_response_status->title !!}
                    @endif
                  @endif
                </td>
                <td>
                  <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group mr-2" role="group" aria-label="First group">

                      {{-- reset --}}
                      <form action="{{ route('quote-reminder-emails-response.update', $quote->id) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        @if ($quote->quote_reminder_response)
                          <button type="submit" class="btn btn-primary btn-sm" name="action" value="reset">Reset</button>
                        @else
                          <button type="submit" class="btn btn-primary btn-sm" name="action" value="waiting">Waiting</button>
                        @endif
                      </form>
                      {{-- reset --}}

                    </div> {{-- btn-group --}}
                    <div class="btn-group mr-2" role="group" aria-label="Second group">

                      {{-- contact --}}
                      <form action="{{ route('quote-reminder-emails-contact.update', $quote->id) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        @if ($quote->quote_reminder_response)
                          @if ($quote->quote_reminder_response->reminder_response_status_id == 4) {{-- contact --}}
                            <button type="submit" class="btn btn-primary btn-sm" name="action" value="contacted">Contacted</button>
                          @elseif ($quote->quote_reminder_response->reminder_response_status_id == 5) {{-- contacted --}}
                            <button type="submit" class="btn btn-primary btn-sm" name="action" value="waiting">Waiting</button>
                          @else
                            <button type="submit" class="btn btn-primary btn-sm" name="action" value="contact">Contact</button>
                          @endif
                        @else
                          <button type="submit" class="btn btn-primary btn-sm" name="action" value="contact">Contact</button>
                        @endif
                      </form>
                      {{-- contact --}}

                    </div> {{-- btn-group --}}
                    <div class="btn-group mr-2" role="group" aria-label="Third group">

                      {{-- delete modal --}}
                      {{-- modal button --}}
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailsModal{{$quote->id}}">
                        Details
                      </button>
                      {{-- modal button --}}
                      {{-- modal --}}
                      <div class="modal fade" id="detailsModal{{$quote->id}}" tabindex="-1" role="dialog" aria-labelledby="detailsModal{{$quote->id}}Title" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="detailsModal{{$quote->id}}Title">Details</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">

                              <div class="row">
                                <div class="col-4">
                                  <p><b>Selected Response</b></p>
                                </div>
                                <div class="col-8">
                                  @if ($quote->quote_reminder_response == null)
                                    <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
                                  @else
                                    @if ($quote->quote_reminder_response->default_response == null)
                                      <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
                                    @else
                                      <p>{{ $quote->quote_reminder_response->default_response }}</p>
                                    @endif
                                  @endif
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-4">
                                  <p><b>Additional Text</b></p>
                                </div>
                                <div class="col-8">
                                  @if ($quote->quote_reminder_response == null)
                                    <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
                                  @else
                                    @if ($quote->quote_reminder_response->additional_text == null)
                                      <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
                                    @else
                                      <p>{{ $quote->quote_reminder_response->additional_text }}</p>
                                    @endif
                                  @endif
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-4">
                                  <p><b>Sent Reminders</b></p>
                                </div>
                                <div class="col-8">
                                  @if (!$quote->sent_quote_reminders->count())
                                    <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
                                  @else
                                    @foreach ($quote->sent_quote_reminders as $sent_quote_reminder)
                                      <p>{{ $loop->iteration . ') ' . date('d-m-Y - h:iA', strtotime($sent_quote_reminder->created_at)) }}</p>
                                    @endforeach
                                  @endif
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>
                      </div>
                      {{-- modal --}}
                      {{-- delete modal --}}

                    </div> {{-- btn-group --}}
                    <div class="btn-group" role="group" aria-label="Fourth group">

                      {{-- reset --}}
                      <form action="{{ route('ack-email-reminder-response.update', $quote->id) }}" method="POST">
                        @method('PATCH')
                        @csrf
                          <button type="submit" class="btn btn-primary btn-sm" name="action" value="waiting">Acknowledge</button>
                      </form>
                      {{-- reset --}}

                    </div> {{-- btn-group --}}
                  </div> {{-- btn-toolbar --}}
                </td>
                <td>
                  <i class="fas fa-square-full border border-dark mr-2" style="color:{{ $quote->job->follow_up_call_status->colour->colour}};"></i>{{ $quote->job->follow_up_call_status->title }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- quote reminders table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- jquery datatables js --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function() {
    $('#datatable').DataTable({
      "info": true, {{-- Show the page info --}}
      "lengthChange": true, {{-- Show results length --}}
      "ordering": true, {{-- Allow ordering of all columns --}}
      "paging": true, {{-- Show pagination --}}
      "processing": true, {{-- Show processing message on long load time --}}
      "searching": true, {{-- Search for results --}}
      order: [[ 6, "desc" ]],
      pageLength: 100,
      columnDefs: [
        {targets: 0, orderable: false, className: "text-center"},
        {targets: 7, orderable: false},
      ],
    });
  });
</script>
{{-- jquery datatables js --}}
@endpush