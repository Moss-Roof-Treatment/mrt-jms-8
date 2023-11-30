@extends('layouts.profile')

@section('title', '- Profile - View My Profile')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">MY PROFILE</h3>
    <h5>View My Personal Details</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('profile.index') }}" class="btn btn-primary btn-block">
          <i class="fas fa-user mr-2" aria-hidden="true"></i>Personal Details
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('profile-financial-details.index') }}" class="btn btn-primary btn-block">
          <i class="fas fa-dollar-sign mr-2" aria-hidden="true"></i>Financial Details
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('profile-qualifications.index') }}" class="btn btn-primary btn-block">
          <i class="fas fa-id-card-alt mr-2" aria-hidden="true"></i>Qualifications
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('profile-testimonials.index') }}" class="btn btn-primary btn-block">
          <i class="fas fa-star mr-2" aria-hidden="true"></i>Testimonials
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- user images --}}
    <div class="row">
      <div class="col-sm-6">
        <h5 class="text-primary my-3"><b>My Image</b></h5>
        @if (auth()->user()->image_path == null)
          <img class="img-fluid mx-auto d-block shadow-sm" src="{{ asset('storage/images/placeholders/user-256x256.jpg') }}">
        @else
          <img class="img-fluid mx-auto d-block shadow-sm" src="{{ asset(auth()->user()->image_path) }}">
        @endif
      </div> {{-- col-sm-6 --}}
      <div class="col-sm-6">
        <h5 class="text-primary my-3"><b>My Logo</b></h5>
        @if (auth()->user()->logo_path == null)
          <img class="img-fluid mx-auto d-block shadow-sm" src="{{ asset('storage/images/placeholders/briefcase-256x256.jpg') }}">
        @else
          <img class="img-fluid mx-auto d-block shadow-sm" src="{{ asset(auth()->user()->logo_path) }}">
        @endif
      </div> {{-- col-sm-6 --}}
    </div> {{-- row --}}
    {{-- user images --}}

    <div class="row">
      <div class="col-sm-6">

        {{-- user detail table --}}
        <h5 class="text-primary my-3"><b>My Details</b></h5>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>Name</th>
                <td>{{ auth()->user()->getFullNameAttribute() }}</td>
              </tr>
              <tr>
                <th>Email</th>
                <td>{{ auth()->user()->email }}</td>
              </tr>
              <tr>
                <th>Street Address</th>
                <td>{{ auth()->user()->street_address }}</td>
              </tr>
              <tr>
                <th>Suburb</th>
                <td>{{ auth()->user()->suburb . ', ' . auth()->user()->postcode }}</td>
              </tr>
              <tr>
                <th>State</th>
                <td>{{ auth()->user()->state->title }}</td>
              </tr>
              <tr>
                <th>Home Phone</th>
                <td>
                  @if (auth()->user()->home_phone == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fa fa-times" aria-hidden="true"></i> Not Applicable
                    </span>
                  @else
                    {{ auth()->user()->home_phone }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Mobile Phone</th>
                <td>{{ auth()->user()->mobile_phone }}</td>
              </tr>
              <tr>
                <th>Account Class</th>
                <td>{{ auth()->user()->account_class->title }}</td>
              </tr>
              <tr>
                <th>Account Type</th>
                <td>{{ auth()->user()->account_role->title }}</td>
              </tr>
              <tr>
                <th>Business Name</th>
                <td>
                  @if (auth()->user()->business_name == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fa fa-times" aria-hidden="true"></i> Not Applicable
                    </span>
                  @else
                    {{ auth()->user()->business_name }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>ABN</th>
                <td>
                  @if (auth()->user()->abn == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fa fa-times" aria-hidden="true"></i> Not Applicable
                    </span>
                  @else
                    {{ auth()->user()->abn }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Business Phone</th>
                <td>
                  @if (auth()->user()->business_phone == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fa fa-times" aria-hidden="true"></i> Not Applicable
                    </span>
                  @else
                    {{ auth()->user()->business_phone }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Last Login</th>
                <td>{!! auth()->user()->getLastLoginDateTime() !!}</td>
              </tr>
            </tbody>
          </table>
        </div>{{-- table-responsive --}}
        {{-- user detail table --}}

      </div> {{-- col-sm-6 --}}
      <div class="col-sm-6">

        {{-- user next of kin detail table --}}
        <h5 class="text-primary my-3"><b>Next Of Kin Details</b></h5>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>Name</th>
                <td>
                  @if (auth()->user()->kin_name == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ auth()->user()->kin_name }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Mobile Phone</th>
                <td>
                  @if (auth()->user()->kin_mobile_phone == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ auth()->user()->kin_mobile_phone }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Street Address</th>
                <td>
                  @if (auth()->user()->kin_address == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ auth()->user()->kin_address }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Relationship</th>
                <td>
                  @if (auth()->user()->kin_relationship == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                    </span>
                  @else
                    {{ auth()->user()->kin_relationship }}
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div>{{-- table-responsive --}}
        {{-- user next of kin detail table --}}

      </div> {{-- col-sm-6 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection