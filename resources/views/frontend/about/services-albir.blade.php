@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k7.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>{{ __('translation.services_albir') }}</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>{{ __('translation.services_albir') }}</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section class="chart-page container my-5">
        {!! $services_albir->value ? $services_albir->value : '' !!}
    </section>
@endsection
