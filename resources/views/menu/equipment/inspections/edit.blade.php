@extends('layouts.app')

@section('title', '- Equipment - Edit Selected Inspection')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">EQUIPMENT INSPECTIONS</h3>
    <h5>Edit Selected Inspection</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('equipment.show', $inspection->equipment_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Equipment
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <h5 class="text-primary my-3"><b>Edit Selected Inspection</b></h5>

    <div class="row">
      <div class="col-sm-7">

        <form action="{{ route('equipment-inspections.update', $inspection->id) }}" method="POST">
          @method('PATCH')
          @csrf

          <div class="form-group row">
            <label for="inspection_date" class="col-md-4 col-form-label text-md-right">Inspection Date</label>
            <div class="col-md-8">
              <input type="date" class="form-control @error('inspection_date') is-invalid @enderror mb-2" name="inspection_date" id="inspection_date" value="{{ old('inspection_date', $inspection_date) }}" autofocus>
              @error('inspection_date')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="inspection_company" class="col-md-4 col-form-label text-md-right">Inspection Company</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('inspection_company') is-invalid @enderror mb-2" name="inspection_company" id="inspection_company" value="{{ old('inspection_company', $inspection->inspection_company) }}" placeholder="Please enter the inspection company">
              @error('inspection_company')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="inspector_name" class="col-md-4 col-form-label text-md-right">Inspected By</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('inspector_name') is-invalid @enderror mb-2" name="inspector_name" id="inspector_name" value="{{ old('inspector_name', $inspection->inspector_name) }}" placeholder="Please enter the inspector name">
              @error('inspector_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="tag_and_test_id" class="col-md-4 col-form-label text-md-right">Tag And Test Number</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('tag_and_test_id') is-invalid @enderror mb-2" name="tag_and_test_id" id="tag_and_test_id" value="{{ old('tag_and_test_id', $inspection->tag_and_test_id) }}" placeholder="Please enter the tag and test number">
              @error('tag_and_test_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="text" class="col-md-4 col-form-label text-md-right">Comments</label>
            <div class="col-md-8">
              <textarea class="form-control @error('text') is-invalid @enderror mb-2" type="text" name="text" rows="5" placeholder="Please enter comments" style="resize:none">{{ old('text', $inspection->text) }}</textarea>
              @error('text')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="next_inspection_date" class="col-md-4 col-form-label text-md-right">Next Inspection Date</label>
            <div class="col-md-8">
              <input type="date" class="form-control @error('next_inspection_date') is-invalid @enderror mb-2" name="next_inspection_date" id="next_inspection_date" value="{{ old('next_inspection_date', $next_inspection_date) }}">
              @error('next_inspection_date')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
              {{-- create button --}}
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
              </button>
              {{-- create button --}}
              {{-- reset modal --}}
              {{-- modal button --}}
              <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
              </button>
              {{-- modal button --}}
              {{-- modal --}}
              <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalCenterTitle">Reset</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="text-center">Are you sure that you would like to reset this form?</p>
                      <a href="{{ route('equipment-inspections.edit', $inspection->id) }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              {{-- cancel button --}}
              <a href="{{ route('equipment-inspections.show', $inspection->id) }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
              {{-- cancel button --}}
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

        </form>

      </div>{{-- col-sm-7 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection