@extends('layouts.app')

@section('title', '- Settings - Customer Leads Statuses - Edit Selected Customer Leads Status')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">CUSTOMER LEADS STATUSES</h3>
    <h5>Edit Selected Customer Leads Status</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('customer-lead-statuses.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Customer Leads Status Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-7">

        <p class="text-primary my-3"><b>Edit Customer Leads Status</b></p>

        <form action="{{ route('customer-lead-statuses.update', $selected_lead_status->id) }}" method="POST">
          @method('PATCH')
          @csrf

          <div class="form-group row">
            <label for="title" class="col-md-2 col-form-label text-md-right">Title</label>
            <div class="col-md-9">
              <input type="text" class="form-control @error('title') is-invalid @enderror mb-2" name="title" id="title" value="{{ @old('title', $selected_lead_status->title) }}" placeholder="Please enter the title" autofocus>
              @error('title')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="colour" class="col-md-2 col-form-label text-md-right">Colour</label>
            <div class="col-md-9">
              <select name="colour" id="colour" class="custom-select @error('colour') is-invalid @enderror mb-2">
                  <option disabled>Please select a colour</option>
                  @foreach ($all_colours as $colour)
                    <option
                        value="{{ $colour->id }}"
                        @if (old('colour', $selected_lead_status->colour_id) == $colour->id) selected @endif
                        @if ($selected_lead_status->colour_id == $colour->id) hidden @endif
                    >
                        {{ $colour->title }}
                    </option>
                  @endforeach
              </select>
              @error('colour')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="description" class="col-md-2 col-form-label text-md-right">Description</label>
            <div class="col-md-9">
              <textarea class="form-control @error('description') is-invalid @enderror mb-2" type="text" name="description" rows="5" placeholder="Please enter the description" style="resize:none">{{ old('description', $selected_lead_status->description) }}</textarea>
              @error('description')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="is_selectable" class="col-md-2 col-form-label text-md-right">Selectable</label>
            <div class="col-md-9">
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="isSelectablecustomRadioInline1" name="is_selectable" class="custom-control-input" value="1" @if ($selected_lead_status->is_selectable == 1) checked @endif>
                <label class="custom-control-label" for="isSelectablecustomRadioInline1">Is Selectable</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="isSelectablecustomRadioInline2" name="is_selectable" class="custom-control-input" value="0" @if ($selected_lead_status->is_selectable == 0) checked @endif>
                <label class="custom-control-label" for="isSelectablecustomRadioInline2">Is Not Selectable</label>
              </div>
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <div class="col-md-9 offset-md-2">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
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
                      <a href="{{ route('customer-lead-statuses.edit', $selected_lead_status->id) }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              <a href="{{ route('customer-lead-statuses.index') }}" class="btn btn-dark">
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