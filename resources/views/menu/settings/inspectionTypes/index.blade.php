@extends('layouts.app')

@section('title', '- Settings - All Inspection Types')

@section('content')
    <section>
        <div class="container py-5">

            {{-- title --}}
            <h3 class="text-secondary mb-0">INSPECTION TYPES</h3>
            <h5>View All Inspection Types</h5>
            {{-- title --}}

            {{-- navigation --}}
            <div class="row pt-3">
                <div class="col-sm-3 pb-3">
                    <a class="btn btn-dark btn-block" href="{{ route('settings.index') }}">
                        <i class="fas fa-bars mr-2" aria-hidden="true"></i>Settings Menu
                    </a>
                </div> {{-- col-sm-3 pb-3 --}}
                <div class="col-sm-3 pb-3">
                    <a class="btn btn-primary btn-block" href="{{ route('inspection-type-settings.create') }}">
                        <i class="fas fa-plus mr-2" aria-hidden="true"></i>Create New Inspection Type
                    </a>
                </div> {{-- col-sm-3 pb-3 --}}
            </div> {{-- row pt-3 --}}
            {{-- navigation --}}

            <p class="text-primary my-3"><b>All Inspection Types</b></p>

            @if (!$inspection_types->count())
                <div class="card shadow-sm mt-3">
                    <div class="card-body text-center">
                        <h5>There are no inspection types to display</h5>
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
                            @foreach ($inspection_types as $inspection_type)
                                <tr>
                                    <td>{{ $inspection_type->id }}</td>
                                    <td>{{ $inspection_type->title }}</td>
                                    <td>
                                        @if ($inspection_type->description == null)
                                            <span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>The description has not been set</span>
                                        @else
                                            {{ substr($inspection_type->description, 0, 40) }}{{ strlen($inspection_type->description) > 40 ? '...' : '' }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-primary btn-sm" href="{{ route('inspection-type-settings.edit', $inspection_type->id) }}">
                                            <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                                        </a>
                                        {{-- delete modal --}}
                                        {{-- modal button --}}
                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete-button-{{ $inspection_type->id }}" type="button">
                                            <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i>Delete
                                        </button>
                                        {{-- modal button --}}
                                        {{-- modal --}}
                                        <div class="modal fade" id="confirm-delete-button-{{ $inspection_type->id }}" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-button-{{ $inspection_type->id }}Title" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="confirm-delete-button-{{ $inspection_type->id }}Title">Delete</h5>
                                                        <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="subtitle text-center">Are you sure you would like to delete this item...?</p>
                                                        <form method="POST" action="{{ route('inspection-type-settings.destroy', $inspection_type->id) }}">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button class="btn btn-danger btn-block" type="submit">
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

            {{ $inspection_types->links() }}

        </div> {{-- container --}}
    </section> {{-- section --}}
@endsection
