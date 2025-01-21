@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k7.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>{{ __('translation.governance_material') }}</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>{{ __('translation.governance_material') }}</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section class="event-page pt-120 pb-120">
        <div class="container">
            @if ($governments->count() > 0)
                <div class="event-grid">
                    @foreach ($governments as $government)
                        <div class="event-card">
                            <div class="event-card-inner">
                                <div class="event-card-content">
                                    <h3>{{ $government->title }}</h3>
                                    <ul class="event-card-list">
                                        @if ($government->file)
                                            <li>
                                                <i class="far fa-file-alt"></i>
                                                <strong><a href="{{ $government->file_path }}" target="_blank">عرض الملف</a></strong>
                                            </li>
                                        @endif

                                        @if ($government->content)
                                            <li>
                                                <i class="far fa-file-alt"></i>
                                                <strong><a href="{{ route('frontend.about-the-association.governance-material.show', $government->slug) }}">عرض المزيد</a></strong>
                                            </li>
                                        @endif
                                    </ul><!-- /.event-card-list -->
                                </div><!-- /.event-card-content -->
                            </div><!-- /.event-card-inner -->
                        </div><!-- /.event-card -->
                    @endforeach
                </div><!-- /.event-grid -->
            @endif

            {!! $governments->appends(request()->input())->links() !!}
        </div><!-- /.container -->
    </section><!-- /.event-page -->
@endsection
