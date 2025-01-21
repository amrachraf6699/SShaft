@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k7.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>{{ $section->title }}</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>{{ $section->title }}</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section class="event-page pt-120 pb-120">
        <div class="container">
            @if ($modules->count() > 0)
                <div class="event-grid">
                    @foreach ($modules as $module)
                        <div class="event-card">
                            <div class="event-card-inner">
                                <div class="event-card-content">
                                    <h3>{{ $module->title }}</h3>
                                    <ul class="event-card-list">
                                        @if ($module->file)
                                            <li>
                                                <i class="far fa-file-alt"></i>
                                                <strong><a href="{{ $module->file_path }}" target="_blank">عرض الملف</a></strong>
                                            </li>
                                        @endif

                                        @if ($module->content)
                                            <li>
                                                <i class="far fa-file-alt"></i>
                                                <strong><a href="{{ route('frontend.modules.show', [$module->module_section->slug, $module->slug]) }}">عرض المزيد</a></strong>
                                            </li>
                                        @endif
                                    </ul><!-- /.event-card-list -->
                                </div><!-- /.event-card-content -->
                            </div><!-- /.event-card-inner -->
                        </div><!-- /.event-card -->
                    @endforeach
                </div><!-- /.event-grid -->
            @endif

            {!! $modules->appends(request()->input())->links() !!}
        </div><!-- /.container -->
    </section><!-- /.event-page -->
@endsection
