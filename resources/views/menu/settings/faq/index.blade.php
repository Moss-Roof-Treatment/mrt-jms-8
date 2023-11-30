@extends('layouts.app')

@section('title', 'Frequently Asked Questions - View All Frequently Asked Question')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">FAQ SETTINGS</h3>
    <h5>View All Frequently Asked Questions</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row row-cols-1 row-cols-sm-4 pt-3">
      <div class="col pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col pb-3 --}}
      <div class="col mb-3">
        <a href="{{ route('faq-settings.create') }}" class="btn btn-primary btn-block">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New FAQ
        </a>
      </div> {{-- col mb-3 --}}
    </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
    {{-- navigation --}}

    {{-- index table --}}
    <h5 class="text-primary my-3"><b>All Frequently Asked Questions</b></h5>
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
          @foreach ($all_faqs as $faq)
            <tr>
              <td>{{ $faq->id }}</td>
              <td>{{ substr($faq->question, 0, 100) }}{{ strlen($faq->question) > 100 ? "..." : "" }}</td>
              <td class="text-center text-nowrap">
                <a href="{{ route('faq-settings.show', $faq->id) }}" class="btn btn-primary btn-sm">
                  <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                </a>
                <a href="{{ route('faq-settings.edit', $faq->id) }}" class="btn btn-primary btn-sm">
                  <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                </a>
                {{-- delete modal --}}
                {{-- modal button --}}
                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal-{{$faq->id}}">
                  <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                </button>
                {{-- modal button --}}
                {{-- modal --}}
                <div class="modal fade" id="deleteModal-{{$faq->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModal-{{$faq->id}}-Title" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteModal-{{$faq->id}}-Title">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p class="text-center">Are you sure that you would like to delete this item?</p>
                        <form method="POST" action="{{ route('faq-settings.destroy', $faq->id) }}">
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