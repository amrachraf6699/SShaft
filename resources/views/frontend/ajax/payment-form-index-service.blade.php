@section('main')
    <script>
        var wpwlOptions = {
            locale: "ar",
            style:  "card",
            paymentTarget: "_top",
            applePay: {
                displayName: "albir",
                total: { label: "Albir, INC." },
                merchantCapabilities: ["supports3DS"],
                countryCode: "SA",
                supportedNetworks: ["masterCard", "visa", "mada"]
            }
        }
    </script>
    <script src="https://oppwa.com/v1/paymentWidgets.js?checkoutId={{ $res['id'] }}"></script>
    <form action="{{ route('frontend.home') }}?payment_brand={{ $payment_brand }}&service_id={{ $id }}&total_amount={{ $total_amount }}&phone={{ $phone }}&quantity={{ $quantity }}" class="paymentWidgets" data-brands="{{ $payment_brand }}"></form>
@endsection
