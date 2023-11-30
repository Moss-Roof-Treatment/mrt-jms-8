@extends('layouts.app')

@section('title', '- Tradesperson Rates - Create New Tradesperson Rates')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">TRADESPERSON RATES</h3>
    <h5>Create New Tradesperson Rate</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('tradesperson-rates.index', ['selected_user_id' => $selected_user->id]) }}" class="btn btn-dark btn-block">
          <i class="fas fa-dollar-sign mr-2" aria-hidden="true"></i>View Rates
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- create new tradesperson rate form --}}
    <h5 class="text-primary my-3"><b>Create New Tradesperson Rate</b></h5>
    <div class="row">
      <div class="col-sm-7">

        <form action="{{ route('tradesperson-rates.store') }}" method="POST">
          @csrf

          <input type="hidden" name="user_id" value="{{ $selected_user->id }}">

          <div class="form-group row">
            <label for="rate_id" class="col-md-3 col-form-label text-md-right">Rate</label>
            <div class="col-md-8">
              <select name="rate_id" id="rate_id" class="custom-select @error('rate_id') is-invalid @enderror mb-2">
                <option selected disabled>Please select a rate</option>
                @foreach ($all_rates as $rate)
                  <option value="{{ $rate->id }}" @if (old('rate_id') == $rate->id) selected @endif>
                    @if ($rate->job_type == null)
                      {{ $rate->title }}
                    @else
                      {{ $rate->title . ' - ' . $rate->job_type->title }}
                    @endif
                    {{ ' - $' . number_format(($rate->price / 100), 2, '.', ',') }}
                  </option>
                @endforeach
              </select>
              @error('rate_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-6 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="price" class="col-md-3 col-form-label text-md-right">Cost Price</label>
            <div class="col-md-8">
              <input type="text" class="form-control @error('price') is-invalid @enderror mb-2" name="price" id="price" value="{{ old('price') }}" placeholder="Please enter the price">
              @error('price')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-3">
              {{-- create button --}}
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-check mr-2" aria-hidden="true"></i>Create
              </button>
              {{-- create button --}}
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
                      <a href="{{ route('tradesperson-rates.create', ['selected_user_id' => $selected_user->id]) }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              {{-- cancel button --}}
              <a href="{{ route('tradesperson-rates.index', ['selected_user_id' => $selected_user->id]) }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
              {{-- cancel button --}}
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

        </form>

      </div> {{-- col-sm-7 --}}
    </div> {{-- row --}}
    {{-- create new tradesperson rate form --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection