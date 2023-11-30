@extends('layouts.jquery')

@section('title', 'Quotes - Quick Quote')

@push('css')
{{-- Datepicker CSS --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-PMjWzHVtwxdq7m7GIxBot5vdxUY+5aKP9wpKtvnNBZrVv1srI8tU6xvFMzG8crLNcMj/8Xl/WWmo/oAP/40p1g==" crossorigin="anonymous" />
{{-- Datepicker CSS --}}
{{-- DropzoneJS CSS --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css" integrity="sha512-WvVX1YO12zmsvTpUQV8s7ZU98DnkaAokcciMZJfnNWyNzm7//QRV61t4aEr0WdIa4pe854QHLTV302vH92FSMw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
{{-- DropzoneJS CSS --}}
{{-- bootstrap-select css --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css">
{{-- bootstrap-select css --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">QUOTES</h3>
    <h5>Quick Quote</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('quotes.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Quote Menu
        </a>
      </div> {{-- col pb-3 --}}
      @if ($selected_quote->job->quote_request != null)
        <div class="col pb-3">
          <a class="btn btn-primary btn-block" target="_blank" href="{{ route('quote-requests.show', $selected_quote->job->quote_request->id) }}">
            <i class="fas fa-file-invoice mr-2" aria-hidden="true"></i>Open Quote Request
          </a>
        </div> {{-- col pb-3 --}}
      @endif
      <div class="col pb-3">
        <a href="{{ route('jobs.show', $selected_quote->job_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Job
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('quotes.show', $selected_quote->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Quote
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <form action="{{ route('quick-quote.update', $selected_quote->id) }}" method="POST">
      @method('PATCH')
      @csrf

      <div class="row">
        <div class="col-sm-7">

          {{-- customer details table --}}
          <h5 class="text-primary my-3"><b>Customer Details</b></h5>
          <div class="table-responsive">
            <table class="table table-bordered table-fullwidth table-striped bg-white">
              <tbody>
                <tr>
                  <th>Customer Number</th>
                  <td>{{ $selected_quote->customer_id }}</td>
                </tr>
                <tr>
                  <th>Customer Name</th>
                  <td>
                    {{ $selected_quote->customer->getFullNameAttribute() }}
                    @if ($selected_quote->customer->business_name != null)
                      ({{ $selected_quote->customer->business_name }})
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Customer Address</th>
                  <td>{{ $selected_quote->customer->street_address . ', ' . $selected_quote->customer->suburb . ', ' . $selected_quote->customer->postcode }}</td>
                </tr>
                @if ($selected_quote->customer->home_phone != null)
                  <tr>
                    <th>Home Phone Number</th>
                    <td>{{ $selected_quote->customer->home_phone }}</td>
                  </tr>
                @endif
                @if ($selected_quote->customer->mobile_phone != null)
                  <tr>
                    <th>Mobile Phone Number</th>
                    <td>{{ $selected_quote->customer->mobile_phone }}</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div> {{-- table-responsive --}}
          {{-- customer details table --}}

          {{-- edit job form inputs --}}
          <h5 class="text-primary my-3"><b>Job Details</b></h5>
          <div class="card">
            <div class="card-body pb-0">

              <div class="form-group row">
                <label for="salesperson_id" class="col-md-3 col-form-label text-md-right">Job Salesperson</label>
                <div class="col-md-8">
                  <select name="salesperson_id" id="salesperson_id" class="custom-select">
                    @if (old('salesperson_id'))
                      <option disabled>Please select a salesperson</option>
                      @foreach ($staff_members as $salesperson)
                        <option value="{{ $salesperson->id }}" @if (old('salesperson_id') == $salesperson->id) selected @endif>{{ $salesperson->getFullNameTitleAttribute() }}</option>
                      @endforeach
                    @else
                      @if ($selected_quote->job->salesperson_id != null)
                        <option value="{{ $selected_quote->job->salesperson_id }}" selected>
                          {{ $selected_quote->job->salesperson->getFullNameTitleAttribute() }}
                        </option>
                        <option disabled>Please select a salesperson</option>
                      @else
                        <option selected disabled>Please select a salesperson</option>
                      @endif
                      @foreach ($staff_members as $salesperson)
                        <option value="{{ $salesperson->id }}" @if ($salesperson->id == $selected_quote->job->salesperson_id) hidden @endif>{{ $salesperson->getFullNameTitleAttribute() }}</option>
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
                <label for="salespersons" class="col-md-3 col-form-label text-md-right">Quote Commissions</label>
                <div class="col-md-8">
                  <select name="salespersons[]" class="form-control border selectpicker @error('salespersons') is-invalid @enderror mb-2" multiple="multiple" data-style="bg-white" data-live-search="true" data-size="5" data-container="#for-bootstrap-select" title="Please select the salespersons">
                    @foreach ($selected_quote->commissions as $commission)
                      <option selected value="{{ $commission->salesperson->id }}">{{ $commission->salesperson->getFullNameTitleAttribute() }}</option>
                    @endforeach
                    @foreach ($staff_members as $salesperson)
                      <option value="{{ $salesperson->id }}" @if (in_array($salesperson->id, $selected_quote->commissions()->pluck('salesperson_id')->toArray())) hidden @endif>{{ $salesperson->getFullNameTitleAttribute() }}</option>
                    @endforeach
                  </select>
                  @error('salespersons')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="business_name" class="col-md-3 col-form-label text-md-right">Tenant</label>
                <div class="col-md-8">
                  <input id="tenant_name" type="text" class="form-control @error('tenant_name') is-invalid @enderror mb-2" name="tenant_name" value="{{ old('tenant_name',  $selected_quote->job->tenant_name) }}" placeholder="Please enter the tenant name">
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
                  <input id="tenant_home_phone" type="text" class="form-control @error('tenant_home_phone') is-invalid @enderror mb-2" name="tenant_home_phone" value="{{ old('tenant_home_phone',  $selected_quote->job->tenant_home_phone) }}" placeholder="Please enter the home phone">
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
                  <input id="tenant_mobile_phone" type="text" class="form-control @error('tenant_mobile_phone') is-invalid @enderror mb-2" name="tenant_mobile_phone" value="{{ old('tenant_mobile_phone',  $selected_quote->job->tenant_mobile_phone) }}" placeholder="Please enter the mobile phone">
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
                  <input id="tenant_street_address" type="text" class="form-control @error('tenant_street_address') is-invalid @enderror mb-2" name="tenant_street_address" value="{{ old('tenant_street_address',  $selected_quote->job->tenant_street_address) }}" placeholder="Please enter the mobile phone">
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
                  <input id="tenant_suburb" type="text" class="form-control @error('tenant_suburb') is-invalid @enderror mb-2" name="tenant_suburb" value="{{ old('tenant_suburb',  $selected_quote->job->tenant_suburb) }}" placeholder="Please enter the suburb">
                  @error('tenant_suburb')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> {{-- col-md-5 --}}
                <div class="col-md-4">
                  <input id="tenant_postcode" type="text" class="form-control @error('tenant_postcode') is-invalid @enderror mb-2" name="tenant_postcode" value="{{ old('tenant_postcode',  $selected_quote->job->tenant_postcode) }}" placeholder="Please enter the postcode">
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
                  <select name="material_type_id" id="material_type_id" class="custom-select">
                    @if (old('material_type_id'))
                      <option disabled>Please select a roof surface</option>
                      @foreach ($material_types as $material_type)
                        <option value="{{ $material_type->id }}" @if (old('material_type_id') == $material_type->id) selected @endif>{{ $material_type->title }}</option>
                      @endforeach
                    @else
                      @if ($selected_quote->job->material_type_id == null)
                        <option selected disabled>Please select a roof surface</option>
                      @else
                        <option value="{{ $selected_quote->job->material_type_id }}" selected>
                          {{ $selected_quote->job->material_type->title }}
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
                      @if ($selected_quote->job->building_style_id == null)
                        <option selected disabled>Please select a building style</option>
                      @else
                        <option value="{{ $selected_quote->job->building_style_id }}" selected>
                          {{ $selected_quote->job->building_style->title }}
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
                      @if ($selected_quote->job->building_type_id == null)
                        <option selected disabled>Please select a building type</option>
                      @else
                        <option value="{{ $selected_quote->job->building_type_id }}" selected>
                          {{ $selected_quote->job->building_type->title }}
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
                <label for="start_date" class="col-md-3 col-form-label text-md-right">Start Date</label>
                <div class="col-md-5 mb-3">
                  <div class="input-group date" id="start" data-target-input="nearest">
                    <input type="text" name="start_date" class="form-control datetimepicker-input @error('start_date') is-invalid @enderror" data-target="#start" @if ($selected_quote->job->start_date != null) value="{{date('d-m-Y - h:iA', strtotime($selected_quote->job->start_date)) }}" @endif placeholder="Please enter a start date and time"/>
                    <div class="input-group-append" data-target="#start" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                    @error('start_date')
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

              <div class="form-group row">
                <div class="col-md-8 offset-sm-3 mb-2">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="start_date_null" name="start_date_null" {{ old('start_date_null', $selected_quote->job->start_date_null == 1 ? 'checked' : null) ? 'checked' : null }}>
                    <label class="custom-control-label" for="start_date_null">Unknown (Uncheck to set the start date and time)</label>
                  </div>
                </div> {{-- col-md-8 offset-sm-3 --}}
              </div> {{-- form-group row --}}

            </div> {{-- card-body pb-0 --}}
          </div> {{-- card --}}
          {{-- edit job form inputs --}}

        </div> {{-- col-sm-7 --}}
        <div class="col-sm-5">

          {{-- job type selections --}}
          <h5 class="text-primary my-3"><b>Job Types</b></h5>
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
                      @error('job_types')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div> {{-- col-sm-6 --}}
                  @endforeach
                </div> {{-- row --}}
              @endforeach
            </div> {{-- card-body --}}
          </div> {{-- card --}}
          {{-- job type selections --}}

          {{-- public job note --}}
          <h5 class="text-primary my-3"><b>Customer Note</b></h5>
          <div class="form-group row">
            <div class="col-md">
              <textarea class="form-control @error('public_message') is-invalid @enderror mb-2" type="text" name="public_message" rows="5" placeholder="Please enter an optional customer job note" style="resize:none">{{ old('public_message') }}</textarea>
              @error('public_message')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md --}}
          </div> {{-- form-group row --}}
          {{-- public job note --}}

        </div> {{-- col-sm-7 --}}
      </div> {{-- row --}}

      <div class="form-group row py-3">
        <div class="col-md">
          <button type="submit" class="btn btn-primary" name="action" value="update-job">
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
                  <a href="{{ route('customers.show', $selected_quote->customer_id) }}" class="btn btn-dark btn-block">
                    <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                  </a>
                </div> {{-- modal-body --}}
              </div> {{-- modal-content --}}
            </div> {{-- modal-dialog --}}
          </div> {{-- modal fade --}}
          {{-- modal --}}
          {{-- reset modal --}}
          <a href="{{ route('jobs.index') }}" class="btn btn-dark">
            <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
          </a>
        </div>
      </div>

    </form>

  </div> {{-- container --}}
</section> {{-- section --}}

<section class="bg-white">
  <div class="container py-5">

    <div class="row">
      <div class="col-sm-6">

        <h5 class="text-primary my-3"><b>Job Details Quick Reference</b></h5>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>Tenant</th>
                <td>
                  @if ($selected_quote->job->tenant_name == null)
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                    </span>
                  @else
                    {{ $selected_quote->job->tenant_name }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Address</th>
                <td>
                  @if ($selected_quote->job->tenant_street_address == null && $selected_quote->job->tenant_suburb == null && $selected_quote->job->tenant_postcode == null)
                    <span class="badge badge-warning py-2 px-2">
                      <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                    </span>
                  @else
                    @if ($selected_quote->job->tenant_street_address != null){{ $selected_quote->job->tenant_street_address . ', ' }}@endif
                    @if ($selected_quote->job->tenant_suburb != null){{ $selected_quote->job->tenant_suburb . ', ' }}@endif
                    @if ($selected_quote->job->tenant_postcode != null){{ $selected_quote->job->tenant_postcode }}@endif
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table container --}}

      </div> {{-- col-sm-6 --}}
      <div class="col-sm-5 offset-sm-1">

        <h5 class="text-primary my-3"><b>Quote Request Quick Reference</b></h5>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>Building Style</th>
                <td>
                @if ($selected_quote->job->quote_request->building_style_id == null)
                  <span class="badge badge-warning py-2 px-2">
                    <i class="fas fa-times mr-2" aria-hidden="true"></i>The building style has not been set
                  </span>
                @else
                  {{ $selected_quote->job->quote_request->building_style->title }}
                @endif
                </td>
              </tr>
              @if ($selected_quote->job->quote_request->house == 1)
                <tr>
                  <th>Building Type</th>
                  <td>House</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->carport == 1)
                <tr>
                  <th>Building Type</th>
                  <td>Carport</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->veranda == 1)
                <tr>
                  <th>Building Type</th>
                  <td>Veranda</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->pergola == 1)
                <tr>
                  <th>Building Type</th>
                  <td>Pergola</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->garage == 1)
                <tr>
                  <th>Building Type</th>
                  <td>Garage</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->garden_shed == 1)
                <tr>
                  <th>Building Type</th>
                  <td>Garden Shed</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->barn == 1)
                <tr>
                  <th>Building Type</th>
                  <td>Barn</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->retirement_village == 1)
                <tr>
                  <th>Building Type</th>
                  <td>Retirement Village</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->industrial_shed == 1)
                <tr>
                  <th>Building Type</th>
                  <td>Industrial Shed</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->house_unit == 1)
                <tr>
                  <th>Building Type</th>
                  <td>House Unit</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->school_buildings == 1)
                <tr>
                  <th>Building Type</th>
                  <td>School Buildings</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->church == 1)
                <tr>
                  <th>Building Type</th>
                  <td>Church</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->shops == 1)
                <tr>
                  <th>Building Type</th>
                  <td>Shops</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->iron == 1)
                <tr>
                  <th>Roof Surface</th>
                  <td>Iron / Colorbond</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->slate == 1)
                <tr>
                  <th>Roof Surface</th>
                  <td>Slate</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->laserlight == 1)
                <tr>
                  <th>Roof Surface</th>
                  <td>laserlight</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->cement == 1)
                <tr>
                  <th>Roof Surface</th>
                  <td>cement</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->terracotta == 1)
                <tr>
                  <th>Roof Surface</th>
                  <td>terracotta</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->paint == 1)
                <tr>
                  <th>Roof Surface</th>
                  <td>Pre Painted</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->solar_panels == 1)
                <tr>
                  <th>Additions</th>
                  <td>Solar Panels</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->air_conditioner == 1)
                <tr>
                  <th>Additions</th>
                  <td>Air Conditioner</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->pool_heating == 1)
                <tr>
                  <th>Additions</th>
                  <td>Pool Heating</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->under_aerial == 1)
                <tr>
                  <th>Additions</th>
                  <td>Under Aerial</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->walls == 1)
                <tr>
                  <th>Additions</th>
                  <td>Walls</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->additions_laserlight == 1)
                <tr>
                  <th>Additions</th>
                  <td>Additions Laserlight</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->outside_of_gutters == 1)
                <tr>
                  <th>Additions</th>
                  <td>Outside Of Gutters</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->concrete_paths == 1)
                <tr>
                  <th>Additions</th>
                  <td>Concrete Paths</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->additions_other == 1)
                <tr>
                  <th>Additions</th>
                  <td>Additions Other</td>
                </tr>
              @endif
              @if ($selected_quote->job->quote_request->has_water_tanks == 1)
                <tr>
                  <th>Others</th>
                  <td>Has Water Tanks</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div> {{-- table container --}}

      </div> {{-- col-sm-5 offset-sm-1 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}

<section>
  <div class="container py-5">

    <div class="row">
      <div class="col-sm-6">

        <h5 class="text-primary my-3" id="job-type-title"><b>Job Type</b></h5>

        <form action="{{ route('quick-quote.update', $selected_quote->id) }}" method="POST">
          @method('PATCH')
          @csrf

          <div class="table-responsive">
            <table class="table table-bordered table-fullwidth table-striped bg-white">
              <thead class="table-secondary">
                <tr>
                  <th>Job Type</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <div class="field">
                      <select name="job_type_id" class="custom-select @error('job_type_id') is-invalid @enderror">
                        @if ($selected_quote->job_type_id != null)
                          <option value="{{ $selected_quote->job_type_id }}" selected>
                            {{ $selected_quote->job_type->title }}
                          </option>
                          <option disabled>Please select a job type</option>
                        @else
                          <option selected disabled>Please select a job type</option>
                        @endif
                        @foreach ($job_types as $job_type)
                          <option value="{{ $job_type->id }}" @if ($job_type->id == $selected_quote->job_type_id) hidden @endif>
                            {{ $job_type->title }}
                          </option>
                        @endforeach
                      </select>
                      @error('job_type_id')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div> {{-- field --}}
                  </td>
                  <td width="10">
                    <button type="submit" class="btn btn-primary" name="action" value="update-quote-job-type">
                      <i class="fas fa-save"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div> {{-- table-responsive --}}

        </form>

      </div> {{-- col-sm-6 --}}
      <div class="col-sm-5 offset-sm-1">

        <h5 class="text-primary my-3" id="job-type-title"><b>Quote Description</b></h5>

        <form action="{{ route('quick-quote.update', $selected_quote->id) }}" method="POST">
          @method('PATCH')
          @csrf

          <div class="form-group row">
            <div class="col">
              <textarea class="form-control @error('description') is-invalid @enderror" type="text" name="description" rows="3" placeholder="Please enter the quote description" style="resize:none">{{ @old('description', $selected_quote->description) }}</textarea>
              @error('description')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col --}}
          </div> {{-- form-group row --}}

          <button type="submit" class="btn btn-primary" name="action" value="update-quote-description">
            <i class="fas fa-save mr-2" aria-hidden="true"></i>Save
          </button>
        </form>

      </div> {{-- col-sm-5 offset-sm-1 --}}
    </div> {{-- row --}}

    <h5 class="text-primary my-3" id="areas-to-be-treated-title"><b>Areas To Be Treated</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white text-nowrap">
        <thead class="table-secondary">
          <tr>
            <th>Building Style</th>
            <th>Building Type</th>
            <th>Roof Surface</th>
            <th width="10%">Roof Area</th>
            <th width="10%">Roof Pitch</th>
            <th width="10%">Total Area</th>
            <th width="10%"></th>
          </tr>
        </thead>
        <tbody>
          @if ($all_areas_to_be_treated_quote_tasks->count())
            @foreach ($all_areas_to_be_treated_quote_tasks as $areas_to_be_treated_quote_task)

              <form action="{{ route('quick-quote.update', $selected_quote->id) }}" method="POST">
                @method('PATCH')
                @csrf

                <tr>
                  <td>
                    @if ($areas_to_be_treated_quote_task->task->building_style_id == null)
                      <span class="badge badge-light">
                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                      </span>
                    @else
                      {{ $areas_to_be_treated_quote_task->task->building_style->title }}
                    @endif
                  </td>
                  <td>
                    @if ($areas_to_be_treated_quote_task->task->building_type_id == null)
                      <span class="badge badge-light">
                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                      </span>
                    @else
                      {{ $areas_to_be_treated_quote_task->task->building_type->title }}
                    @endif
                  </td>
                  <td>
                    @if ($areas_to_be_treated_quote_task->task->material_type_id == null)
                      <span class="badge badge-light">
                        <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                      </span>
                    @else
                      {{ $areas_to_be_treated_quote_task->task->material_type->title }}
                    @endif
                  </td>
                  <td>
                    <input type="text" class="form-control" name="areas_to_be_treated_edit_quantity" value="{{ $areas_to_be_treated_quote_task->quantity }}">
                  </td>
                  <td>
                    <input type="text" class="form-control" name="areas_to_be_treated_edit_roof_pitch" value="{{ $areas_to_be_treated_quote_task->pitch }}">
                  </td>
                  <td>{{ $areas_to_be_treated_quote_task->total_quantity }}</td>
                  <td>

                    <button type="submit" class="btn btn-primary" name="action" value="areas-to-be-treated-update">
                      <i class="fas fa-edit"></i>
                    </button>

                    {{-- delete modal --}}
                    {{-- modal button --}}
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirm-delete-areas-to-be-treated-{{ $areas_to_be_treated_quote_task->id }}">
                      <i class="fas fa-trash-alt" aria-hidden="true"></i>
                    </button>
                    {{-- modal button --}}
                    {{-- modal --}}
                    <div class="modal fade" id="confirm-delete-areas-to-be-treated-{{ $areas_to_be_treated_quote_task->id }}" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-areas-to-be-treated-{{ $areas_to_be_treated_quote_task->id }}Title" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirm-delete-areas-to-be-treated-{{ $areas_to_be_treated_quote_task->id }}Title">Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                  <p class="text-center">Are you sure that you would like to delete this area to be treated?</p>
                                  <input type="hidden" name="quote_task_id" value="{{ $areas_to_be_treated_quote_task->id }}">
                                  <button type="submit" class="btn btn-danger btn-block" name="action" value="areas-to-be-treated-delete">
                                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                                  </button>
                                </div> {{-- modal-body --}}
                            </div> {{-- modal-content --}}
                        </div> {{-- modal-dialog --}}
                    </div> {{-- modal fade --}}
                    {{-- modal --}}
                    {{-- delete modal --}}

                  </td>
                </tr>

              </form>

            @endforeach
          @endif
          <tr> {{-- Add New Task --}}
            <form action="{{ route('quick-quote.update', $selected_quote->id) }}" method="POST">
              @method('PATCH')
              @csrf
              <td>
                <select name="building_style_id" class="custom-select @error('building_style_id') is-invalid @enderror">
                  @if (old('building_style_id'))
                    <option disabled>Please select a building style</option>
                    @foreach ($building_styles as $building_style)
                      <option value="{{ $building_style->id }}" @if (old('building_style_id') == $building_style->id) selected @endif>{{ $building_style->title }}</option>
                    @endforeach
                  @else
                    <option selected disabled>Please select a building style</option>
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
              </td>
              <td>
                <select name="building_type_id" class="custom-select @error('building_type_id') is-invalid @enderror">
                  @if (old('building_type_id'))
                    <option disabled>Please select a building type</option>
                    @foreach ($building_types as $building_type)
                      <option value="{{ $building_type->id }}" @if (old('building_type_id') == $building_type->id) selected @endif>{{ $building_type->title }}</option>
                    @endforeach
                  @else
                    <option selected disabled>Please select a building type</option>
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
              </td>
              <td>
                <select name="material_type_id" class="custom-select @error('material_type_id') is-invalid @enderror">
                  @if (old('material_type_id'))
                    <option disabled>Please select a roof surface</option>
                    @foreach ($material_types as $material_type)
                      <option value="{{ $material_type->id }}" @if (old('material_type_id') == $material_type->id) selected @endif>{{ $material_type->title }}</option>
                    @endforeach
                  @else
                    <option selected disabled>Please select a roof surface</option>
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
              </td>
              <td>
                <input class="form-control @error('roof_area') is-invalid @enderror" type="text" name="roof_area" placeholder="Roof Area" value="{{ old('roof_area') }}">
                @error('roof_area')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </td>
              <td>
                <input class="form-control @error('roof_pitch') is-invalid @enderror" type="text" name="roof_pitch" placeholder="Roof Pitch" value="{{ old('roof_pitch') }}">
                @error('roof_pitch')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </td>
              <td>
                <input class="form-control" type="text" placeholder="Total Area" disabled>
              </td>
              <td width="5%">
                <button type="submit" class="btn btn-primary" name="action" value="areas-to-be-treated-create">
                  <i class="fas fa-plus"></i>
                </button>
              </td>
            </form>
          </tr> {{-- Add New Task --}}
        </tbody>
      </table>
    </div> {{-- table-responsive --}}

    <div class="row pt-2">
      <div class="col-sm-6">

        <h5 class="text-primary my-3" id="additions-title"><b>Additions</b></h5>

        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <thead class="table-secondary">
              <tr>
                <th>Task</th>
                <th>Quantity</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @if ($all_additions_quote_tasks->count())
                @foreach ($all_additions_quote_tasks as $additions_quote_task)
                  <tr>
                    <td>{{ $additions_quote_task->task->title }}</td>
                    <td>{{ $additions_quote_task->quantity }}</td>
                    <td>
                      {{-- delete modal --}}
                      {{-- modal button --}}
                      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirm-delete-additions-{{ $additions_quote_task->id }}">
                        <i class="fas fa-trash-alt" aria-hidden="true"></i>
                      </button>
                      {{-- modal button --}}
                      {{-- modal --}}
                      <div class="modal fade" id="confirm-delete-additions-{{ $additions_quote_task->id }}" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-additions-{{ $additions_quote_task->id }}Title" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="confirm-delete-additions-{{ $additions_quote_task->id }}Title">Delete</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                    <p class="text-center">Are you sure that you would like to delete this addition?</p>
                                    <form action="{{ route('quick-quote.update', $selected_quote->id) }}" method="POST">
                                      @method('PATCH')
                                      @csrf
                                      <input type="hidden" name="quote_task_id" value="{{ $additions_quote_task->id }}">
                                      <button type="submit" class="btn btn-danger btn-block" name="action" value="additions-delete">
                                        <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                                      </button>
                                    </form>
                                  </div> {{-- modal-body --}}
                              </div> {{-- modal-content --}}
                          </div> {{-- modal-dialog --}}
                      </div> {{-- modal fade --}}
                      {{-- modal --}}
                      {{-- delete modal --}}
                    </td>
                  </tr>
                @endforeach
              @endif
              <tr>
                <form action="{{ route('quick-quote.update', $selected_quote->id) }}" method="POST">
                  @method('PATCH')
                  @csrf
                  <td>
                    <select name="addition_id" class="custom-select @error('addition_id') is-invalid @enderror">
                      @if (old('addition_id'))
                        <option disabled>Please select an addition</option>
                        @foreach ($all_available_additions as $available_addition)
                          <option value="{{ $available_addition->id }}" @if (old('addition_id') == $available_addition->id) selected @endif>{{ $available_addition->title }}</option>
                        @endforeach
                      @else
                        <option selected disabled>Please select an addition</option>
                        @foreach ($all_available_additions as $available_addition)
                          <option value="{{ $available_addition->id }}">{{ $available_addition->title }}</option>
                        @endforeach
                      @endif
                    </select>
                    @error('addition_id')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @endif
                  </td>
                  <td width="30%">
                    <input class="form-control @error('quantity') is-invalid @enderror" type="text" name="quantity" value="{{ old('quantity') }}" placeholder="Quantity">
                    @error('quantity')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @endif
                  </td>
                  <td width="10%">
                    <button type="submit" class="btn btn-primary" name="action" value="additions-create">
                      <i class="fas fa-plus"></i>
                    </button>
                  </td>
                </form>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}

        <h5 class="text-primary my-3" id="other-works-title"><b>Other Works</b></h5>

        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <thead class="table-secondary">
              <tr>
                <th>Task</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @if ($all_other_works_quote_tasks->count())
                @foreach ($all_other_works_quote_tasks as $other_works_quote_task)
                  <tr>
                    <td>{{ $other_works_quote_task->task->title }}</td>
                    <td>
                      {{-- delete modal --}}
                      {{-- modal button --}}
                      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirm-delete-other-works-{{ $other_works_quote_task->id }}">
                        <i class="fas fa-trash-alt" aria-hidden="true"></i>
                      </button>
                      {{-- modal button --}}
                      {{-- modal --}}
                      <div class="modal fade" id="confirm-delete-other-works-{{ $other_works_quote_task->id }}" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-other-works-{{ $other_works_quote_task->id }}Title" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="confirm-delete-other-works-{{ $other_works_quote_task->id }}Title">Delete</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                    <p class="text-center">Are you sure that you would like to delete this other works?</p>
                                    <form action="{{ route('quick-quote.update', $selected_quote->id) }}" method="POST">
                                      @method('PATCH')
                                      @csrf
                                      <input type="hidden" name="quote_task_id" value="{{ $other_works_quote_task->id }}">
                                      <button type="submit" class="btn btn-danger btn-block" name="action" value="additions-delete">
                                        <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                                      </button>
                                    </form>
                                  </div> {{-- modal-body --}}
                              </div> {{-- modal-content --}}
                          </div> {{-- modal-dialog --}}
                      </div> {{-- modal fade --}}
                      {{-- modal --}}
                      {{-- delete modal --}}
                    </td>
                  </tr>
                @endforeach
              @endif
              <tr>
                <form action="{{ route('quick-quote.update', $selected_quote->id) }}" method="POST">
                  @method('PATCH')
                  @csrf
                  <td>
                    <select name="other_work_id" class="custom-select @error('other_work_id') is-invalid @enderror">
                      <option selected disabled>Please select an other works</option>
                      @foreach ($all_available_other_works as $available_other_work)
                        <option value="{{ $available_other_work->id }}">{{ $available_other_work->title }}</option>
                      @endforeach
                    </select>
                    @error('other_work_id')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @endif
                  </td>
                  <td width="10">
                    <button type="submit" class="btn btn-primary" name="action" value="other-works-create">
                      <i class="fas fa-plus"></i>
                    </button>
                  </td>
                </form>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}

      </div>
      <div class="col-sm-5 offset-sm-1">

        <h5 class="text-primary my-3"><b>Image Upload</b></h5>

        {{-- dropzone image upload --}}
        {{-- menu tabs --}}
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="pills-none-tab" data-toggle="pill" href="#pills-none" role="tab" aria-controls="pills-none" aria-selected="true">None</a>
          </li>
          @foreach ($image_types as $type)
            <li class="nav-item">
              <a class="nav-link" id="pills-{{ $type->id }}-tab" data-toggle="pill" href="#pills-{{ $type->id }}" role="tab" aria-controls="pills-{{ $type->id }}" aria-selected="false">{{ $type->title }}</a>
            </li>
          @endforeach
        </ul>
        {{-- menu tabs --}}
        {{-- menu panels --}}
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-none" role="tabpanel" aria-labelledby="pills-none-tab">
            <div class="card">
              <div class="card-body text-center">
                Please select an image type from the tabs above
              </div>
            </div>
          </div>
          @foreach ($image_types as $type)
            <div class="tab-pane fade" id="pills-{{ $type->id }}" role="tabpanel" aria-labelledby="pills-{{ $type->id }}-tab">
              <form action="{{ route('job-images.store') }}" class="dropzone" id="uploadImagesForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="job_id" value="{{ $selected_quote->job_id }}">
                <input type="hidden" name="image_type" value="{{ $type->id }}">
              </form>
            <p class="text-center">(This page will automatically reload after successful image uploads)</p>
            </div> {{-- tab-pane fade --}}
          @endforeach
        </div>
        {{-- menu panels --}}
        {{-- dropzone image upload --}}

        {{-- uploaded images --}}
        @if ($image_type_collections->count())
          <h5 class="text-primary my-3"><b>Uploaded Images</b></h5>
          <div class="card">
            <div class="card-body">
              @foreach ($image_type_collections as $collections)
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="imageCollection{{$loop->index}}" onclick="toggle_visibility('{{ $collections->first()->job_image_type->title }}');" checked>
                  <label class="custom-control-label" for="imageCollection{{$loop->index}}">
                    <b>{{ $collections->first()->job_image_type->title }}</b></span> - {{ $collections->last()->staff->getFullNameAttribute() . ' - ' . date('d/m/y', strtotime($collections->last()->created_at)) }}
                  </label>
                </div>
                <div class="" id="{{ $collections->first()->job_image_type->title }}">
                  @foreach ($collections->chunk(2) as $collection_chunk)
                    <div class="container">
                      <div class="row row-cols-2">
                        @foreach ($collection_chunk as $image)
                          <div class="col py-3">
                            {{-- modal start --}}
                            <a class="modal-button" data-target="view-image-{{ $image->id }}">
                              @if ($image->image_path == null)
                                <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                              @else
                                <img class="img-fluid" src="{{ asset($image->image_path) }}" alt="job_image">
                              @endif
                            </a>
                            <div class="modal" id="view-image-{{ $image->id }}">
                              <div class="modal-background"></div>
                              <div class="modal-content">
                                @if ($image->image_path == null)
                                  <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                                @else
                                  <img class="img-fluid" src="{{ asset($image->image_path) }}" alt="job_image">
                                @endif
                              </div> {{-- modal-content --}}
                              <button class="modal-close is-large" aria-label="close"></button>
                            </div> {{-- modal --}}
                            {{-- modal end --}}
                          </div>
                        @endforeach
                      </div>
                    </div>
                  @endforeach
                </div> {{-- visibility div --}}
              @endforeach
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @endif
        {{-- uploaded images --}}

        <h5 class="text-primary my-3" id="additional-comments-title"><b>Additional Comments</b></h5>

        <form action="{{ route('quick-quote.update', $selected_quote->id) }}" method="POST">
          @method('PATCH')
          @csrf

          <select name="default_additional_comment" class="custom-select mb-3">
            <option selected disabled>Please select a default additional comment</option>
            <option value=""></option>
            @foreach ($all_default_additional_comments as $default_additional_comment)
              <option value="{{ $default_additional_comment->id }}">
                {{ substr($default_additional_comment->text, 0, 50) }}{{ strlen($default_additional_comment->text) > 50 ? "..." : "" }}
              </option>
            @endforeach
          </select>

          <div class="field">
            <p class="control">
              <textarea name="additional_comments" rows="5" class="form-control @error('additional_comments') is-invalid @enderror" style="resize:none;" placeholder="Please enter an optional additional comment">{{ $selected_quote->additional_comments, old('additional_comments')  }}</textarea>
            </p> {{-- control --}}
            @error('additional_comments')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div> {{-- field --}}
          <button type="submit" class="btn btn-primary" name="action" value="update-additional-comments">
            <i class="fas fa-save mr-2" aria-hidden="true"></i>Save
          </button>
        </form>

        <h5 class="text-primary my-3" id="default-properties-to-view-title"><b>Properties To View</b></h5>

        <form action="{{ route('quick-quote.update', $selected_quote->id) }}" method="POST">
          @method('PATCH')
          @csrf


          <div class="form-group row">
            <div class="col">
              <select name="default_properties_to_view" id="default_properties_to_view" class="custom-select @error('default_properties_to_view') is-invalid @enderror">
                @if ($selected_quote->job->default_properties_to_view_id == null)
                  <option selected disabled>Please select a default properties to view</option>
                @else
                  <option selected value="{{ $selected_quote->job->default_properties_to_view_id }}">{{ $selected_quote->job->default_properties_to_view->title }}</option>
                  <option disabled>Please select a default properties to view</option>
                @endif
                @foreach ($all_default_properties_to_view as $default_properties_to_view)
                  <option value="{{ $default_properties_to_view->id }}" @if ($default_properties_to_view->id == $selected_quote->job->default_properties_to_view_id) hidden @endif>
                    {{ substr($default_properties_to_view->title, 0, 50) }}{{ strlen($default_properties_to_view->title) > 50 ? "..." : "" }}
                  </option>
                @endforeach
              </select>
              @error('default_properties_to_view')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col --}}
          </div> {{-- form-group row --}}

          <button type="submit" class="btn btn-primary" name="action" value="update-default-properties">
            <i class="fas fa-save mr-2" aria-hidden="true"></i>Save
          </button>
        </form>

      </div> {{-- col-sm-7 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}

<section class="bg-white">
  <div class="container py-5">

    <h5 class="text-primary my-3"><b>Product Calculations</b></h5>

    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white text-nowrap">
        <thead class="table-secondary">
          <tr>
            <th>Total Area</th>
            <th>MPA Coverage</th>
            <th>Mixed Product Amount</th>
            <th>Bottle Size</th>
            <th>Total Product Required</th>
            <th>Total Bottles Required</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              @if (!$selected_quote->quote_tasks->count())
                <span class="badge badge-warning py-2 px-2">
                  <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                </span>
              @else
                {!! $selected_quote->getTotalProductArea() !!}
              @endif
            </td>
            <td>
              @if (!$selected_quote->quote_tasks->count())
                <span class="badge badge-warning py-2 px-2">
                  <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                </span>
              @else
                {{ $selected_quote->mpa_coverage }}
              @endif
            </td>
            <td>
              @if (!$selected_quote->quote_tasks->count())
                <span class="badge badge-warning py-2 px-2">
                  <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                </span>
              @else
                {{ $selected_quote->getTotalMixedProduct() }}
              @endif
            </td>
            <td>
              15L
            </td>
            <td>
              @if (!$selected_quote->quote_tasks->count())
                <span class="badge badge-warning py-2 px-2">
                  <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                </span>
              @else
                {{ $selected_quote->getTotalRequiredProduct() }}
              @endif
            </td>
            <td>
              {{ $selected_quote->getTotalRequiredBottles() }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  </div> {{-- container --}}
</section> {{-- section --}}

@if($fuel_product != null)

<section>
  <div class="container py-5">

    <h5 class="text-primary my-3" id="fuel-calculations-title"><b>Fuel Calculations</b></h5>

    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white text-nowrap">
        <thead class="table-secondary">
          <tr>
            <th>Travel Distance (Km)</th>
            <th>Petrol Price (Per Litre)</th>
            <th>Usage (Per 100Kms)</th>
            <th>Trip Cost</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <form action="{{ route('quick-quote.update', $selected_quote->id) }}" method="POST">
              @method('PATCH')
              @csrf
              <td width="25%">
                <input type="text" name="travel_distance" value="{{ $fuel_product->quantity }}" class="form-control @error('travel_distance') is-invalid @enderror" placeholder="Quantity">
                @error('travel_distance')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </td>
              <td>
                {{ '$' . number_format(($fuel_product->price_per_litre / 100), 2, '.', ',') }}
              </td>
              <td>
                {{ number_format(($fuel_product->usage_per_100_kms), 2, '.', ',') }}
              </td>
              <td>
                {{ '$' . number_format(($fuel_product->total_price / 100), 2, '.', ',') }}
              </td>
              <td width="10%">
                <button type="submit" class="btn btn-primary" name="action" value="fuel-update">
                  <i class="fas fa-edit"></i>
                </button>
              </td>
            </form>
          </tr>
        </tbody>
      </table>
    </div>

  </div> {{-- container --}}
</section> {{-- section --}}

@endif

<section class="bg-white">
  <div class="container py-5">

    <h5 class="text-primary my-3" id="rates-title"><b>Tradespersons Rates</b></h5>

    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white text-nowrap">
        <thead class="table-secondary">
          <tr>
            <th>Title</th>
            <th>Quantity</th>
            <th>Individual Price</th>
            <th>Total Price</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @if ($selected_quote->quote_rates->count())
            @foreach ($selected_quote->quote_rates as $quote_rate)

              <form action="{{ route('quick-quote.update', $selected_quote->id) }}" method="POST">
                @method('PATCH')
                @csrf

                <tr>
                  <td>{{ $quote_rate->rate->title }}</td>
                  <td>
                    <div class="input-group">
                      <input type="text" name="tradesperson_rate_update_quantity" class="form-control" placeholder="Quantity" value="{{ $quote_rate->quantity }}" aria-label="Quantity" aria-describedby="tradespersonRateQtyUpdateInput">
                      <div class="input-group-append">
                        <span class="input-group-text" id="tradespersonRateQtyUpdateInput">Rate</span>
                      </div>
                    </div> {{-- input-group --}}
                  </td>
                  <td>${{ number_format(($quote_rate->individual_price / 100), 2, '.', ',') }}</td>
                  <td>${{ number_format(($quote_rate->total_price / 100), 2, '.', ',') }}</td>
                  <td>
                    <button class="btn btn-primary" name="action" value="rates-update">
                      <i class="fas fa-edit"></i>
                    </button>

                    {{-- delete modal --}}
                    {{-- modal button --}}
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirm-delete-tradesperson-rate-{{ $quote_rate->id }}">
                      <i class="fas fa-trash-alt" aria-hidden="true"></i>
                    </button>
                    {{-- modal button --}}
                    {{-- modal --}}
                    <div class="modal fade" id="confirm-delete-tradesperson-rate-{{ $quote_rate->id }}" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-tradesperson-rate-{{ $quote_rate->id }}Title" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="confirm-delete-tradesperson-rate-{{ $quote_rate->id }}Title">Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p class="text-center">Are you sure that you would like to delete this tradesperson rate?</p>
                            <input type="hidden" name="quote_rate_id" value="{{ $quote_rate->id }}">
                            <button type="submit" class="btn btn-danger btn-block" name="action" value="rates-delete">
                              <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                            </button>
                          </div> {{-- modal-body --}}
                        </div> {{-- modal-content --}}
                      </div> {{-- modal-dialog --}}
                    </div> {{-- modal fade --}}
                    {{-- modal --}}
                    {{-- delete modal --}}
                  </td>
                </tr>

              </form>

            @endforeach
          @endif
          <tr>
            <form action="{{ route('quick-quote.update', $selected_quote->id) }}" method="POST">
              @method('PATCH')
              @csrf
              <td width="25%">
                <select name="tradesperson_new_rate_id" class="custom-select @error('tradesperson_new_rate_id') is-invalid @enderror">
                  <option selected disabled>Please select a rate</option>
                  @foreach ($all_rates as $rate)
                    <option value="{{ $rate->id }}">{{ $rate->title }}</option>
                  @endforeach
                </select>
                @error('tradesperson_new_rate_id')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </td>
              <td>
                <input type="text" name="tradesperson_rate_new_quantity" class="form-control" placeholder="Quantity">
              </td>
              <td>
                <input class="form-control" type="text" placeholder="Individual Price" disabled>
              </td>
              <td>
                <input class="form-control" type="text" placeholder="Total Price" disabled>
              </td>
              <td width="10%">
                <button type="submit" class="btn btn-primary" name="action" value="rates-create">
                  <i class="fas fa-plus"></i>
                </button>
              </td>
            </form>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}

  </div> {{-- container --}}
</section> {{-- section --}}
<section>
  <div class="container py-5">
    <a href="{{ route('quotes.show', $selected_quote->id) }}" class="btn btn-primary">
      <i class="fas fa-arrow-right mr-2" aria-hidden="true"></i>Continue to Quote
    </a>
  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- DropzoneJS JS  --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  Dropzone.options.uploadImagesForm = {
    maxFilesize: 3, // 3MB
    acceptedFiles: ".jpeg,.jpg,.png",
    init: function() {
      this.on('success', function(){
        if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
          location.reload();
        }
      });
    }
  };
</script>
{{-- DropzoneJS JS  --}}
{{-- Toggle Visibility By Id Generic --}}
<script type="text/javascript">
  function toggle_visibility(id) {
    var e = document.getElementById(id);
    if (e.style.display == 'none')
      e.style.display = 'block';
    else
      e.style.display = 'none';
  }
</script>
{{-- Toggle Visibility By Id Generic --}}
{{-- Date Time Picker JS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.28.0/moment.min.js" integrity="sha512-Q1f3TS3vSt1jQ8AwP2OuenztnLU6LwxgyyYOG1jgMW/cbEMHps/3wjvnl1P3WTrF3chJUWEoxDUEjMxDV8pujg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-2JBCbWoMJPH+Uj7Wq5OLub8E5edWHlTM4ar/YJkZh3plwB2INhhOC3eDoqHm1Za/ZOSksrLlURLoyXVdfQXqwg==" crossorigin="anonymous"></script>
<script type="text/javascript">
  $(function () {
    $('#start').datetimepicker({
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
{{-- bootstrap-select js --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/js/bootstrap-select.min.js"></script>
{{-- bootstrap-select js --}}
@endpush