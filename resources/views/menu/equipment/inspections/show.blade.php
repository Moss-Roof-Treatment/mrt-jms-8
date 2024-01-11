@extends('layouts.app')

@section('title', '- Equipment - Inspections - View Selected Equipment Inspection')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">EQUIPMENT INSPECTIONS</h3>
    <h5>View Selected Equipment Inpsection</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('equipment.show', $inspection->equipment_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Equipment
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('equipment-inspections.edit', $inspection->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit Inspection
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('equipment-inspection-images.create', ['inspection_id' => $inspection->id]) }}" class="btn btn-primary btn-block">
          <i class="fas fa-images mr-2" aria-hidden="true"></i>Upload Images
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        {{-- delete modal --}}
        {{-- modal button --}}
        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModal">
          <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
        </button>
        {{-- modal button --}}
        {{-- modal --}}
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="deleteModalTitle">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center">Are you sure that you would like to delete this item?</p>
                <form action="{{ route('equipment-inspections.destroy', $inspection->id) }}" method="POST">
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

    <h5 class="text-primary my-3"><b>Inspection Details</b></h5>

    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <thead class="table-secondary">
          <tr>
            <th>Inspection Company</th>
            <th>Inspected By</th>
            <th>Tag and Test Number</th>
            <th>Inspection Date</th>
            <th>Next Inspection Date</th>
            <th>Created At</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $inspection->inspection_company }}</td>
            <td>{{ $inspection->inspector_name }}</td>
            <td>{{ $inspection->tag_and_test_id }}</td>
            <td>{{ date('d/m/y', strtotime($inspection->inspection_date)) }}</td>
            <td>{{ date('d/m/y', strtotime($inspection->next_inspection_date)) }}</td>
            <td>{{ date('d/m/y - h:iA', strtotime($inspection->created_at)) }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}

    <h5 class="text-primary my-3"><b>Inspection Comment</b></h5>
    <div class="card shadow-sm">
      <div class="card-body">
        {{ $inspection->text }}
      </div> {{-- card-body --}}
    </div> {{-- card --}}

    <h5 class="text-primary my-3"><b>Inspection Images</b></h5>
    @if (!$inspection->images->count())
      <div class="card shadow-sm">
        <div class="card-body text-center">
          <h5>No images have been uploaded for this inspection</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="container">
            <div class="row row-cols-2">
              @foreach ($inspection->images as $image)
                <div class="col-sm-2">
                  {{-- image modal --}}
                  {{-- modal button --}}
                  <a type="button" data-toggle="modal" data-target="#imageModal{{$image->id}}">
                    @if ($image->image_path == null)
                      <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/tools-256x256.jpg') }}" alt="">
                    @else
                      <img class="img-fluid shadow-sm" src="{{ asset($image->image_path) }}" alt="">
                    @endif
                  </a>
                  {{-- modal button --}}
                  {{-- modal --}}
                  <div class="modal fade" id="imageModal{{$image->id}}" tabindex="-1" role="dialog" aria-labelledby="imageModal{{$image->id}}Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">{{ $image->equipment_inspection->equipment->title }}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          @if ($image->image_path == null)
                            <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/tools-256x256.jpg') }}" alt="">
                          @else
                            <img class="img-fluid shadow-sm" src="{{ asset($image->image_path) }}" alt="">
                          @endif
                        </div> {{-- modal-body --}}
                        <div class="modal-footer">
                          <button type="button" class="btn btn-dark" data-dismiss="modal">
                          <i class="fas fa-times mr-2" aria-hidden="true"></i>Close
                          </button>
                        </div> {{-- modal-footer --}}
                      </div> {{-- modal-content --}}
                    </div>{{-- modal-dialog modal-dialog-centered --}}
                  </div> {{-- modal fade --}}
                  {{-- modal --}}
                  {{-- image modal --}}

                </div> {{-- col-sm-2 --}}
              @endforeach
            </div> {{-- row row-cols-2 --}}
          </div> {{-- container --}}
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @endif

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection