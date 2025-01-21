@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k7.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>تفاصيل الفيديو</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>تفاصيل الفيديو</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section class="blog-details pt-120 pb-40">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="blog-card__image">
                        <iframe width="853" height="480" src="https://www.youtube-nocookie.com/embed/{{ get_youtube_id($video->url) }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <div class="blog-card__date">20 May</div><!-- /.blog-card__date -->
                    </div><!-- /.blog-card__image -->
                    <div class="blog-card__meta d-flex justify-content-start mt-0 mb-0"></div><!-- /.blog-card__meta -->
                    <h3>{{ $video->title }}</h3>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.blog-details -->
@endsection
