<div>

    <div class="row">
        <div class="col-sm-7">

            <h5 class="text-primary my-3"><b>Property Search</b></h5>

            <div class="form-group row">
                <label for="material_type_id" class="col-md-3 col-form-label text-md-right">Roof Surface</label>
                <div class="col-md-8">
                    <select name="material_type_id" id="material_type_id" class="custom-select @error('material_type_id') is-invalid @enderror mb-2" wire:model="material_type_id">
                        <option selected value="">Please select a roof surface</option>
                        @foreach ($all_material_types as $material_type)
                            <option value="{{ $material_type->id }}" @if (old('material_type_id') == $material_type->id) selected @endif>{{ $material_type->title }}</option>
                        @endforeach
                    </select>
                    @error('material_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> {{-- col-md-9 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
            <label for="building_style_id" class="col-md-3 col-form-label text-md-right">Building Style</label>
            <div class="col-md-8">
                <select name="building_style_id" id="building_style_id" class="custom-select @error('building_style_id') is-invalid @enderror mb-2" wire:model="building_style_id">
                <option selected value="">Please select a building style</option>
                @foreach ($all_building_styles as $building_style)
                    <option value="{{ $building_style->id }}" @if (old('building_style_id') == $building_style->id) selected @endif>{{ $building_style->title }}</option>
                @endforeach
                </select>
                @error('building_style')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div> {{-- col-md-9 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
            <label for="building_type_id" class="col-md-3 col-form-label text-md-right">Building Type</label>
            <div class="col-md-8">
                <select name="building_type_id" id="building_type_id" class="custom-select @error('building_type_id') is-invalid @enderror mb-2" wire:model="building_type_id">
                <option selected value="">Please select a building type</option>
                @foreach ($all_building_types as $building_type)
                    <option value="{{ $building_type->id }}" @if (old('building_type_id') == $building_type->id) selected @endif>{{ $building_type->title }}</option>
                @endforeach
                </select>
                @error('building_type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div> {{-- col-md-9 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
                <label for="job_status_id" class="col-md-3 col-form-label text-md-right">Job Status</label>
                <div class="col-md-8">
                    <select name="job_status_id" id="job_status_id" class="custom-select @error('job_status_id') is-invalid @enderror mb-2" wire:model="job_status_id">
                        <option selected value="">Please select a job status</option>
                        @foreach ($all_job_statuses as $job_status)
                            <option value="{{ $job_status->id }}" @if (old('job_status_id') == $job_status->id) selected @endif>{{ $job_status->title }}</option>
                        @endforeach
                    </select>
                    @error('job_status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> {{-- col-md-9 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
                <label for="email" class="col-md-3 col-form-label text-md-right">Email</label>
                <div class="col-md-8">
                    <input type="email" class="form-control @error('email') is-invalid @enderror mb-2" name="email" id="email" value="{{ old('email') }}" placeholder="Please enter the street address" wire:model="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> {{-- col-md-6 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
                <label for="street_address" class="col-md-3 col-form-label text-md-right">Street Address</label>
                <div class="col-md-8">
                    <input type="text" class="form-control @error('street_address') is-invalid @enderror mb-2" name="street_address" id="street_address" value="{{ old('street_address') }}" placeholder="Please enter the street address" wire:model="street_address">
                    @error('street_address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> {{-- col-md-6 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
            <label for="suburb" class="col-md-3 col-form-label text-md-right">Suburb</label>
            <div class="col-md-4">
                <input type="text" class="form-control @error('suburb') is-invalid @enderror mb-2" name="suburb" id="suburb" value="{{ old('suburb') }}" placeholder="Please enter the suburb" wire:model="suburb">
                @error('suburb')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div> {{-- col-md-4 --}}
            <div class="col-md-4">
                <input type="text" class="form-control @error('postcode') is-invalid @enderror mb-2" name="postcode" id="postcode" value="{{ old('postcode') }}" placeholder="Please enter the postcode" wire:model="postcode">
                @error('postcode')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div> {{-- col-md-4 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row">
                <label for="suburb" class="col-md-3 col-form-label text-md-right">Inspection Date</label>
                <div class="col-md-4">
                    <input class="form-control @error('start_date') is-invalid @enderror mb-2" type="date" name="start_date" value="{{ old('start_date') }}" wire:model="start_date">
                    @error('start_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> {{-- col-md-5 --}}
                <div class="col-md-4">
                    <input class="form-control @error('end_date') is-invalid @enderror mb-2" type="date" name="end_date" value="{{ old('end_date') }}" wire:model="end_date">
                    @error('end_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> {{-- col-md-5 --}}
            </div> {{-- form-group row --}}

            <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-3">
                {{-- reset modal --}}
                {{-- modal button --}}
                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#confirmResetModal">
                <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                </button>
                {{-- modal button --}}
                {{-- modal --}}
                <div class="modal fade" id="confirmResetModal" tabindex="-1" role="dialog" aria-labelledby="confirmResetModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmResetModalTitle">Reset</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">Are you sure that you would like to reset this form?</p>
                        <a class="btn btn-dark btn-block" href="{{ route('email-recipient-groups.create') }}">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                        </a>
                    </div> {{-- modal-body --}}
                    </div> {{-- modal-content --}}
                </div> {{-- modal-dialog --}}
                </div> {{-- modal fade --}}
                {{-- modal --}}
                {{-- reset modal --}}
                {{-- cancel button --}}
                <a href="{{ route('email-recipient-groups.index') }}" class="btn btn-dark">
                    <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
                </a>
                {{-- cancel button --}}
            </div>
            </div> {{-- form-group row --}}

        </div> {{-- col-sm-7 --}}
        <div class="col-sm-5" style=" @if ($results == null) display:none; @endif">

            <h5 class="text-primary my-3"><b>Create New Group</b></h5>

            <form wire:submit.prevent="submit">
                @csrf

                <div class="form-group row">
                    <label for="title" class="col-md-3 col-form-label text-md-right">Title</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control @error('title') is-invalid @enderror mb-2" wire:model="title" placeholder="Please enter the title" id="title">
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> {{-- col-md-9 --}}
                </div> {{-- form-group row --}}

                <div class="form-group row">
                    <label for="description" class="col-md-3 col-form-label text-md-right">Description</label>
                    <div class="col-md-8">
                        <textarea class="form-control @error('description') is-invalid @enderror mb-2" type="text" wire:model="description" rows="5" placeholder="Please enter the description" style="resize:none" id="description">{{ old('description') }}</textarea>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> {{-- col-md-9 --}}
                </div> {{-- form-group row --}}

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-3">
                        {{-- cancel button --}}
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check mr-2" aria-hidden="true"></i>Create New Email Group
                        </button>
                        {{-- cancel button --}}
                    </div>
                </div> {{-- form-group row --}}

        </div>
    </div> {{-- row --}}

    <h5 class="text-primary my-3"><b>Search Results ({{ $results?->total() ?? 0 }})</b></h5>
    @if ($results == null)
        <div class="card">
            <div class="card-body">
                <h5 class="text-center mb-0">Please fill out the search form</h5>
            </div> {{-- card-body --}}
        </div> {{-- card --}}
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-fullwidth table-striped text-nowrap">
                <thead class="table-secondary">
                    <tr>
                        <th></th>
                        <th>Customer ID</th>
                        <th>Name</th>
                        <th>Mobile Phone</th>
                        <th>Follow Up Call Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!$results->count())
                        <tr>
                            <td class="text-center" colspan="5">There are no results that match your search criteria</td>
                        </tr>
                    @else
                        @foreach ($results as $result)
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck{{ $result->customer_id }}" name="users" wire:model="users.{{ $result->customer_id }}" value="{{ $result->customer_id }}" checked>
                                        <label class="custom-control-label" for="customCheck{{ $result->customer_id }}">Select this user</label>
                                    </div>
                                </td>
                                <td>
                                    {{ $result->id }}
                                </td>
                                <td>{{ $result->customer->getFullNameAttribute() }}</td>
                                <td>
                                    @if ($result->customer->email == null)
                                        <span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>
                                    @else
                                        {{ $result->customer->email }}
                                    @endif
                                </td>
                                <td>
                                    <i class="fas fa-square-full border border-dark mr-2" style="color:{{ $result->follow_up_call_status->colour->colour}};"></i>{{ $result->follow_up_call_status->title }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        </form>

        {{ $results->links() }}
    @endif

</div>
