@extends('layouts.app')

@section('title', 'Main Menu')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SETTINGS</h3>
    <h5>Settings Menu</h5>
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

    {{-- menu items --}}
    <div class="row pt-3">
      <div class="col-sm-4">

        <div class="card mb-4 shadow-sm">
          <div class="card-body">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"><b>Authentication</b></a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('account-classes.index') }}">
                  <i class="fas fa-shield-alt mr-2" aria-hidden="true"></i>Account Classes
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('account-roles.index') }}">
                  <i class="fas fa-shield-alt mr-2" aria-hidden="true"></i>Account Roles
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('login-statuses-settings.index') }}">
                  <i class="fas fa-shield-alt mr-2" aria-hidden="true"></i>Login Statuses
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('contractors.index') }}">
                <i class="fas fa-user-shield mr-2" aria-hidden="true"></i>Contractors
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('customers.index') }}">
                <i class="fas fa-user-shield mr-2" aria-hidden="true"></i>Customers
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('staff.index') }}">
                <i class="fas fa-user-shield mr-2" aria-hidden="true"></i>Staff Members
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('tradespersons.index') }}">
                  <i class="fas fa-user-shield mr-2" aria-hidden="true"></i>Tradespersons
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('user-login-settings.index') }}">
                  <i class="fas fa-user-lock mr-2" aria-hidden="true"></i>User Logins
                </a>
              </li>
              </ul>
          </div> {{-- card-body --}}
        </div> {{-- card --}}

        <div class="card mb-4 shadow-sm">
          <div class="card-body">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"><b>Content</b></a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('content-categories.index') }}">
                <i class="fas fa-folder mr-2" aria-hidden="true"></i>Content Categories
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('content-tags.index') }}">
                  <i class="fas fa-tags mr-2" aria-hidden="true"></i>Content Tags
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('building-style-post-settings.index') }}">
                  <i class="fas fa-list mr-2" aria-hidden="true"></i>Building Type Posts
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('building-style-post-t-settings.index') }}">
                  <i class="fas fa-list mr-2" aria-hidden="true"></i>Building Type Post Types
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('faq-settings.index') }}">
                  <i class="fas fa-list mr-2" aria-hidden="true"></i>Frequently Asked Questions
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('seo-keywords-settings.index') }}">
                  <i class="fas fa-list mr-2" aria-hidden="true"></i>SEO Keywords
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('seo-tags-settings.index') }}">
                  <i class="fas fa-list mr-2" aria-hidden="true"></i>SEO Tags
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('service-area-settings.index') }}">
                  <i class="fas fa-map-marked-alt mr-2" aria-hidden="true"></i>Service Areas
                </a>
              </li>
            </ul>
          </div> {{-- card-body --}}
        </div> {{-- card --}}

        <div class="card mb-4 shadow-sm">
          <div class="card-body">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"><b>Email</b></a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('email-templates.index') }}">
                  <i class="fas fa-at mr-2" aria-hidden="true"></i>Email Templates
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('default-email-response-text.index') }}">
                  <i class="fas fa-paragraph mr-2" aria-hidden="true"></i>Default Email Response Texts
                </a>
              </li>
            </ul>
          </div> {{-- card-body --}}
        </div> {{-- card --}}

      </div> {{-- col-sm-4 --}}
      <div class="col-sm-4">

        <div class="card mb-4 shadow-sm">
          <div class="card-body">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"><b>Equipment</b></a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('equipment-category-settings.index') }}">
                  <i class="fas fa-tools mr-2" aria-hidden="true"></i>Equipment Categories
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('equipment-group-settings.index') }}">
                  <i class="fas fa-tools mr-2" aria-hidden="true"></i>Equipment Groups
                </a>
              </li>
            </ul>
          </div> {{-- card-body --}}
        </div> {{-- card --}}

        <div class="card mb-4 shadow-sm">
          <div class="card-body">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"><b>General</b></a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('building-style-settings.index') }}">
                  <i class="fas fa-building mr-2" aria-hidden="true"></i>Building Styles
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('building-type-settings.index') }}">
                  <i class="fas fa-building mr-2" aria-hidden="true"></i>Building Types
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('colour-settings.index') }}">
                  <i class="fas fa-palette mr-2" aria-hidden="true"></i>Colours
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('customer-lead-statuses.index') }}">
                  <i class="fas fa-user-shield mr-2" aria-hidden="true"></i>Customer Leads Statuses
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('dimensions-settings.index') }}">
                  <i class="fas fa-pencil-ruler mr-2" aria-hidden="true"></i>Dimensions
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('expected-payment-settings.index') }}">
                  <i class="fas fa-dollar-sign mr-2" aria-hidden="true"></i>Expected Payment Methods
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('follow-up-call-settings.index') }}">
                  <i class="fas fa-business-time mr-2" aria-hidden="true"></i>Follow Up Call Statuses
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('inspection-type-settings.index') }}">
                  <i class="fas fa-eye mr-2" aria-hidden="true"></i>Inspection Types
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('manual-testimonials-settings.index') }}">
                  <i class="fas fa-tasks mr-2" aria-hidden="true"></i>Manual Testimonials
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('payment-method-settings.index') }}">
                  <i class="fas fa-dollar-sign mr-2" aria-hidden="true"></i>Payment Methods
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('payment-type-settings.index') }}">
                  <i class="fas fa-dollar-sign mr-2" aria-hidden="true"></i>Payment Types
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('postcode-settings.index') }}">
                  <i class="fas fa-building mr-2" aria-hidden="true"></i>Postcodes
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('priority-settings.index') }}">
                  <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Priorities
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('rate-settings.index') }}">
                  <i class="fas fa-dollar-sign mr-2" aria-hidden="true"></i>Rates
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('referral-settings.index') }}">
                  <i class="fas fa-gift mr-2" aria-hidden="true"></i>Referrals
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('roof-pitch-factor-settings.index') }}">
                  <i class="fas fa-ruler-combined mr-2" aria-hidden="true"></i>Roof Pitch Factor
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('rounding-calculator.index') }}">
                  <i class="fas fa-calculator mr-2" aria-hidden="true"></i>Rounding Calculator
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('survey-settings.index') }}">
                  <i class="fas fa-tasks mr-2" aria-hidden="true"></i>Survey Testimonials
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('task-type-settings.index') }}">
                  <i class="fas fa-briefcase mr-2" aria-hidden="true"></i>Task Types
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('task-settings.index') }}">
                  <i class="fas fa-briefcase mr-2" aria-hidden="true"></i>Tasks
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('terms-and-conditions.index') }}">
                  <i class="fas fa-tasks mr-2" aria-hidden="true"></i>Terms and Conditions
                </a>
              </li>
            </ul>
          </div> {{-- card-body --}}
        </div> {{-- card --}}

      </div> {{-- col-sm-4 --}}
      <div class="col-sm-4">

        <div class="card mb-4 shadow-sm">
          <div class="card-body">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"><b>Jobs</b></a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('default-image-text-settings.index') }}">
                  <i class="fas fa-paragraph mr-2" aria-hidden="true"></i>Default Image Texts
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('default-image-title-settings.index') }}">
                  <i class="fas fa-paragraph mr-2" aria-hidden="true"></i>Default Image Titles
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('default-properties-settings.index') }}">
                  <i class="fas fa-paragraph mr-2" aria-hidden="true"></i>Default Properties To View
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('job-progress-settings.index') }}">
                  <i class="fas fa-business-time mr-2" aria-hidden="true"></i>Job Progress
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('job-status-settings.index') }}">
                  <i class="fas fa-business-time mr-2" aria-hidden="true"></i>Job Status
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('job-type-settings.index') }}">
                  <i class="fas fa-business-time mr-2" aria-hidden="true"></i>Job Types
                </a>
              </li>
            </ul>
          </div> {{-- card-body --}}
        </div> {{-- card --}}

        <div class="card mb-4 shadow-sm">
          <div class="card-body">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"><b>Quotes</b></a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('default-additional-text-settings.index') }}">
                  <i class="fas fa-paragraph mr-2" aria-hidden="true"></i>Default Additional Comments
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('quote-document-settings.index') }}">
                  <i class="fas fa-file-pdf mr-2" aria-hidden="true"></i>Quote Documents
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('quote-request-status-settings.index') }}">
                  <i class="fas fa-business-time mr-2" aria-hidden="true"></i>Quote Request Status
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('quote-sent-status-settings.index') }}">
                  <i class="fas fa-business-time mr-2" aria-hidden="true"></i>Quote Sent Status
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('quote-status-settings.index') }}">
                  <i class="fas fa-business-time mr-2" aria-hidden="true"></i>Quote Status
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('swms-settings.index') }}">
                  <i class="fas fa-clipboard-list mr-2" aria-hidden="true"></i>SWMS
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('swms-questions-settings.index') }}">
                  <i class="fas fa-clipboard-list mr-2" aria-hidden="true"></i>SWMS Questions
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('swms-questions-category-settings.index') }}">
                  <i class="fas fa-clipboard-list mr-2" aria-hidden="true"></i>SWMS Question Categories
                </a>
              </li>
            </ul>
          </div> {{-- card-body --}}
        </div> {{-- card --}}

        <div class="card mb-4 shadow-sm">
          <div class="card-body">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"><b>Store</b></a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('discount-code-settings.index') }}">
                  <i class="fas fa-barcode mr-2" aria-hidden="true"></i>Discount Codes
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('product-settings.index') }}">
                  <i class="fas fa-boxes mr-2" aria-hidden="true"></i>Products
                </a>
              </li>
            </ul>
          </div> {{-- card-body --}}
        </div> {{-- card --}}

        <div class="card mb-4 shadow-sm">
          <div class="card-body">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"><b>Totals</b></a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('task-price-range-settings.index') }}">
                  <i class="fas fa-dollar-sign mr-2" aria-hidden="true"></i>Task Price Ranges
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('product-settings.show', 5) }}">
                  <i class="fas fa-boxes mr-2" aria-hidden="true"></i>Material Product
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('material-type-settings.index') }}">
                  <i class="fas fa-stream mr-2" aria-hidden="true"></i>Roof Surfaces
                </a>
              </li>
            </ul>
          </div> {{-- card-body --}}
        </div> {{-- card --}}


      </div> {{-- col-sm-4 --}}
    </div> {{-- row --}}
    {{-- menu items --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection