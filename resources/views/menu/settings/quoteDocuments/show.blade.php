@extends('layouts.app')

@section('title', '- Quote Documents - View Selected Quote Document')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">QUOTE DOCUMENTS</h3>
    <h5>View Selected Quote Document</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('quote-document-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Quote Documents Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        {{-- Render PDF Button --}}
        @if ($selected_quote_document->document_path == null)
          {{-- disabled --}}
          <a href="#" class="btn btn-primary btn-block disabled" tabindex="-1" role="button" aria-disabled="true">
            <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
          </a>
        @else
          {{-- enabled --}}
          <a class="btn btn-primary btn-block" href="{{ route('quote-document-render.show', $selected_quote_document->id) }}" >
            <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
          </a>
        @endif
        {{-- Render PDF Button --}}
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('quote-document-settings.edit', $selected_quote_document->id) }}">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        {{-- Download PDF Button --}}
        @if ($selected_quote_document->document_path == null)
          {{-- disabled --}}
          <a href="#" class="btn btn-primary btn-block disabled" tabindex="-1" role="button" aria-disabled="true">
            <i class="fas fa-download mr-2" aria-hidden="true"></i>Download
          </a>
        @else
          {{-- enabled --}}
          <a class="btn btn-primary btn-block" href="{{ route('quote-document-download.show', $selected_quote_document->id) }}">
            <i class="fas fa-download mr-2" aria-hidden="true"></i>Download
          </a>
        @endif
        {{-- Download PDF Button --}}
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-6">

        <p class="text-primary my-3"><b>Document Image</b></p>
        @if ($selected_quote_document->image_path == null)
          <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset('storage/images/placeholders/quote-256x256.png') }}" alt="placeholder image">
        @else
          <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset($selected_quote_document->image_path) }}" alt="quote document image">
        @endif

      </div> {{-- col-sm-6 --}}
      <div class="col-sm-6">

        <p class="text-primary my-3"><b>Document Details</b></p>

        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>ID</th>
                <td>{{ $selected_quote_document->id }}</td>
              </tr>
              <tr>
                <th>Title</th>
                <td>{{ $selected_quote_document->title }}</td>
              </tr>
              <tr>
                <th width="25%">Material Type</th>
                <td>
                  @if ($selected_quote_document->material_type_id == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ $selected_quote_document->material_type->title }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Task Type</th>
                <td>
                  @if ($selected_quote_document->task_type_id == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ $selected_quote_document->task_type->title }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Task</th>
                <td>
                  @if ($selected_quote_document->task_id == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ $selected_quote_document->task->title }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Image Path</th>
                <td>
                  @if ($selected_quote_document->image_path == null)
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>This image does not exist on the server.
                    </span>
                  @else
                    {{ $selected_quote_document->image_path }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Document Path</th>
                <td>
                  @if ($selected_quote_document->document_path == null)
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>This document does not exist on the server.
                    </span>
                  @else
                    {{ $selected_quote_document->document_path }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Is Editable</th>
                <td>
                  @if ($selected_quote_document->is_editable == 0)
                    <span class="badge badge-danger py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Is not editable
                    </span>
                  @else
                    <span class="badge badge-success py-2 px-2">
                      <i class="fas fa-check mr-2" aria-hidden="true"></i>Is editable
                    </span>
                  @endif  
                </td>
              </tr>
              <tr>
                <th>Is Delible</th>
                <td>
                  @if ($selected_quote_document->is_delible == 0)
                    <span class="badge badge-danger py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Is not delible
                    </span>
                  @else
                    <span class="badge badge-success py-2 px-2">
                      <i class="fas fa-check mr-2" aria-hidden="true"></i>Is delible
                    </span>
                  @endif   
                </td>
              </tr>
              <tr>
                <th>Is Default</th>
                <td>
                  @if ($selected_quote_document->is_default == 0)
                    <span class="badge badge-danger py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Is not default
                    </span>
                  @else
                    <span class="badge badge-success py-2 px-2">
                      <i class="fas fa-check mr-2" aria-hidden="true"></i>Is default
                    </span>
                  @endif   
                </td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}

        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <thead class="table-secondary">
              <tr>
                <th>Description</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  @if ($selected_quote_document->description == null)
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>The description has not been set.
                    </span>
                  @else
                    {{ $selected_quote_document->description }}
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}


      </div> {{-- col-sm-6 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection