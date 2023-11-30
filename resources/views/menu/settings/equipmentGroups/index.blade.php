@extends('layouts.app')

@section('title', '- Equipment Groups - View All Equipment Groups')

@section('content')
<section>
  <div class="container py-5">

    {{-- title --}}
    <h3 class="text-secondary mb-0">EQUIPMENT GROUPS</h3>
    <h5>View All Equipment Groups</h5>
    {{-- title --}}

    {{-- navigation --}}
    <div class="row pt-3">
      <div class="col-sm-3 pb-3">
        <a class="btn btn-dark btn-block" href="{{ route('settings.index') }}">
          <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
      <div class="col-sm-3 pb-3">
        <a class="btn btn-primary btn-block" href="{{ route('equipment-group-settings.create') }}">
          <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Group
        </a>
      </div> {{-- col-sm-3 pb-3 --}}
    </div> {{-- row pt-3 --}}
    {{-- navigation --}}

    {{-- all groups table --}}
    <p class="text-primary my-3"><b>All Equipment Groups</b></p>
    @if (!$all_equipment_groups->count())
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center">
          <h5>There are no equipment groups to display</h5>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    @else
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
          @foreach ($all_equipment_groups as $equipment_group)
            <tr>
              <td>
                <a href="{{ route('equipment-group-settings.show', $equipment_group->id) }}">
                  {{ $equipment_group->id }}</td>
                </a>
              <td>{{ $equipment_group->title }}</td>
              <td>
                @if ($equipment_group->description == null)
                  <span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>The description has not been set.</span>
                @else
                  {{ substr($equipment_group->description, 0, 80) }}{{ strlen($equipment_group->description) > 80 ? "..." : "" }}
                @endif
              </td>
              <td class="text-center">
                <a href="{{ route('equipment-group-settings.show', $equipment_group->id) }}" class="btn btn-primary btn-sm">
                  <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
    {{-- all groups table --}}

    {{ $all_equipment_groups->links() }}

  </div> {{-- container --}}
</section> {{-- section --}}
@endsection