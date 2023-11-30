@extends('layouts.app')

@section('title', '- Settings - View All Testimonials')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">TESTIMONIALS</h3>
    <h5>View All Testimonials</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('manual-testimonials-settings.create') }}">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Testimonial
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    <p class="text-primary my-3"><b>All Testimonials</b></p>

    @if (!$all_testimonials->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no testimonials to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>Staff Member</th>
              <th>Text</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_testimonials as $testimonial)
              <tr>
                <td>{{ $testimonial->user->getFullNameAttribute() }}</td>
                <td>
                  @if ($testimonial->text == null)
                    <span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>The text has not been set</span>
                  @else
                    {{ substr($testimonial->text, 0, 80) }}{{ strlen($testimonial->text) > 80 ? "..." : "" }}
                  @endif
                </td>
                <td class="text-center">
                  <a href="{{ route('manual-testimonials-settings.show', $testimonial->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                  <a href="{{ route('manual-testimonials-settings.edit', $testimonial->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                  </a>
                  {{-- delete modal --}}
                  {{-- modal button --}}
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{$testimonial->id}}">
                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                  </button>
                  {{-- modal button --}}
                  {{-- modal --}}
                  <div class="modal fade" id="deleteModal{{$testimonial->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{$testimonial->id}}Title" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteModal{{$testimonial->id}}Title">Delete</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p class="text-center">Are you sure that you would like to delete this item?</p>
                          <form method="POST" action="{{ route('manual-testimonials-settings.destroy', $testimonial->id) }}">
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
      </div> {{-- table-responsive --}}
    @endif

    {{ $all_testimonials->links() }}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection