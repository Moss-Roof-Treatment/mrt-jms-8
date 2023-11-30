@extends('layouts.app')

@section('title', '- Contractors - View Selected Contractors')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">CONTRACTORS</h3>
    <h5>View Selected Contractor</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('contractors.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Contractor Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('contractor-qualifications.index', ['selected_user_id' => $selected_user->id]) }}" class="btn btn-primary btn-block">
          <i class="fas fa-id-card-alt mr-2" aria-hidden="true"></i>Qualifications
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('contractor-testimonials.index', ['selected_user_id' => $selected_user->id]) }}" class="btn btn-primary btn-block">
          <i class="fas fa-star mr-2" aria-hidden="true"></i>Testimonials
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- body --}}
    <div class="row">
      <div class="col-sm-7">

        <h5 class="text-primary my-3"><b>Contractor Details</b></h5>
        <form action="{{ route('contractors.update', $selected_contractor->id) }}" method="POST" enctype="multipart/form-data">
          @method('PATCH')
          @csrf

          <div class="form-group row">
            <label for="email" class="col-md-3 col-form-label text-md-right">Name</label>
            <div class="col-md-4">
              <input type="text" class="form-control @error('first_name') is-invalid @enderror mb-2" name="first_name" id="first_name" value="{{ old('first_name', $selected_contractor->first_name) }}" placeholder="Please enter the first name">
              @error('first_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-5 --}}
            <div class="col-md-4">
              <input type="text" class="form-control @error('last_name') is-invalid @enderror mb-2" name="last_name" id="last_name" value="{{ old('last_name', $selected_contractor->last_name) }}" placeholder="Please enter the last name">
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
              <input type="email" class="form-control @error('email') is-invalid @enderror mb-2" name="email" id="email" value="{{ old('email', $selected_contractor->email) }}" placeholder="Please enter the email">
              @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-6 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="street_address" class="col-md-3 col-form-label text-md-right">Street Address</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('street_address') is-invalid @enderror mb-2" name="street_address" id="street_address" value="{{ old('street_address', $selected_contractor->street_address) }}" placeholder="Please enter the street address">
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
              <input type="text" class="form-control @error('suburb') is-invalid @enderror mb-2" name="suburb" id="suburb" value="{{ old('suburb', $selected_contractor->suburb) }}" placeholder="Please enter the suburb">
              @error('suburb')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-5 --}}
            <div class="col-md-4">
              <input type="text" class="form-control @error('postcode') is-invalid @enderror mb-2" name="postcode" id="postcode" value="{{ old('postcode', $selected_contractor->postcode) }}" placeholder="Please enter the postcode">
              @error('postcode')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-5 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="state_id" class="col-md-3 col-form-label text-md-right">State</label>
            <div class="col-md-8">
              <select name="state_id" id="state_id" class="custom-select @error('state_id') is-invalid @enderror mb-2">
                @if (old('state_id'))
                  <option disabled>Please select a state</option>
                  @foreach ($all_states as $state)
                    <option value="{{ $state->id }}" @if (old('state_id') == $state->id) selected @endif>{{ $state->title }}</option>
                  @endforeach
                @else
                  @if ($selected_contractor->state_id == null)
                    <option selected disabled>Please select a state</option>
                  @else
                    <option selected value="{{ $selected_contractor->state_id }}">{{ $selected_contractor->state->title }}</option>
                    <option disabled>Please select a state</option>
                  @endif
                  @foreach ($all_states as $state)
                    <option value="{{ $state->id }}">{{ $state->title }}</option>
                  @endforeach
                @endif
              </select>
              @error('state_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-6 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="home_phone" class="col-md-3 col-form-label text-md-right">Home Phone</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('home_phone') is-invalid @enderror mb-2" name="home_phone" id="home_phone" value="{{ old('home_phone', $selected_contractor->home_phone) }}" placeholder="Please enter the home phone">
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
              <input type="text" class="form-control @error('mobile_phone') is-invalid @enderror mb-2" name="mobile_phone" id="mobile_phone" value="{{ old('mobile_phone', $selected_contractor->mobile_phone) }}" placeholder="Please enter the mobile phone">
              @error('mobile_phone')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="user_description" class="col-md-3 col-form-label text-md-right">User Description</label>
            <div class="col-md-8">
              <textarea type="text" class="form-control @error('user_description') is-invalid @enderror mb-2" name="user_description" rows="5" placeholder="Please enter the user description" style="resize:none">{{ old('user_description', $selected_contractor->user_description) }}</textarea>
              @error('user_description')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="color" class="col-md-3 col-form-label text-md-right">User Hex Colour</label>
            <div class="col-md-8">
              <div class="input-group mb-2">
                <input id="color" type="text" class="form-control @error('color') is-invalid @enderror" name="color" value="{{ @old('color', $selected_staff_member->user_color) }}" placeholder="Please enter the 6 digit hexidecimal colour value including the #">
                <div class="input-group-append">
                  <span class="input-group-text" style="background-color:{{ $selected_contractor->user_color }};"><i class="fas fa-calendar-alt" aria-hidden="true"></i></span>
                </div>
              </div> {{-- input-group mb-2 --}}
              @error('color')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="has_commissions" class="col-md-3 col-form-label text-md-right">Receives Commissions</label>
            <div class="col-md-8">
              <div class="custom-control custom-radio custom-control-inline my-2">
                <input type="radio" id="isVisiblecustomRadioInline1" name="has_commissions" class="custom-control-input" value="1" @if ($selected_user->has_commissions == 1) checked @endif>
                <label class="custom-control-label" for="isVisiblecustomRadioInline1">Yes</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline my-2">
                <input type="radio" id="isVisiblecustomRadioInline2" name="has_commissions" class="custom-control-input" value="0" @if ($selected_user->has_commissions == 0) checked @endif>
                <label class="custom-control-label" for="isVisiblecustomRadioInline2">No</label>
              </div>
              @error('has_commissions')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <h5 class="text-primary my-3"><b>Contractor Authentication</b></h5>

          <div class="form-group row">
            <label for="account_class_id" class="col-md-3 col-form-label text-md-right">Account Class</label>
            <div class="col-md-8">
                <select name="account_class_id" class="custom-select @error('account_class_id') is-invalid @enderror mb-2" id="account_class_id">
                  @if (old('account_class_id'))
                    <option disabled>Please select an account class</option>
                    @foreach ($all_account_classes as $account_class)
                      <option value="{{ $account_class->id }}" @if (old('account_class_id') == $account_class->id) selected @endif>{{ $account_class->title }}</option>
                    @endforeach
                  @else
                    @if ($selected_contractor->account_class_id == null)
                      <option selected disabled>Please select a account class</option>
                    @else
                      <option selected value="{{ $selected_contractor->account_class_id }}">{{ $selected_contractor->account_class->title }}</option>
                      <option disabled>Please select an account class</option>
                    @endif
                    @foreach ($all_account_classes as $account_class)
                      <option value="{{ $account_class->id }}">{{ $account_class->title }}</option>
                    @endforeach
                  @endif
                </select>
                @error('account_class_id')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
            </div> {{-- col-md-6 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="account_role_id" class="col-md-3 col-form-label text-md-right">Account Type</label>
            <div class="col-md-8">
                <select name="account_role_id" id="account_role_id" class="custom-select @error('account_role_id') is-invalid @enderror mb-2">
                  @if (old('account_role_id'))
                    <option disabled>Please select an account type</option>
                    @foreach ($all_account_roles as $account_role)
                      <option value="{{ $account_role->id }}" @if (old('account_role_id') == $account_role->id) selected @endif>{{ $account_role->title }}</option>
                    @endforeach
                  @else
                    @if ($selected_contractor->account_role_id == null)
                      <option selected disabled>Please select a account type</option>
                    @else
                      <option selected value="{{ $selected_contractor->account_role_id }}">{{ $selected_contractor->account_role->title }}</option>
                      <option disabled>Please select an account type</option>
                    @endif
                    @foreach ($all_account_roles as $account_role)
                      <option value="{{ $account_role->id }}">{{ $account_role->title }}</option>
                    @endforeach
                  @endif
                </select>
                @error('account_role_id')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
            </div> {{-- col-md-6 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="login_status_id" class="col-md-3 col-form-label text-md-right">Online Access</label>
            <div class="col-md-8">
              <select name="login_status_id" id="login_status_id" class="custom-select @error('login_status_id') is-invalid @enderror mb-2">
                @if ($selected_contractor->login_status_id == null)
                  <option selected disabled>Please select an account type</option>
                @else
                  <option selected value="{{ $selected_contractor->login_status_id }}">{{ $selected_contractor->login_status->title }}</option>
                  <option disabled>Please select an account type</option>
                @endif
                @foreach ($all_login_statuses as $login_status)
                  <option value="{{ $login_status->id }}">{{ $login_status->title }}</option>
                @endforeach
              </select>
              @error('login_status_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="last_login" class="col-md-3 col-form-label text-md-right">Last Login</label>
            <div class="col-md-8 my-2">
              {!! $selected_contractor->getLastLoginAttribute() !!}
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <h5 class="text-primary my-3"><b>Contractor Images</b></h5>

          <div class="form-group row">
            <label for="image" class="col-md-3 col-form-label text-md-right">Image</label>
            <div class="col-md-8 mb-2">
              <div class="custom-file">
                <label class="custom-file-label" for="image" id="image_name">Please select an image to upload</label>
                <input type="file" class="custom-file-input" name="image" id="image" aria-describedby="image">
              </div> {{-- custom-file --}}
              @error('image')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="logo" class="col-md-3 col-form-label text-md-right">Logo</label>
            <div class="col-md-8 mb-2">
              <div class="custom-file">
                <label class="custom-file-label" for="logo" id="logo_name">Please select a logo to upload</label>
                <input type="file" class="custom-file-input" name="logo" id="logo" aria-describedby="logo">
              </div> {{-- custom-file --}}
              @error('logo')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <h5 class="text-primary my-3"><b>Business Details</b></h5>

          <div class="form-group row">
            <label for="business_name" class="col-md-3 col-form-label text-md-right">Business Name</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('business_name') is-invalid @enderror mb-2" name="business_name" id="business_name" value="{{ old('business_name', $selected_contractor->business_name) }}" placeholder="Please enter the business name">
              @error('business_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="abn" class="col-md-3 col-form-label text-md-right">ABN</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('abn') is-invalid @enderror mb-2" name="abn" id="abn" value="{{ old('abn', $selected_contractor->abn) }}" placeholder="Please enter the australian business number">
              @error('abn')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="business_phone" class="col-md-3 col-form-label text-md-right">Business Phone</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('business_phone') is-invalid @enderror mb-2" name="business_phone" id="business_phone" value="{{ old('business_phone', $selected_contractor->business_phone) }}" placeholder="Please enter the business phone">
              @error('business_phone')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="business_position" class="col-md-3 col-form-label text-md-right">Position</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('business_position') is-invalid @enderror mb-2" name="business_position" id="business_position" value="{{ old('business_position', $selected_contractor->business_position) }}" placeholder="Please enter the business position">
              @error('business_position')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="business_contact_phone" class="col-md-3 col-form-label text-md-right">Contact Phone</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('business_contact_phone') is-invalid @enderror mb-2" name="business_contact_phone" id="business_contact_phone" value="{{ old('business_contact_phone', $selected_contractor->business_contact_phone) }}" placeholder="Please enter the business contact phone">
              @error('business_contact_phone')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="business_description" class="col-md-3 col-form-label text-md-right">Business Description</label>
            <div class="col-md-8">
              <textarea type="text" class="form-control @error('business_description') is-invalid @enderror mb-2" name="business_description" rows="5" placeholder="Please enter the business description" style="resize:none">{{ old('business_description', $selected_contractor->business_description) }}</textarea>
              @error('business_description')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="has_gst" class="col-md-3 col-form-label text-md-right">GST</label>
            <div class="col-md-8">
              <div class="custom-control custom-radio custom-control-inline my-2">
                <input type="radio" id="isVisiblecustomRadioInline1" name="has_gst" class="custom-control-input" value="1" @if ($selected_contractor->has_gst == 1) checked @endif>
                <label class="custom-control-label" for="isVisiblecustomRadioInline1">Has GST</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline my-2">
                <input type="radio" id="isVisiblecustomRadioInline2" name="has_gst" class="custom-control-input" value="0" @if ($selected_contractor->has_gst == 0) checked @endif>
                <label class="custom-control-label" for="isVisiblecustomRadioInline2">Does Not Have GST</label>
              </div>
              @error('has_gst')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="super_fund_name" class="col-md-3 col-form-label text-md-right">Super Fund Name</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('super_fund_name') is-invalid @enderror mb-2" name="super_fund_name" id="super_fund_name" value="{{ old('super_fund_name', $selected_tradesperson->super_fund_name) }}" placeholder="Please enter the super fund name">
              @error('super_fund_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="super_member_numnber" class="col-md-3 col-form-label text-md-right">Super Member Number</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('super_member_numnber') is-invalid @enderror mb-2" name="super_member_numnber" id="super_member_numnber" value="{{ old('super_member_numnber', $selected_tradesperson->super_member_numnber) }}" placeholder="Please enter the super member number">
              @error('super_member_numnber')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <h5 class="text-primary my-3"><b>Business Bank Details</b></h5>

          <div class="form-group row">
            <label for="bank_name" class="col-md-3 col-form-label text-md-right">Bank Name</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('bank_name') is-invalid @enderror mb-2" name="bank_name" id="bank_name" value="{{ old('bank_name', $selected_contractor->bank_name) }}" placeholder="Please enter the bank name">
              @error('bank_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="bank_account_name" class="col-md-3 col-form-label text-md-right">Account Name</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('bank_account_name') is-invalid @enderror mb-2" name="bank_account_name" id="bank_account_name" value="{{ old('bank_account_name', $selected_contractor->bank_account_name) }}" placeholder="Please enter the bank account name">
              @error('bank_account_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="bank_bsb" class="col-md-3 col-form-label text-md-right">Bank BSB</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('bank_bsb') is-invalid @enderror mb-2" name="bank_bsb" id="bank_bsb" value="{{ old('bank_bsb', $selected_contractor->bank_bsb) }}" placeholder="Please enter the bank bsb number">
              @error('bank_bsb')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="bank_account_number" class="col-md-3 col-form-label text-md-right">Account Number</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('bank_account_number') is-invalid @enderror mb-2" name="bank_account_number" id="bank_account_number" value="{{ old('bank_account_number', $selected_contractor->bank_account_number) }}" placeholder="Please enter the bank account number">
              @error('bank_account_number')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <h5 class="text-primary my-3"><b>Next of Kin</b></h5>

          <div class="form-group row">
            <label for="kin_name" class="col-md-3 col-form-label text-md-right">Name</label>
            <div class="col-md-8">
                <input id="kin_name" type="text" class="form-control @error('kin_name') is-invalid @enderror mb-2" name="kin_name" value="{{ old('kin_name', $selected_contractor->kin_name) }}" placeholder="Please enter the name">
                @error('kin_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="kin_address" class="col-md-3 col-form-label text-md-right">Address</label>
            <div class="col-md-8">
              <input id="kin_address" type="text" class="form-control @error('kin_address') is-invalid @enderror mb-2" name="kin_address" value="{{ old('kin_address', $selected_contractor->kin_address) }}" placeholder="Please enter the address">
              @error('kin_street_address')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="kin_mobile_phone" class="col-md-3 col-form-label text-md-right">Mobile Phone</label>
            <div class="col-md-8">
              <input id="kin_mobile_phone" type="text" class="form-control @error('kin_mobile_phone') is-invalid @enderror mb-2" name="kin_mobile_phone" value="{{ old('kin_mobile_phone', $selected_contractor->kin_mobile_phone) }}" placeholder="Please enter the mobile phone">
              @error('kin_mobile_phone')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="kin_relationship" class="col-md-3 col-form-label text-md-right">Relationship</label>
            <div class="col-md-8">
              <input id="kin_relationship" type="text" class="form-control @error('kin_relationship') is-invalid @enderror mb-2" name="kin_relationship" value="{{ old('kin_relationship', $selected_contractor->kin_relationship) }}" placeholder="Please enter the relationship">
              @error('kin_relationship')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <div class="col-md-8 offset-md-3">
              {{-- edit button --}}
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
              </button>
              {{-- edit button --}}
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
                      <a href="{{ route('contractors.show', $selected_contractor->id )}}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              {{-- cancel button --}}
              <a href="{{ route('contractors.index') }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
              {{-- cancel button --}}
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

        </form>

        {{-- manual update password form --}}
        <h5 class="text-primary my-3"><b>Manually Update Password</b></h5>

        <form action="{{ route('customer-manual-update-password.update', $selected_contractor->id) }}" method="POST">
          @method('PATCH')
          @csrf

          <div class="form-group row">
            <label for="password" class="col-md-3 col-form-label text-md-right">{{ __('Password') }}</label>
            <div class="col-md-8">
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Please enter the new password">
              @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-6 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="password-confirm" class="col-md-3 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
            <div class="col-md-8">
              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Please confirm the new password">
            </div> {{-- col-md-6 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <div class="col-md-8 offset-md-3">
              {{-- edit button --}}
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
              </button>
              {{-- edit button --}}
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

        </form>
        {{-- manual update password form --}}

      </div> {{-- col-sm-7 --}}
      <div class="col-sm-5">

        <div class="row">
          <div class="col-sm-6">

            <h5 class="text-primary my-3"><b>Contractor Image</b></h5>
            @if ($selected_contractor->image_path == null)  
              <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset('storage/images/placeholders/user-256x256.jpg') }}">
            @else
              <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset($selected_contractor->image_path) }}">
            @endif

          </div> {{-- col-sm-6 --}}
          <div class="col-sm-6">

            <h5 class="text-primary my-3"><b>Contractor Logo</b></h5>
            @if ($selected_contractor->logo_path == null)  
              <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset('storage/images/placeholders/briefcase-256x256.jpg') }}">
            @else
              <img class="img-fluid shadow-sm mx-auto d-block" src="{{ asset($selected_contractor->logo_path) }}">
            @endif

          </div> {{-- col-sm-6 --}}
        </div> {{-- row --}}

      </div> {{-- col-sm-5 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
<script>
  // Display the filename of the selected file to the user in the view from the upload form.
  var image = document.getElementById("image");
  image.onchange = function(){
    if (image.files.length > 0)
    {
      document.getElementById('image_name').innerHTML = image.files[0].name;
    }
  };

  // Display the filename of the selected file to the user in the view from the upload form.
  var logo = document.getElementById("logo");
  logo.onchange = function(){
    if (logo.files.length > 0)
    {
      document.getElementById('logo_name').innerHTML = logo.files[0].name;
    }
  };
</script>
@endpush