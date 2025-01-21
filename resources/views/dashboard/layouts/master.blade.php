<!DOCTYPE html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="">
		<meta name="Author" content="">
		<meta name="Keywords" content=""/>
		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="userId" content="{{ auth()->check() ? auth()->user()->id : '' }}">
        @include('dashboard.layouts.head')
        @php
        	$setting = App\Setting::orderBy('id', 'DESC')->first()
        @endphp
	</head>

	<body class="main-body app sidebar-mini">
            <!-- Loader -->
            <div id="global-loader">
                <img src="{{URL::asset('dashboard_files/assets/img/loader.svg')}}" class="loader-img" alt="Loader">
            </div>
            <!-- /Loader -->
            @include('dashboard.layouts.main-sidebar')
            <!-- main-content -->
            <div class="main-content app-content" id="app">
                @include('dashboard.layouts.main-header')
                <!-- container -->
                <div class="container-fluid">
                    @yield('page-header')
                    @yield('content')
                    @include('partials._session')
                    @include('dashboard.layouts.footer')
                    @include('dashboard.layouts.footer-scripts')
	</body>
</html>
