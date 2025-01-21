c<!DOCTYPE html>
<html lang="ar" class="translated-rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @php
        $setting = setting()
    @endphp
    <title>{{ $setting->name }} {{ !empty($pageTitle) ? '» ' . $pageTitle : '' }}</title>
    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ URL::asset('frontend_files/assets/images/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::asset('frontend_files/assets/images/favicon.ico') }}">

    <link rel="stylesheet" href="{{ URL::asset('frontend_files/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('frontend_files/assets/css/fontawesome-all.min.css') }}">
    <!-- template styles -->
    <link rel="stylesheet" href="{{ URL::asset('frontend_files/assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('frontend_files/assets/css/rtl.css') }}">
</head>
<body style="background-color:#16a085;">

    <section style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="container">
            <div class="row m-3 justify-content-center ">
                <h2 class="text-center col-12"> <img src="{{ URL::asset('frontend_files/assets/images/favicon.ico') }}" alt="logo" class="ml-2">دفع مبلغ <strong>"{{ $donation->total_amount }}"</strong> ريال سعودي</h2>
                <div id="showPayForm"></div>
            </div>
        </div>
    </section>

    <script src="{{ URL::asset('frontend_files/assets/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ URL::asset('frontend_files/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                type: 'get',
                url: "{{ route('frontend.donations.check-out') }}",
                data: {
                    total_amount: {{ $donation->total_amount }},
                    donationId: {{ $donation->id }},
                    donation_code: '{{ $donation->donation_code }}',
                    payment_brand: '{{ request('payment_brand') }}',
                },
                success: function(data) {
                    if (data.status == true ) {
                        $('#showPayForm').empty().html(data.content);
                    } else {
                        //
                    }
                },
            });
        });
    </script>
</body>
</html>

