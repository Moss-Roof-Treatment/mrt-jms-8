@extends('layouts.app')

@section('title', '- Equipment - Edit Selected Note')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">EQUIPMENT</h3>
    <h5>Edit Selected Equipment Note</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('equipment.show', $note->equipment_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Equipment
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    <h5 class="text-primary my-3"><b>Edit Selected Note</b></h5>

    <div class="row">
      <div class="col-sm-6">

        <form action="{{ route('equipment-notes.update', $note->id) }}" method="POST">
          @method('PATCH')
          @csrf

            <div class="form-group row">
              <label for="priority_id" class="col-md-2 col-form-label text-md-right">Priority</label>
              <div class="col-md-9">
                <select name="priority_id" id="priority_id" class="custom-select @error('priority_id') is-invalid @enderror mb-2">
                  @if (old('priority_id'))
                    <option disabled>Please select a roof surface</option>
                    @foreach ($priorities as $priority)
                      <option value="{{ $priority->id }}" @if (old('priority_id') == $priority->id) selected @endif>{{ $priority->title }}</option>
                    @endforeach
                  @else
                    @if ($note->priority_id == null)
                      <option selected disabled>Please select a roof surface</option>
                    @else
                      <option value="{{ $note->priority_id }}" selected>
                        {{ $note->priority->title }}
                      </option>
                      <option disabled>Please select a roof surface</option>
                    @endif
                    @foreach ($priorities as $priority)
                      <option value="{{ $priority->id }}">{{ $priority->title }}</option>
                    @endforeach
                  @endif
                </select>
                @error('priority_id')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div> {{-- col-md-6 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
              <label for="text" class="col-md-2 col-form-label text-md-right">Message</label>
              <div class="col-md-9">
                <textarea class="form-control @error('text') is-invalid @enderror mb-2" type="text" name="text" rows="5" placeholder="Please enter the message" style="resize:none">{{ old('text', $note->text) }}</textarea>
                @error('text')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div> {{-- col-md-8 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row mb-0">
            <div class="col-md-9 offset-md-2">
              <button class="btn btn-primary" type="submit">
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
                      <a href="{{ route('equipment-notes.edit', $note->id) }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              {{-- cancel button --}}
              <a href="{{ route('equipment-notes.show', $note->id) }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
              {{-- cancel button --}}
            </div>
          </div> {{-- form-group row --}}

        </form>

      </div>{{-- col-sm-6 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection