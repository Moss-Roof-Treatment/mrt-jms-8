@extends('layouts.app')

@section('title', '- Quote Documents - View All Quote Documents')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">QUOTE DOCUMENTS</h3>
    <h5>View All Quote Documents</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a href="{{ route('quote-document-settings.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Quote Document
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <p class="text-primary my-3"><b>All Quote Documents</b></p>
    @if (!$all_quote_documents->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          There are no quote documents to display
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
            @foreach ($all_quote_documents as $quote_document)
              <tr>
                <td>
                  <a href="{{ route('quote-document-settings.show', $quote_document->id) }}">
                    {{ $quote_document->id }}
                  </a>                  
                </td>
                <td>{{ $quote_document->title }}</td>
                <td>
                  {{ substr($quote_document->description, 0, 80) }}{{ strlen($quote_document->description) > 80 ? "..." : "" }}
                </td>
                <td class="text-nowrap">
                  <a href="{{ route('quote-document-settings.show', $quote_document->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                  @if ($quote_document->is_editable == 0)
                    <a href="#" class="btn btn-primary btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">
                      <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                    </a>
                  @else
                    <a href="{{ route('quote-document-settings.edit', $quote_document->id) }}" class="btn btn-primary btn-sm">
                      <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                    </a>
                  @endif
                  @if ($quote_document->is_delible == 0)
                    <a href="#" class="btn btn-danger btn-sm disabled" tabindex="-1" role="button" aria-disabled="true">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                    </a>
                  @else
                    {{-- delete modal --}}
                    {{-- modal button --}}
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{$quote_document->id}}">
                      <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                    </button>
                    {{-- modal button --}}
                    {{-- modal --}}
                    <div class="modal fade" id="deleteModal{{$quote_document->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{$quote_document->id}}Title" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteModal{{$quote_document->id}}Title">Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p class="text-center">Are you sure that you would like to delete this item?</p>
                            <form method="POST" action="{{ route('quote-document-settings.destroy', $quote_document->id) }}">
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

    {{ $all_quote_documents->links() }}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection