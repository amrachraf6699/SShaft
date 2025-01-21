<!DOCTYPE html>
<html lang="ar" class="translated-rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $setting = setting()
    @endphp
    <title>{{ $setting->name }} {{ !empty($pageTitle) ? '» ' . $pageTitle : '' }}</title>
    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ URL::asset('frontend_files/assets/images/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::asset('frontend_files/assets/images/favicon.ico') }}">

    <meta name="author" content="" />
    <meta name="description" content="{{ !empty($metaDesc) ? $metaDesc : $setting->description }}">
    <meta name="keywords" content="{{ !empty($metaKey) ? $metaKey : $setting->keywords }}" />
    <meta property="og:title" content="{{ $setting->name }} {{ !empty($pageTitle) ? '» ' . $pageTitle : '' }}" />
    <meta property="og:site_name" content="{{ $setting->name ? $setting->name : '' }}" />
    <meta property="og:url" content="{{ !empty($metaUrl) ? $metaUrl : route('frontend.home') }}" />
    <meta property="og:description" content="{{ !empty($metaDesc) ? $metaDesc : $setting->description }}" />
    <meta property="og:image" content="{{ !empty($metaImg) ? $metaImg : URL::asset('frontend_files/assets/images/logo.png') }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1024">
    <meta property="og:image:height" content="1024">

    <link rel="stylesheet" href="{{ URL::asset('frontend_files/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('frontend_files/assets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('frontend_files/assets/css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('frontend_files/assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('frontend_files/assets/css/azino-icons.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('frontend_files/assets/css/odometer.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('frontend_files/assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('frontend_files/assets/css/bootstrap-select.min.css') }}">

    <!-- template styles -->
    <link rel="stylesheet" href="{{ URL::asset('frontend_files/assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('frontend_files/assets/css/rtl.css') }}">
</head>

<body>
    <div class="page-wrapper">

        @include('partials._sessionError')
        @include('partials._sessionSuccess')
        @include('partials._sessionAuthError')
        @include('partials._sessionCartSuccess')
        @include('partials._sessionSuccessReview')

        <!-- Header -->
        <div class="main-header__two">
            <div class="main-header__top">
                <div class="container">
                    <p>اهلا بكم في {{ $setting->name }}</p>
                    <div class="main-header__social">
                        @if ($setting->twitter)
                            <a href="{{ $setting->twitter }}" aria-label="twitter" target="_blank"><i class="fab fa-twitter"></i></a>
                        @endif
                        @if ($setting->facebook)
                            <a href="{{ $setting->facebook }}" aria-label="facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if ($setting->youtube)
                            <a href="{{ $setting->youtube }}" aria-label="pinterest" target="_blank"><i class="fab fa-youtube"></i></a>
                        @endif
                        @if ($setting->instagram)
                            <a href="{{ $setting->instagram }}" aria-label="instagram" target="_blank"><i class="fab fa-instagram"></i></a>
                        @endif

                        @if ($setting->snapchat)
                            <a href="{{ $setting->snapchat }}" aria-label="snapchat" target="_blank"><i class="fab fa-snapchat"></i></a>
                        @endif
                        @if ($setting->whatsapp)
                            <a href="https://wa.me/{{ $setting->whatsapp }}" aria-label="whatsapp" target="_blank"><i class="fab fa-whatsapp"></i></a>
                        @endif
                    </div><!-- /.main-header__social -->
                </div><!-- /.container -->
            </div><!-- /.main-header__top -->
        </div>
        <!-- Header -->

        <!-- Socail links -->
        @include('frontend.layouts.socail-links')
        <!-- Socail links -->

        <!-- ========== End of Header ======= -->

        <!-- Yield Content
        ====================================== -->
        @yield('content')
        <!-- Yield Content
        ====================================== -->

        <!-- footer -->
        @include('frontend.layouts.footer')
        <!-- footer -->

    </div><!-- /.page-wrapper -->

    <script src="{{ URL::asset('frontend_files/assets/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ URL::asset('frontend_files/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('frontend_files/assets/js/swiper.min.js') }}"></script>
    {{-- <script src="{{ URL::asset('frontend_files/assets/js/jquery.ajaxchimp.min.js') }}"></script> --}}
    <script src="{{ URL::asset('frontend_files/assets/js/jquery.magnific-popup.min.js') }}"></script>
    {{-- <script src="{{ URL::asset('frontend_files/assets/js/jquery.validate.min.js') }}"></script> --}}
    <script src="{{ URL::asset('frontend_files/assets/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ URL::asset('frontend_files/assets/js/wow.js') }}"></script>
    <script src="{{ URL::asset('frontend_files/assets/js/odometer.min.js') }}"></script>
    <script src="{{ URL::asset('frontend_files/assets/js/jquery.appear.min.js') }}"></script>
    <!-- template js -->
    <script src="{{ URL::asset('frontend_files/assets/js/jquery-ui.js') }}"></script>
    <script src="{{ URL::asset('frontend_files/assets/js/jquery-ui.js') }}"></script>
    <script src="{{ URL::asset('frontend_files/assets/js/theme.js') }}"></script>
    @yield('js')
    <script>
        $(function() {
            $(document).on('click', '#quickCkeckout', function(e) {
                var serviceId   = $(this).parents('.side-donation').find('input[type="radio"][name="service"]:checked').val();
                var paymentWays = $(this).parents('.side-donation').find('input[type="radio"][name="payment_ways"]:checked').val();

                e.preventDefault();

                $(this).parents('.side-donation').find('#total_amount__err__sidebar').text('');
                $(this).parents('.side-donation').find('#phoneNumber__err__sidebar').text('');
                $(this).parents('.side-donation').find('#payment_brand__err__sidebar').text('');

                var phoneNumber  = $(this).parents('.side-donation').find('input[name="phone_number"]').val();
                var totalAmount  = $(this).parents('.side-donation').find('input[name="total_amount"]').val();

                $.ajax({
                    type: 'get',
                    url: "{{ route('frontend.quick-donation-side-bar-check-out.check-out') }}",
                    data: {
                        total_amount: totalAmount,
                        phoneNumber: phoneNumber,
                        serviceId: serviceId,
                        quantity: 1,
                        payment_brand: paymentWays,
                    }, success: function(data) {
                        if (data.status == true ) {
                            $('.side-donation .second-part').addClass('open');
                            $('.side-donation .title .left-block input').val(totalAmount);

                            $('#showPayFormQuickDonation').empty().html(data.content);
                        }
                    }, error: function(reject) {
                        $('.side-donation .second-part').removeClass('open');

                        var res = $.parseJSON(reject.responseText);
                        $.each(res.errors, function(key, value) {
                            $("#" + key + "__err__sidebar").text(value[0]);
                        });
                    }
                });

            });
        });
    </script>
</body>

</html>
