@extends('layouts.jquery')

@section('title', '- Invoices - View All Commissions')

@livewireStyles

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
    <div class="container py-5">

        {{-- title --}}
        <h3 class="text-secondary mb-0">COMMISSIONS</h3>
        <h5>View All Commissions</h5>
        {{-- title --}}

        {{-- navigation --}}
        <div class="row row-cols-1 row-cols-sm-4 pt-3">
        <div class="col pb-3">
            <a href="{{ route('invoices.index') }}" class="btn btn-dark btn-block">
                <i class="fas fa-bars mr-2" aria-hidden="true"></i>Invoice Menu
            </a>
        </div> {{-- col pb-3 --}}
        </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
        {{-- navigation --}}

        <h5 class="text-primary my-3"><b>Pending Commissions</b></h5>
        @livewire('commissions-filter')

        {{-- sold jobs table --}}
        <h5 class="text-primary my-3 mt-5"><b>Completed Commissions</b></h5>
        @if(!$all_commissions->count())
            <div class="card shadow-sm mt-3">
                <div class="card-body text-center">
                    <h5>There are currently no commissions to display</h5>
                </div> {{-- card-body --}}
            </div> {{-- card --}}
        @else
            <div class="table-responsive py-2 px-2">
                <table class="table table-bordered table-fullwidth table-striped bg-white" id="datatable" style="width:100%">
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
                </table>
            </div> {{-- table-responsive --}}
        @endif
        {{-- sold jobs table --}}

    </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@livewireScripts

@push('js')
{{-- jquery datatables js --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script>
    new DataTable('#datatable', {
        "processing": true,
        "serverSide": true,
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            {"targets": 5, "orderable": false, "className": "text-nowrap"},
        ],
        ajax: '{{ route('invoice-commissions-completed-dt.create') }}',
        "columns": [
            { "data": 'id', "name": 'id' },
            { "data": 'job', "name": 'job' },
            { "data": 'customer', "name": 'customer' },
            { "data": 'quote_status', "name": 'quote_status' },
            { "data": 'salesperson', "name": 'salesperson' },
            { "data": 'action', "name": 'action', "orderable": false, "searchable": false }
        ],
    });
</script>
{{-- jquery datatables js --}}
@endpush