@extends('layouts.app')

@section('title', '- Equipment - Documents - View Selected Equipment')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">EQUIPMENT DOCUMENTS</h3>
    <h5>View Selected Equipment Document</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('equipment-items.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Equipment Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('equipment-items.show', $document->equipment_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Equipment
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('equipment-documents.edit', $document->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit Document
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        @if ($document->document_path == null)
          <a href="#" class="btn btn-primary btn-block disabled" tabindex="-1" role="button" aria-disabled="true">
            <i class="fas fa-download mr-2" aria-hidden="true"></i>Download
          </a>
        @else
          <a class="btn btn-primary btn-block" href="{{ route('equipment-documents-download.show', $document->id) }}">
            <i class="fas fa-download mr-2" aria-hidden="true"></i>Download
          </a>
        @endif
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        {{-- delete modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteDocumentModal">
            <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="deleteDocumentModal" tabindex="-1" role="dialog" aria-labelledby="deleteDocumentModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="deleteDocumentModalTitle">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center">Are you sure that you would like to delete this item?</p>
                <form action="{{ route('equipment-documents.destroy', $document->id) }}" method="POST">
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
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-6">

        <h5 class="text-primary my-4"><b>Document Image</b></h5>
        <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset($document->get_document_image()) }}">

      </div> {{-- col-sm-6 --}}
      <div class="col-sm-6">

        <h5 class="text-primary my-4"><b>Document Details</b></h5>

        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <tbody>
            <tr>
              <th>Title</th>
              <td>{{ $document->title }}</td>
            </tr>
            <tr>
              <th>Image Location</th>
              <td>
                @if ($document->image_path == null)
                  <span class="badge badge-warning py-2 px-2">
                  <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>this image has been deleted
                  </span>
                @else
                  {{ $document->image_path }}
                @endif
              </td>
            </tr>
            <tr>
              <th>Document Location</th>
              <td>
                @if ($document->document_path == null)
                  <span class="badge badge-warning py-2 px-2">
                  <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>this document has been deleted
                  </span>
                @else
                  {{ $document->document_path }}
                @endif
              </td>
            </tr>
            <tr>
              <th>Upload Date</th>
              <td>{{ date('d/m/y', strtotime($document->created_at)) }}</td>
            </tr>
          </tbody>
        </table>

        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ $document->description }}</td>
            </tr>
          </tbody>
        </table>

      </div> {{-- col-sm-6 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection