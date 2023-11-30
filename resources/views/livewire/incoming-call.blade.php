<div>

  <div class="row">
    <div class="col-sm-6">

      <form action="{{ route('incoming-call.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <h5 class="text-primary my-3"><b>Business Details</b></h5>
        <div class="form-group row">
          <label for="business_name" class="col-md-3 col-form-label text-md-right">Business Name</label>
          <div class="col-md-8">
            <input type="text" class="form-control @error('business_name') is-invalid @enderror mb-2" name="business_name" id="business_name" value="{{ old('business_name') }}" placeholder="Please enter the business name" wire:model="business_name">
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
            <input type="text" class="form-control @error('abn') is-invalid @enderror mb-2" name="abn" id="abn" value="{{ old('abn') }}" placeholder="Please enter the australian business number" wire:model="abn">
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
            <input type="text" class="form-control @error('business_phone') is-invalid @enderror mb-2" name="business_phone" id="business_phone" value="{{ old('business_phone') }}" placeholder="Please enter the business phone" wire:model="business_phone">
            @error('business_phone')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div> {{-- col-md-8 --}}
        </div> {{-- form-group row --}}

        <h5 class="text-primary my-3"><b>Customer Details</b></h5>

        <div class="form-group row">
          <label for="first_name" class="col-md-3 col-form-label text-md-right">First Name</label>
          <div class="col-md-8">
            <input type="text" class="form-control @error('first_name') is-invalid @enderror mb-2" name="first_name" id="first_name" value="{{ old('first_name') }}" placeholder="Please enter the first name" wire:model="first_name">
            @error('first_name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div> {{-- col-md-8 --}}
        </div> {{-- form-group row --}}

        <div class="form-group row">
          <label for="last_name" class="col-md-3 col-form-label text-md-right">Last Name</label>
          <div class="col-md-8">
            <input type="text" class="form-control @error('last_name') is-invalid @enderror mb-2" name="last_name" id="last_name" value="{{ old('last_name') }}" placeholder="Please enter the last name" wire:model="last_name">
            @error('last_name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div> {{-- col-md-8 --}}
        </div> {{-- form-group row --}}

        <div class="form-group row">
          <label for="street_address" class="col-md-3 col-form-label text-md-right">Street Address</label>
          <div class="col-md-8">
            <input type="text" class="form-control @error('street_address') is-invalid @enderror mb-2" name="street_address" id="street_address" value="{{ old('street_address') }}" placeholder="Please enter the street address" wire:model="street_address">
            @error('street_address')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div> {{-- col-md-6 --}}
        </div> {{-- form-group row --}}

        <div wire:ignore id="for-bootstrap-select">
          <div class="form-group row">
            <label for="suburb" class="col-md-3 col-form-label text-md-right">Suburb</label>
            <div class="col-md-8">
              <select name="suburb" id="suburb" class="form-control border selectpicker @error('suburb') is-invalid @enderror mb-2" data-style="bg-white" data-live-search="true" data-size="5" data-container="#for-bootstrap-select">
                <option selected disabled>Please select a suburb</option>
                @foreach ($all_suburbs as $suburb)
                  <option value="{{ $suburb->id }}" @if (old('suburb') == $suburb->id) selected @endif>{{ $suburb->title . ' -  ' . $suburb->code }}</option>
                @endforeach
              </select>
              @error('suburb')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-6 --}}
          </div> {{-- form-group row --}}
        </div>

        <div class="form-group row">
          <label for="state" class="col-md-3 col-form-label text-md-right">State</label>
          <div class="col-md-8">
            <select name="state" id="state" class="custom-select @error('state') is-invalid @enderror mb-2">
              <option disabled>Please select a state</option>
              <option selected value="7">Victoria</option>
              @foreach ($all_states as $state)
                <option value="{{ $state->id }}" @if (old('state') == $state->id) selected @endif @if ($state->id == 7) hidden @endif>{{ $state->title }}</option>
              @endforeach
            </select>
            @error('state')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div> {{-- col-md-8 --}}
        </div> {{-- form-group row --}}

        <div class="form-group row">
          <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
          <div class="col-md-8">
            <input type="email" class="form-control @error('email') is-invalid @enderror mb-2" name="email" id="email" value="{{ old('email') }}" wire:model="email" placeholder="Please enter the email">
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
            <input type="text" class="form-control @error('username') is-invalid @enderror mb-2" name="username" id="username" value="{{ old('username') }}" wire:model="username" placeholder="Please enter the username">
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
            <input type="text" class="form-control @error('home_phone') is-invalid @enderror mb-2" name="home_phone" id="home_phone" value="{{ old('home_phone') }}" wire:model="home_phone" placeholder="Please enter the home phone">
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
            <input type="text" class="form-control @error('mobile_phone') is-invalid @enderror mb-2" name="mobile_phone" id="mobile_phone" value="{{ old('mobile_phone') }}" wire:model="mobile_phone" placeholder="Please enter the mobile phone">
            @error('mobile_phone')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div> {{-- col-md-8 --}}
        </div> {{-- form-group row --}}

        <div class="form-group row">
          <label for="referral_id" class="col-md-3 col-form-label text-md-right">Referral</label>
          <div class="col-md-8">
            <select name="referral_id" id="referral_id" class="custom-select @error('referral_id') is-invalid @enderror mb-2">
              <option selected disabled>Please select a referral</option>
              @foreach ($all_referrals as $referral)
                <option value="{{ $referral->id }}" @if (old('referral_id') == $referral->id) selected @endif>{{ $referral->title }}</option>
              @endforeach
            </select>
            @error('referral_id')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div> {{-- col-md-6 --}}
        </div> {{-- form-group row --}}

        <div class="form-group row">
          <label for="account_class_id" class="col-md-3 col-form-label text-md-right">Account Class</label>
          <div class="col-md-8">
              <select name="account_class_id" id="account_class_id" class="custom-select @error('account_class_id') is-invalid @enderror mb-2">
                <option selected disabled>Please select an account class</option>
                @foreach ($all_account_classes as $account_class)
                  <option value="{{ $account_class->id }}" @if (old('account_class_id') == $account_class->id) selected @endif>{{ $account_class->title }}</option>
                @endforeach
              </select>
              @error('account_class_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
          </div> {{-- col-md-6 --}}
        </div> {{-- form-group row --}}

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

        <div class="form-group row mb-0">
          <div class="col-md-8 offset-md-3">
            <button class="btn btn-primary" type="submit">
              <i class="fas fa-user-plus mr-2" aria-hidden="true"></i>Create
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
                    <a href="{{ route('incoming-call.index') }}" class="btn btn-dark btn-block">
                      <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                    </a>
                  </div> {{-- modal-body --}}
                </div> {{-- modal-content --}}
              </div> {{-- modal-dialog --}}
            </div> {{-- modal fade --}}
            {{-- modal --}}
            {{-- reset modal --}}
            {{-- cancel button --}}
            <a href="{{ route('main-menu.index') }}" class="btn btn-dark">
              <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
            </a>
            {{-- cancel button --}}
          </div>
        </div> {{-- form-group row --}}

      </form>

    </div> {{-- col-sm-6 --}}
    <div class="col-sm-6">

      <h5 class="text-primary my-3"><b>Search Results</b></h5>
      @if ($users == null)
        <div class="card">
          <div class="card-body">
            <h5 class="text-center mb-0">Please fill out the search form</h5>
          </div> {{-- card-body --}}
        </div> {{-- card --}}
      @else
        <table class="table table-bordered table-fullwidth table-striped">
          <thead class="bg-white">
            <tr>
              <th>Firstname</th>
              <th>Lastname</th>
              <th>Email</th>
              <th>Business Name</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @if (!$users->count())
              <tr>
                <td class="text-center" colspan="4">There are no results that match your search criteria</td>
              </tr>
            @else
              @foreach ($users as $user)
                <tr>
                  <td>{{ $user->first_name }}</td>
                  <td>{{ $user->last_name }}</td>
                  <td>{{ $user->email ?? 'Not Applicable' }}</td>
                  <td>{{ $user->business_name ?? 'Not Applicable' }}</td>
                  <td class="text-center">
                    <a href="{{ route('customers.show', $user->id) }}" class="btn btn-primary btn-sm">
                      <i class="fas fa-eye" aria-hidden="true"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      @endif

    </div> {{-- col-sm-6 --}}
  </div> {{-- row --}}

</div>
