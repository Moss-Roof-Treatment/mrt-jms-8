<div>

    <div class="row mb-3">
        <div class="col-sm">
            <div class="mb-3 row">
                <div class="col-sm-12">
                    <input type="text" class="form-control" wire:model="search" aria-label="Search" placeholder="Search">
                </div> {{-- col-sm-8 --}}
            </div> {{-- mb-3 row --}}
        </div> {{-- col-sm --}}
        <div class="col-sm">
            <div class="mb-3 row">
                <div class="col-sm-12">
                    <select id="sort_direction" class="custom-select" wire:model="sort_direction" aria-label="Order by direction">
                        <option value="asc">Ascending</option>
                        <option value="desc">Decending</option>
                    </select>
                </div> {{-- col-sm-8 --}}
            </div> {{-- mb-3 row --}}
        </div> {{-- col-sm --}}
        <div class="col-sm">
            <div class="mb-3 row">
                <div class="col-sm-12">
                    <select id="per_page" class="custom-select" wire:model="per_page" aria-label="Results per page">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div> {{-- col-sm-8 --}}
            </div> {{-- mb-3 row --}}
        </div> {{-- col-sm --}}
        <div class="col-sm">
            <button class="btn btn-dark btn-block" wire:click="refresh()">
                <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
            </button>
        </div> {{-- col-sm --}}
    </div> {{-- row --}}

    <div class="table-responsive mb-3">
        <table class="table table-bordered table-fullwidth table-striped bg-white">
            <thead class="table-secondary">
                <tr>
                    <th>Suburb</th>
                    <th>Job Count</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($results as $result)
                    <tr>
                        <td>{{ $result->tenant_suburb }}</td>
                        <td>{{ $result->qty }}</td>
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
        <div class="col-sm-12">
            {{ $results->onEachSide(0)->links() }}
        </div> {{-- col-sm-12 --}}
    </div> {{-- row --}}

</div>
