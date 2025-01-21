@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k3.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>تفاصيل الحدث</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>تفاصيل الحدث</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section class="event-details pt-120">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <h3>{{ $event->title }}</h3>
                    {!! $event->content !!}
                </div><!-- /.col-md-12 -->
                <div class="col-md-12 col-lg-6">
                    <img src="{{ $event->image_path }}" alt="{{ $event->title }}" class="img-fluid">
                </div><!-- /.col-md-12 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.event-details -->

    <div class="event-down event-infos pt-20 pb-90 text-center" style="height: 300px !important">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12 mb-30">
                    <div class="event-infos__single background-secondary">
                        <h3>{{ $event->location }}</h3>
                        <ul class="list-unstyled event-infos__list">
                            <li><strong>التاريخ:</strong> {{ $event->date_of_event }}</li>
                            <li><strong>الوقت:</strong> {{ $event->time_of_event }}</li>
                        </ul><!-- /.list-unstyled event-infos__list -->
                    </div><!-- /.event-infos__single -->
                </div><!-- /.col-md-12 col-lg-4 mb-30 -->
            </div><!-- /.row -->

        </div><!-- /.container -->
    </div><!-- /.event-infos -->
@endsection
