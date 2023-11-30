@extends('layouts.profile')

@section('title', '- Jobs - View Selected Job')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SWMS</h3>
    <h5>View Selected SWMS</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('profile-jobs.show', $selected_swms->quote_id) }}" class="btn btn-primary btn-block">
          <i class="fas fa-clipboard-list mr-2" aria-hidden="true"></i>View Job 
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col pb-3">
        <a href="{{ route('profile-jobs-swms.create', ['selected_swms_id' => $selected_swms->id]) }}" class="btn btn-dark btn-block">
          <i class="fas fa-download mr-2" aria-hidden="true"></i>Download PDF
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- swms form --}}
    <h5 class="text-primary my-3"><b>Update Selected SWMS</b></h5>
    @if (!$all_swms_questions->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are currently no SWMS questions to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <form method="POST" action="{{ route('profile-jobs-swms.update', $selected_swms->id)}}">
        @method('PATCH')
        @csrf

        <div class="card">
          <div class="card-body">

            @foreach ($all_swms_question_categories as $swms_question_category)
              <h3 class="text-secondary my-3">{{ $swms_question_category->title }}</h3>
              <div class="container">
                <div class="row row-cols-1 row-cols-sm-2">
                  @foreach ($swms_question_category->quote_questions as $swms_question)
                    <div class="col">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheckSwms{{$swms_question->id}}" name="questions[]" value="{{$swms_question->id}}" @if (in_array($swms_question->id, $answers_array)) checked @endif>
                        <label class="custom-control-label" for="customCheckSwms{{$swms_question->id}}">{{ $swms_question->question }}</label>
                      </div> {{-- custom-control custom-checkbox --}}
                    </div> {{-- col --}}
                  @endforeach
                </div> {{-- row row-cols-3 --}}
              </div> {{-- container --}}
            @endforeach

          </div> {{-- card-body --}}
        </div> {{-- card --}}

        <div class="form-group row py-3">
          <div class="col">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-edit mr-2" aria-hidden="true"></i>Update
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
                    <a href="{{ route('profile-jobs-swms.show', $selected_swms->quote_id) }}" class="btn btn-dark btn-block">
                      <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                    </a>
                  </div> {{-- modal-body --}}
                </div> {{-- modal-content --}}
              </div> {{-- modal-dialog --}}
            </div> {{-- modal fade --}}
            {{-- modal --}}
            {{-- reset modal --}}
            <a href="{{ route('profile-jobs.show', $selected_swms->quote_id) }}" class="btn btn-dark">
              <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
            </a>
          </div> {{-- col --}}
        </div> {{-- row --}}

      </form>

    @endif
    {{-- swms form --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection