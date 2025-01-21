@php
	$setting = App\Setting::orderBy('id', 'DESC')->first()
@endphp
<!-- Title -->
<title>
    {{ $setting->name }} | لوحة التحكم</title>
<!-- Favicon -->
<link rel="icon" href="{{ $setting->fav_path }}" type="image/png" />
<!-- Icons css -->
<link href="{{URL::asset('dashboard_files/assets/css/icons.css')}}" rel="stylesheet">
<!-- Google fonts -->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
<!--  Custom Scroll bar-->
<link href="{{URL::asset('dashboard_files/assets/plugins/mscrollbar/jquery.mCustomScrollbar.css')}}" rel="stylesheet"/>
<!--  Sidebar css -->
<link href="{{URL::asset('dashboard_files/assets/plugins/sidebar/sidebar.css')}}" rel="stylesheet">
<!-- Sidemenu css -->
<link rel="stylesheet" href="{{URL::asset('dashboard_files/assets/css-rtl/sidemenu.css')}}">
@yield('css')
<!-- Sidemenu css -->
<link rel="stylesheet" href="{{URL::asset('dashboard_files/assets/css-rtl/sidemenu.css')}}">
<!--- Style css -->
<link href="{{URL::asset('dashboard_files/assets/css-rtl/style.css')}}" rel="stylesheet">
<!--- Dark-mode css -->
<link href="{{URL::asset('dashboard_files/assets/css-rtl/style-dark.css')}}" rel="stylesheet">
<!---Skinmodes css-->
<link href="{{URL::asset('dashboard_files/assets/css-rtl/skin-modes.css')}}" rel="stylesheet">
<!---noty-->
<link rel="stylesheet" href="{{URL::asset('dashboard_files/assets/plugins/noty/noty.css')}}">
<script src="{{URL::asset('dashboard_files/assets/plugins/noty/noty.min.js')}}"></script>
<!---summernote-->
<link href="{{URL::asset('dashboard_files/assets/plugins/summernote/summernote-bs4.min.css')}}" rel="stylesheet">
