@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k7.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>تفاصيل الخبر</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>تفاصيل الخبر</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section class="blog-details pt-120 pb-40">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="blog-card__image">
                        <img src="{{ $new->image_path }}" alt="{{ $new->title }}">
                        <div class="blog-card__date">{{ $new->created_at->format('d M') }}</div><!-- /.blog-card__date -->
                    </div><!-- /.blog-card__image -->
                    <div class="blog-card__meta d-flex justify-content-start mt-0 mb-0"></div>
                    <h3>{{ $new->title }}</h3>
                    {!! $new->content !!}
                </div>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.blog-details -->
@endsection
