@extends("frontend.theme.master")
@section("page_title")
Sadhana :: Payment Processing
@endsection

@section("content")
<div class="section section-padding pt-5 mt-5" style="padding-top:50px;">
    <div class="container">
        <div class="row sigma_broadcast-video mt-5">
            <div class="col-8 mb-5 mx-auto">
                <form action="{{ route('sadhana.sadhana_payment_complete') }}" method="post">
                    @csrf
                    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="pk_test_pIaGoPD69OsOWmh1FIE8Hl4J" data-amount="1999" data-name="Stripe Demo" data-description="Online course about integrating Stripe" data-image="https://stripe.com/img/documentation/checkout/marketplace.png" data-locale="auto" data-currency="usd">
                    </script>

                </form>
                <button type="button" id="esewa-payment" data-url="{{ route('sadhana.sadhana_local_payment_process',['esewa']) }}" class="btn btn-success">
                    E-Sewa Payment
                </butotn>
                <button type="button" id="qr-payment" data-url="" class="btn btn-danger">
                    Scan QR
                </button>
                    <!-- <h3>Please wait, Loading content</h3> -->
                    <input id="card-holder-name" class="form-control" type="text">

                    <!-- Stripe Elements Placeholder -->
                    <div id="card-element"></div>

                    <button id="card-button" class="btn btn-primary" data-secret="{{ $intent->client_secret }}">
                        Update Payment Method
                    </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section("page_script")
<script src="https://js.stripe.com/v3/"></script>

<script>
    const stripe = Stripe('{{ env("STRIPE_KEY") }}');

    const elements = stripe.elements({
        clientSecret: "{{ $intent->client_secret }}"
    });
    const cardElement = elements.create('payment');

    cardElement.mount('#card-element');

    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');

    // cardButton.addEventListener('click', async (e) => {
    //     const {
    //         paymentMethod,
    //         error
    //     } = await stripe.createPaymentMethod(
    //         'card', cardElement, {
    //             billing_details: {
    //                 name: cardHolderName.value
    //             }
    //         }
    //     );

    //     if (error) {
    //         console.log(error.message)
    //         // Display "error.message" to the user...
    //     } else {
    //         // The card has been verified successfully...
    //     }
    // });
    stripe.confirmPayment({
            elements,
            confirmParams: {
                // Return URL where the customer should be redirected after the PaymentIntent is confirmed.
                return_url: 'https://example.com',
            },
        })
        .then(function(result) {
            if (result.error) {
                // Inform the customer that there was an error.
            }
        });
</script>

<script type="text/javascript">
    $("#esewa-payment").click(function(e) {
        e.preventDefault();
        var esewa_form = document.createElement("form");
        esewa_form.setAttribute("method","post")
        esewa_form.setAttribute("action",$(this).attr("data-url"))
        hiddenField = document.createElement("input");
        hiddenField.setAttribute('type','hidden');
        hiddenField.setAttribute('name',"_token");
        hiddenField.setAttribute("value",$('meta[name="csrf-token"]').attr('content'));
        esewa_form.appendChild(hiddenField);
        document.body.appendChild(esewa_form);

        esewa_form.submit();
    })
</script>
@endsection