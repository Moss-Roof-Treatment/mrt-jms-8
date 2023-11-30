@extends('layouts.jquery')

@section('title', '- Invoices - View All Group Invoices')

@push('css')
{{-- jquery datatables css --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
{{-- jquery datatables css --}}
@endpush

@section('content')
<section>
    <div class="container py-5">

        {{-- title --}}
        <h3 class="text-secondary mb-0">GROUP INVOICES</h3>
        <h5>View All Group Invoices</h5>
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

        <h5 class="text-primary my-3"><b>All Group Invoices</b></h5>
        <div class="table-responsive">
            <table class="table table-bordered table-fullwidth table-striped bg-white" id="group-datatable" style="width:100%">
                <thead class="table-secondary">
                    <th>Confirmation Number</th>
                    <th>Name</th>
                    <th>Total</th>
                    <th>Invoice Count</th>
                    <th>Paid Date</th>
                    <th>Options</th>
                </thead>
            </table>
        </div> {{-- table-responsive --}}

    </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- jquery datatables js --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    $('#group-datatable').DataTable({
        processing: true,
        serverSide: true,
        order: [[ 0, "desc" ]],
        columnDefs: [
            {targets: 5, orderable: false, className: "text-nowrap"},
        ],
        ajax: '{{ route('group-invoices-dt.create') }}',
        columns: [
            { data: 'confirmation_number', name: 'confirmation_number' },
            { data: 'user_id', name: 'user_id' },
            { data: 'total', name: 'total' },
            { data: 'count', name: 'count' },
            { data: 'paid_date', name: 'paid_date' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
    });
});
</script>
@endpush
