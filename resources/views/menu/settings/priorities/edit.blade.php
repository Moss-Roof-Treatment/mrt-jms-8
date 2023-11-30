@extends('layouts.app')

@section('title', '- Priorities - Edit Selected Priority')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">PRIORITIES</h3>
    <h5>Edit Selected Priority</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('priority-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Priorities Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-7">

        <p class="text-primary my-3"><b>Edit Priority</b></p>

        <form action="{{ route('priority-settings.update', $selected_priority->id) }}" method="POST">
          @method('PATCH')
          @csrf

          <div class="form-group row">
            <label for="title" class="col-md-2 col-form-label text-md-right">Title</label>
            <div class="col-md-9">
              <input type="text" class="form-control @error('title') is-invalid @enderror mb-2" name="title" id="title" value="{{ old('title', $selected_priority->title) }}" placeholder="Please enter the title" autofocus>
              @error('title')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="resolution_amount" class="col-md-2 col-form-label text-md-right">Resolution</label>
            <div class="col-md-9">
              <select name="resolution_amount" id="resolution_amount" class="custom-select @error('resolution_amount') is-invalid @enderror mb-2">
                <option selected value="{{ $selected_priority->resolution_amount }}">{{ $selected_priority->resolution_amount }}</option>
                <option disabled>Please select a resolution amount</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
              </select>
              @error('resolution_amount')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="resolution_period" class="col-md-2 col-form-label text-md-right">Resolution</label>
            <div class="col-md-9">
              <select name="resolution_period" id="resolution_period" class="custom-select @error('resolution_period') is-invalid @enderror mb-2">
                <option selected value="{{ $selected_priority->resolution_period }}">{{ $selected_priority->resolution_period }}</option>
                <option disabled>Please select a resolution time period</option>
                <option value="hours">Hours</option>
                <option value="days">Days</option>
              </select>
              @error('resolution_period')
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
                @if (old('colour'))
                  <option disabled>Please select a colour</option>
                  @foreach ($all_colours as $colour)
                    <option value="{{ $colour->id }}" @if (old('colour') == $colour->id) selected @endif>{{ $colour->title }}</option>
                  @endforeach
                @else
                  @if ($selected_priority->colour_id == null)
                    <option selected disabled>Please select a colour</option>
                  @else
                    <option selected value="{{ $selected_priority->colour_id }}">{{ $selected_priority->colour->title }}</option>
                    <option disabled>Please select a colour</option>
                  @endif
                  @foreach ($all_colours as $colour)
                    <option @if ($selected_priority->colour_id == $colour->id) hidden @endif value="{{ $colour->id }}">{{ $colour->title }}</option>
                  @endforeach
                @endif
              </select>
              @error('colour')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row mb-0">
            <div class="col-md-9 offset-md-2">
              {{-- create button --}}
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
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
                      <a href="{{ route('priority-settings.edit', $selected_priority->id) }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              {{-- cancel button --}}
              <a href="{{ route('priority-settings.index') }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
              {{-- cancel button --}}
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

        </form>

      </div>
    </div>

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection