@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k3.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>الفيديو</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>الفيديو</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    @if ($videos->count() > 0)
        <section class="gallery-page pt-120 pb-120">
            <div class="container">
                <h3 class="address">الفيديو</h3>
                <div class="gallery-3-col">
                    @foreach ($videos as $video)
                        <div>
                            <div class="gallery-card">
                                <img src="http://img.youtube.com/vi/{{ get_youtube_id($video->url) }}/hqdefault.jpg" class="img-fluid" alt="{{ $video->title }}">
                                <div class="gallery-content">
                                    <a href="http://img.youtube.com/vi/{{ get_youtube_id($video->url) }}/hqdefault.jpg" class="img-popup" aria-label="open image">
                                        <div><i class="fa fa-eye"></i></div>
                                    </a>
                                </div><!-- /.gallery-content -->
                            </div><!-- /.gallery-card -->
                            <h5><a href="{{ route('frontend.videos-details.show', [$video->video_section->slug, $video->slug]) }}">{{ $video->title }}</a></h5>
                        </div>
                    @endforeach
                </div><!-- /.gallery-3-col -->
                {!! $videos->appends(request()->input())->links() !!}
            </div><!-- /.container -->
        </section><!-- /.gallery-page -->
    @endif
@endsection
