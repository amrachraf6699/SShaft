@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k7.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>الأخبار</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>الأخبار</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    @if ($news->count() > 0)
        <section class="news-page pb-120 pt-120">
            <div class="container">
                <div class="news-3-col">
                    @foreach ($news as $new)
                        <div class="blog-card">
                            <div class="blog-card__inner">
                                <div class="blog-card__image">
                                    <img src="{{ $new->image_path }}" alt="{{ $new->title }}">
                                    <div class="blog-card__date">{{ $new->created_at->format('d M') }}</div>
                                </div><!-- /.blog-card__image -->
                                <div class="blog-card__content">
                                    <div class="blog-card__meta"></div>
                                    <h3><a href="{{ route('frontend.news-details.show', [$new->blog_section->slug, $new->slug]) }}">{{ $new->title }}</a></h3>
                                    <a href="{{ route('frontend.news-details.show', [$new->blog_section->slug, $new->slug]) }}" class="blog-card__more"><i class="far fa-angle-right"></i>المزيد</a>
                                    <!-- /.blog-card__more -->
                                </div><!-- /.blog-card__content -->
                            </div><!-- /.blog-card__inner -->
                        </div><!-- /.blog-card -->
                    @endforeach
                </div><!-- /.news-3-col -->

                {!! $news->appends(request()->input())->links() !!}
            </div><!-- /.container -->
        </section><!-- /.news-page -->
    @endif
@endsection
