@extends('layouts.app')

@section('title', 'Quote Requests - Convert the selected Quote Request')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">QUOTE REQUESTS</h3>
    <h5>Convert the selected Quote Request</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('main-menu.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Main Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-7">

        {{-- CUSTOMER DETAILS --}}

        <p class="text-primary my-3"><b>Customer Details</b></p>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>Customer Number</th>
                <td>{{ $selected_customer->id }}</td>
              </tr>
              <tr>
                <th>Customer Name</th>
                <td>
                  {{ $selected_customer->getFullNameAttribute() }}
                  @if ($selected_customer->business_name != null)
                    ({{ $selected_customer->business_name }})
                  @endif
                </td>
              </tr>
              <tr>
                <th>Customer Address</th>
                <td>{{ $selected_customer->street_address . ', ' . $selected_customer->suburb . ', ' . $selected_customer->postcode }}</td>
              </tr>
              @if ($selected_customer->home_phone != null)
                <tr>
                  <th>Home Phone Number</th>
                  <td>{{ $selected_customer->home_phone }}</td>
                </tr>
              @endif
              @if ($selected_customer->mobile_phone != null)
                <tr>
                  <th>Mobile Phone Number</th>
                  <td>{{ $selected_customer->mobile_phone }}</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div> {{-- table-responsive --}}

        {{-- CUSTOMER DETAILS --}}

        {{-- JOB DETAILS --}}

        <p class="text-primary my-3"><b>Job Details</b></p>
        <div class="card">
          <div class="card-body">

            <form action="{{ route('convert-quote-requests.store') }}" method="POST">
              @csrf

              <input type="hidden" name="selected_customer_id" value="{{ $selected_customer->id }}">
              <input type="hidden" name="selected_quote_request_id" value="{{ $selected_quote_request->id }}">

              <div class="form-group row">
                <label for="salesperson_id" class="col-md-3 col-form-label text-md-right">Salesperson</label>
                <div class="col-md-8">
                  <select name="salesperson_id" id="salesperson_id" class="custom-select">
                    <option value="{{ auth()->id() }}" selected>{{ auth()->user()->getFullNameAttribute() }}</option>
                    @foreach ($staff_members as $salesperson)
                      <option value="{{ $salesperson->id }}" @if (old('salesperson_id') == $salesperson->id) selected @endif>{{ $salesperson->getFullNameAttribute() }}</option>
                    @endforeach
                  </select>
                  @error('salesperson_id')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> {{-- col-md-8 --}}
              </div> {{-- form-group row --}}

              <div class="form-group row">
                <label for="business_name" class="col-md-3 col-form-label text-md-right">Tenant</label>
                <div class="col-md-8">
                  @if ($selected_customer->business_name == null)
                  <input id="tenant_name" type="text" class="form-control @error('tenant_name') is-invalid @enderror mb-2" name="tenant_name" value="{{ old('tenant_name',  $selected_customer->getFullNameAttribute()) }}" placeholder="Please enter the tenant name">
                  @else
                  <input id="tenant_name" type="text" class="form-control @error('tenant_name') is-invalid @enderror mb-2" name="tenant_name" value="{{ old('tenant_name',  $selected_customer->getFullNameAttribute() .  ' (' . $selected_customer->business_name . ')' ) }}" placeholder="Please enter the tenant name">
                  @endif
                  @error('tenant_name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> {{-- col-md-8 --}}
              </div> {{-- form-group row --}}

              <div class="form-group row">
                <label for="tenant_home_phone" class="col-md-3 col-form-label text-md-right">Home Phone</label>
                <div class="col-md-8">
                  <input id="tenant_home_phone" type="text" class="form-control @error('tenant_home_phone') is-invalid @enderror mb-2" name="tenant_home_phone" value="{{ old('tenant_home_phone', $selected_customer->home_phone) }}" placeholder="Please enter the home phone">
                  @error('tenant_home_phone')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> {{-- col-md-8 --}}
              </div> {{-- form-group row --}}

              <div class="form-group row">
                <label for="tenant_mobile_phone" class="col-md-3 col-form-label text-md-right">Mobile Phone</label>
                <div class="col-md-8">
                  <input id="tenant_mobile_phone" type="text" class="form-control @error('tenant_mobile_phone') is-invalid @enderror mb-2" name="tenant_mobile_phone" value="{{ old('tenant_mobile_phone', $selected_customer->mobile_phone) }}" placeholder="Please enter the mobile phone">
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
                  <input id="tenant_street_address" type="text" class="form-control @error('tenant_street_address') is-invalid @enderror mb-2" name="tenant_street_address" value="{{ old('tenant_street_address', $selected_customer->street_address) }}" placeholder="Please enter the mobile phone">
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
                  <input id="tenant_suburb" type="text" class="form-control @error('tenant_suburb') is-invalid @enderror mb-2" name="tenant_suburb" value="{{ old('tenant_suburb',  $selected_customer->suburb) }}" placeholder="Please enter the suburb">
                  @error('tenant_suburb')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> {{-- col-md-5 --}}
                <div class="col-md-4">
                  <input id="tenant_postcode" type="text" class="form-control @error('tenant_postcode') is-invalid @enderror mb-2" name="tenant_postcode" value="{{ old('tenant_postcode',  $selected_customer->postcode) }}" placeholder="Please enter the postcode">
                  @error('tenant_postcode')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div> {{-- col-md-5 --}}
              </div> {{-- form-group row --}}

              <div class="form-group row">
                <label for="inspection_type_id" class="col-md-3 col-form-label text-md-right">Inspection Type</label>
                <div class="col-md-8">
                  <select name="inspection_type_id" id="inspection_type_id" class="custom-select @error('inspection_type_id') is-invalid @enderror mb-2">
                    @foreach ($inspection_types as $inspection_type)
                      <option value="{{ $inspection_type->id }}" @if (old('inspection_type_id') == $inspection_type->id) selected @endif>{{ $inspection_type->title }}</option>
                    @endforeach
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
                  <div class="input-group date" id="start" data-target-input="nearest">
                    <input type="text" name="inspection_date_time" class="form-control datetimepicker-input @error('start') is-invalid @enderror" data-target="#start" value="{{ old('inspection_date', date('m/d/Y h:iA', strtotime(\Carbon\Carbon::now('Australia/Melbourne')))) }}" placeholder="Please enter the inspection start date and time"/>
                    <div class="input-group-append" data-target="#start" data-toggle="datetimepicker">
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

              <div class="form-group row">
                <div class="col-md-8 offset-sm-3 mb-2">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="inspection_date_null" name="inspection_date_null" {{ old('inspection_date_null', 'checked') ? 'checked' : null }}>
                    <label class="custom-control-label" for="inspection_date_null">Unknown (Uncheck to set the inspection date and time)</label>
                  </div>
                </div> {{-- col-md-8 offset-sm-3 --}}
              </div> {{-- form-group row --}}

          </div> {{-- card-body --}}
        </div> {{-- card --}}

        {{-- JOB DETAILS --}}

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
                      <input type="checkbox" class="custom-control-input @error('job_types') is-invalid @enderror mb-2" name="job_types[{{ $job_type->id }}]" id="job_types[{{ $job_type->id }}]" value="{{ $job_type->id }}" {{ old("job_types.{$job_type->id}") ? 'checked' : null }}>
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

        {{-- public job note --}}
        <p class="text-primary my-3"><b>Customer Notes</b></p>
        <div class="form-group row">
          <div class="col-md">
            <textarea class="form-control @error('public_message') is-invalid @enderror mb-2" type="text" name="public_message" rows="5" placeholder="Please enter an optional customer note" style="resize:none">{{ old('public_message') }}</textarea>
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

  </div> {{-- container --}}
</section> {{-- section --}}
<section class="bg-white">
  <div class="container py-5">

    {{-- Quote your own roof form --}}

    <div class="row">
      <div class="col-sm-8">

        <p class="text-primary my-3"><b>Areas To Be Treated</b></p>

        <div class="row">
          <div class="col-sm">

            <p><b>Building Style</b></p>

            <div class="row">
              <div class="col-md-4 my-2">
                <div class="custom-control custom-radio">
                  <input type="radio" id="buildingStyle1" name="building_style_id" class="custom-control-input @error('building_style_id') is-invalid @enderror mb-2" value="1" @if ($selected_quote_request->building_style_id == 1) checked @endif>
                  <label class="custom-control-label" for="buildingStyle1">Single Storey</label>
                </div>
              </div> {{-- col-md-4 --}}
              <div class="col-md-4 my-2">
                <div class="custom-control custom-radio">
                  <input type="radio" id="buildingStyle2" name="building_style_id" class="custom-control-input @error('building_style_id') is-invalid @enderror mb-2" value="2" @if ($selected_quote_request->building_style_id == 2) checked @endif>
                  <label class="custom-control-label" for="buildingStyle2">Double Storey</label>
                </div>
              </div> {{-- col-md-4 --}}
              <div class="col-md-4 my-2">
                <div class="custom-control custom-radio">
                  <input type="radio" id="buildingStyle3" name="building_style_id" class="custom-control-input @error('building_style_id') is-invalid @enderror mb-2" value="3" @if ($selected_quote_request->building_style_id == 3) checked @endif>
                  <label class="custom-control-label" for="buildingStyle3">Single & Double</label>
                </div>
              </div> {{-- col-md-4 --}}
            </div> {{-- row --}}

            <p class="pt-3"><b>Building Type</b></p>

            <div class="row">
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="house" class="custom-control-input" id="buildingTypeCheck1" @if ($selected_quote_request->house) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck1">House</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="carport" class="custom-control-input" id="buildingTypeCheck2" @if ($selected_quote_request->carport) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck2">Carport</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="veranda" class="custom-control-input" id="buildingTypeCheck3" @if ($selected_quote_request->veranda) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck3">Veranda</label>
                </div>

              </div> {{-- col-sm-4 --}}
            </div> {{-- row --}}

            <div class="row">
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="pergola" class="custom-control-input" id="buildingTypeCheck4" @if ($selected_quote_request->pergola) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck4">Pergola</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="garage" class="custom-control-input" id="buildingTypeCheck5" @if ($selected_quote_request->garage) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck5">Garage</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="garden_shed" class="custom-control-input" id="buildingTypeCheck6" @if ($selected_quote_request->garden_shed) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck6">Garden Shed</label>
                </div>

              </div> {{-- col-sm-4 --}}
            </div> {{-- row --}}

            <div class="row">
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="barn" class="custom-control-input" id="buildingTypeCheck7" @if ($selected_quote_request->barn) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck7">Barn</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="retirement_village" class="custom-control-input" id="buildingTypeCheck8" @if ($selected_quote_request->garden_shed) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck8">Retirement Village</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="industrial_shed" class="custom-control-input" id="buildingTypeCheck9" @if ($selected_quote_request->industrial_shed) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck9">Industrial Shed</label>
                </div>

              </div> {{-- col-sm-4 --}}
            </div> {{-- row --}}

            <div class="row">
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="house_unit" class="custom-control-input" id="buildingTypeCheck10" @if ($selected_quote_request->house_unit) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck10">House Unit</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="school_buildings" class="custom-control-input" id="buildingTypeCheck11" @if ($selected_quote_request->school_buildings) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck11">School Buildings</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="church" class="custom-control-input" id="buildingTypeCheck12" @if ($selected_quote_request->church) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck12">Church</label>
                </div>

              </div> {{-- col-sm-4 --}}
            </div> {{-- row --}}

            <div class="row">
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="shops" class="custom-control-input" id="buildingTypeCheck13" @if ($selected_quote_request->shops) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck13">Shops</label>
                </div>

              </div> {{-- col-sm-4 --}}
            </div> {{-- row --}}

            <p class="pt-3"><b>Roof Surfaces</b></p>

            <div class="row">
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="iron" class="custom-control-input" id="roofSurfaceCheck1" @if ($selected_quote_request->iron) checked @endif>
                  <label class="custom-control-label" for="roofSurfaceCheck1">Colorbond</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="slate" class="custom-control-input" id="roofSurfaceCheck2" @if ($selected_quote_request->slate) checked @endif>
                  <label class="custom-control-label" for="roofSurfaceCheck2">Slate Tiled</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="laserlight" class="custom-control-input" id="roofSurfaceCheck3" @if ($selected_quote_request->laserlight) checked @endif>
                  <label class="custom-control-label" for="roofSurfaceCheck3">Laserlight</label>
                </div>

              </div> {{-- col-sm-4 --}}
            </div> {{-- row --}}

            <div class="row">
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="cement" class="custom-control-input" id="roofSurfaceCheck4" @if ($selected_quote_request->cement) checked @endif>
                  <label class="custom-control-label" for="roofSurfaceCheck4">Cement Tiled</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="terracotta" class="custom-control-input" id="roofSurfaceCheck5" @if ($selected_quote_request->terracotta) checked @endif>
                  <label class="custom-control-label" for="roofSurfaceCheck5">Terracotta Tiled</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="paint" class="custom-control-input" id="roofSurfaceCheck6" @if ($selected_quote_request->paint) checked @endif>
                  <label class="custom-control-label" for="roofSurfaceCheck6">Pre Painted</label>
                </div>

              </div> {{-- col-sm-4 --}}
            </div> {{-- row --}}

            <p class="pt-3"><b>Additions</b></p>

            <div class="row">
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="solar_panels" class="custom-control-input" id="additionsCheck1" @if ($selected_quote_request->solar_panels) checked @endif>
                  <label class="custom-control-label" for="additionsCheck1">Solar Panels</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="air_conditioner" class="custom-control-input" id="additionsCheck2" @if ($selected_quote_request->air_conditioner) checked @endif>
                  <label class="custom-control-label" for="additionsCheck2">Air Conditioner</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="pool_heating" class="custom-control-input" id="additionsCheck3" @if ($selected_quote_request->pool_heating) checked @endif>
                  <label class="custom-control-label" for="additionsCheck3">Pool Heating</label>
                </div>

              </div> {{-- col-sm-4 --}}
            </div> {{-- row --}}

            <div class="row">
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="under_aerial" class="custom-control-input" id="additionsCheck4" @if ($selected_quote_request->under_aerial) checked @endif>
                  <label class="custom-control-label" for="additionsCheck4">Under Aerial</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="walls" class="custom-control-input" id="additionsCheck5" @if ($selected_quote_request->walls) checked @endif>
                  <label class="custom-control-label" for="additionsCheck5">Walls</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="laserlight" class="custom-control-input" id="additionsCheck6" @if ($selected_quote_request->laserlight) checked @endif>
                  <label class="custom-control-label" for="additionsCheck6">Laserlight</label>
                </div>

              </div> {{-- col-sm-4 --}}
            </div> {{-- row --}}

            <div class="row">
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="outside_of_gutters" class="custom-control-input" id="additionsCheck7" @if ($selected_quote_request->outside_of_gutters) checked @endif>
                  <label class="custom-control-label" for="additionsCheck7">Outside of Gutters</label>
                </div>

              </div> {{-- col-sm-6 --}}
            </div> {{-- row --}}

          </div> {{-- col-sm-6 --}}
        </div> {{-- row --}}

        <div class="row">
          <div class="col-sm">

            <p class="pt-3"><b>Others</b></p>

            <div class="form-group row">
              <div class="col-md">
                <textarea class="form-control @error('additions_other') is-invalid @enderror mb-2" type="text" name="additions_other" rows="5" placeholder="Please enter any optional other details" style="resize:none">{{ old('additions_other', $selected_quote_request->additions_other) }}</textarea>
                @error('additions_other')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div> {{-- col-md --}}
            </div> {{-- form-group row --}}

          </div> {{-- col-sm --}}
        </div> {{-- row --}}

        <p><b>Are There Any Water Tanks?</b></p>

        <div class="row">
          <div class="col-sm">

            <div class="form-group row">
              <div class="col-md-4 my-2">
                <div class="custom-control custom-radio">
                  <input type="radio" id="hasWaterTanks" name="has_water_tanks" class="custom-control-input @error('has_water_tanks') is-invalid @enderror mb-2" value="1" @if ($selected_quote_request->has_water_tanks == 1) checked @endif>
                  <label class="custom-control-label" for="hasWaterTanks">Yes</label>
                </div>
              </div> {{-- col-md-4 --}}
              <div class="col-md-4 my-2">
                <div class="custom-control custom-radio">
                  <input type="radio" id="hasNoWaterTanks" name="has_water_tanks" class="custom-control-input @error('has_water_tanks') is-invalid @enderror mb-2" value="0" @if ($selected_quote_request->has_water_tanks == 0) checked @endif>
                  <label class="custom-control-label" for="hasNoWaterTanks">No</label>
                </div>
              </div> {{-- col-md-4 --}}
            </div> {{-- row --}}

          </div> {{-- col-sm --}}
        </div> {{-- row --}}

        <p><b>Further Information</b></p>

        <div class="form-group row">
          <div class="col-md">
            <textarea class="form-control @error('further_information') is-invalid @enderror mb-2" type="text" name="further_information" rows="5" placeholder="Please enter any optional further information" style="resize:none">{{ old('further_information', $selected_quote_request->further_information) }}</textarea>
            @error('further_information')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div> {{-- col-md --}}
        </div> {{-- form-group row --}}

      </div> {{-- col-sm-8 --}}
    </div> {{-- row --}}

    {{-- Quote your own roof form --}}

    <button type="submit" class="btn btn-primary" name="action" value="finish">
      <i class="fas fa-save mr-2" aria-hidden="true"></i>Save and Finish
    </button>
    {{-- reset modal --}}
    {{-- modal button --}}
    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#resetModalCenter">
      <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
    </button>
    {{-- modal button --}}
    {{-- modal --}}
    <div class="modal fade" id="resetModalCenter" tabindex="-1" role="dialog" aria-labelledby="resetModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="resetModalCenterTitle">Reset</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p class="text-center">Are you sure that you would like to reset this form?</p>
            <a href="{{ route('convert-quote-requests.create') }}" class="btn btn-dark btn-block">
              <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
            </a>
          </div> {{-- modal-body --}}
        </div> {{-- modal-content --}}
      </div> {{-- modal-dialog --}}
    </div> {{-- modal fade --}}
    {{-- modal --}}
    {{-- reset modal --}}
    <a href="{{ route('quote-requests.show', $selected_quote_request->id) }}" class="btn btn-dark">
      <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
    </a>

    </form>

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection