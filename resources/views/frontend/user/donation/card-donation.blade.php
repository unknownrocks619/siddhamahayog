@extends("frontend.theme.portal")

@section("content")
<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Dashboard /</span>
        <span class="text-muted fw-light">
            <a href="{{ route('donations.list') }}">Donation</a> /</span>
        Card Payment
    </h4>

    <div class="row">
        <div class="col-md-12">
            <x-alert></x-alert>
            <form id="stripePaymentForm" enctype="multipart/form-data" action="{{route('donations.donate_post','stripe')}}" method="post">
                @csrf
                <div class="card mb-4">
                    <div class="row d-flex justify-content-between mt-2">
                        <div class="col-md-8">
                            <h5 class="card-header mt-0 pt-0">Dakshina </h5>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-sm btn-danger clickable" data-href="{{ route('donations.list') }}">
                                <i class="bx bx-window-close">
                                </i>
                                Cancel Donation
                            </button>
                        </div>
                    </div>
                    <!-- Payment information detail -->
                    <div class="card-body">
                        <p class="text-info">
                            Please Note: We do not store any card or personal information. All payments are processed by stripe.

                        </p>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="amount">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">USD</span>
                                    <input name="amount" type="text" required class="form-control" placeholder="Amount" aria-label="Amount">
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="payment_type">Your Name(Card Holder Name)
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <input type="text" name="card_holder_name" id="card-holder-name" class="form-control card_holder_name" required />
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3 ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="card_detail">
                                        Card Detail
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <div id="card-element" class="border border-primary"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="payment_method" class="payment-method" id="payment_method">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success pay">
                                    Process Dakshina
                                </button>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <!-- /Payment information detail -->
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push("custom_script")
<script src="https://js.stripe.com/v3/"></script>
<script>
    let stripe = Stripe("{{ env('STRIPE_KEY') }}")
    let elements = stripe.elements()
    let style = {
        base: {
            color: '#32325d',
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
    }
    let card = elements.create('card', {
        style: style
    })
    card.mount('#card-element')
    let paymentMethod = null
    $('form#stripePaymentForm').on('submit', function(e) {
        $('button.pay').attr('disabled', true)
        if (paymentMethod) {
            console.log('payment method return null');
            return true
        }
        stripe.confirmCardSetup(
            "{{ $intent->client_secret }}", {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: $('.card_holder_name').val()
                    }
                }
            }
        ).then(function(result) {
            console.log(result.error);
            if (result.error) {
                $('#card-errors').text(result.error.message)
                $('button.pay').removeAttr('disabled')
            } else {
                paymentMethod = result.setupIntent.payment_method
                console.log(paymentMethod);
                $('.payment-method').val(paymentMethod)
                $('form#stripePaymentForm').submit()
            }
        })
        return false
    })
</script>

@endpush

@push("custom_css")
<style>
    .StripeElement {
        box-sizing: border-box;
        height: 40px;
        padding: 10px 12px;
        border: 1px solid transparent;
        border-radius: 4px;
        background-color: white;
        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }

    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .StripeElement--invalid {
        border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }
</style>
@endpush