@extends('layouts.app')

@section('title', '- System - Edit System')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SYSTEM</h3>
    <h5>Edit System</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('systems.show', 1) }}" class="btn btn-dark btn-block">
          <i class="fas fa-columns mr-2" aria-hidden="true"></i>View System
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-8">

        <h5 class="text-primary my-4"><b>General Settings</b></h5>

        <form action="{{ route('systems.update', $selected_system->id) }}" method="POST" enctype="multipart/form-data">
          @method('PATCH')
          @csrf

          <div class="form-group row">
            <label for="title" class="col-md-3 col-form-label text-md-right">Title</label>
            <div class="col-md-8">
              <input id="title" type="text" class="form-control @error('title') is-invalid @enderror mb-2" name="title" value="{{ $selected_system->title }}" placeholder="Please enter the title" autofocus>
              @error('title')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="abn" class="col-md-3 col-form-label text-md-right">ABN</label>
            <div class="col-md-8">
              <input id="abn" type="text" class="form-control @error('abn') is-invalid @enderror mb-2" name="abn" value="{{ $selected_system->abn }}" placeholder="Please enter the australian business number">
              @error('abn')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="contact_name" class="col-md-3 col-form-label text-md-right">Contact Name</label>
            <div class="col-md-8">
              <input id="contact_name" type="text" class="form-control @error('contact_name') is-invalid @enderror mb-2" name="contact_name" value="{{ $selected_system->contact_name }}" placeholder="Please enter the system contact name">
              @error('contact_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="contact_address" class="col-md-3 col-form-label text-md-right">Contact Address</label>
            <div class="col-md-8">
              <input id="contact_address" type="text" class="form-control @error('contact_address') is-invalid @enderror mb-2" name="contact_address" value="{{ $selected_system->contact_address }}" placeholder="Please enter the system contact address">
              @error('contact_address')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="contact_phone" class="col-md-3 col-form-label text-md-right">Contact Phone</label>
            <div class="col-md-8">
              <input id="contact_phone" type="text" class="form-control @error('contact_phone') is-invalid @enderror mb-2" name="contact_phone" value="{{ $selected_system->contact_phone }}" placeholder="Please enter the system contact phone">
              @error('contact_phone')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="contact_email" class="col-md-3 col-form-label text-md-right">Contact Email</label>
            <div class="col-md-8">
              <input id="contact_email" type="email" class="form-control @error('contact_email') is-invalid @enderror mb-2" name="contact_email" value="{{ $selected_system->contact_email }}" placeholder="Please enter the system contact email">
              @error('contact_email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="website_url" class="col-md-3 col-form-label text-md-right">Website URL</label>
            <div class="col-md-8">
              <input id="website_url" type="text" class="form-control @error('website_url') is-invalid @enderror mb-2" name="website_url" value="{{ $selected_system->website_url }}" placeholder="Please enter the system website url">
              @error('website_url')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="description" class="col-md-3 col-form-label text-md-right">Description</label>
            <div class="col-md-8">
              <textarea class="form-control @error('description') is-invalid @enderror mb-2" type="text" name="description" rows="5" placeholder="Please enter the description" style="resize:none">{{ $selected_system->description }}</textarea>
              @error('description')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="acronym" class="col-md-3 col-form-label text-md-right">Acronym</label>
            <div class="col-md-8">
              <input id="acronym" type="text" class="form-control @error('acronym') is-invalid @enderror mb-2" name="acronym" value="{{ $selected_system->acronym }}" placeholder="Please enter the system acronym">
              @error('acronym')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="letterhead" class="col-md-3 col-form-label text-md-right">Letterhead</label>
            <div class="col-md-8">
              <div class="custom-file">
                <label class="custom-file-label" for="letterhead" id="letterhead_name">Please select a letterhead to upload</label>
                <input type="file" class="custom-file-input" name="letterhead" id="letterhead" aria-describedby="letterhead">
              </div> {{-- custom-file --}}
              @error('letterhead')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="logo" class="col-md-3 col-form-label text-md-right">Logo</label>
            <div class="col-md-8">
              <div class="custom-file">
                <label class="custom-file-label" for="logo" id="logo_name">Please select a logo to upload</label>
                <input type="file" class="custom-file-input" name="logo" id="logo" aria-describedby="image">
              </div> {{-- custom-file --}}
              @error('logo')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <h5 class="text-primary my-4"><b>Payment Settings</b></h5>

          <div class="form-group row">
            <label for="bank_bsb_number" class="col-md-3 col-form-label text-md-right">Bank Account BSB</label>
            <div class="col-md-8">
              <input id="bank_bsb_number" type="text" class="form-control @error('bank_bsb_number') is-invalid @enderror mb-2" name="bank_bsb_number" value="{{ $selected_system->bank_bsb_number }}" placeholder="Please enter the bank_bsb_number">
              @error('bank_bsb_number')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="bank_account_number" class="col-md-3 col-form-label text-md-right">Bank Account Number</label>
            <div class="col-md-8">
              <input id="bank_account_number" type="text" class="form-control @error('bank_account_number') is-invalid @enderror mb-2" name="bank_account_number" value="{{ $selected_system->bank_account_number }}" placeholder="Please enter the bank_account_number">
              @error('bank_account_number')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="bank_account_name" class="col-md-3 col-form-label text-md-right">Bank Account Name</label>
            <div class="col-md-8">
              <input id="bank_account_name" type="text" class="form-control @error('bank_account_name') is-invalid @enderror mb-2" name="bank_account_name" value="{{ $selected_system->bank_account_name }}" placeholder="Please enter the bank_account_name">
              @error('bank_account_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="bank_name" class="col-md-3 col-form-label text-md-right">Bank Name</label>
            <div class="col-md-8">
              <input id="bank_name" type="text" class="form-control @error('bank_name') is-invalid @enderror mb-2" name="bank_name" value="{{ $selected_system->bank_name }}" placeholder="Please enter the bank_name">
              @error('bank_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <h5 class="text-primary my-4"><b>Default Settings</b></h5>

          <div class="form-group row">
            <label for="default_tax_value" class="col-md-3 col-form-label text-md-right">Tax Amount</label>
            <div class="col-md-8">
              <input id="default_tax_value" type="text" class="form-control @error('default_tax_value') is-invalid @enderror mb-2" name="default_tax_value" value="{{ $selected_system->default_tax_value }}" placeholder="Please enter the default_tax_value">
              @error('default_tax_value')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="default_superannuation_value" class="col-md-3 col-form-label text-md-right">Superannuation Amount</label>
            <div class="col-md-8">
              <input id="default_superannuation_value" type="text" class="form-control @error('default_superannuation_value') is-invalid @enderror mb-2" name="default_superannuation_value" value="{{ $selected_system->default_superannuation_value }}" placeholder="Please enter the default_superannuation_value">
              @error('default_superannuation_value')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="default_total_commission" class="col-md-3 col-form-label text-md-right">Commission Amount</label>
            <div class="col-md-8">
              <input id="default_total_commission" type="text" class="form-control @error('default_total_commission') is-invalid @enderror mb-2" name="default_total_commission" value="{{ $selected_system->default_total_commission }}" placeholder="Please enter the default total commission">
              @error('default_total_commission')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="default_petrol_price" class="col-md-3 col-form-label text-md-right">Petrol Price Per Litre</label>
            <div class="col-md-8">
              <input id="default_petrol_price" type="text" class="form-control @error('default_petrol_price') is-invalid @enderror mb-2" name="default_petrol_price" value="{{ number_format(($selected_system->default_petrol_price / 100), 2, '.', ',') }}" placeholder="Please enter the default total commission">
              @error('default_petrol_price')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="default_petrol_usage" class="col-md-3 col-form-label text-md-right">Petrol Consumption Per 100Kms</label>
            <div class="col-md-8">
              <input id="default_petrol_usage" type="text" class="form-control @error('default_petrol_usage') is-invalid @enderror mb-2" name="default_petrol_usage" value="{{ number_format(($selected_system->default_petrol_usage), 2, '.', ',') }}" placeholder="Please enter the default total commission">
              @error('default_petrol_usage')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-8 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-3">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
              </button>
              {{-- reset modal --}}
              {{-- modal button --}}
              <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
              </button>
              {{-- modal button --}}
              {{-- modal --}}
              <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalCenterTitle">Reset</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="text-center">Are you sure that you would like to reset this form?</p>
                      <a href="{{ route('systems.edit', $selected_system->id) }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              <a href="{{ route('systems.show', $selected_system->id) }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

        </form>

      </div> {{-- col-sm-8 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
<script>
  // Display the filename of the selected file to the user in the view from the upload form.
  var letterhead = document.getElementById("letterhead");
  letterhead.onchange = function(){
    if (letterhead.files.length > 0)
    {
      document.getElementById('letterhead_name').innerHTML = letterhead.files[0].name;
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