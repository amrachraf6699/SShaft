@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k7.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>{{ __('translation.seasonal_projects') }}</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>{{ __('translation.seasonal_projects') }}</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    @if ($projects->count() > 0)
        <section class="news-page services-page pb-120 pt-120">
            <div class="container">
                <div class="news-3-col">
                    @foreach ($projects as $project)
                            <div class="blog-card">
                                <div class="blog-card__inner">
                                    <div class="blog-card__image">
                                        <img src="{{ $project->image_path }}" alt="{{ $project->title }}">
                                        {{-- <div class="blog-card__date">{{ $project->created_at->format('d M') }}</div> --}}
                                    </div><!-- /.blog-card__image -->
                                    <div class="blog-card__content">
                                        <div class="blog-card__meta"></div>
                                        <h3><a href="{{ route('frontend.about-the-association.seasonal-projects.show', $project->slug) }}">{{ $project->title }}</a></h3>
                                        <a href="{{ route('frontend.about-the-association.seasonal-projects.show', $project->slug) }}" class="blog-card__more"><i class="far fa-angle-right"></i>المزيد</a>
                                        <!-- /.blog-card__more -->
                                    </div><!-- /.blog-card__content -->
                                </div><!-- /.blog-card__inner -->
                            </div><!-- /.blog-card -->
                        @endforeach
                </div><!-- /.news-3-col -->

                {!! $projects->appends(request()->input())->links() !!}
            </div><!-- /.container -->
        </section><!-- /.news-page -->
    @endif
@endsection
