@extends('layouts.app')

@section('title', 'SEO Keywords - View All SEO Keywords')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">SEO KEYWORDS SETTINGS</h3>
    <h5>View All SEO Keywords</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col mb-3">
        <a href="{{ route('seo-keywords-settings.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New SEO Keyword
        </a>
      </div> {{-- col mb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- index table --}}
    <h5 class="text-primary my-3"><b>All SEO Keywords</b></h5>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <thead class="table-secondary">
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($all_keywords as $keyword)
            <tr>
              <td>{{ $keyword->id }}</td>
              <td>{{ $keyword->keyword }}</td>
              <td class="text-center">
                <a href="{{ route('seo-keywords-settings.edit', $keyword->id) }}" class="btn btn-primary btn-sm">
                  <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                </a>
                {{-- delete modal --}}
                {{-- modal button --}}
                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal-{{$keyword->id}}">
                  <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                </button>
                {{-- modal button --}}
                {{-- modal --}}
                <div class="modal fade" id="deleteModal-{{$keyword->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModal-{{$keyword->id}}-Title" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteModal-{{$keyword->id}}-Title">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p class="text-center">Are you sure that you would like to delete this item?</p>
                        <form method="POST" action="{{ route('seo-keywords-settings.destroy', $keyword->id) }}">
                          @method('DELETE')
                          @csrf
                          <button type="submit" class="btn btn-danger btn-block">
                            <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                {{-- modal --}}
                {{-- delete modal --}}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    {{-- index table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection