@extends('layouts.app')

@section('title', '- System - View System')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SYSTEM</h3>
    <h5>View System</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('main-menu.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-th-large mr-2" aria-hidden="true"></i>Main Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('systems.edit', $selected_system->id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit Selected System
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <h5 class="text-primary my-4"><b>General Settings</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <tbody>
          <tr>
            <th>Title</th>
            <td>{{ $selected_system->title }}</td>
          </tr>
          <tr>
            <th>Short Title</th>
            <td>{{ $selected_system->short_title }}</td>
          </tr>
          <tr>
            <th>ABN</th>
            <td>{{ $selected_system->abn }}</td>
          </tr>
          <tr>
            <th>Contact Name</th>
            <td>{{ $selected_system->contact_name }}</td>
          </tr>
          <tr>
            <th>Contact Address</th>
            <td>{{ $selected_system->contact_address }}</td>
          </tr>
          <tr>
            <th>Contact Phone</th>
            <td>{{ substr($selected_system->contact_phone, 0, 4) . ' ' . substr($selected_system->contact_phone, 4, 3) . ' ' . substr($selected_system->contact_phone, 7, 3) }}</td>
          </tr>
          <tr>
            <th>Default SMS Phone</th>
            <td>{{ substr($selected_system->default_sms_phone, 0, 4) . ' ' . substr($selected_system->default_sms_phone, 4, 3) . ' ' . substr($selected_system->default_sms_phone, 7, 3) }}</td>
          </tr>
          <tr>
            <th>Contact Email</th>
            <td>{{ $selected_system->contact_email }}</td>
          </tr>
          <tr>
            <th>Website URL</th>
            <td>{{ $selected_system->website_url }}</td>
          </tr>
          <tr>
            <th>Description</th>
            <td>{{ $selected_system->description }}</td>
          </tr>
          <tr>
            <th>Acronym</th>
            <td>{{ $selected_system->acronym }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}

    <h5 class="text-primary my-4"><b>Branding</b></h5>
    <div class="row">
      <div class="col-sm-3">

        <div class="text-center mb-4">
          <p><b>Logo</b></p>
          @if ($selected_system->logo_path == null)  
            <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/logo-359x190.jpg') }}" alt="">
          @else
            <img class="img-fluid" src="{{ asset($selected_system->logo_path) }}" alt="">
          @endif
        </div>

      </div> {{-- col-sm-3 --}}
      <div class="col-sm-7 offset-sm-1">

        <div class="text-center">
          <p><b>Letterhead</b></p>
          @if ($selected_system->logo_path == null)  
            <img class="img-fluid shadow-sm" src="{{ asset('storage/images/placeholders/letterhead-1000x200.jpg') }}" alt="">
          @else
            <img class="img-fluid" src="{{ asset($selected_system->letterhead_path) }}" alt="">
          @endif
        </div>

      </div> {{-- col-sm-7 offset-sm-1 --}}
    </div> {{-- row --}}

    <h5 class="text-primary my-4"><b>Payment Settings</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <tbody>
          <tr>
            <th>Bank Name</th>
            <td>{{ $selected_system->bank_name }}</td>
          </tr>
          <tr>
            <th>Bank Account Name</th>
            <td>{{ $selected_system->bank_account_name }}</td>
          </tr>
          <tr>
            <th>Bank Account BSB</th>
            <td>{{ $selected_system->bank_bsb_number }}</td>
          </tr>
          <tr>
            <th>Bank Account Number</th>
            <td>{{ $selected_system->bank_account_number }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}

    <h5 class="text-primary my-4"><b>Default Settings</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <tbody>
          <tr>
            <th>Default Tax Amount</th>
            <td>{{ $selected_system->getFormattedDefaultTaxValue() }}</td>
          </tr>
          <tr>
            <th>Default Superannuation Amount</th>
            <td>{{ $selected_system->getFormattedDefaultSuperannuationValue() }}</td>
          </tr>
          <tr>
            <th>Default Commission Amount</th>
            <td>{{ $selected_system->getFormattedDefaultCommissionValue() }}</td>
          </tr>
          <tr>
            <th>Default Petrol Price Per Litre</th>
            <td>{{ '$' . number_format(($selected_system->default_petrol_price / 100), 2, '.', ',') }}</td>
          </tr>
          <tr>
            <th>Default Petrol Consumption Per 100Kms</th>
            <td>{{ number_format(($selected_system->default_petrol_usage), 2, '.', ',') }}</td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection