@extends('layouts.app')

@section('title', 'Quotes - View All Quote Requests')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">QUOTE</h3>
    <h5>View Selected Quote Requests</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('quote-requests.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Quote Request Menu
        </a>
      </div> {{-- col pb-3 --}}
      @if ($selected_quote_request->job_id != null)
        <div class="col pb-3">
          <a href="{{ route('jobs.show', $selected_quote_request->job_id) }}" class="btn btn-primary btn-block">
            <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Job
          </a>
        </div> {{-- col pb-3 --}}
      @endif
      {{-- show delete button if required --}}
      <div class="col pb-3">
        @if ($selected_quote_request->is_delible == 0)
          <button class="btn btn-danger btn-block" disabled>
            <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete Quote Request
          </button>
        @else
          <form action="{{ route('quote-requests.destroy', $selected_quote_request->id) }}" method="POST">
            @method('DELETE')
            @csrf
            <button class="btn btn-danger btn-block">
              <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete Quote Request
            </button>
          </form>
        @endif
      </div> {{-- col pb-3 --}}
      {{-- show delete button if required --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-6">

        <form action="{{ route('quote-requests.update', $selected_quote_request->id) }}" method="POST">
          @method('PATCH')
          @csrf

          <p class="text-primary my-3"><b>Customer Details</b></p>

            <div class="form-group row">
              <label for="email" class="col-md-3 col-form-label text-md-right">Name</label>
              <div class="col-md-4">
                  <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror mb-2" name="first_name" value="{{ old('first_name', $selected_quote_request->first_name) }}" placeholder="Please enter the first name">
                  @error('first_name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div> {{-- col-md-5 --}}
              <div class="col-md-4">
                  <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror mb-2" name="last_name" value="{{ old('last_name', $selected_quote_request->last_name) }}" placeholder="Please enter the last name">
                  @error('last_name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div> {{-- col-md-5 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
              <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
              <div class="col-md-8">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror mb-2" name="email" value="{{ old('email', $selected_quote_request->email) }}" placeholder="Please enter the email">
                @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div> {{-- col-md-6 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
              <label for="username" class="col-md-3 col-form-label text-md-right">{{ __('Username') }}</label>
              <div class="col-md-8">
                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror mb-2" name="username" value="{{ old('username', $selected_quote_request->username) }}" placeholder="Please enter the username">
                @error('username')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div> {{-- col-md-6 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
              <label for="home_phone" class="col-md-3 col-form-label text-md-right">Home Phone</label>
              <div class="col-md-8">
                <input id="home_phone" type="text" class="form-control @error('home_phone') is-invalid @enderror mb-2" name="home_phone" value="{{ old('home_phone', $selected_quote_request->home_phone) }}" placeholder="Please enter the home phone">
                @error('home_phone')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div> {{-- col-md-8 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
              <label for="mobile_phone" class="col-md-3 col-form-label text-md-right">Mobile Phone</label>
              <div class="col-md-8">
                <input id="mobile_phone" type="text" class="form-control @error('mobile_phone') is-invalid @enderror mb-2" name="mobile_phone" value="{{ old('home_phone', $selected_quote_request->mobile_phone) }}" placeholder="Please enter the mobile phone">
                @error('mobile_phone')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div> {{-- col-md-8 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
              <label for="street_address" class="col-md-3 col-form-label text-md-right">Street Address</label>
              <div class="col-md-8">
                <input id="street_address" type="text" class="form-control @error('street_address') is-invalid @enderror mb-2" name="street_address" value="{{ old('street_address', $selected_quote_request->street_address) }}" placeholder="Please enter the street address">
                @error('street_address')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div> {{-- col-md-6 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
              <label for="email" class="col-md-3 col-form-label text-md-right">Suburb</label>
              <div class="col-md-4">
                <input id="suburb" type="text" class="form-control @error('suburb') is-invalid @enderror mb-2" name="suburb" value="{{ old('suburb', $selected_quote_request->suburb) }}" placeholder="Please enter the suburb">
                @error('suburb')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div> {{-- col-md-5 --}}
              <div class="col-md-4">
                <input id="postcode" type="text" class="form-control @error('postcode') is-invalid @enderror mb-2" name="postcode" value="{{ old('postcode', $selected_quote_request->postcode) }}" placeholder="Please enter the postcode">
                @error('postcode')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div> {{-- col-md-5 --}}
            </div> {{-- form-group row --}}

            <p class="text-primary my-3"><b>Areas To Be Treated</b></p>

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
                  <input type="checkbox" name="house" class="custom-control-input" id="buildingTypeCheck1" @if (old('house', $selected_quote_request->house)) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck1">House</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="carport" class="custom-control-input" id="buildingTypeCheck2" @if (old('carport', $selected_quote_request->carport)) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck2">Carport</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="veranda" class="custom-control-input" id="buildingTypeCheck3" @if (old('veranda', $selected_quote_request->veranda)) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck3">Veranda</label>
                </div>

              </div> {{-- col-sm-4 --}}
            </div> {{-- row --}}

            <div class="row">
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="pergola" class="custom-control-input" id="buildingTypeCheck4" @if (old('pergola', $selected_quote_request->pergola)) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck4">Pergola</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="garage" class="custom-control-input" id="buildingTypeCheck5" @if (old('garage', $selected_quote_request->garage)) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck5">Garage</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="garden_shed" class="custom-control-input" id="buildingTypeCheck6" @if (old('garden_shed', $selected_quote_request->garden_shed)) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck6">Garden Shed</label>
                </div>

              </div> {{-- col-sm-4 --}}
            </div> {{-- row --}}

            <div class="row">
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="barn" class="custom-control-input" id="buildingTypeCheck7" @if (old('barn', $selected_quote_request->barn)) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck7">Barn</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="retirement_village" class="custom-control-input" id="buildingTypeCheck8" @if (old('retirement_village', $selected_quote_request->retirement_village)) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck8">Retirement Village</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="industrial_shed" class="custom-control-input" id="buildingTypeCheck9" @if (old('industrial_shed', $selected_quote_request->industrial_shed)) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck9">Industrial Shed</label>
                </div>

              </div> {{-- col-sm-4 --}}
            </div> {{-- row --}}

            <div class="row">
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="house_unit" class="custom-control-input" id="buildingTypeCheck10" @if (old('house_unit', $selected_quote_request->house_unit)) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck10">House Unit</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="school_buildings" class="custom-control-input" id="buildingTypeCheck11" @if (old('school_buildings', $selected_quote_request->school_buildings)) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck11">School Buildings</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="church" class="custom-control-input" id="buildingTypeCheck12" @if (old('church', $selected_quote_request->church)) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck12">Church</label>
                </div>

              </div> {{-- col-sm-4 --}}
            </div> {{-- row --}}

            <div class="row">
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="shops" class="custom-control-input" id="buildingTypeCheck13" @if (old('shops', $selected_quote_request->shops)) checked @endif>
                  <label class="custom-control-label" for="buildingTypeCheck13">Shops</label>
                </div>

              </div> {{-- col-sm-4 --}}
            </div> {{-- row --}}

            <p class="pt-3"><b>Roof Surfaces</b></p>

            <div class="row">
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="iron" class="custom-control-input" id="roofSurfaceCheck1" @if (old('iron', $selected_quote_request->iron)) checked @endif>
                  <label class="custom-control-label" for="roofSurfaceCheck1">Colorbond</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="slate" class="custom-control-input" id="roofSurfaceCheck2" @if (old('slate', $selected_quote_request->slate)) checked @endif>
                  <label class="custom-control-label" for="roofSurfaceCheck2">Slate Tiled</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="laserlight" class="custom-control-input" id="roofSurfaceCheck3" @if (old('laserlight', $selected_quote_request->laserlight)) checked @endif>
                  <label class="custom-control-label" for="roofSurfaceCheck3">Laserlight</label>
                </div>

              </div> {{-- col-sm-4 --}}
            </div> {{-- row --}}

            <div class="row">
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="cement" class="custom-control-input" id="roofSurfaceCheck4" @if (old('cement', $selected_quote_request->cement)) checked @endif>
                  <label class="custom-control-label" for="roofSurfaceCheck4">Cement Tiled</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="terracotta" class="custom-control-input" id="roofSurfaceCheck5" @if (old('terracotta', $selected_quote_request->terracotta)) checked @endif>
                  <label class="custom-control-label" for="roofSurfaceCheck5">Terracotta Tiled</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="paint" class="custom-control-input" id="roofSurfaceCheck6" @if (old('paint', $selected_quote_request->paint)) checked @endif>
                  <label class="custom-control-label" for="roofSurfaceCheck6">Pre Painted</label>
                </div>

              </div> {{-- col-sm-4 --}}
            </div> {{-- row --}}

            <p class="pt-3"><b>Additions</b></p>

            <div class="row">
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="solar_panels" class="custom-control-input" id="additionsCheck1" @if (old('solar_panels', $selected_quote_request->solar_panels)) checked @endif>
                  <label class="custom-control-label" for="additionsCheck1">Solar Panels</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="air_conditioner" class="custom-control-input" id="additionsCheck2" @if (old('air_conditioner', $selected_quote_request->air_conditioner)) checked @endif>
                  <label class="custom-control-label" for="additionsCheck2">Air Conditioner</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="pool_heating" class="custom-control-input" id="additionsCheck3" @if (old('pool_heating', $selected_quote_request->pool_heating)) checked @endif>
                  <label class="custom-control-label" for="additionsCheck3">Pool Heating</label>
                </div>

              </div> {{-- col-sm-4 --}}
            </div> {{-- row --}}

            <div class="row">
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="under_aerial" class="custom-control-input" id="additionsCheck4" @if (old('under_aerial', $selected_quote_request->under_aerial)) checked @endif>
                  <label class="custom-control-label" for="additionsCheck4">Under Aerial</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="walls" class="custom-control-input" id="additionsCheck5" @if (old('walls', $selected_quote_request->walls)) checked @endif>
                  <label class="custom-control-label" for="additionsCheck5">Walls</label>
                </div>

              </div> {{-- col-sm-4 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="laserlight" class="custom-control-input" id="additionsCheck6" @if (old('laserlight', $selected_quote_request->laserlight)) checked @endif>
                  <label class="custom-control-label" for="additionsCheck6">Laserlight</label>
                </div>

              </div> {{-- col-sm-4 --}}
            </div> {{-- row --}}

            <div class="row">
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="outside_of_gutters" class="custom-control-input" id="additionsCheck7" @if (old('outside_of_gutters', $selected_quote_request->outside_of_gutters)) checked @endif>
                  <label class="custom-control-label" for="additionsCheck7">Outside of Gutters</label>
                </div>

              </div> {{-- col-sm-6 --}}
              <div class="col-sm-4 my-2">

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="concrete_paths" class="custom-control-input" id="additionsCheck8" @if (old('concrete_paths', $selected_quote_request->concrete_paths)) checked @endif>
                  <label class="custom-control-label" for="additionsCheck8">Concrete Paths</label>
                </div>

              </div> {{-- col-sm-6 --}}
            </div> {{-- row --}}

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

            <p class="pt-3"><b>Water Tanks</b></p>
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

            <p class="pt-3"><b>Further Information</b></p>
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

            <p class="pt-3"><b>Generated By</b></p>
            <div class="form-group row">
              <div class="col-md-4 my-2">
                <div class="custom-control custom-radio">
                  <input type="radio" id="isStaffGenerated" name="is_customer_generated" class="custom-control-input @error('is_customer_generated') is-invalid @enderror mb-2" value="1" @if ($selected_quote_request->is_customer_generated == 0) checked @endif>
                  <label class="custom-control-label" for="isStaffGenerated">Staff Member</label>
                </div>
              </div> {{-- col-md-4 --}}
              <div class="col-md-4 my-2">
                <div class="custom-control custom-radio">
                  <input type="radio" id="isCustomerGenerated" name="is_customer_generated" class="custom-control-input @error('is_customer_generated') is-invalid @enderror mb-2" value="0" @if ($selected_quote_request->is_customer_generated == 1) checked @endif>
                  <label class="custom-control-label" for="isCustomerGenerated">Customer</label>
                </div>
              </div> {{-- col-md-4 --}}
            </div> {{-- row --}}

            <div class="btn-toolbar" role="toolbar">
              <div class="btn-group mb-2 mr-2" role="group" aria-label="First group">

                @if ($selected_quote_request->job()->exists())
                  <button type="submit" class="btn btn-primary" name="action" value="update" @if ($selected_quote_request->job->has('quotes')) disabled @endif>
                    <i class="fas fa-edit mr-2" aria-hidden="true"></i>Update
                  </button>
                @else
                  <button type="submit" class="btn btn-primary" name="action" value="update">
                    <i class="fas fa-edit mr-2" aria-hidden="true"></i>Update
                  </button>
                @endif

        </form>

              </div>
              <div class="btn-group mb-2 mr-2" role="group" aria-label="Second group">

                <a href="{{ route('quote-requests.show', $selected_quote_request->id) }}" class="btn btn-dark">
                  <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                </a>

              </div>
              <div class="btn-group mb-2 mr-2" role="group" aria-label="Third group">

                <a href="{{ route('quote-requests.index') }}" class="btn btn-dark">
                  <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
                </a>

              </div>
              <div class="btn-group mb-2" role="group" aria-label="fourth group">

                {{-- actions --}}
                @if ($selected_quote_request->quote_request_status_id == 3) {{-- complete --}}
                  <button type="button" class="btn btn-primary" disabled>
                    <i class="fas fa-plus mr-2" aria-hidden="true"></i>Convert
                  </button>
                @else
                  <form action="{{ route('convert-quote-requests.update', $selected_quote_request->id) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <button type="submit" class="btn btn-primary">
                      <i class="fas fa-plus mr-2" aria-hidden="true"></i>Convert
                    </button>
                  </form>
                @endif
                {{-- actions --}}

            </div>
          </div>

      </div> {{-- col-sm-6 --}}
      <div class="col-sm-6">

        <p class="text-primary my-3"><b>Uploaded Images</b></p>

        @if (!$selected_quote_request->quote_request_images->count())
          <div class="card">
            <div class="card-body text-center">
              <h5>There are no images to display</h5>
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @else
          <div class="row row-cols-sm-2">
            @foreach ($selected_quote_request->quote_request_images as $image)
              <div class="col my-3">
                {{-- image modal --}}
                {{-- modal button --}}
                <a href="#" data-toggle="modal" data-target="#view-image-modal-{{$image->id}}">
                  @if ($image->image_path == null)
                    <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                  @else
                    <img class="img-fluid" src="{{ asset($image->image_path) }}" alt="job_image">
                  @endif
                </a>
                {{-- modal button --}}
                {{-- modal --}}
                <div class="modal fade" id="view-image-modal-{{$image->id}}" tabindex="-1" role="dialog" aria-labelledby="view-image-modal-{{$image->id}}Title" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="view-image-modal-{{$image->id}}Title">{{ $image->image_identifier }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body pt-0 pl-0 pr-0 pb-0 mt-0">
                        <a href="{{ route('job-images.show', $image->id) }}">
                          @if ($image->image_path == null)
                            <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/home-256x256.jpg') }}" alt="home-256x256">
                          @else
                            <img class="img-fluid" src="{{ asset($image->image_path) }}" alt="job_image">
                          @endif
                        </a>
                      </div> {{-- modal-body --}}
                    </div> {{-- modal-content --}}
                  </div> {{-- modal-dialog --}}
                </div> {{-- modal fade --}}
                {{-- modal --}}
                {{-- image modal --}}
              </div>
            @endforeach
          </div> {{-- row row-cols-sm-6 --}}

        @endif

      </div> {{-- col-sm-6 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection