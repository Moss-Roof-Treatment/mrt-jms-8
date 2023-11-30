@extends('layouts.app')

@section('title', '- SEO Keywords - Create New SEO Keyword')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SEO KEYWORDS SETTINGS</h3>
    <h5>Create New SEO Keyword</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('seo-keywords-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Rates Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    {{-- create new seo keyword form --}}
    <p class="text-primary my-3"><b>Create New SEO Keyword</b></p>

    <div class="row">
      <div class="col-sm-7">

        <form action="{{ route('seo-keywords-settings.store') }}" method="POST">
          @csrf

          <div class="form-group row">
            <label for="keyword" class="col-md-2 col-form-label text-md-right">Keyword</label>
            <div class="col-md-9">
              <input type="text" class="form-control @error('keyword') is-invalid @enderror mb-2" name="keyword" id="keyword" value="{{ old('keyword') }}" placeholder="Please enter the keyword" autofocus>
              @error('keyword')
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
                      <a href="{{ route('seo-keywords-settings.create') }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
              {{-- cancel button --}}
              <a href="{{ route('seo-keywords-settings.index') }}" class="btn btn-dark">
                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
              </a>
              {{-- cancel button --}}
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

        </form>

      </div> {{-- col-sm-7 --}}
    </div> {{-- row --}}
    {{-- create new seo keyword form --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection