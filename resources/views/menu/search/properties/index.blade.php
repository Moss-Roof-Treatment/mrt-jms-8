@extends('layouts.app')

@section('title', '- Search - Global Search')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SEARCH</h3>
    <h5>Property Search Menu</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('search.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Search Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-7">

        <h5 class="text-primary my-3"><b>Property Search</b></h5>

        <form action="{{ route('search-properties-results.show') }}" method="POST">
          @csrf

          <div class="form-group row">
            <label for="material_type_id" class="col-md-3 col-form-label text-md-right">Roof Surface</label>
            <div class="col-md-8">
              <select name="material_type_id" class="custom-select @error('material_type_id') is-invalid @enderror mb-2">
                <option selected disabled>Please select a roof surface</option>
                @foreach ($all_material_types as $material_type)
                  <option value="{{ $material_type->id }}" @if ($material_type->id == old('material_type_id')) selected @endif>
                    {{ $material_type->title }}
                  </option>
                @endforeach
              </select>
              @error('material_type_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="building_style_id" class="col-md-3 col-form-label text-md-right">Building Style</label>
            <div class="col-md-8">
              <select name="building_style_id" class="custom-select @error('building_style_id') is-invalid @enderror mb-2">
                <option selected disabled>Please select a building style</option>
                @foreach ($all_building_styles as $building_style)
                  <option value="{{ $building_style->id }}" @if ($building_style->id == old('building_style_id')) selected @endif>
                    {{ $building_style->title }}
                  </option>
                @endforeach
              </select>
              @error('building_style_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="building_type_id" class="col-md-3 col-form-label text-md-right">Building Type</label>
            <div class="col-md-8">
              <select name="building_type_id" class="custom-select @error('building_type_id') is-invalid @enderror mb-2">
                <option selected disabled>Please select a building type</option>
                @foreach ($all_building_types as $building_type)
                  <option value="{{ $building_type->id }}" @if ($building_type->id == old('building_type_id')) selected @endif>
                    {{ $building_type->title }}
                  </option>
                @endforeach
              </select>
              @error('building_type_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="street_address" class="col-md-3 col-form-label text-md-right">Street Address</label>
            <div class="col-md-8">
              <input id="street_address" type="text" class="form-control @error('street_address') is-invalid @enderror mb-2" name="street_address" value="{{ old('street_address') }}" placeholder="Please enter a street address">
              @error('street_address')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-6 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="suburb" class="col-md-3 col-form-label text-md-right">Suburb</label>
            <div class="col-md-4">
              <input id="suburb" type="text" class="form-control @error('suburb') is-invalid @enderror mb-2" name="suburb" value="{{ old('suburb') }}" placeholder="Please enter a suburb">
              @error('suburb')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-5 --}}
            <div class="col-md-4">
              <input id="postcode" type="text" class="form-control @error('postcode') is-invalid @enderror mb-2" name="postcode" value="{{ old('postcode') }}" placeholder="Please enter a postcode">
              @error('postcode')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-5 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="account_class_id" class="col-md-3 col-form-label text-md-right">Account Class</label>
            <div class="col-md-8">
              <select name="account_class_id" class="custom-select @error('account_class_id') is-invalid @enderror mb-2">
                <option selected disabled>Please select account class</option>
                @foreach ($all_account_classes as $account_class)
                  <option value="{{ $account_class->id }}" @if ($account_class->id == old('account_class_id')) selected @endif>
                    {{ $account_class->title }}
                  </option>
                @endforeach
              </select>
              @error('account_class_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="suburb" class="col-md-3 col-form-label text-md-right">Completion Date</label>
            <div class="col-md-4">
              <input class="form-control @error('start_date') is-invalid @enderror mb-2" type="date" name="start_date" value="{{ old('start_date') }}">
              @error('start_date')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-5 --}}
            <div class="col-md-4">
              <input class="form-control @error('end_date') is-invalid @enderror mb-2" type="date" name="end_date" value="{{ old('end_date') }}">
              @error('end_date')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-5 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="job_status_id" class="col-md-3 col-form-label text-md-right">Job Status</label>
            <div class="col-md-8">
              <select name="job_status_id" class="custom-select @error('job_status_id') is-invalid @enderror mb-2">
                <option selected disabled>Please select a job status</option>
                @foreach ($all_job_statuses as $job_status)
                  <option value="{{ $job_status->id }}" @if ($job_status->id == old('job_status_id')) selected @endif>
                    {{ $job_status->title }}
                  </option>
                @endforeach
              </select>
              @error('job_status_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-3">
              <button class="btn btn-primary" type="submit">
                <i class="fas fa-search mr-2" aria-hidden="true"></i>Search
              </button>
              {{-- reset modal --}}
              {{-- modal button --}}
              <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#confirmResetModal">
                <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
              </button>
              {{-- modal button --}}
              {{-- modal --}}
              <div class="modal fade" id="confirmResetModal" tabindex="-1" role="dialog" aria-labelledby="confirmResetModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="confirmResetModalTitle">Reset</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="text-center">Are you sure that you would like to reset this form?</p>
                      <a class="btn btn-dark btn-block" href="{{ route('search-properties.index') }}">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              {{-- cancel button --}}
              <a href="{{ route('search.index') }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
              {{-- cancel button --}}
            </div>
          </div> {{-- form-group row --}}

        </form>

      </div> {{-- col-sm-7 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
<section class="bg-white">
  <div class="container-fluid py-5">

    {{-- search results table --}}
    <h5 class="text-primary my-3"><b>Search Results</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped">
        <thead class="table-secondary">
          <tr>
            <th>Job ID</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Last Login</th>
            <th>Address</th>
            <th>Suburb</th>
            <th>Status</th>
            <th>Image</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="8" class="text-center">Please fill out the search form to have the results displayed here</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- search results table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection