@extends('layouts.jquery')

@section('title', 'Jobs - Edit Selected Job')

@push('css')
{{-- Datepicker CSS --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-PMjWzHVtwxdq7m7GIxBot5vdxUY+5aKP9wpKtvnNBZrVv1srI8tU6xvFMzG8crLNcMj/8Xl/WWmo/oAP/40p1g==" crossorigin="anonymous" />
{{-- Datepicker CSS --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">JOBS</h3>
    <h5>Edit Selected Job</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('jobs.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Jobs Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('jobs.show', $selected_job->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Job
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <form action="{{ route('jobs.update', $selected_job->id) }}" method="POST">
      @method('PATCH')
      @csrf

    {{-- body --}}
    <div class="row">
      <div class="col-sm-7">

        {{-- customer details table --}}
        <p class="text-primary my-3"><b>Customer Details</b></p>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>Customer Number</th>
                <td>{{ $selected_job->customer_id }}</td>
              </tr>
              <tr>
                <th>Customer Name</th>
                <td>{{ $selected_job->customer->getFullNameAttribute() }}</td>
              </tr>
              <tr>
                <th>Customer Address</th>
                <td>{{ $selected_job->customer->street_address . ', ' . $selected_job->customer->suburb . ', ' . $selected_job->customer->postcode }}</td>
              </tr>
              @if ($selected_job->customer->home_phone != null)
                <tr>
                  <th>Home Phone Number</th>
                  <td>{{ $selected_job->customer->home_phone }}</td>
                </tr>
              @endif
              @if ($selected_job->customer->mobile_phone != null)
                <tr>
                  <th>Mobile Phone Number</th>
                  <td>{{ $selected_job->customer->mobile_phone }}</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div> {{-- table-responsive --}}
        {{-- customer details table --}}

        {{-- edit job form --}}
        <p class="text-primary my-3"><b>Job Details</b></p>
        <div class="card">
          <div class="card-body">

            <div class="form-group row">
              <label for="salesperson_id" class="col-md-3 col-form-label text-md-right">Salesperson</label>
              <div class="col-md-8">
                <select name="salesperson_id" id="salesperson_id" class="custom-select">
                  @if (old('salesperson_id'))
                    <option disabled>Please select a salesperson</option>
                    @foreach ($staff_members as $salesperson)
                      <option value="{{ $salesperson->id }}" @if (old('salesperson_id') == $salesperson->id) selected @endif>{{ $salesperson->getFullNameAttribute() }}</option>
                    @endforeach
                  @else
                    @if ($selected_job->salesperson_id != null)
                      <option value="{{ $selected_job->salesperson_id }}" selected>
                        {{ $selected_job->salesperson->getFullNameAttribute() }}
                      </option>
                      <option disabled>Please select a salesperson</option>
                    @else
                      <option selected disabled>Please select a salesperson</option>
                    @endif
                    @foreach ($staff_members as $salesperson)
                      <option value="{{ $salesperson->id }}">{{ $salesperson->getFullNameAttribute() }}</option>
                    @endforeach
                  @endif
                </select>
                @error('suburb')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div> {{-- col-md-8 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
              <label for="label" class="col-md-3 col-form-label text-md-right">Label</label>
              <div class="col-md-8">
                <input id="label" type="text" class="form-control @error('label') is-invalid @enderror mb-2" name="label" value="{{ old('label', $selected_job->label) }}" placeholder="Please enter the label">
                @error('label')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div> {{-- col-md-8 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
              <label for="business_name" class="col-md-3 col-form-label text-md-right">Tenant</label>
              <div class="col-md-8">
                <input id="tenant_name" type="text" class="form-control @error('tenant_name') is-invalid @enderror mb-2" name="tenant_name" value="{{ old('tenant_name',  $selected_job->tenant_name) }}" placeholder="Please enter the tenant name">
                @error('tenant_name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div> {{-- col-md-8 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
              <label for="tenant_home_phone" class="col-md-3 col-form-label text-md-right">Tenant Phone</label>
              <div class="col-md-8">
                <input id="tenant_home_phone" type="text" class="form-control @error('tenant_home_phone') is-invalid @enderror mb-2" name="tenant_home_phone" value="{{ old('tenant_home_phone',  $selected_job->tenant_home_phone) }}" placeholder="Please enter the tenant home phone">
                @error('tenant_home_phone')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div> {{-- col-md-8 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
              <label for="tenant_mobile_phone" class="col-md-3 col-form-label text-md-right">Tenant Mobile</label>
              <div class="col-md-8">
                <input id="tenant_mobile_phone" type="text" class="form-control @error('tenant_mobile_phone') is-invalid @enderror mb-2" name="tenant_mobile_phone" value="{{ old('tenant_mobile_phone',  $selected_job->tenant_mobile_phone) }}" placeholder="Please enter the tenant mobile phone">
                @error('tenant_mobile_phone')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div> {{-- col-md-8 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
              <label for="tenant_street_address" class="col-md-3 col-form-label text-md-right">Address</label>
              <div class="col-md-8">
                <input id="tenant_street_address" type="text" class="form-control @error('tenant_street_address') is-invalid @enderror mb-2" name="tenant_street_address" value="{{ old('tenant_street_address',  $selected_job->tenant_street_address) }}" placeholder="Please enter the street address">
                @error('tenant_street_address')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div> {{-- col-md-8 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
              <label for="tenant_suburb" class="col-md-3 col-form-label text-md-right">Suburb</label>
              <div class="col-md-4">
                <input id="tenant_suburb" type="text" class="form-control @error('tenant_suburb') is-invalid @enderror mb-2" name="tenant_suburb" value="{{ old('tenant_suburb',  $selected_job->tenant_suburb) }}" placeholder="Please enter the suburb">
                @error('tenant_suburb')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div> {{-- col-md-5 --}}
              <div class="col-md-4">
                <input id="tenant_postcode" type="text" class="form-control @error('tenant_postcode') is-invalid @enderror mb-2" name="tenant_postcode" value="{{ old('tenant_postcode',  $selected_job->tenant_postcode) }}" placeholder="Please enter the postcode">
                @error('tenant_postcode')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div> {{-- col-md-5 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
              <label for="material_type_id" class="col-md-3 col-form-label text-md-right">Roof Surface</label>
              <div class="col-md-8">
                <select name="material_type_id" id="material_type_id" class="custom-select @error('material_type_id') is-invalid @enderror mb-2">
                  @if (old('material_type_id'))
                    <option disabled>Please select a roof surface</option>
                    @foreach ($material_types as $material_type)
                      <option value="{{ $material_type->id }}" @if (old('material_type_id') == $material_type->id) selected @endif>{{ $material_type->title }}</option>
                    @endforeach
                  @else
                    @if ($selected_job->material_type_id == null)
                      <option selected disabled>Please select a roof surface</option>
                    @else
                      <option value="{{ $selected_job->material_type_id }}" selected>
                        {{ $selected_job->material_type->title }}
                      </option>
                      <option disabled>Please select a roof surface</option>
                    @endif
                    @foreach ($material_types as $material_type)
                      <option value="{{ $material_type->id }}">{{ $material_type->title }}</option>
                    @endforeach
                  @endif
                </select>
                @error('material_type_id')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div> {{-- col-md-6 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
              <label for="building_style_id" class="col-md-3 col-form-label text-md-right">Building Style</label>
              <div class="col-md-8">
                <select name="building_style_id" id="building_style_id" class="custom-select @error('building_style_id') is-invalid @enderror mb-2">
                  @if (old('building_style_id'))
                    <option disabled>Please select a building style</option>
                    @foreach ($building_styles as $building_style)
                      <option value="{{ $building_style->id }}" @if (old('building_style_id') == $building_style->id) selected @endif>{{ $building_style->title }}</option>
                    @endforeach
                  @else
                    @if ($selected_job->building_style_id == null)
                      <option selected disabled>Please select a building style</option>
                    @else
                      <option value="{{ $selected_job->building_style_id }}" selected>
                        {{ $selected_job->building_style->title }}
                      </option>
                      <option disabled>Please select a building style</option>
                    @endif
                    @foreach ($building_styles as $building_style)
                      <option value="{{ $building_style->id }}">{{ $building_style->title }}</option>
                    @endforeach
                  @endif
                </select>
                @error('building_style_id')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div> {{-- col-md-6 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
              <label for="building_type_id" class="col-md-3 col-form-label text-md-right">Building Type</label>
              <div class="col-md-8">
                <select name="building_type_id" id="building_type_id" class="custom-select @error('building_type_id') is-invalid @enderror mb-2">
                  @if (old('building_type_id'))
                    <option disabled>Please select a building type</option>
                    @foreach ($building_types as $building_type)
                      <option value="{{ $building_type->id }}" @if (old('building_type_id') == $building_type->id) selected @endif>{{ $building_type->title }}</option>
                    @endforeach
                  @else
                    @if ($selected_job->building_type_id == null)
                      <option selected disabled>Please select a building type</option>
                    @else
                      <option value="{{ $selected_job->building_type_id }}" selected>
                        {{ $selected_job->building_type->title }}
                      </option>
                      <option disabled>Please select a building type</option>
                    @endif
                    @foreach ($building_types as $building_type)
                      <option value="{{ $building_type->id }}">{{ $building_type->title }}</option>
                    @endforeach
                  @endif
                </select>
                @error('building_type_id')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div> {{-- col-md-6 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
              <label for="inspection_type_id" class="col-md-3 col-form-label text-md-right">Inspection Type</label>
              <div class="col-md-8">
                <select name="inspection_type_id" id="inspection_type_id" class="custom-select @error('inspection_type_id') is-invalid @enderror mb-2">
                  @if (old('inspection_type_id'))
                    <option disabled>Please select a inspection type</option>
                    @foreach ($inspection_types as $inspection_type)
                      <option value="{{ $inspection_type->id }}" @if (old('inspection_type_id') == $inspection_type->id) selected @endif>{{ $inspection_type->title }}</option>
                    @endforeach
                  @else
                    @if ($selected_job->inspection_type_id == null)
                      <option selected disabled>Please select a inspection type</option>
                    @else
                      <option value="{{ $selected_job->inspection_type_id }}" selected>
                        {{ $selected_job->inspection_type->title }}
                      </option>
                      <option disabled>Please select a inspection type</option>
                    @endif
                    @foreach ($inspection_types as $inspection_type)
                      <option value="{{ $inspection_type->id }}">{{ $inspection_type->title }}</option>
                    @endforeach
                  @endif
                </select>
                @error('inspection_type_id')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div> {{-- col-md-6 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
              <label for="inspection_date_time" class="col-md-3 col-form-label text-md-right">Inspection Date</label>
              <div class="col-md-5 mb-3">
                <div class="input-group date" id="inspection_date_time" data-target-input="nearest">
                  <input type="text" name="inspection_date_time" class="form-control datetimepicker-input @error('inspection_date_time') is-invalid @enderror" data-target="#inspection_date_time" @if ($selected_job->inspection_date != null) value="{{ date('d-m-Y - h:iA', strtotime($selected_job->inspection_date)) }}" @endif placeholder="Please enter the inspection date and time"/>
                  <div class="input-group-append" data-target="#inspection_date_time" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                  </div>
                  @error('inspection_date_time')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div> {{-- col-md-5 --}}
              <div class="col-md-3">
                <a href="{{ route('calendar.index') }}" class="btn btn-primary btn-block" target="_blank">
                  <i class="fas fa-calendar-alt mr-2" aria-hidden="true"></i>View
                </a>
              </div> {{-- col-md-5 --}}
            </div> {{-- form-group row --}}

          </div> {{-- card-body --}}
        </div> {{-- card --}}
        {{-- edit job form --}}

      </div> {{-- col-sm-7 --}}
      <div class="col-sm-5">

        {{-- job type selections --}}
        <p class="text-primary my-3"><b>Job Types</b></p>
        <div class="card">
          <div class="card-body">
            <p class="text-primary">* Please select at least 1 job type.</p>
            @foreach ($job_types->chunk(2) as $job_typeChunk)
              <div class="row">
                @foreach ($job_typeChunk as $job_type)
                  <div class="col-sm-6 my-2">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input @error('job_types') is-invalid @enderror mb-2" name="job_types[{{ $job_type->id }}]" id="job_types[{{ $job_type->id }}]" value="{{ $job_type->id }}" {{ in_array($job_type->id, $selected_job_types) ? 'checked' : null }}>
                      <label class="custom-control-label" for="job_types[{{ $job_type->id }}]">{{ $job_type->title }}</label>
                    </div>
                  </div> {{-- col-sm-6 --}}
                @endforeach
              </div> {{-- row --}}
            @endforeach
            @error('job_types')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div> {{-- card-body --}}
        </div> {{-- card --}}
        {{-- job type selections --}}

      </div> {{-- col-sm-7 --}}
    </div> {{-- row --}}

    <div class="form-group row py-3">
      <div class="col">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Update
        </button>
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
                <a href="{{ route('jobs.edit', $selected_job->id) }}" class="btn btn-dark btn-block">
                  <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                </a>
              </div> {{-- modal-body --}}
            </div> {{-- modal-content --}}
          </div> {{-- modal-dialog --}}
        </div> {{-- modal fade --}}
        {{-- modal --}}
        {{-- reset modal --}}
        <a href="{{ route('jobs.show', $selected_job->id) }}" class="btn btn-dark">
          <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
        </a>
      </div> {{-- col --}}
    </div> {{-- row --}}

    </form>

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- Date Time Picker JS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.28.0/moment.min.js" integrity="sha512-Q1f3TS3vSt1jQ8AwP2OuenztnLU6LwxgyyYOG1jgMW/cbEMHps/3wjvnl1P3WTrF3chJUWEoxDUEjMxDV8pujg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-2JBCbWoMJPH+Uj7Wq5OLub8E5edWHlTM4ar/YJkZh3plwB2INhhOC3eDoqHm1Za/ZOSksrLlURLoyXVdfQXqwg==" crossorigin="anonymous"></script>
<script type="text/javascript">
  $(function () {
    $('#inspection_date_time').datetimepicker({
      icons: {
        time: "fas fa-clock",
        date: "fas fa-calendar-alt",
        up: "fas fa-chevron-up",
        down: "fas fa-chevron-down"
      },
      format: 'DD-MM-YYYY LT',
    });
  });
</script>
{{-- Date Time Picker JS --}}
@endpush