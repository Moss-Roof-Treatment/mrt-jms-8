@extends('layouts.app')

@section('title', '- Settings - SWMS - Edit Selected SWMS Question')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SWMS QUESTIONS</h3>
    <h5>Edit Selected SWMS Question</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('swms-questions-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>SWMS Questions Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <div class="row">
      <div class="col-sm-7">

        <p class="text-primary my-3"><b>Edit SWMS Question</b></p>

        <form action="{{ route('swms-questions-settings.update', $selected_swms_question->id) }}" method="POST">
          @method('PATCH')
          @csrf

          <div class="form-group row">
            <label for="swms_question_category_id" class="col-md-2 col-form-label text-md-right">Category</label>
            <div class="col-md-9">
              <select name="swms_question_category_id" id="swms_question_category_id" class="custom-select @error('swms_question_category_id') is-invalid @enderror mb-2">
                @if (old('swms_question_category_id'))
                  <option disabled>Please select an equipment category</option>
                  @foreach ($all_swms_question_categories as $swms_question_category)
                    <option value="{{ $swms_question_category->id }}" @if (old('swms_question_category_id') == $swms_question_category_id) selected @endif>{{ $swms_question_category->title }}</option>
                  @endforeach
                @else
                  @if ($selected_swms_question->swms_question_category_id == null)
                    <option selected disabled>Please select an equipment category</option>
                  @else
                    <option value="{{ $selected_swms_question->swms_question_category_id }}" selected>
                      {{ $selected_swms_question->swms_question_category->title }}
                    </option>
                    <option disabled>Please select an equipment category</option>
                  @endif
                  @foreach ($all_swms_question_categories as $swms_question_category)
                    <option value="{{ $swms_question_category->id }}">{{ $swms_question_category->title }}</option>
                  @endforeach
                @endif
              </select>
              @error('swms_question_category_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-6 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="question" class="col-md-2 col-form-label text-md-right">Question</label>
            <div class="col-md-9">
              <textarea class="form-control @error('question') is-invalid @enderror mb-2" type="text" name="question" rows="5" placeholder="Please enter the question" style="resize:none">{{ old('question', $selected_swms_question->question) }}</textarea>
              @error('question')
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
                      <a href="{{ route('swms-questions-settings.edit', $selected_swms_question->id) }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              {{-- cancel button --}}
              <a href="{{ route('swms-questions-settings.index') }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
              {{-- cancel button --}}
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

        </form>

      </div> {{-- col-sm-7 --}}
    </div> {{-- row --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection