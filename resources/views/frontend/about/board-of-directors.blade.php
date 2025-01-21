@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k7.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>أعضاء مجلس الإدارة</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>أعضاء مجلس الإدارة</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section class="gallery-page pt-120 pb-120 board-members">
        <div class="container">
            <div class="title">
                <h1>أعضاء مجلس الإدارة</h1>
            </div>
            @if ($directors->count() > 0)
                <div class="gallery-3-col">
                    @foreach ($directors as $director)
                        <div class="gallery-card">
                            <img src="{{ $director->image_path }}" class="img-fluid" alt="{{ $director->adjective . ' ' . $director->name }}">
                            <div class="gallery-content">
                                <a href="{{ $director->image_path }}" class="img-popup" aria-label="open image"><i class="fal fa-plus"></i></a>
                            </div><!-- /.gallery-content -->
                            <div class="team-card__content">
                                <h5>{{ $director->adjective }}</h5>
                                <h3>{{ $director->name }}</h3>
                                <p>{{ $director->job_title }}</p>
                            </div><!-- /.team-card__content -->
                        </div><!-- /.gallery-card -->
                    @endforeach
                </div><!-- /.gallery-3-col -->
            @endif
            <div class="last-news-text">
                <p>{!! $board_of_directors->value ? $board_of_directors->value : '' !!}</p>
            </div>
        </div><!-- /.container -->
    </section><!-- /.gallery-page -->
@endsection
