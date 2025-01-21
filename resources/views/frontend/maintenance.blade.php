<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    @php
        $setting = setting()
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $setting->name }} {{ !empty($pageTitle) ? '» ' . $pageTitle : '' }}</title>
    <link href="{{ URL::asset('frontend_files/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ URL::asset('frontend_files/assets/images/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::asset('frontend_files/assets/images/favicon.ico') }}">
</head>
<body>
    <div class="text-center" style="width: 400px !important; height: auto; margin: 35px auto">
        <div class="img-responsive img-fluid">
            {!! $maintenance->message_maintenance !!}
        </div>
    </div>

    <script src="{{ URL::asset('frontend_files/assets/js/jquery-2.2.4.min.js') }}"></script>
</body>
</html>
