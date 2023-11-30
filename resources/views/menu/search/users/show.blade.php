@extends('layouts.jquery')

@section('title', '- Search - Global Customer Search Results')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SEARCH</h3>
    <h5>User Search Results</h5>
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
      <div class="col-sm-6">

        <h5 class="text-primary my-3"><b>Customer Search</b></h5>

        <form action="{{ route('search-user-results.show') }}" method="POST">
          @csrf

          <div class="form-group row">
            <label for="email" class="col-md-3 col-form-label text-md-right">Name</label>
            <div class="col-md-4">
                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror mb-2" name="first_name" value="{{ old('first_name', $data['first_name']) }}" placeholder="Please enter the first name">
                @error('first_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div> {{-- col-md-5 --}}
            <div class="col-md-4">
                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror mb-2" name="last_name" value="{{ old('last_name', $data['last_name']) }}" placeholder="Please enter the last name">
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
              <input id="street_address" type="text" class="form-control @error('street_address') is-invalid @enderror mb-2" name="street_address" value="{{ old('street_address', $data['street_address']) }}" placeholder="Please enter the street address">
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
              <input id="suburb" type="text" class="form-control @error('suburb') is-invalid @enderror mb-2" name="suburb" value="{{ old('suburb', $data['suburb']) }}" placeholder="Please enter the suburb">
              @error('suburb')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-5 --}}
            <div class="col-md-4">
              <input id="postcode" type="text" class="form-control @error('postcode') is-invalid @enderror mb-2" name="postcode" value="{{ old('postcode', $data['postcode']) }}" placeholder="Please enter the postcode">
              @error('postcode')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-5 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('email') is-invalid @enderror mb-2" name="email" id="email" value="{{ old('email', $data['email']) }}" placeholder="Please enter the email">
              @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="home_phone" class="col-md-3 col-form-label text-md-right">Home Phone</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('home_phone') is-invalid @enderror mb-2" name="home_phone" id="home_phone" value="{{ old('home_phone', $data['home_phone']) }}" placeholder="Please enter the home phone">
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
              <input type="text" class="form-control @error('mobile_phone') is-invalid @enderror mb-2" name="mobile_phone" id="mobile_phone" value="{{ old('mobile_phone', $data['mobile_phone']) }}" placeholder="Please enter the home phone">
              @error('mobile_phone')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="business_phone" class="col-md-3 col-form-label text-md-right">Business Phone</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('business_phone') is-invalid @enderror mb-2" name="business_phone" id="business_phone" value="{{ old('business_phone', $data['business_phone']) }}" placeholder="Please enter the home phone">
              @error('business_phone')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <div class="col-md-8 offset-md-3">
              <button type="submit" class="btn btn-primary">
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
                      <a href="{{ route('search-users.index') }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              <a href="{{ route('search.index') }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

        </form>
      </div>{{-- col-sm-6 --}}
      <div class="col-sm-6">

        <h5 class="text-primary my-3"><b>Customer Results</b></h5>

        @if (!$users->count())
          <div class="card">
            <div class="card-body">
              There are no results matching your search criteria
            </div> {{-- card-body --}}
          </div> {{-- card --}}
        @else
          <div class="table-responsive">
            <table class="table table-bordered table-fullwidth table-striped bg-white">
              <thead class="table-secondary">
                <th>Name</th>
                <th>Address</th>
                <th>Options</th>
              </thead>  
              <tbody>
                @foreach ($users as $user)
                  <tr>
                    <td>
                      <b>{{ $user->getFullNameAttribute() }}</b>
                    </td>
                    <td>
                      {{ $user->street_address }}
                    </td>
                    <td class="text-center">
                      <a class="btn btn-primary btn-sm" href="{{ route('customers.show', $user->id) }}"><i class="fas fa-eye mr-2" aria-hidden="true"></i>View</a>
                    </td>                  
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div> {{-- table-responsive --}}
        @endif

      </div> {{-- col-sm-5 --}}   
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection