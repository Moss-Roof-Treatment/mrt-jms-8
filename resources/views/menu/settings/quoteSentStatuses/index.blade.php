@extends('layouts.app')

@section('title', '- Quote Sent Statuses - View All Quote Sent Statuses')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">QUOTE SENT STATUSES</h3>
    <h5>View All Quote Sent Statuses</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a href="{{ route('quote-sent-status-settings.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Quote Sent Status
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    {{-- quote sent statuses table --}}
    <p class="text-primary my-3"><b>All Quote Sent Statuses</b></p>
    @if (!$all_quote_sent_statuses->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no quote sent statuses to display</h5>
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
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_quote_sent_statuses as $quote_sent_status)
              <tr>
                <td>{{ $quote_sent_status->id }}</td>
                <td>{{ $quote_sent_status->title }}</td>
                <td>
                  {{ substr($quote_sent_status->description, 0, 70) }}{{ strlen($quote_sent_status->description) > 70 ? "..." : "" }}
                </td>
                <td class="text-center">
                  @if ($quote_sent_status->is_editable == 0)
                    <a href="#" class="btn btn-primary btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">
                      <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                    </a>
                  @else
                    <a href="{{ route('quote-sent-status-settings.edit', $quote_sent_status->id) }}" class="btn btn-primary btn-sm">
                      <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                    </a>
                  @endif
                  @if ($quote_sent_status->is_delible == 0)
                    <a href="#" class="btn btn-danger btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                    </a>
                  @else
                    {{-- delete modal --}}
                    {{-- modal button --}}
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{$quote_sent_status->id}}">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                    </button>
                    {{-- modal button --}}
                    {{-- modal --}}
                    <div class="modal fade" id="deleteModal{{$quote_sent_status->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{$quote_sent_status->id}}Title" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteModal{{$quote_sent_status->id}}Title">Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p class="text-center">Are you sure that you would like to delete this item?</p>
                            <form method="POST" action="{{ route('quote-sent-status-settings.destroy', $quote_sent_status->id) }}">
                              @method('DELETE')
                              @csrf
                              <button type="submit" class="btn btn-danger btn-block">
                                <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                              </button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    {{-- modal --}}
                    {{-- delete modal --}}
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- quote sent statuses table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection