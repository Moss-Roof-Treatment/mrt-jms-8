@extends('layouts.app')

@section('title', '- Rates - View All Rates')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">RATES</h3>
    <h5>View Selected Rates</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a href="{{ route('rate-settings.index') }}" class="btn btn-dark btn-block">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Rates Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        @if ($selected_rate->is_editable == 0)
          <a class="btn btn-primary btn-block disabled" tabindex="-1" role="button" aria-disabled="true">
            <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
          </a>
        @else
          <a class="btn btn-primary btn-block" href="{{ route('rate-settings.edit', $selected_rate->id) }}">
            <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
          </a>
        @endif
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        @if ($selected_rate->is_delible == 0)
          <a class="btn btn-danger btn-block disabled" tabindex="-1" role="button" aria-disabled="true">
            <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
          </a>
        @else
          {{-- delete modal --}}
          {{-- modal button --}}
          <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModal">
            <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
          </button>
          {{-- modal button --}}
          {{-- modal --}}
          <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="deleteModalTitle">Delete</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p class="text-center">Are you sure that you would like to delete this item?</p>
                  <form method="POST" action="{{ route('rate-settings.destroy', $selected_rate->id) }}">
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
        @endif
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    {{-- rate details --}}
    <div class="row">
      <div class="col-sm-6">

        {{-- rate details table --}}
        <p class="text-primary my-3"><b>Rate Details</b></p>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>ID</th>
                <td>{{ $selected_rate->id }}</td>
              </tr>
              <tr>
                <th>Title</th>
                <td>{{ $selected_rate->title }}</td>
              </tr>
              <tr>
                <th>Default Cost</th>
                <td>${{ number_format(($selected_rate->price / 100), 2, '.', ',') }}</td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}
        {{-- rate details table --}}

      </div> {{-- col-sm-6 --}}
      <div class="col-sm-6">

        {{-- rate options table --}}
        <p class="text-primary my-3"><b>Rate Options</b></p>
        <div class="table-responsive">
          <table class="table table-bordered table-fullwidth table-striped bg-white">
            <tbody>
              <tr>
                <th>Is Editable</th>
                <td>
                  @if ($selected_rate->is_editable == 0)
                    <span class="badge badge-danger py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Is not editable
                    </span>
                  @else
                    <span class="badge badge-success py-2 px-2">
                      <i class="fas fa-check mr-2" aria-hidden="true"></i>Is editable
                    </span>
                  @endif  
                </td>
              </tr>
              <tr>
                <th>Is Delible</th>
                <td>
                  @if ($selected_rate->is_delible == 0)
                    <span class="badge badge-danger py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Is not delible
                    </span>
                  @else
                    <span class="badge badge-success py-2 px-2">
                      <i class="fas fa-check mr-2" aria-hidden="true"></i>Is delible
                    </span>
                  @endif   
                </td>
              </tr>
              <tr>
                <th>Is Selectable</th>
                <td>
                  @if ($selected_rate->is_selectable == 0)
                    <span class="badge badge-danger py-2 px-2">
                      <i class="fas fa-times mr-2" aria-hidden="true"></i>Is not selectable
                    </span>
                  @else
                    <span class="badge badge-success py-2 px-2">
                      <i class="fas fa-check mr-2" aria-hidden="true"></i>Is selectable
                    </span>
                  @endif   
                </td>
              </tr>
            </tbody>
          </table>
        </div> {{-- table-responsive --}}
        {{-- rate options table --}}

      </div> {{-- col-sm-6 --}}
    </div> {{-- row --}}
    {{-- rate details --}}

    {{-- rate description --}}
    <p class="text-primary my-3"><b>Rate Description</b></p>
    <div class="card">
      <div class="card-body">
        {{ $selected_rate->description }}
      </div> {{-- card-body --}}
    </div> {{-- card --}}
    {{-- rate description --}}

    {{-- rate rocedure --}}
    <p class="text-primary my-3"><b>Rate Procedure</b></p>
    <div class="card">
      <div class="card-body">
        {{ $selected_rate->procedure }}
      </div> {{-- card-body --}}
    </div> {{-- card --}}
    {{-- rate rocedure --}}

    {{-- rate tradespersons table --}}
    <p class="text-primary my-3"><b>Tradespersons With This Rate</b></p>
    @if (!$selected_rate->rate_users->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no tradespersons that have this rate</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Account Class</th>
              <th>Price</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($selected_rate->rate_users as $rate)
              <tr>
                <td>
                  <a href="{{ route('tradespersons.show', $rate->user_id) }}">
                    {{ $rate->user_id }}
                  </td>
                <td>{{ $rate->user->getFullNameAttribute() }}</td>
                <td>{{ $rate->user->account_class->title }}</td>
                <td>${{ number_format(($rate->price / 100), 2, '.', ',') }}</td>
                <td class="text-center">
                  <a href="{{ route('tradespersons.show', $rate->user_id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- rate tradespersons table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection