@extends('layouts.app')

@section('title', '- Quote Reminders - View All Default Email Response Text')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">QUOTE REMINDERS</h3>
    <h5>View All Default Email Response Texts</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('emails.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('default-email-response-text.create') }}">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Default Text
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <p class="text-primary my-3"><b>All Default Email Response Texts</b></p>

    @if (!$all_default_email_response_texts->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no default email response texts to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Text</th>
              <th>Type</th>
              <th>Options</th>
            </tr>
          <thead class="table-secondary">
          <tbody>
            @foreach ($all_default_email_response_texts as $default_email_response_text)
              <tr>
                <td>{{ $default_email_response_text->id }}</td>
                <td>
                  {{ substr($default_email_response_text->text, 0, 100) }}{{ strlen($default_email_response_text->text) > 100 ? "..." : "" }}
                </td>
                <td>
                  @if ($default_email_response_text->type == 0)
                    Waiting
                  @else
                    Do Not Proceed
                  @endif
                </td>
                <td class="text-center">
                  @if ($default_email_response_text->is_editable == 0)
                    <a href="#" class="btn btn-primary btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">
                      <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                    </a>
                  @else
                    <a href="{{ route('default-email-response-text.edit', $default_email_response_text->id) }}" class="btn btn-primary btn-sm">
                      <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                    </a>
                  @endif
                  @if ($default_email_response_text->is_delible == 0)
                    <a href="#" class="btn btn-danger btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                    </a>
                  @else
                    {{-- delete modal --}}
                    {{-- modal button --}}
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{$default_email_response_text->id}}">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                    </button>
                    {{-- modal button --}}
                    {{-- modal --}}
                    <div class="modal fade" id="deleteModal{{$default_email_response_text->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{$default_email_response_text->id}}Title" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteModal{{$default_email_response_text->id}}Title">Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p class="text-center">Are you sure that you would like to delete this item?</p>
                            <form method="POST" action="{{ route('default-email-response-text.destroy', $default_email_response_text->id) }}">
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

    {{ $all_default_email_response_texts->links() }}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection