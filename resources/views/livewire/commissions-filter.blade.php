<div>

    <div class="row">
        <div class="col-sm">

            <div class="form-group row">
                <div class="col-md-12">
                    <label for="staff_member_id">Staff Member</label>
                    <select id="staff_member_id" class="custom-select mb-2" wire:model="staff_member_id">
                        <option selected disabled value="">Please select a staff member</option>
                        @foreach ($all_staff_members as $staff_member)
                            <option value="{{ $staff_member->id }}">{{ $staff_member->getFullnameAttribute() }}</option>
                        @endforeach
                    </select>
                </div> {{-- col-md-9 --}}
            </div> {{-- form-group row --}}

        </div> {{-- col-sm --}}
        <div class="col-sm">

            <div class="form-group row">
                <div class="col-md-12">
                    <label for="staff_member_id">Quote Status</label>
                    <select id="quote_status_id" class="custom-select mb-2" wire:model="quote_status_id">
                        <option selected disabled value="">Please select a quote Status</option>
                        @foreach ($all_quote_statuses as $quote_status)
                            <option value="{{ $quote_status->id }}">{{ $quote_status->title }}</option>
                        @endforeach
                    </select>
                </div> {{-- col-md-9 --}}
            </div> {{-- form-group row --}}

        </div> {{-- col-sm --}}
        <div class="col-sm">

            <div class="form-group row">
                <div class="col-md-12">
                    <label for="order_asc">Sort By</label>
                    <select id="order_asc" class="custom-select mb-2" wire:model="order_asc">
                        <option selected value="1">Ascending</option>
                        <option selected value="0">Decending</option>
                    </select>
                </div> {{-- col-md-9 --}}
            </div> {{-- form-group row --}}

        </div> {{-- col-sm --}}
        <div class="col-sm">

            <div class="form-group row">
                <div class="col-md-12">
                    <label for="per_page">Show Entries</label>
                    <select id="per_page" class="custom-select mb-2" wire:model="per_page">
                        <option selected value="10">10</option>
                        <option selected value="25">25</option>
                        <option selected value="50">50</option>
                        <option selected value="100">100</option>
                    </select>
                </div> {{-- col-md-9 --}}
            </div> {{-- form-group row --}}

        </div> {{-- col-sm --}}
        <div class="col-sm">

            <div class="form-group row">
                <div class="col-md-12">
                    <label for="per_page">Options</label>
                    <a href="{{ route('invoice-commissions.index') }}" class="btn btn-dark btn-block">
                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                    </a>
                </div> {{-- col-md-9 --}}
            </div> {{-- form-group row --}}

        </div> {{-- col-sm --}}
    </div> {{-- row --}}

    <div class="table-responsive py-2 px-2">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
            <thead class="table-secondary">
                <tr>
                    <th>ID</th>
                    <th>job id</th>
                    <th>Customer</th>
                    <th>Quote Status</th>
                    <th>Staff Member</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($results as $result)
                    <tr>
                        <td>{{ $result->id }}</td>
                        <td>{{ $result?->quote?->job_id }}</td>
                        <td>{{ $result?->quote?->customer->getFullNameAttribute() ?? '' }}</td>
                        <td>{{ $result?->quote?->quote_status->title }}</td>
                        <td>{{ $result?->salesperson->getFullNameTitleAttribute() }}</td>
                        <td>
                            <a href="{{ route('invoice-commissions.show', $result->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye mr-2" aria-hidden="true"></i>View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">There are no results that match your search criteria</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div> {{-- table-responsive --}}

    <div class="row">
        <div class="col-sm">
            <p>Showing {{ $results->count() }} entries</p>
        </div> {{-- col-sm --}}
        <div class="col-sm">
            {{ $results->links() }}
        </div> {{-- col-sm --}}
    </div> {{-- row --}}

</div>
