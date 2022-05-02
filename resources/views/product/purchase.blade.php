@extends('layouts.app')
@section('styles')
<style>
    .card {
        margin: auto;
        margin-top:100px;
        width: 600px;
        padding: 3rem 3.5rem;
        box-shadow: 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }
    
    @media(max-width:767px) {
        .card {
            width: 90%;
            padding: 1.5rem;
        }
    }
    
    @media(height:1366px) {
        .card {
            width: 90%;
            padding: 8vh;
        }
    }
    
    .card-title {
        font-weight: 700;
        font-size: 2.5em;
    }
    
    .btn {
        width: 100%;
        background-color: #ffc107;
        color: white;
        justify-content: center;
        padding: 2vh 0;
        margin-top: 3vh;
        border: none;
    }
    
    .btn:hover {
        color: #ffc107;
        background: white;
        border: 1px solid #ffc107;
    }
    
    </style>
    @endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="">
                    <p>You will be charged ${{ number_format($product->price, 2) }} for {{ $product->name }} Product</p>
                </div>
                <form action="{{ route('cart.create') }}" method="post" id="payment-form">
                    @csrf                    
                    <div class="form-group ">
                        <div class="card-header">
                            <label for="card-element">
                                Enter your credit card information
                            </label>
                            
                        </div>
                        <div class="card-body">
                            <div id="card-element">
                            <!-- A Stripe Element will be inserted here. -->
                            </div>
                            <!-- Used to display form errors. -->
                            <div id="card-errors" role="alert"></div>
                            <input type="hidden" name="item" value="{{ $product->id }}" />
                        </div>
                    </div>
                    <div class="card-footer">
                      <button
                      id="card-button"
                      class="btn"
                      type="submit"
                      data-secret="{{ $intent->client_secret }}"
                    > Pay </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    // Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
    base: {
        color: '#32325d',
        lineHeight: '18px',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};

const stripe = Stripe('{{ env("STRIPE_KEY") }}', { locale: 'en' }); // Create a Stripe client.
const elements = stripe.elements(); // Create an instance of Elements.
const cardElement = elements.create('card', { style: style }); // Create an instance of the card Element.
const cardButton = document.getElementById('card-button');
const clientSecret = cardButton.dataset.secret;

cardElement.mount('#card-element'); // Add an instance of the card Element into the `card-element` <div>.

// Handle real-time validation errors from the card Element.
cardElement.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

// Handle form submission.
var form = document.getElementById('payment-form');

form.addEventListener('submit', function(event) {
    event.preventDefault();

    stripe
        .handleCardSetup(clientSecret, cardElement, {
            payment_method_data: {
            //    billing_details: { name: cardHolderName.value }
            }
        })
        .then(function(result) {
            console.log(result);
            if (result.error) {
                // Inform the user if there was an error.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                console.log(result);
                // Send the token to your server.
                stripeTokenHandler(result.setupIntent.payment_method);
            }
        });
});

// Submit the form with the token ID.
function stripeTokenHandler(paymentMethod) {
    // Insert the token ID into the form so it gets submitted to the server
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'paymentMethod');
    hiddenInput.setAttribute('value', paymentMethod);
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
}
</script>
@endsection