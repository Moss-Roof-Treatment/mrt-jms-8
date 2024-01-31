@extends('layouts.app')

@section('title', '- Equipment Categories - View Selected Equipment Category')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">EQUIPMENT CATEGORIES</h3>
    <h5>View Selected Equipment Category</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('equipment-category-settings.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Equipment Category Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('equipment-category-settings.edit', $selected_equipment_category->id) }}">
          <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit Equipment Category
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    {{-- equipment category details table --}}
    <p class="text-primary my-3"><b>Equipment Category Details</b></p>
    <div class="table-responsive">
      <table class="table table-bordered table-fullwidth table-striped bg-white">
        <thead class="table-secondary">
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th width="70%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $selected_equipment_category->id }}</td>
            <td>{{ $selected_equipment_category->title }}</td>
            <td>
              @if ($selected_equipment_category->description == null)
                <span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>The description has not been set.</span>
              @else
                {{ $selected_equipment_category->description }}
              @endif
            </td>
          </tr>
        </tbody>
      </table>
    </div> {{-- table-responsive --}}
    {{-- equipment category details table --}}

    {{-- category equipment table --}}
    <p class="text-primary my-3"><b>Equipment With This Category {{ '(' . $selected_equipment_category->equipments->count() . ')' }}</b></p>
    @if (!$selected_equipment_category->equipments->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no equipments to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Used By</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($selected_equipment_category->equipments as $equipment)
              <tr>
                <td>
                  <a href="{{ route('equipment-items.show', $equipment->id) }}">
                    {{ $equipment->id }}
                  </a>
                </td>
                <td>{{ $equipment->title }}</td>
                <td>{{ $equipment->owner->getFullNameAttribute() }}</td>
                <td class="text-center">
                  <a href="{{ route('equipment-items.show', $equipment->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Equipment
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- category equipment table --}}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection