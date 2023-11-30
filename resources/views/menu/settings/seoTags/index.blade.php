@extends('layouts.app')

@section('title', 'SEO Tags - View All SEO Tags')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SEO TAGS</h3>
    <h5>View All SEO Tags</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col pb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- index table --}}
    <h5 class="text-primary my-3"><b>All SEO Tags</b></h5>

    <div class="row">
      <div class="col-sm-7">

        <form action="{{ route('seo-tags-settings.update', $seo_tags->id) }}" method="POST">
          @method('PATCH')
          @csrf

          <h6 class="text-primary my-3"><b>Open Graph Tags</b></h6>

          <div class="form-group row">
            <label for="ogTitle" class="col-md-3 col-form-label text-md-right">og:title</label>
            <div class="col-md-8">
              <input class="form-control" type="text" name="ogTitle" id="ogTitle" placeholder="The title of the page being viewed" readonly aria-describedby="ogTitleHelp">
              <small id="ogTitleHelp" class="form-text text-muted">The title that appears in shared posts.</small>
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="ogSiteName" class="col-md-3 col-form-label text-md-right">og:site_name</label>
            <div class="col-md-8">
              <input class="form-control" type="text" name="ogSiteName" id="ogSiteName" placeholder="{{ config('app.name') }}" readonly aria-describedby="ogSiteNameHelp">
              <small id="ogSiteNameHelp" class="form-text text-muted">The website name.</small>
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="ogType" class="col-md-3 col-form-label text-md-right">og:type</label>
            <div class="col-md-8">
              <input class="form-control" type="text" name="ogType" id="ogType" placeholder="website" readonly aria-describedby="ogTypeHelp">
              <small id="ogTypeHelp" class="form-text text-muted">The type of content currently being viewed.</small>
              <input class="form-control mt-2" type="text" name="ogType" id="ogType" placeholder="article" readonly aria-describedby="ogTypeHelp">
              <small id="ogTypeHelp" class="form-text text-muted">The type of content currently being viewed on blogs.</small>
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="ogDescription" class="col-md-3 col-form-label text-md-right">og:description</label>
            <div class="col-md-8">
              <textarea class="form-control mb-2" type="text" name="ogDescription" id="ogDescription" rows="4" placeholder="{{ $seo_tags->description }}" style="resize:none" readonly aria-describedby="ogDescriptionHelp"></textarea>
              <small id="ogDescriptionHelp" class="form-text text-muted">The website description (Same as meta tag).</small>
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="ogLocale" class="col-md-3 col-form-label text-md-right">og:locale</label>
            <div class="col-md-8">
              <input class="form-control" type="text" name="ogLocale" id="ogLocale" placeholder="en_au" readonly aria-describedby="ogLocalHelp">
              <small id="ogLocalHelp" class="form-text text-muted">The website language and location.</small>
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="ogUrl" class="col-md-3 col-form-label text-md-right">og:url</label>
            <div class="col-md-8">
              <input class="form-control" type="text" name="ogUrl" id="ogUrl" placeholder="The URL of the current page being viewed" readonly aria-describedby="ogUrlHelp">
              <small id="ogUrlHelp" class="form-text text-muted">The URL of the current page being viewed.</small>
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <h6 class="text-primary my-3"><b>Meta Tags</b></h6>

          <div class="form-group row">
            <label for="author" class="col-md-3 col-form-label text-md-right">Author</label>
            <div class="col-md-8">
              <input class="form-control" type="text" name="author" id="author" placeholder="{{ config('app.name') }}" readonly aria-describedby="authorHelp">
              <small id="authorHelp" class="form-text text-muted">The website author.</small>
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="keywords" class="col-md-3 col-form-label text-md-right">Keywords</label>
            <div class="col-md-8">
              <textarea class="form-control mb-2" type="text" name="keywords" id="keywords" rows="6" placeholder="@foreach($all_keywords as $keyword){{ $keyword->keyword }}@if(!$loop->last),@endif @endforeach" style="resize:none" readonly aria-describedby="keywordsHelp"></textarea>
              <small id="keywordsHelp" class="form-text text-muted">The website keywords (editable in the keywords settings).</small>
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row">
            <label for="description" class="col-md-3 col-form-label text-md-right">Description</label>
            <div class="col-md-8">
              <textarea class="form-control @error('description') is-invalid @enderror mb-2" type="text" name="description" rows="4" placeholder="Please enter the description" style="resize:none" aria-describedby="descriptionHelp">{{ old('description', $seo_tags->description) }}</textarea>
              <small id="descriptionHelp" class="form-text text-muted">The description that appears in the search results under the URL.</small>
              @error('description')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

          <div class="form-group row mb-2">
            <div class="col-md-8 offset-md-3">
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
                      <a href="{{ route('seo-tags-settings.index') }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                      </a>
                    </div> {{-- modal-body --}}
                  </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
              </div> {{-- modal fade --}}
              {{-- modal --}}
              {{-- reset modal --}}
            </div> {{-- col-md-9 --}}
          </div> {{-- form-group row --}}

        </form>

      </div> {{-- col-sm-7 --}}
    </div> {{-- row --}}
    {{-- index table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection