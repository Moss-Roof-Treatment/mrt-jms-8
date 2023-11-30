@extends('layouts.app')

@section('title', '- Equipment Categories - View All Equipment Categories')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">EQUIPMENT CATEGORIES</h3>
    <h5>View All Equipment Categories</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('settings.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('equipment-category-settings.create') }}">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Category
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    {{-- all categories table --}}
    <p class="text-primary my-3"><b>All Equipment Categories</b></p>
    @if (!$all_equipment_categories->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no equipment categories to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
          <thead class="table-secondary">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Description</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($all_equipment_categories as $equipment_category)
              <tr>
                <td>
                  <a href="{{ route('equipment-category-settings.show', $equipment_category->id) }}">
                    {{ $equipment_category->id }}
                  </a>
                </td>
                <td>{{ $equipment_category->title }}</td>
                <td>
                  @if ($equipment_category->description == null)
                    <span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>The description has not been set.</span>
                  @else
                    {{ substr($equipment_category->description, 0, 80) }}{{ strlen($equipment_category->description) > 80 ? "..." : "" }}
                  @endif
                </td>
                <td class="text-center">
                  <a href="{{ route('equipment-category-settings.show', $equipment_category->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> {{-- table-responsive --}}
    @endif
    {{-- all categories table --}}

    {{ $all_equipment_categories->links() }}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection