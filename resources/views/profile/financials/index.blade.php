@extends('layouts.profile')

@section('title', '- Profile - View My Financial Details')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">MY PROFILE</h3>
    <h5>View My Financial Details</h5>
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

    {{-- body --}}
    <div class="row pt-3">
      <div class="col-sm-8 offset-sm-2">

        {{-- user detail table --}}
        <h5 class="text-primary my-3"><b>My Financial Details</b></h5>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>Bank Name</th>
                <td>{{ $selected_user->bank_name }}</td>
              </tr>
              <tr>
                <th>Bank BSB</th>
                <td>{{ $selected_user->bank_bsb }}</td>
              </tr>
              <tr>
                <th>Account Name</th>
                <td>{{ $selected_user->bank_account_name }}</td>
              </tr>
              <tr>
                <th>Account Number</th>
                <td>{{ $selected_user->bank_account_number }}</td>
              </tr>
              <tr>
                <th>Super Fund Name</th>
                <td>
                  @if ($selected_user->super_fund_name == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fa fa-times" aria-hidden="true"></i> Not Applicable
                    </span>
                  @else
                    {{ $selected_user->super_fund_name }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>Super Membership Number</th>
                <td>
                  @if ($selected_user->super_member_numnber == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fa fa-times" aria-hidden="true"></i> Not Applicable
                    </span>
                  @else
                    {{ $selected_user->super_member_numnber }}
                  @endif
                </td>
              </tr>
              <tr>
                <th>WorkCover Company Name</th>
                <td>
                  @if ($selected_user->workcover_company_name == null)
                    <span class="badge badge-light py-2 px-2">
                      <i class="fa fa-times" aria-hidden="true"></i> Not Applicable
                    </span>
                  @else
                    {{ $selected_user->workcover_company_name }}
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div>{{-- table-responsive --}}
        {{-- user detail table --}}

      </div>{{-- col-sm-8 offset-sm-1 --}}
    </div>{{-- row --}}
    {{-- body --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection