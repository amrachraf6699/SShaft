@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k7.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>{{ $section->title . ' - ' . $module->title }}</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>{{ $section->title . ' - ' . $module->title }}</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section class="event-details pt-120">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <h3>{{ $module->title }}</h3>
                    {!! $module->content !!}
                    <br>
                    <ul class="event-card-list">
                        {{-- @if ($module->file)
                            <li>
                                <i class="far fa-file-alt"></i>
                                <strong><a href="{{ $module->file_path }}" target="_blank">عرض الملف</a></strong>
                            </li>
                        @endif --}}
                    </ul><!-- /.event-card-list -->
                </div><!-- /.col-md-12 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.event-details -->
@endsection
