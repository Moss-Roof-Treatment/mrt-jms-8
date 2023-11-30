@extends('layouts.app')

@section('title', '- Contractors - Create A New Contractor')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">CONTRACTORS</h3>
    <h5>Create A New Contractor</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('contractors.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Contractor Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-8">

        <h5 class="text-primary my-3"><b>Contractor Details</b></h5>

        <form action="{{ route('contractors.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="form-group row">
            <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
            <div class="col-md-8">
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror mb-2" name="email" value="{{ old('email') }}" placeholder="Please enter the email" autofocus>
              @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-6 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="password" class="col-md-3 col-form-label text-md-right">Password</label>
            <div class="col-md-4">
              <input class="form-control @error('password') is-invalid @enderror mb-2" type="password" name="password" placeholder="Please enter the password">
              @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-5 --}}
            <div class="col-md-4">
              <input class="form-control @error('password_confirmation') is-invalid @enderror mb-2" type="password" name="password_confirmation" placeholder="Please confirm the password">
              @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-5 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="first_name" class="col-md-3 col-form-label text-md-right">Name</label>
            <div class="col-md-4">
                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror mb-2" name="first_name" value="{{ old('first_name') }}" placeholder="Please enter the first name">
                @error('first_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div> {{-- col-md-5 --}}
            <div class="col-md-4">
                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror mb-2" name="last_name" value="{{ old('last_name') }}" placeholder="Please enter the last name">
                @error('last_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div> {{-- col-md-5 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="street_address" class="col-md-3 col-form-label text-md-right">Street Address</label>
            <div class="col-md-8">
              <input id="street_address" type="text" class="form-control @error('street_address') is-invalid @enderror mb-2" name="street_address" value="{{ old('street_address') }}" placeholder="Please enter the street address">
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
              <input id="suburb" type="text" class="form-control @error('suburb') is-invalid @enderror mb-2" name="suburb" value="{{ old('suburb') }}" placeholder="Please enter the suburb">
              @error('suburb')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-5 --}}
            <div class="col-md-4">
              <input id="postcode" type="text" class="form-control @error('postcode') is-invalid @enderror mb-2" name="postcode" value="{{ old('postcode') }}" placeholder="Please enter the postcode">
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
                <option disabled>Please select a state</option>
                <option selected value="7">Victoria</option>
                @foreach ($all_states as $state)
                  <option value="{{ $state->id }}" @if (old('state_id') == $state->id) selected @endif @if ($state->id == 7) hidden @endif>{{ $state->title }}</option>
                @endforeach
              </select>
              @error('state_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="home_phone" class="col-md-3 col-form-label text-md-right">Home Phone</label>
            <div class="col-md-8">
              <input id="home_phone" type="text" class="form-control @error('home_phone') is-invalid @enderror mb-2" name="home_phone" value="{{ old('home_phone') }}" placeholder="Please enter the home phone">
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
              <input id="mobile_phone" type="text" class="form-control @error('mobile_phone') is-invalid @enderror mb-2" name="mobile_phone" value="{{ old('mobile_phone') }}" placeholder="Please enter the mobile phone">
              @error('mobile_phone')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
              <label for="user_description" class="col-md-3 col-form-label text-md-right">Contractor Description</label>
              <div class="col-md-8">
                  <textarea class="form-control @error('user_description') is-invalid @enderror mb-2" type="text" name="user_description" rows="5" placeholder="Please enter the contractor description" style="resize:none">{{ old('user_description') }}</textarea>
                  @error('user_description')
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
              <input id="business_name" type="text" class="form-control @error('business_name') is-invalid @enderror mb-2" name="business_name" value="{{ old('business_name') }}" placeholder="Please enter the business name">
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
              <input id="abn" type="text" class="form-control @error('abn') is-invalid @enderror mb-2" name="abn" value="{{ old('abn') }}" placeholder="Please enter the australian business number">
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
              <input id="business_phone" type="text" class="form-control @error('business_phone') is-invalid @enderror mb-2" name="business_phone" value="{{ old('business_phone') }}" placeholder="Please enter the business phone">
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
              <input id="business_position" type="text" class="form-control @error('business_position') is-invalid @enderror mb-2" name="business_position" value="{{ old('business_position') }}" placeholder="Please enter the contractor position in the business">
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
              <input id="business_contact_phone" type="text" class="form-control @error('business_contact_phone') is-invalid @enderror mb-2" name="business_contact_phone" value="{{ old('business_contact_phone') }}" placeholder="Please enter the contractor contact business phone">
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
                  <textarea class="form-control @error('business_description') is-invalid @enderror mb-2" type="text" name="business_description" rows="5" placeholder="Please enter the business description" style="resize:none">{{ old('business_description') }}</textarea>
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
                <input type="radio" id="isVisiblecustomRadioInline1" name="has_gst" class="custom-control-input" value="1" @if (old('has_gst') == 1) checked @endif>
                <label class="custom-control-label" for="isVisiblecustomRadioInline1">Has GST</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline my-2">
                <input type="radio" id="isVisiblecustomRadioInline2" name="has_gst" class="custom-control-input" value="0" @if (old('has_gst') == 0) checked @endif>
                <label class="custom-control-label" for="isVisiblecustomRadioInline2">Does Not Have GST</label>
              </div>
              @error('has_gst')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <h5 class="text-primary my-3"><b>Business Bank Details</b></h5>

          <div class="form-group row">
            <label for="bank_name" class="col-md-3 col-form-label text-md-right">Bank Name</label>
            <div class="col-md-8">
              <input id="bank_name" type="text" class="form-control @error('bank_name') is-invalid @enderror mb-2" name="bank_name" value="{{ old('bank_name') }}" placeholder="Please enter the business bank name">
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
              <input id="bank_account_name" type="text" class="form-control @error('bank_account_name') is-invalid @enderror mb-2" name="bank_account_name" value="{{ old('bank_account_name') }}" placeholder="Please enter the business bank name">
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
              <input id="bank_bsb" type="text" class="form-control @error('bank_bsb') is-invalid @enderror mb-2" name="bank_bsb" value="{{ old('bank_bsb') }}" placeholder="Please enter the business bank name">
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
              <input id="bank_account_number" type="text" class="form-control @error('bank_account_number') is-invalid @enderror mb-2" name="bank_account_number" value="{{ old('bank_account_number') }}" placeholder="Please enter the business bank account number">
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
                <input id="kin_name" type="text" class="form-control @error('kin_name') is-invalid @enderror mb-2" name="kin_name" value="{{ old('kin_name') }}" placeholder="Please enter the name">
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
              <input id="kin_address" type="text" class="form-control @error('kin_address') is-invalid @enderror mb-2" name="kin_address" value="{{ old('kin_address') }}" placeholder="Please enter the address">
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
              <input id="kin_mobile_phone" type="text" class="form-control @error('kin_mobile_phone') is-invalid @enderror mb-2" name="kin_mobile_phone" value="{{ old('kin_mobile_phone') }}" placeholder="Please enter the mobile phone">
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
              <input id="kin_relationship" type="text" class="form-control @error('kin_relationship') is-invalid @enderror mb-2" name="kin_relationship" value="{{ old('kin_relationship') }}" placeholder="Please enter the relationship">
              @error('kin_relationship')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <h5 class="text-primary my-3"><b>Contractor Images</b></h5>

          <div class="form-group row">
            <label for="image" class="col-md-3 col-form-label text-md-right">Image</label>
            <div class="col-md-8">
              <div class="custom-file">
                <label class="custom-file-label" for="image" id="image_name">Please select an image to upload</label>
                <input type="file" class="custom-file-input" name="image" id="image" aria-describedby="image">
              </div> {{-- custom-file --}}
              @error('image')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="logo" class="col-md-3 col-form-label text-md-right">Logo</label>
            <div class="col-md-8">
              <div class="custom-file">
                <label class="custom-file-label" for="logo" id="logo_name">Please select a logo to upload</label>
                <input type="file" class="custom-file-input" name="logo" id="logo" aria-describedby="logo">
              </div> {{-- custom-file --}}
              @error('logo')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <div class="col-md-8 offset-md-3">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-check mr-2" aria-hidden="true"></i>Create
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
                      <a href="{{ route('contractors.create') }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              <a href="{{ route('contractors.index') }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

        </form>

      </div> {{-- col-sm-7 --}}
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