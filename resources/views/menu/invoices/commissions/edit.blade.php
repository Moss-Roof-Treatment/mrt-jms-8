@extends('layouts.app')

@section('title', '- Invoices - Edit Selected Pending Commission')

@section('content')
<section>
    <div class="container py-5">

        {{-- title --}}
        <h3 class="text-secondary mb-0">COMMISSIONS</h3>
        <h5>Edit Selected Pending Commission</h5>
        {{-- title --}}

        {{-- navigation --}}
        <div class="row row-cols-1 row-cols-sm-4 pt-3">
            <div class="col pb-3">
                <a href="{{ route('invoice-commissions.index') }}" class="btn btn-dark btn-block">
                    <i class="fas fa-bars mr-2" aria-hidden="true"></i>Commissions Menu
                </a>
            </div> {{-- col pb-3 --}}
            <div class="col pb-3">
                <a href="{{ route('invoice-commissions.show', $selected_commission->id) }}" class="btn btn-primary btn-block">
                    <i class="fas fa-eye mr-2" aria-hidden="true"></i>View Commission
                </a>
            </div> {{-- col pb-3 --}}
        </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
        {{-- navigation --}}

        <div class="row">
            <div class="col-sm-7">

                <h5 class="text-primary my-3"><b>Edit Commission Details</b></h5>

                <form action="{{ route('invoice-commissions.update', $selected_commission->id) }}" method="POST">
                    @method('PATCH')
                    @csrf

                    <div class="form-group row">
                        <label for="edited_total" class="col-md-3 col-form-label text-md-right">Custom Total</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control @error('edited_total') is-invalid @enderror mb-2" name="edited_total" id="edited_total" value="{{ @old('edited_total', number_format(($selected_commission->edited_total / 100), 2, '.', ',')) }}" placeholder="Please enter custom total value" autofocus>
                            @error('edited_total')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> {{-- col-md-9 --}}
                    </div> {{-- form-group row --}}

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit
                            </button>
                            {{-- reset modal --}}
                            {{-- modal button --}}
                            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                                <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                            </button>
                            {{-- modal button --}}
                            {{-- modal --}}
                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Reset</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                    <p class="text-center">Are you sure that you would like to reset this form?</p>
                                    <a href="{{ route('invoice-commissions.edit', $selected_commission->id) }}" class="btn btn-dark btn-block">
                                        <i class="fas fa-undo-alt mr-2" aria-hidden="true"></i>Reset
                                    </a>
                                    </div> {{-- modal-body --}}
                                </div> {{-- modal-content --}}
                                </div> {{-- modal-dialog --}}
                            </div> {{-- modal fade --}}
                            {{-- modal --}}
                            {{-- reset modal --}}
                            <a href="{{ route('invoice-commissions.show', $selected_commission->id) }}" class="btn btn-dark">
                                <i class="fas fa-times mr-2" aria-hidden="true"></i>Cancel
                            </a>
                        </div>
                    </div> {{-- form-group row --}}

                </form>

            </div> {{-- col-sm-7 --}}
            <div class="col-sm-5">

                {{-- sold jobs table --}}
                <h5 class="text-primary my-3"><b>Commission Details</b></h5>
                <div class="table-responsive py-2 px-2">
                    <table class="table table-bordered table-fullwidth table-striped bg-white" id="datatable" style="width:100%">
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{ $selected_commission->salesperson->getFullNameTitleAttribute() }}</td>
                            </tr>
                            <tr>
                                <th>Quote Total</th>
                                <td>${{ number_format(($selected_commission->quote_total / 100), 2, '.', ',') }}</td>
                            </tr>
                            <tr>
                                <th>Default Total Commission</th>
                                <td>{{ $selected_commission->total_percent * 100 }}%</td>
                            </tr>
                            <tr>
                                <th>Total Quote Commissions</th>
                                <td>
                                    @if($selected_commission->quote_id == null)
                                        <span class="badge badge-light py-2 px-2">
                                            <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                                        </span>
                                    @else
                                        {{ $selected_commission->quote->commissions->count() }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Individual Commission</th>
                                <td>{{ $selected_commission->individual_percent_value * 100 }}%</td>
                            </tr>
                            <tr>
                                <th>Commission Total</th>
                                <td>${{ number_format(($selected_commission->quote_total * $selected_commission->individual_percent_value / 100), 2, '.', ',') }}</td>
                            </tr>
                            @if ($selected_commission->edited_total != null)
                                <tr>
                                    <th>Edited Total</th>
                                    <td>${{ number_format(($selected_commission->edited_total / 100), 2, '.', ',') }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge badge-warning p-2">
                                        <i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> {{-- table-responsive --}}
                {{-- sold jobs table --}}

            </div> {{-- col-sm-5 --}}
        </div> {{-- row --}}

    </div> {{-- container --}}
</section> {{-- section --}}
@endsection