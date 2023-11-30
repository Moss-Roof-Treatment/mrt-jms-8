@extends('layouts.profile')

@section('title', 'Profile - Jobs')

@push('css')
<style>
    .card-input{
        padding: 8px; border: 1px solid #dbdbdb; border-radius: 4px; box-shadow: inset 0 1px 2px rgba(10, 10, 10, 0.1);
    }
    .card-input:hover {
        padding: 8px; border: 1px solid #a6a6a6; border-radius: 4px; box-shadow: inset 0 1px 2px rgba(10, 10, 10, 0.1);
    }
</style>
@endpush

@section('content')
<section>
    <div class="container py-5">

        {{-- title --}}
        <h3 class="text-secondary mb-0">PAYMENT GATEWAY</h3>
        <h5>Process Card Payment</h5>
        {{-- title --}}

        {{-- navigation --}}
        <div class="row row-cols-1 row-cols-sm-4 pt-3">
            <div class="col pb-3">
                <a href="{{ route('profile-jobs.show', $selected_quote->id) }}" class="btn btn-dark btn-block">
                    <i class="fas fa-arrow-left mr-2" aria-hidden="true"></i>Back To Job
                </a>
            </div> {{-- col pb-3 --}}
        </div> {{-- row row-cols-1 row-cols-sm-4 pt-3 --}}
        {{-- navigation --}}

        {{-- order summary box --}}
        <h2 class="text-secondary text-center py-4"><b>Payment Gateway</b></h2>
        <h4 class="text-secondary"><b>Order Summary</b></h4>
        <div class="card border border-secondary mb-4">
            <div class="card-body pb-0">
                <div class="row">
                    <div class="col-sm-6">
                        <table class="table table-fullwidth">
                            <thead>
                                <tr>
                                    <th class="text-secondary" colspan="2">Customer Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $selected_quote->customer->getFullNameAttribute() }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $selected_quote->job->tenant_street_address }}</td>
                                </tr>
                                <tr>
                                    <th>Suburb</th>
                                    <td>{{ $selected_quote->job->tenant_suburb . ', ' . $selected_quote->job->tenant_postcode }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>
                                        @if($selected_quote->customer->email == null)
                                            <span class="badge badge-light py-2 px-2">
                                                <i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable
                                            </span>
                                        @else
                                            {{ $selected_quote->customer->email }}
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> {{-- col-sm-6 --}}
                    <div class="col-sm-6">
                        <table class="table table-fullwidth">
                            <thead>
                                <tr>
                                <th class="text-secondary" colspan="2">Order Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th>Job Type</th>
                                <td>Moss Roof Treatment</td>
                                </tr>
                                <tr>
                                <th>Job No</th>
                                <td>{{ $selected_quote->quote_identifier }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-fullwidth">
                            <thead>
                                <tr>
                                    <th class="text-secondary" colspan="2">Payment Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Subtotal</th>
                                    <td>{{ $selected_quote->getFormattedRemainingBalanceTaxInvoice() }}</td>
                                </tr>
                                <tr>
                                    <th>GST Component</th>
                                    <td>{{ $selected_quote->getFormattedRemainingBalanceTaxInvoiceGst() }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Total</th>
                                    <td><b>{{ $selected_quote->getFormattedRemainingBalanceTaxInvoice() }}</b></td>
                                </tr>
                                <tr>
                                    <th>Balance Owing After Payment</th>
                                    <td>$0.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div> {{-- col-sm-6 --}}
                </div> {{-- row --}}
            </div> {{-- card-body --}}
        </div> {{-- card --}}
        {{-- order summary box --}}

        {{-- payment card input --}}
        <div class="row">
            <div class="col-sm-6">

                <form action="{{ route('tradesperson-accept-card-payment.store') }}" method="POST" id="payment-form">
                    @csrf

                    <div class="card border border-secondary">
                        <div class="card-body">

                            <p class="text-secondary"><b>Please Fill Out The Below Form To Make Payment Via Credit Or Debit Card</b></p>
                            <p>A 2% merchant surcharge applies for payments using credit or debit cards</p>

                            <input type="hidden" name="quote_id" value="{{ $selected_quote->id }}">

                            <div class="form-group">
                                <label for="name_on_card">Name On Card</label>
                                <input type="text" class="form-control" name="name_on_card" id="name_on_card" value="{{ old('name_on_card') }}" placeholder="Name on card" aria-describedby="nameOnCard">
                                @error('name_on_card')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="field">
                                <label class="label" for="card-element">
                                    Card Details
                                </label>
                                <div id="card-element" class="card-input bg-white">
                                    <!-- a Stripe Element will be inserted here. -->
                                </div>
                                <!-- Used to display form errors -->
                                <div id="card-errors" role="alert"></div>
                            </div> {{-- field --}}

                        </div> {{-- card-body --}}
                    </div> {{-- card --}}

                    <button type="submit" id="complete-order" class="btn btn-secondary mt-3">
                    <i class="fa fa-check pr-2"></i>Submit
                    </button>
                    <a href="{{ route('profile-jobs.show', $selected_quote->id) }}" class="btn btn-dark mt-3">
                        <i class="fa fa-times pr-2"></i>Cancel
                    </a>

                </form>

            </div> {{-- col-sm-6 --}}
        </div> {{-- row --}}
        {{-- payment card input --}}

    </div> {{-- container --}}
</section> {{-- section --}}
@endsection

@push('js')
{{-- Stripe Payment Gateway --}}
<script src="https://js.stripe.com/v3/"></script>
<script>
    (function(){
        // Create a Stripe client
        var stripe = Stripe('{{ config('services.stripe.public') }}');

        // Create an instance of Elements
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Maven Pro", sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '1rem',
                '::placeholder': {
                    color: '#cccccc'
                }
            },
            invalid: {
                color: '#ff3860',
                iconColor: '#ff3860'
            }
        };

        // Create an instance of the card Element
        var card = elements.create('card', {
            style: style,
            hidePostalCode: true
        });

        // Add an instance of the card Element into the `card-element` <div>
        card.mount('#card-element');

        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
        event.preventDefault();

        // Disable the submit button to prevent repeated clicks
        document.getElementById('complete-order').disabled = true;

        var options = {
            name: document.getElementById('name_on_card').value
        }

        stripe.createToken(card, options).then(function(result) {
            if (result.error) {
                // Inform the user if there was an error
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;

                // Enable the submit button
                document.getElementById('complete-order').disabled = false;
                } else {
                // Send the token to your server
                stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }
    })();
</script>
{{-- Stripe Payment Gateway --}}
@endpush