@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k3.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>فروعنا</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>فروعنا</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    @if ($branches->count() > 0)
        <div class="event-infos pt-20 pb-90">
            <h3 class="Branch">فروع الجمعية</h3>
            @foreach ($branches as $branch)
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-lg-6 mb-30">
                            <div class="event-infos__single background-secondary">
                                <h3>{{ $branch->name }}</h3>

                                {!! $branch->content !!}

                                {{-- <div class="event-infos__social">
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-youtube"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                </div> --}}
                            </div><!-- /.event-infos__single -->
                        </div><!-- /.col-md-12 col-lg-4 mb-30 -->
                        <div class="col-md-12 col-lg-6 mb-30">
                            <div class="google-map__event">
                                {!! $branch->link_map_address !!}
                            </div><!-- /.google-map -->
                        </div><!-- /.col-md-12 col-lg-4 mb-30 -->

                    </div><!-- /.row -->

                </div><!-- /.container -->
            @endforeach
        </div><!-- /.event-infos -->
    @endif
@endsection
