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

    @if ($sections->count() > 0)
        <section class="event-page pt-120 pb-120 news-page">
            <div class="container">
                <div class="event-grid">
                    @foreach ($sections as $section)
                        <div class="event-card">
                            <a href="{{ route('frontend.news.index', $section->slug) }}">
                                <div class="event-card-inner">
                                    <div class="event-card-image">
                                        <div class="event-card-image-inner">
                                            <img src="{{ $section->image_path }}" alt="{{ $section->title }}">
                                        </div><!-- /.event-card-image-inner -->
                                    </div><!-- /.event-card-image -->
                                    <div class="event-card-content">
                                        <h3>{{ $section->title }}</h3>
                                        <ul class="event-card-list">
                                            {{-- <li><i class="far fa-eye"></i> <strong>250</strong></li> --}}
                                            <li><i class="fas fa-list-ul"></i> <strong>{{ $section->blogs_count }}</strong></li>
                                        </ul><!-- /.event-card-list -->
                                    </div><!-- /.event-card-content -->
                                </div><!-- /.event-card-inner -->
                            </a>
                        </div><!-- /.event-card -->
                    @endforeach
                </div><!-- /.event-grid -->

                <!-- pagination -->
                    {!! $sections->appends(request()->input())->links() !!}
                <!-- ./Pagination -->

            </div><!-- /.container -->
        </section><!-- /.event-page -->
    @endif
@endsection
