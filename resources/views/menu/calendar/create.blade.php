@extends('layouts.jquery')

@section('title', 'Calendar - Create A New Calendar Event')

@push('css')
{{-- Datepicker CSS --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-PMjWzHVtwxdq7m7GIxBot5vdxUY+5aKP9wpKtvnNBZrVv1srI8tU6xvFMzG8crLNcMj/8Xl/WWmo/oAP/40p1g==" crossorigin="anonymous" />
{{-- Datepicker CSS --}}
@endpush

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">CALENDAR</h3>
    <h5>Create A New Calendar Event</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('calendar.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-calendar-alt mr-2" aria-hidden="true"></i>View Calendar
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- create calendar event form --}}
    <h5 class="text-primary my-3"><b>Create New Calendar Event</b></h5>
    <div class="row">
      <div class="col-sm-8">

        <form method="POST" action="{{ route('calendar.store')}}">
          @csrf

          <div class="form-group row">
            <label for="title" class="col-md-2 col-form-label text-md-right">Title</label>
            <div class="col-md-9">
              <input type="text" class="form-control @error('title') is-invalid @enderror mb-2" name="title" id="title" value="{{ old('title') }}" placeholder="Please enter the title" autofocus>
              @error('title')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="start" class="col-md-2 col-form-label text-md-right">Start</label>
            <div class="col-md-9 mb-2">
              <div class="input-group date" id="start" data-target-input="nearest">
                <input type="text" name="start" class="form-control datetimepicker-input @error('start') is-invalid @enderror" data-target="#start" @if (old('start'))value="{{ date('d-m-Y - h:iA', strtotime(old('start'))) }}"@endif placeholder="Please enter a start date and time"/>
                <div class="input-group-append" data-target="#start" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                </div>
                @error('start')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="end" class="col-md-2 col-form-label text-md-right">End</label>
            <div class="col-md-9 mb-2">
              <div class="input-group date" id="end" data-target-input="nearest">
                <input type="text" name="end" class="form-control datetimepicker-input @error('end') is-invalid @enderror" data-target="#end" @if (old('end'))value="{{ date('d-m-Y - h:iA', strtotime(old('end'))) }}"@endif placeholder="Please enter an end date and time"/>
                <div class="input-group-append" data-target="#end" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                </div>
                @error('end')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="staff_id" class="col-md-2 col-form-label text-md-right">Staff Member</label>
            <div class="col-md-9">
              <select name="staff_id" id="staff_id" class="custom-select @error('staff_id') is-invalid @enderror mb-2">
                <option selected disabled>Please select a staff member</option>
                @foreach ($staff_members as $staff_member)
                  <option value="{{ $staff_member->id }}" @if (old('staff_id') == $staff_member->id) selected @endif>{{ $staff_member->getFullNameTitleAttribute() }}</option>
                @endforeach
              </select>
              @error('staff_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="is_personal" class="col-md-2 col-form-label text-md-right">Is Personal</label>
            <div class="col-md-9">
              <div class="custom-control custom-radio custom-control-inline my-2">
                <input type="radio" id="isPersonalRadioInline1" name="is_personal" class="custom-control-input @error('is_personal') is-invalid @enderror mt-2" value="0" @if (old('is_personal') == 0) checked @endif>
                <label class="custom-control-label" for="isPersonalRadioInline1">Is Not Personal</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline my-2">
                <input type="radio" id="isPersonalRadioInline2" name="is_personal" class="custom-control-input @error('is_personal') is-invalid @enderror mt-2" value="1" @if (old('is_personal') == 1) checked @endif>
                <label class="custom-control-label" for="isPersonalRadioInline2">Is Personal</label>
              </div>
              @error('is_personal')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="description" class="col-md-2 col-form-label text-md-right">Description</label>
            <div class="col-md-9">
              <textarea class="form-control @error('description') is-invalid @enderror mb-2" type="text" name="description" rows="5" placeholder="Please enter the description" style="resize:none">{{ old('description') }}</textarea>
              @error('description')
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
                      <a href="{{ route('calendar.create') }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              {{-- cancel button --}}
              <a href="{{ route('calendar.index') }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
              {{-- cancel button --}}
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

        </form>	

      </div> {{-- col-sm-8 --}}
    </div> {{-- row --}}
    {{-- create calendar event form --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- Date Time Picker JS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.28.0/moment.min.js" integrity="sha512-Q1f3TS3vSt1jQ8AwP2OuenztnLU6LwxgyyYOG1jgMW/cbEMHps/3wjvnl1P3WTrF3chJUWEoxDUEjMxDV8pujg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-2JBCbWoMJPH+Uj7Wq5OLub8E5edWHlTM4ar/YJkZh3plwB2INhhOC3eDoqHm1Za/ZOSksrLlURLoyXVdfQXqwg==" crossorigin="anonymous"></script>
<script type="text/javascript">
  $(function () {
    $('#start').datetimepicker({
      icons: {
        time: "fas fa-clock",
        date: "fas fa-calendar-alt",
        up: "fas fa-chevron-up",
        down: "fas fa-chevron-down"
      },
      format: 'DD-MM-YYYY LT',
    });
  });
</script>
<script type="text/javascript">
  $(function () {
    $('#end').datetimepicker({
      icons: {
        time: "fas fa-clock",
        date: "fas fa-calendar-alt",
        up: "fas fa-chevron-up",
        down: "fas fa-chevron-down"
      },
      format: 'DD-MM-YYYY LT',
    });
  });
</script>
{{-- Date Time Picker JS --}}
@endpush