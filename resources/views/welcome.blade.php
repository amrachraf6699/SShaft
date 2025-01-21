@extends('dashboard.layouts.master2')
@section('css')
    <!-- Sidemenu-respoansive-tabs css -->
    <link href="{{URL::asset('dashboard_files/assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css')}}" rel="stylesheet">
@endsection
@section('content')
		@php
        	$setting = App\Setting::orderBy('id', 'DESC')->first()
        @endphp
    <div style="height:100vh;display:flex;align-items:center">
		<div class="container-fluid">
			<div class="row no-gutter">
				<!-- The image half -->
				<div class="col-md-6 col-lg-6 col-xl-7 d-flex mx-auto">
					<div class="row wd-100p mx-auto text-center">
						<div class="col-12  my-auto mx-auto">
							<img src="{{ $setting->logo_path }}" class="my-auto ht-xl-80p wd-md-100p wd-xl-50p mx-auto" alt="{{ $setting->name }}">
						    <h2 class="mt-5">
						        مرحبا بكم فى 
						        {{ $setting->name }}
						    </h2>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
@endsection
